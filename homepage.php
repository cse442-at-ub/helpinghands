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
   $getall = mysqli_query($conn, "SELECT profile_image,rating,userType,name FROM accounts WHERE email='$email'");
   $rows = mysqli_fetch_array($getall);
   $img = $rows['profile_image'];
   $rating = $rows['rating'];
   $role = $rows['userType'];
   $name = $rows['name'];
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
               <input type="text" id="searchInput" placeholder="Search" oninput="search()">
            </div>
            <nav>
               <a href="#">Settings</a>
               <a href="#">Notifications</a>
            </nav>
            <div class="profile">
               <img src="uploaded/<?php echo $img ?>" alt="<?php echo $img ?>" style="border-radius:50vw;margin-top:1vh; cursor:pointer;" class="profilepic" onclick="redirectToPage('<?php echo $role; ?>')">
               <div class="behindpfp">
                  <?php echo htmlspecialchars_decode($rating) ?>
               </div>
               <div class="activedot"></div>
            </div>
         </header>
      </div>
      <?php
   while ($event = $events->fetch_assoc()) {
   ?>
      <div class="post-body">
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
            <form method="POST" action="registerEvent.php">
               <input type="hidden" id="user" name="user" value="<?php echo $email; ?>">
               <input name="eventID" type="hidden" value="<?php echo $event['eventID']; ?>">
               <button class="post-register" type="submit">Register!</button>
            </form>
         <div class="post-share">
            <a>Share</a>
         </div>
         <form action="bookmarkEvent.php" method="POST">
            <input type="hidden" id="user" name="user" value="<?php echo $email; ?>">
            <input type="hidden" id="<?php echo $eventID; ?>" name="eventID" value="<?php echo $eventID; ?>">
            <div class="post-save"><button type="submit" id="bookmarkEvent">Save for later</button></div>
         </form>
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
      <script src="js/search.js"></script>
   </body>
</html>