<!DOCTYPE html>
<html>
<head>
<title>ProfilePage</title>
<link rel="stylesheet" href="css\volunteerprofilepage.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter">
</head>
<body>
<?php
  require 'connect.php';
  session_start();
  $email = $_SESSION['email'];
  $getimg = mysqli_query($conn,"SELECT profile_image FROM accounts WHERE email='$email'");
  $getname = mysqli_query($conn, "SELECT name FROM accounts WHERE email='$email'");
  $getrating = mysqli_query($conn, "SELECT rating FROM accounts WHERE email='$email'");
  $getdesc = mysqli_query($conn, "SELECT description FROM accounts WHERE email='$email'");
  $rows = mysqli_fetch_array($getimg);
  $rows_name = mysqli_fetch_array($getname);
  $rows_rating = mysqli_fetch_array($getrating);
  $rows_description = mysqli_fetch_array($getdesc);
  $img = $rows['profile_image'];
  $name = $rows_name['name'];
  $rating = $rows_rating['rating'];
  $desc = $rows_description['description'];
?>
<header>
    <div class="left">
            <img src="Images/Helping Hands Logo.png"/>
            <div class="logo-title">

            <a href="homepage.php"> HELPING <span class="multicolorlogo">HANDS</span></a>

            </div>
            <div class="searchbar" >
                    <input type="text" placeholder="Search"/>
 </div>      </div>
        <div class="right">
                    <a href="#">Settings</a>
                    <a href="#">Notifcations</a>
                    <div class="img">
                    <img src="uploaded/<?php echo $img?>" alt="<?php echo $img ?>" style="border-radius:50vw;margin-top:1vh; cursor:pointer;" onclick="redirectToPage('<?php echo $role; ?>')"/>
                        <div class="online"></div>
                        <div class="rating"><?php echo htmlspecialchars_decode($rating)?></div>
                    </div>
        </div>
</header>
<div class="container">
    <nav>
        <ul>
            <li>
                <a hef="#">Leave a comment</a>
            </li>
            <li>
                <a hef="#">Rate</a>
            </li>
            <li>
                <a hef="#">View Events</a>
            </li>
            <li>
                <a hef="#">View History</a>
            </li>
            <li>
              <a href="volunteeredit.php">Edit Profile</a>
            </li>
              <li>
              <a href= "https://www-student.cse.buffalo.edu/CSE442-542/2023-Fall/cse-442d/signin.html" >Logout</a>
          </li>
        </ul>
    </nav>
    <div class="first_box">
        <div class="df">
        <div class="img">
            <img src="uploaded/<?php echo $img?>" alt="<?php echo $img ?>"/>
                <div class="online"></div>
            </div>
            <h1><?php echo htmlspecialchars_decode($name);?></h1>
            </div>
            <div class="ratings"><?php echo htmlspecialchars_decode($rating)?>/5</div>
    </div>
    <div class="second_box">
        <h5>Description</h5>
        <p><?php echo htmlspecialchars_decode($desc)?></p>
    </div>
    <div class="first_box mt_4">
            <h1 class="heading">Current Events</h1>
             <img class="hideall d_none" src="Images/png-transparent-arrow-expand-expand-less-expandless-top-up-navigation-set-arrows-part-one-icon.png" onclick="showall(this)" data-box="events">
                <button class="showall" onclick="hideall(this)" data-box="events">Hide All</button>
    </div>
    <div class="second_box " id="events">
        <div class="logo_box">
          <img src="Images/HomeAid-National.png">
            <div class="df">
              <div class="box_rating">
                4.92
              </div>
              <div class="pepople_rating">
                <img src="Images/people.png">
                30/50
              </div>
            </div>
            <div class="date">
            <span>Apr 08, 2023 - Aug 03, 2023</span><span>8am - 1pm</span>
            </div>
        </div>
    </div>
     <div class="first_box mt_4">
            <h1 class="heading">Event History</h1>
                 <img class="hideall d_none" src="Images/png-transparent-arrow-expand-expand-less-expandless-top-up-navigation-set-arrows-part-one-icon.png" onclick="showall(this)" data-box="history">
                <button class="showall" onclick="hideall(this)" data-box="history">Hide All</button>
    </div>
    <div class="second_box " id="history">
       <h2 class="history">Empty, You should volunter to fill this </h2>
    </div>
     <div class="first_box mt_4">
            <h1 class="heading">Comments</h1>
               <img class="hideall" src="Images/png-transparent-arrow-expand-expand-less-expandless-top-up-navigation-set-arrows-part-one-icon.png" onclick="showall(this)" data-box="comments">
              <button class="showall d_none" onclick="hideall(this)" data-box="comments" >Hide All</button>
    </div>
    <div class="second_box hidden" id="comments">
       <h2 class="history">Empty, You should volunter to fill this </h2>
    </div>
    <div class="first_box mt_4">
            <h1 class="heading">Bookmarked Events</h1>
             <img class="hideall d_none" src="Images/png-transparent-arrow-expand-expand-less-expandless-top-up-navigation-set-arrows-part-one-icon.png" onclick="showall(this)" data-box="bookmarkedEvents">
                <button class="showall" onclick="hideall(this)" data-box="events">Hide All</button>
    </div>
    <div class="second_box " id="bookmarkedEvents">
    <?php
        require 'connect.php'; // Connecting to database
        $sql = "SELECT eventID,user FROM bookmarkedEvents WHERE 'user'=$email";
        $sql2 = "SELECT startTime, endTime, startDate, endDate, eventID, volunteersRequired, username FROM events WHERE eventID IN ( SELECT eventID FROM bookmarkedEvents WHERE 'user'=$email )";
        $sql3 = "SELECT name, profile_image, rating FROM accounts WHERE name IN ( SELECT username FROM events WHERE eventID IN ( SELECT eventID FROM bookmarkedEvents WHERE 'user'=$email ) ) ";
        $sql4 = "SELECT eventID, user FROM eventRegistrations WHERE eventID IN ( SELECT eventID FROM bookmarkedEvents WHERE 'user'=$email )";
        $result = $conn->query($sql);
        $result2 = $conn->query($sql2);
        $result3 = $conn->query($sql3);
        $result4 = $conn->query($sql4);
        if ($result->num_rows > 0){
          while ($rowEvents = $result2->fetch_assoc()) {
            //Grabbing Registered Users count for current iteration of event
            $countregisteredUsers = 0;
            while ($rowRegistrations = mysqli_fetch_assoc($result4)){
              if ($rowRegistrations["eventID"]==$rowEvents["eventID"]){
                  $countregisteredUsers++;
              }
            }
            //Grabbing profile image and rating for current iteration of event
            $image = "";
            $ratingEvent = 0;
            while ($row3 = mysqli_fetch_assoc($result3)){
              if ($row3["name"]==$row["username"]){
                  $rating = $row3["rating"];
                  $image = $row3["profile_image"];
              }
            }
            //Main Declaration
            echo "<div class=\"logo_box\">";
            // Image Display
            echo  "<img src=\"uploaded/" . $image . "\">";
            echo    "<div class=\"df\">";
            //Rating
            echo      "<div class=\"box_rating\">";
            echo        $ratingEvent;
            echo      "</div>";
            //PEPOPLE count >:(
            echo      "<div class=\"pepople_rating\">";
            echo        "<img src=\"Images/people.png\">";
            echo        $countregisteredUsers . "/" . $rowEvents["volunteersRequired"];
            echo      "</div>";
            echo    "</div>";
            //Date and Time
            echo    "<div class=\"date\">";
            echo    "<span>" . $rowEvents["startDate"] . " - " . $rowEvents["endDate"] . "</span><span>" . $rowEvents["startTime"] . " - " . $rowEvents["endTime"] . "</span>";
            echo    "</div>";
            echo "</div>";
          }
        } 
        else{
          echo "<h2 class=\"bookmarkedEvents\">Empty, You have no bookmarked events</h2>";
        }
      ?>
    </div>
</div>
<script type="text/javascript">
  function showall(el) {
    el.classList.add("d_none");
    id = el.getAttribute("data-box");
   el.nextElementSibling.classList.remove('d_none')
    document.getElementById(id).classList.remove("hidden")
  }
    function hideall(el) {
    el.classList.add("d_none");
     el.previousElementSibling.classList.remove('d_none')
    id = el.getAttribute("data-box");
    document.getElementById(id).classList.add("hidden")
  }
</script>
<script src="js/redirect.js"></script>
</body>
</html>