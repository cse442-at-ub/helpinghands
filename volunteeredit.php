<!DOCTYPE html>
<html>
   <head>
      <title>Edit Profile</title>
      <link rel="stylesheet" href="css\volunteeredit.css">
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
         $rows=mysqli_fetch_array($getimg);
         $rows_rating = mysqli_fetch_array($getrating);
         $rows_role=mysqli_fetch_array($getrole);
         $img = $rows['profile_image'];
         $rating = $rows_rating['rating'];
         $role = $rows_role['userType'];
      ?>
      <header>
         <div class="left">
            <img src="Images/Helping Hands Logo.png"/>
            <div class="logo-title">
               <a href="homepage.php"> HELPING <span class="multicolorlogo">HANDS</span></a>
            </div>
            <div class="searchbar" >
               <input type="text" placeholder="Search"/>
            </div>
         </div>
         <div class="right">
            <a href="#">Settings</a>
            <a href="#">Notifcations</a>
            <div class="img">
               <img id="profile-image" src="uploaded/<?php echo $img?>" alt="<?php echo $img ?>" style="border-radius: 75px; cursor: pointer" onclick="redirectToPage('<?php echo $role; ?>')"/>
               <div class="rating"><?php echo htmlspecialchars_decode($rating)?></div>
            </div>
         </div>
      </header>
      <div class="editprofile">
        <h1>Edit Profile</h1>
      </div>
      <div class="container">
         <form id="edit-profile-form" action="edit.php" method="POST" enctype="multipart/form-data">
            <div class="first_box">
              <input type="file" id="imgInp" name="imgInp" accept="image/*">
               <img id="profilePic" src="uploaded/<?php echo $img?>" alt="<?php echo $img ?>" style="width: 50%; height: 50%; cursor:pointer;" onclick="redirectToPage('<?php echo $role; ?>')"/>
            </div>

            <div class="second_box">
               <h5>Name</h5>
               <input type="text" name="profile-name" id="profile-name" placeholder="enter your name here..." style="width:50vh; height:3vh">
               <h5>Description</h5>
               <textarea style="resize:none" name="edit-description" id="edit-description" placeholder="enter your description here..." cols="70" rows="8"></textarea>
            </div>

            <div class="overlap-12">
              <input type="submit" name="submit" value="Save Changes" style="height:50px; width: 300px;">
         </form>
      </div>
      <script src="js/volunteeredit.js"></script>
      <script src="js/redirect.js"></script>
   </body>
</html>
