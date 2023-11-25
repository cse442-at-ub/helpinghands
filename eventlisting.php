<?php
require('connect.php');
session_start();
if (!isset($_SESSION['email']) || $_SESSION['userType'] != 'organization') {
   header('location: signin.html');
}
$title = null;
$location = null;
$start_date = null;
$end_date = null;
$start_time = null;
$end_time = null;
$event_type = null;
$categories = null;
$description = null;
$volunters = null;
$age = null;
$cut_of_date = null;
$continue = 1;
$errors = null;
$yes = null;
if (isset($_POST['Event'])) {
   $title = $_POST['title'];
   $location = $_POST['location'];
   $start_date = $_POST['startdate'];
   $end_date = $_POST['enddate'];
   $start_time = $_POST['start_time'];
   $end_time = $_POST['end_time'];
   $event_type = $_POST['event_type'];
   $categories = $_POST['categories'];
   $description = $_POST['description'];
   $volunters = $_POST['total_volunteers'];
   $age = $_POST['age_range'];
   $cut_of_date = $_POST['last_date'];
   if (empty($title)) {
      $continue = 0;
      $errors .= 'Title Required. ';
   }
   if (empty($location)) {
      $continue = 0;
      $errors .= 'Location Required. ';
   }
   if (empty($start_date)) {
      $continue = 0;
      $errors .= 'Start Date Required. ';
   }
   if (empty($end_date)) {
      $continue = 0;
      $errors .= 'End Date Required. ';
   }
   if (empty($start_time)) {
      $continue = 0;
      $errors .= 'Start Time Required. ';
   }
   if (empty($end_time)) {
      $continue = 0;
      $errors .= 'End Time Required. ';
   }
   if (empty($event_type)) {
      $continue = 0;
      $errors .= 'Event Type Required. ';
   }
   if (empty($categories)) {
      $continue = 0;
      $errors .= 'Categories Required. ';
   }
   if (empty($description)) {
      $continue = 0;
      $errors .= 'Description Required. ';
   }
   if (empty($volunters)) {
      $continue = 0;
      $errors .= 'Volunters Required. ';
   }
   if (empty($cut_of_date)) {
      $continue = 0;
      $errors .= 'Cut Of Date Required. ';
   }
   if (empty($age)) {
      $continue = 0;
      $errors .= 'Age Range Required. ';
   }
   if (is_uploaded_file($_FILES['image-input']['tmp_name'])) {
      $dir = "uploaded/";
      $image_file = $dir . basename($_FILES["image-input"]["name"]);
      $file_type = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));

      $check = getimagesize($_FILES["image-input"]["tmp_name"]);
      if ($check !== false) {
         $continue = 1;
      } else {
         $continue = 0;
         $errors .= 'File is not a image. ';
      }

      if (file_exists($image_file)) {
         $continue = 0;
         $errors .= " error: file already exists";
      }

      //check the size of the image (change value "50000" to change file size)
      if ($_FILES["image-input"]["size"] > 500000) {
         $continue = 0;
         $errors .= " error: file too large";
      }

      //check to see if the file is a valid type
      if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif") {
         $continue = 0;
         $errors .= " error: invalid file type";
      }
   } else {
      $errors .= 'Image File is required';
   }
   if ($continue == 1) {
      if (move_uploaded_file($_FILES["image-input"]["tmp_name"], $image_file)) {
         $sql = "INSERT INTO `events` (`titles`, `location`, `startTime`, `endTime`, `startDate`, `endDate`, `description`, `volunteersRequired`, `cutoffDate`, `age`, `username`, `image`, `categories`, `type`) VALUES (?, ? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         $res = $conn->prepare($sql);
         $res->bind_param(
            'ssssssssssssss',
            $title,
            $location,
            $start_time,
            $end_time,
            $start_date,
            $end_date,
            $description,
            $volunters,
            $cut_of_date,
            $age,
            $_SESSION['email'],
            $image_file,
            $categories,
            $event_type
         );
         if ($res->execute()) {
            $yes = 'Event added successfully';
         } else {
            $errors .= 'Facing error! try Again';
         }
      } else {
         $errors .= "Sorry, there was an error uploading your file.";
      }
   }
}
?>
<!DOCTYPE html>
<html>
   <head>
      <meta content='width=device-width, initial-scale=1' name='viewport'/>
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
         $rows=mysqli_fetch_array($getimg);
         $rows_rating = mysqli_fetch_array($getrating);
         $img = $rows['profile_image'];
         $rating = $rows_rating['rating'];
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
                     <a href="volunteerprofilepage.php"><img src="uploaded/<?php echo $img?>" alt="<?php echo $img ?>" style="border-radius:50vw;margin-top:1vh;" class="profilepic" ></a>
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
            <div class="text-wrapper-2">Create event</div>
            <div class="event-form">
               <form id="event-listing-form" action="upload.php" method="POST" enctype="multipart/form-data">
                  <div class="overlap">
                     <p class="text-wrapper">Upload event image</p>
                     <div id="display_image"></div>
                     <div class="overlap-group">
                        <input type="file" id="image_input" name="image-input" accept="image/*">
                        <img id="uploadedImage" src="" alt="Uploaded Image" style="display: none;" />
                     </div>
                  </div>
                  <div class="overlap-2">
                     <div class="text-wrapper-4">
                        <input type="text" id="event_title" name="event_title" placeholder="Event Title" style="width: 870px; height: 20px;">
                     </div>
                  </div>
                  <div class="overlap-3">
                     <div class="text-wrapper-4">
                        <input type="text" id="event_location" name="event_location" placeholder="Event Location" style="width: 870px; height: 20px;">
                     </div>
                  </div>
                  <div class="overlap-4">
                     <div class="text-wrapper-4">
                        <input type="text" id="event_startdate" name="event_startdate" placeholder="Event Start Date" style="width: 190px; height: 20px;">
                     </div>
                  </div>
                  <div class="overlap-11">
                     <div class="text-wrapper-4">
                        <input type="text" id="event_enddate" name="event_enddate" placeholder="Event End Date" style="width: 190px; height: 20px;">
                     </div>
                  </div>
                  <div class="overlap-5">
                     <div class="text-wrapper-4"><input type="text" id="event_start_time" name="event_start_time" placeholder="Start Time (EST)" style="width: 190px; height: 20px;">
                     </div>
                  </div>
                  <div class="overlap-6">
                     <div class="text-wrapper-4"><input type="text" id="event_end_time" name="event_end_time" placeholder="End Time (EST)" style="width: 190px; height: 20px;">
                     </div>
                  </div>
                  <div class="event-type-wrapper">
                     <div class="text-wrapper-4">
                      <input type="text" id="event_type" name="event_type" placeholder="Event Type" style="width: 870px; height: 20px;">
                    </div>
                  </div>
                  <div class="event-categories-wrapper">
                     <div class="text-wrapper-4">
                      <input type="text" id="event_categories" name="event_categories" placeholder="Event Categories" style="width: 870px; height: 20px;">
                    </div>
                  </div>
                  <div class="event-description-wrapper">
                     <div class="text-wrapper-4">
                      <textarea style="resize:none" id="event_description" name="event_description" placeholder="Event Description" cols="111" rows="8"></textarea>
                    </div>
                  </div>
                  <div class="overlap-7">
                     <div class="text-wrapper-5">
                      <input type="text" id="total_volunteers" name="total_volunteers" placeholder="Total volunteers required" style="width: 455px; height: 20px;">
                    </div>
                  </div>
                  <div class="overlap-10">
                     <div class="text-wrapper-6"><input type="text" id="last_date" name="last_date" placeholder="Last date to register" style="width: 455px; height: 20px;">
                    </div>
                  </div>
                  <div class="overlap-8">
                     <div class="text-wrapper-6"><input type="text" id="age_range" name="age_range" placeholder="Volunteer age range required" style="width: 455px; height: 20px;">
                    </div>
                  </div>
                  <div class="overlap-9">
                     <div class="text-wrapper-7"><input type="text" id="other_details" name="other_details" placeholder="Other volunteer details" style="width: 455px; height: 20px;">
                    </div>
                  </div>
                  <p class="p">
                    <input type="checkbox" id="form_confirm" name="form_confirm" value="yes">
                    <label for="form_confirm"> I confirm that all the above information is correct</label><br><br>
                    <input type="checkbox" id="count_hours" name="count_hours" value="yes">
                    <label for="form_confirm"> I want this event to count as volunteer hours</label><br>
                  </p>
                  <div class="overlap-12">
                    <input type="submit" name="submit" value="Create event" style="height:50px; width: 300px;">
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
