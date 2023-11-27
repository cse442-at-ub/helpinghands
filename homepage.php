<?php
require('connect.php');
session_start();
if (!isset($_SESSION['email'])) {
   header('location:signin.html'); //if user is not logined redirect user to signin
}
$events = [];

$sql = "SELECT events.*, accounts.profile_image, accounts.rating , count(eg.eventID) as total_reg FROM `events` INNER JOIN accounts on events.username = accounts.email left JOIN eventRegistrations eg on eg.eventID =events.eventID GROUP BY events.eventID, accounts.profile_image, accounts.rating"; //select all events with organization
$res = $conn->prepare($sql);
$res->execute();
$events = $res->get_result();

$volunteerId = $_SESSION['volunteer_id']; 

// Check if the register action has been triggered
if (isset($_POST['register_event'])) {
    $eventId = $_POST['event_id']; // Get the event ID from the form submission

    // Retrieve event start and end times from the database
    $eventQuery = "SELECT start_time, end_time FROM events WHERE id = ?";
    $stmt = $conn->prepare($eventQuery);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $eventResult = $stmt->get_result();
    $eventData = $eventResult->fetch_assoc();

    if ($eventData) {
        // Calculate volunteer hours
        $startTime = new DateTime($eventData['start_time']);
        $endTime = new DateTime($eventData['end_time']);
        $interval = $startTime->diff($endTime);
        $hours = $interval->h;
        $hours += ($interval->days * 24); // Adding days to hours if event spans multiple days

        // Insert registration and hours into the database
        $insertQuery = "INSERT INTO registered_events (volunteer_id, event_id, hours) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("iii", $volunteerId, $eventId, $hours);
        $insertStmt->execute();
    }
}
?>
<!DOCTYPE html>
<html>

   <head>
      <title>Homepage</title>
      <link rel="stylesheet" href="css\homepage.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter">
   </head>

   <body>
   <?php
      require 'connect.php';
      session_start();
      $email = $_SESSION['email'];
      $getimg = mysqli_query($conn,"SELECT profile_image FROM accounts WHERE email='$email'");
      $getrating = mysqli_query($conn, "SELECT rating FROM accounts WHERE email='$email'");
      $getrole = mysqli_query($conn,"SELECT userType FROM accounts WHERE email='$email'");
      $getname = mysqli_query($conn,"SELECT name FROM accounts WHERE email='$email'");
      $rows=mysqli_fetch_array($getimg);
      $rows_rating = mysqli_fetch_array($getrating);
      $rows_role=mysqli_fetch_array($getrole);
      $rows_name=mysqli_fetch_array($getname);
      $img = $rows['profile_image'];
      $rating = $rows_rating['rating'];
      $role = $rows_role['userType'];
      $name = $rows_name['name'];
   ?>
      <div class="banner">
         <header>
            <div class="wrapper">
               <div class="logo">
                  <img src="Images/Helping Hands Logo.png" alt="Helping Hands Logo" style="margin-right:1vw;margin-top:1.75vh;" class="imgleft">
                  <div class="logo-title">
                     <a href="homepage.php"> HELPING <span class="multicolorlogo">HANDS</span></a>
                  </div>
               </div>
               <div class="searchbar">
                  <input type="text" placeholder="Search">
               </div>
               <nav>
                  <a href="#">Settings</a>
                  <a href="#">Notifications</a>
               </nav>
               <div class="profile">
                  <img src="uploaded/<?php echo $img?>" alt="<?php echo $img ?>" style="border-radius:50vw;margin-top:1vh; cursor:pointer;" class="profilepic" onclick="redirectToPage('<?php echo $role; ?>')">
                  <div class="behindpfp">
                  <?php echo htmlspecialchars_decode($rating)?>
                  </div>
                  <div class="activedot"></div>
               </div>
            </div>
         </header>
      </div>
      <?php
   while ($event = $events->fetch_assoc()) {
   ?>
      div class="post-body">
         <post-header>
            <div class="post-wrapper">
               <div class="post-logo">
                  <img src="Images/<?php echo $event['profile_image']; ?>" alts="Weld Food Bank Logo" class="logocenter">
               </div>
               <a href="#">...</a>
            </div>
         </post-header>
         <div class="post-rating">
            <p>
               <?php echo $event['rating']; ?>
            </p>
         </div>
         <div class="post-description">
            <p>
               <?php echo $event['description']; ?>
            </p>
         </div>
         <post-infomatics>
            <img src="Images/calendar.png" alts="Calendar" class="post-infomatics-images">
            <div class="date">
               <a><?php echo date('M d, Y', strtotime($event['startDate'])); ?> - <?php echo date('M d, Y', strtotime($event['endDate'])); ?></a>
            </div>
            <img src="Images/clock-png-25767.png" alts="Clock" class="post-infomatics-images">
            <div class="time">
               <a><span><?php echo date('ha', strtotime($event['startTime'])); ?> - <?php echo date('ha', strtotime($event['endTime'])); ?></span></a>
            </div>
            <img src="Images/people.png" alts="Five Stick figure torsos and heads" class="post-infomatics-images">
            <div class="participants">
               <a><?php echo $event['total_reg'] . '/' . $event['volunteersRequired'] ?></a>
            </div>
         </post-infomatics>
         <img src="<?php echo $event['image']; ?>" alt="<?php echo $event['titles']; ?>" class="imagecenter" style="max-width: 40vw">
         <div class="">
            <form method="POST" action="registerEvent.php">
               <input name="eventID" type="hidden" value="<?php echo $event['eventID']; ?>" />
               <button class="post-register" type="submit">Register!</button>
               <button onclick="registerForEvent(eventId, volunteerId)">Register</button>
            </form>
         </div>
         <div class="post-share">
            <a>Share</a>
         </div>
         <div class="post-save">
            <a>Save for later</a>
         </div>
         <div class="post-warnings">
            <img src="Images/673px-Wheelchair_symbol.svg.png" alts="Disabled Symbol" class="warningimages">
            <img src="Images/No_Smoking.svg.png" alts="No Smoking Symbol" class="warningimages">
            <img src="Images/HeavyLifting.png" alts="Stick figure lifing heavy box" class="warningimages">
         </div>
      </div>
      <?php } ?>
   <body>
   <?php
   if (isset($_SESSION['flash'])) { //check flah message
   ?>
      <script>
         alert("<?php echo $_SESSION['flash']; ?>")
      </script>
   <?php
      unset($_SESSION['flash']); //unset flash message
   } ?>
   </html>
      <script src="js/redirect.js"></script>
      <script>
      function registerForEvent(eventId, volunteerId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "registerEvent.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            <p> Registration was successful </p>
        }
    }
    xhr.send("volunteer_id=" + volunteerId + "&event_id=" + eventId);
}
   </script>
   </body>
</html>
