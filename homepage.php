<!DOCTYPE html>
<html>
   <head>
      <title>Homepage</title>
      <link rel="stylesheet" href="css\homepage.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter">
   </head>
   <body>
      <div class="banner">
         <header>
            <div class="wrapper">
               <div class="logo">
                  <img src="Images/Helping Hands Logo.png" alt="Helping Hands Logo" style="margin-right:1vw;margin-top:1.75vh;" class="imgleft">
                  <div class="logo-title">
                     <a href="#"> HELPING <span class="multicolorlogo">HANDS</span></a>
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
                  <a href="#"><img src="Images/ProfilePicture.png" alt="Profile Picture" style="border-radius:50vw;margin-top:1vh;" class="profilepic" ></a>
                  <div class="behindpfp">
                     4.98
                  </div>
                  <div class="activedot"></div>
               </div>
            </div>
         </header>
      </div>
      
      <?php
         require 'connect.php'; // Connecting to database

         // Access Events Table
         $sql = "SELECT image,startTime,endTime, startDate, endDate, eventID, description, volunteersRequired, username FROM events";
         $sql2 = "SELECT eventID, user FROM eventRegistrations";
         $result = $conn->query($sql);
         $result2 = $conn->query($sql2);

         // Makes sure there is actually an event to be listed
         if ($result->num_rows > 0){
            // outputs data into event body for each row
            while ($row = $result->fetch_assoc()) {
               $countregisteredUsers = 0;
               while ($row2 = mysqli_fetch_assoc($result2)){
                  if ($row2["eventID"]==$row["eventID"]){
                     $countregisteredUsers++;
                  }
               }
               //$user = $row["username"];
               //$getrating = mysqli_query($conn,"SELECT rating FROM accounts WHERE name='$user'");
               //$rows_rating = mysqli_fetch_array($getrating);
               //$rating = $rows_rating['rating'];
               //$getimg  = mysqli_queryy($conn,"SELECT profile_image FROm accounts WHERE name='$user'");
               //$rows=mysqli_fetch_array($getimg);
               //$img = $rows['profile_image'];
               //echo "<div class=\"post-body\"><post-header><div class=\"post-wrapper\"><div class=\"post-logo\"><img src=" . $rows["profile_image"] . " class=\"logocenter\"></div><a href=\"#\">...</a></div></post-header>";
               if ($row["username"]=="Homeaid"){
                  echo "<div class=\"post-body\"><post-header><div class=\"post-wrapper\"><div class=\"post-logo\"><img src=\"Images/HomeAid-National.png\"class=\"logocenter\"></div><a href=\"#\">...</a></div></post-header>";
                  echo "<div class=\"post-rating\"><p>4.92</p></div>";
               }
               if ($row["username"]=="WeldFoodBank") {
                  echo "<div class=\"post-body\"><post-header><div class=\"post-wrapper\"><div class=\"post-logo\"><img src=\"Images/WeldFoodBank_Vertical CMYK 1.png\" alts=\"Weld Food Bank Logo\" class=\"logocenter\"></div><a href=\"#\">...</a></div></post-header>";
                  echo "<div class=\"post-rating\"><p>4.86</p></div>";
               }
               //echo "<div class=\"post-rating\"><p>" . $rows_rating["rating"] . "</p></div>";
               echo "<div class=\"post-description\"><p>" . $row["description"] . "</p></div>";
               echo "<post-infomatics><img src=\"Images/calendar.png\" alts=\"Calendar\" class=\"post-infomatics-images\"><div class=\"date\"><a>" . $row["startDate"] . " - " . $row["endDate"] ."</a></div>";
               echo "<img src=\"Images/clock-png-25767.png\" alts=\"Clock\" class=\"post-infomatics-images\"><div class=\"time\"><a>" . $row["startTime"] . " - " . $row["endTime"] . "</a></div>";
               echo "<img src=\"Images/people.png\" alts=\"Five Stick figure torsos and heads\" class=\"post-infomatics-images\"><div class=\"participants\"><a>" . $countregisteredUsers . "/" . $row["volunteersRequired"] . "</a></div></post-infomatics>";
               echo "<img src=\"" . $row["image"] . "\"class=\"imagecenter\">";
               echo "<div class=\"post-register\"><a>Register!</a></div>";
               echo "<div class=\"post-share\"><a>Share</a></div>";
               echo "<div class=\"post-save\"><a>Save for later</a></div>";
               //echo "<div class=\"post-warnings\"><img src=\"Images/673px-Wheelchair_symbol.svg.png\" alts=\"Disabled Symbol\" class=\"warningimages\"><img src=\"Images/warning-sign-arning-sign-colored-stroke-icon-34.png\" alts=\"No Smoking Symbol\" class=\"warningimages\"><img src=\"Images/HeavyLifting.png\" alts=\"Stick figure lifing heavy box\" class=\"warningimages\"></div>";
               echo "</div>";
            }
         }
         else {
            echo "no events found";
         }
         $conn->close();
      ?>
      
   </body>
</html>
