<?php
require('connect.php');
session_start();
if (!isset($_SESSION['email']) || $_SESSION['userType'] != 'organization') {
   header('location: signin.html');
}

$event_id = isset($_GET['eventID']) ? intval($_GET['eventID']) : 0;

// Fetch event details for editing
$sql = "SELECT * FROM events WHERE eventID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
   $existing_event = $result->fetch_assoc();

   // Populate form fields with existing event details
   $title = $existing_event['titles'];
   $location = $existing_event['location'];
   $start_date = $existing_event['startDate'];
   $end_date = $existing_event['endDate'];
   $start_time = $existing_event['startTime'];
   $end_time = $existing_event['endTime'];
   $event_type = $existing_event['type'];
   $categories = $existing_event['categories'];
   $description = $existing_event['description'];
   $volunters = $existing_event['volunteersRequired'];
   $age = $existing_event['age'];
   $cut_of_date = $existing_event['cutoffDate'];
} else {
   // Event not found
   header('Location: error_page.php');
   exit();
}
?>

<!DOCTYPE html>
<html>
<head>
   <meta content='width=device-width, initial-scale=1' name='viewport' />
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter">
   <link rel="stylesheet" href="/css/globals.css" />
   <link rel="stylesheet" href="css/eventlisting.css" />
</head>

<body>
   <?php
      require 'connect.php';
      session_start();
      $email = $_SESSION['email'];
      $getimg = mysqli_query($conn,"SELECT profile_image FROM accounts WHERE email='$email'");
      $getrating = mysqli_query($conn, "SELECT rating FROM accounts WHERE email='$email'");
      $getrole = mysqli_query($conn, "SELECT userType FROM accounts WHERE email='$email'");
      $rows=mysqli_fetch_array($getimg);
      $rows_rating = mysqli_fetch_array($getrating);
      $rows_role = mysqli_fetch_array($getrole);
      $img = $rows['profile_image'];
      $rating = $rows_rating['rating'];
      $role = $rows_role['userType'];
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
            <img src="uploaded/<?php echo $img?>" alt="<?php echo $img ?>" style="border-radius:50vw;margin-top:1vh;" class="profilepic" onclick="redirectToPage('<?php echo $role; ?>')">
               <div class="behindpfp">
                  <?php echo htmlspecialchars_decode($rating)?>
               </div>
               <div class="activedot"></div>
            </div>
         </div>
      </header>
   </div>
   <div class="posting-page">
      <div class="div">
         <div class="text-wrapper-2">Edit event</div>
         <div class="event-form">
            <form id="event-listing-form" action="editeventlisting_php.php?eventID=<?php echo $event_id; ?>" method="POST" enctype="multipart/form-data">
               <div class="overlap">
                  <p class="text-wrapper">Upload event image</p>
                  <div id="display_image"></div>
                  <div class="overlap-group">
                     <input type="file" id="image_input" name="image_input" accept="image/*" value="<?php echo htmlspecialchars($image_file); ?>">
                     <img id="uploadedImage" src="" alt="Uploaded Image" style="display: none;" />
                  </div>
               </div>
               <div class="overlap-2">
                  <div class="text-wrapper-4">
                     <input type="text" id="event_title" name="title" placeholder="Event Title" style="width: 870px; height: 20px;" value="<?php echo htmlspecialchars($title); ?>">
                  </div>
               </div>
               <div class="overlap-3">
                  <div class="text-wrapper-4">
                     <input type="text" id="event_location" name="location" placeholder="Event Location" style="width: 870px; height: 20px;" value="<?php echo htmlspecialchars($location); ?>">
                  </div>
               </div>
               <div class="overlap-4">
                  <div class="text-wrapper-4">
                     <input type="text" id="event_start_date" onfocus="(this.type='date')" onblur="(this.type='text')" name="startdate" placeholder="Event Start Date" style="width: 190px; height: 20px;" value="<?php echo htmlspecialchars($start_date); ?>">
                  </div>
               </div>
               <div class="overlap-11">
                  <div class="text-wrapper-4">
                     <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="event_enddate" name="enddate" placeholder="Event End Date" style="width: 190px; height: 20px;" value="<?php echo htmlspecialchars($end_date); ?>">
                  </div>
               </div>
               <div class="overlap-5">
                  <div class="text-wrapper-4"><input type="text" onfocus="(this.type='time')" onblur="(this.type='text')" id="start_time" name="start_time" placeholder="Start Time (EST)" style="width: 190px; height: 20px;" value="<?php echo htmlspecialchars($start_time); ?>">
                  </div>
               </div>
               <div class="overlap-6">
                  <div class="text-wrapper-4"><input type="text" onfocus="(this.type='time')" onblur="(this.type='text')" id="end_time" name="end_time" placeholder="End Time (EST)" style="width: 190px; height: 20px;" value="<?php echo htmlspecialchars($end_time); ?>">
                  </div>
               </div>
               <div class="event-type-wrapper">
                  <div class="text-wrapper-4">
                     <input type="text" id="event_type" name="event_type" placeholder="Event Type" style="width: 870px; height: 20px;" value="<?php echo htmlspecialchars($event_type); ?>">
                  </div>
               </div>
               <div class="event-categories-wrapper">
                  <div class="text-wrapper-4">
                     <input type="text" id="event_categories" name="categories" placeholder="Event Categories" style="width: 870px; height: 20px;" value="<?php echo htmlspecialchars($categories); ?>">
                  </div>
               </div>
               <div class="event-description-wrapper">
                  <div class="text-wrapper-4">
                     <textarea style="resize:none" id="description" name="description" placeholder="Event Description" cols="111" rows="8"><?php echo htmlspecialchars($description); ?></textarea>
                  </div>
               </div>
               <div class="overlap-7">
                  <div class="text-wrapper-5">
                     <input type="number" id="total_volunteers" name="total_volunteers" placeholder="Total volunteers required" style="width: 455px; height: 20px;" value="<?php echo htmlspecialchars($volunters); ?>">
                  </div>
               </div>
               <div class="overlap-10">
                  <div class="text-wrapper-6"><input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="last_date" name="last_date" placeholder="Last date to register" style="width: 455px; height: 20px;" value="<?php echo htmlspecialchars($cut_of_date); ?>">
                  </div>
               </div>
               <div class="overlap-8">
                  <div class="text-wrapper-6"><input type="number" id="age_range" name="age_range" placeholder="Volunteer age range required" style="width: 455px; height: 20px;" value="<?php echo htmlspecialchars($age); ?>">
                  </div>
               </div>
               <div class="overlap-9">
                  <div class="text-wrapper-7"><input type="text" id="other_details" name="other_details" placeholder="Other volunteer details" style="width: 455px; height: 20px;">
                  <div id="error-message" style="color: red; padding-top: 10%"><?php echo isset($_GET['error_message']) ? $_GET['error_message'] : ''; ?></div>
                  </div>
               </div>
               <div class="overlap-12">
                  <input type="submit" name="edit-event" value="Save Changes" style="height:50px; width: 300px;">
               </div>
            </form>
         </div>
      </div>
   </div>
   <script src="js/eventlisting.js"></script>
   <script>
      <?php
      if ($errors != null) {
      ?>
         alert('<?php echo $errors; ?>')
      <?php } ?>

      <?php
      if ($yes != null) {
      ?>
         alert('<?php echo $yes; ?>')
      <?php } ?>
   </script>
</body>

</html>