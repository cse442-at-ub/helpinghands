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
         </div>
      </header>
   </div>

   <?php
   require 'connect.php'; // Connecting to database

   // Access Events Table
   $sql = "SELECT image,startTime,endTime, startDate, endDate, eventID, description, volunteersRequired, username FROM events";
   $result = $conn->query($sql);

   // Makes sure there is actually an event to be listed
   if ($result->num_rows > 0) {
      // outputs data into event body for each row
      while ($rowEvents = $result->fetch_assoc()) {
         $eventcreator = $rowEvents["username"];
         $eventID = $rowEvents["eventID"];
         //Grabbing Profile Image, email, and rating from Accounts for current event
         $sqleventcreator = "SELECT profile_image, rating FROM accounts where email='$eventcreator'";
         $geteventcreator = mysqli_query($conn, $sqleventcreator);
         $eventcreatorarray = mysqli_fetch_array($geteventcreator);
         $image = $eventcreatorarray["profile_image"];
         $ratingevent = $eventcreatorarray["rating"];
         //Grabbing userCount for current event
         $sqlCount = "SELECT COUNT(user) AS userCount FROM eventRegistrations WHERE eventID='$eventID'";
         $getCount = mysqli_query($conn, $sqlCount);
         $countarray = mysqli_fetch_array($getCount);
         $count = $countarray["userCount"];

         //Event Body and Logo
         echo "<div class=\"post-body\"><post-header><div class=\"post-wrapper\"><div class=\"post-logo\"><img src=\"uploaded/" . $image . "\" class=\"logocenter\"></div><a href=\"#\">...</a></div></post-header>";
         //Event's Creator Rating
         echo "<div class=\"post-rating\"><p>" . $ratingevent . "</p></div>";
         //Event Description
         echo "<div class=\"post-description\"><p>" . $rowEvents["description"] . "</p></div>";
         //Event Date
         echo "<post-infomatics><img src=\"Images/calendar.png\" alts=\"Calendar\" class=\"post-infomatics-images\"><div class=\"date\"><a>" . $rowEvents["startDate"] . " - " . $rowEvents["endDate"] . "</a></div>";
         //Event time
         echo "<img src=\"Images/clock-png-25767.png\" alts=\"Clock\" class=\"post-infomatics-images\"><div class=\"time\"><a>" . $rowEvents["startTime"] . " - " . $rowEvents["endTime"] . "</a></div>";
         //Event registered and max people
         echo "<img src=\"Images/people.png\" alts=\"Five Stick figure torsos and heads\" class=\"post-infomatics-images\"><div class=\"participants\"><a>" . $count . "/" . $rowEvents["volunteersRequired"] . "</a></div></post-infomatics>";
         //Event Image
         echo "<img src=\"" . $rowEvents["image"] . "\"class=\"imagecenter\">";
         //Register Event Setup
         echo "<form action=\"registerEvent.php\" method=\"POST\">";
         echo "<input type=\"hidden\" id=\"user\" name=\"user\" value=\"" . $email . "\">";
         echo "<input type=\"hidden\" id=\"" . $eventID . "\" name=\"eventID\" value=\"" . $eventID . "\">";
         echo "<div class=\"post-register\"><button type=\"submit\" id=\"eventRegister\">Register</button></div></form>";
         //Post Sharing Setup
         echo "<div class=\"post-share\"><a>Share</a></div>";
         //Bookmarking Event Setup
         echo "<form action=\"bookmarkEvent.php\" method=\"POST\">";
         echo "<input type=\"hidden\" id=\"user\" name=\"user\" value=\"" . $email . "\">";
         echo "<input type=\"hidden\" id=\"" . $eventID . "\" name=\"eventID\" value=\"" . $eventID . "\">";
         echo "<div class=\"post-save\"><button type=\"submit\" id=\"bookmarkEvent\">Save for later</button></div></form>";
         //echo "<div class=\"post-warnings\"><img src=\"Images/673px-Wheelchair_symbol.svg.png\" alts=\"Disabled Symbol\" class=\"warningimages\"><img src=\"Images/warning-sign-arning-sign-colored-stroke-icon-34.png\" alts=\"No Smoking Symbol\" class=\"warningimages\"><img src=\"Images/HeavyLifting.png\" alts=\"Stick figure lifing heavy box\" class=\"warningimages\"></div>";
         echo "</div>";
      }
   } else {
      echo "no events found";
   }
   $conn->close();
   ?>

   <script src="js/redirect.js"></script>
   <script src="js/search.js"></script>
   
</body>

</html>