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
      $username = $_SESSION['username'];
      $getimg = mysqli_query($conn,"SELECT profile_image FROM volunteers WHERE username='$username'");
      $getrating = mysqli_query($conn, "SELECT rating FROM volunteers WHERE username='$username'");
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
      <div class="post-body">
         <post-header>
            <div class="post-wrapper">
               <div class="post-logo">
                  <img src="Images/WeldFoodBank_Vertical CMYK 1.png" alts="Weld Food Bank Logo" class="logocenter">
               </div>
               <a href="#">...</a>
            </div>
         </post-header>
         <div class="post-rating">
            <p>
               4.86
            </p>
         </div>
         <div class="post-description">
            <p>
               Together, we can fill empty plates and hearts. Your time and energy are powerful
               tools for change, and by volunteering, you become an essential ingredient in the 
               recipe for a better world. Don't wait—take action today! Join us in the fight against 
               hunger and experience the joy of knowing you've played a crucial role in making a 
               brighter, more nourished future for all.
            </p>
         </div>
         <post-infomatics>
            <img src="Images/calendar.png" alts="Calendar" class="post-infomatics-images">
            <div class="date">
               <a>Oct 13,2023 - Oct 17,2023</a>
            </div>
            <img src="Images/clock-png-25767.png" alts="Clock" class="post-infomatics-images">
            <div class="time">
               <a>12pm - 4pm</a>
            </div>
            <img src="Images/people.png" alts="Five Stick figure torsos and heads" class="post-infomatics-images">
            <div class="participants">
               <a>26/30</a>
            </div>
         </post-infomatics>
         <img src="Images/elyssa-kaplan-an-employee-at-world-central-kitchen-news-photo-1586376300 1.png" alts="Elyssa Kaplan and employee at world central kitchen" class="imagecenter">
         <div class="post-register">
            <a>Register!</a>
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
      <div class="post-body">
         <post-header>
            <div class="post-wrapper">
               <div class="post-logo">
                  <img src="Images/HomeAid-National.png" alts="Weld Food Bank Logo" class="logocenter">
               </div>
               <a href="#">...</a>
            </div>
         </post-header>
         <div class="post-rating">
            <p>
               4.92
            </p>
         </div>
         <div class="post-description">
            <p>
               Together, we can transform empty spaces into places of refuge and compassion. 
               Your dedication and effort will be the bricks and mortar of a brighter, more 
               inclusive community. Don't hesitate—take a step towards making homelessness a
               solvable issue. Join our team today, and let's build a better tomorrow for those who need it most.
            </p>
         </div>
         <post-infomatics>
            <img src="Images/calendar.png" alts="Calendar" class="post-infomatics-images">
            <div class="date">
               <a>Apr 08,2023 - Aug 03,2023</a>
            </div>
            <img src="Images/clock-png-25767.png" alts="Clock" class="post-infomatics-images">
            <div class="time">
               <a>8am - 1pm</a>
            </div>
            <img src="Images/people.png" alts="Five Stick figure torsos and heads" class="post-infomatics-images">
            <div class="participants">
               <a>32/50</a>
            </div>
         </post-infomatics>
         <img src="Images/ConstructionVolunteers.png" alts="Elyssa Kaplan and employee at world central kitchen" class="imagecenter">
         <div class="post-register">
            <a>Register!</a>
         </div>
         <div class="post-share">
            <a>Share</a>
         </div>
         <div class="post-save">
            <a>Save for later</a>
         </div>
         <div class="post-warnings">
            <img src="Images/673px-Wheelchair_symbol.svg.png" alts="Disabled Symbol" class="warningimages">
            <img src="Images/warning-sign-arning-sign-colored-stroke-icon-34.png" alts="No Smoking Symbol" class="warningimages">
            <img src="Images/HeavyLifting.png" alts="Stick figure lifing heavy box" class="warningimages">
         </div>
      </div>
   </body>
</html>
