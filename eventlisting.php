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
   </body>
</html>
