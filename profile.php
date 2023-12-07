<!DOCTYPE html>
<?php

require 'connect.php'; // connecting to database

session_start();

$userID = 0; // Initializting userID to 0

// Checking if userID is provided in the URL
if(isset($_GET['userID'])){
    $userID = intval($_GET['userID']); // storing userID as integer
}
if($userID == $_SESSION['userID']){ // If user ID is the same as the person who is signed in
    // Redirect to the appropriate profile page
    if($_SESSION['userType'] == "volunteer"){
        header("Location: volunteerprofilepage.php");
        exit;
    } else {
        header("Location: organizationprofilepage.php");
        exit;
    }
}

// Retrieving data from userID
$stmt = $conn->prepare("SELECT * FROM accounts WHERE userID = ?");
$stmt->bind_param('i', $userID);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if(!$userData){ // If user data doesnt exist
    echo "User not found";
    exit;
}

// Extracting user data
$img = $userData['profile_image'];
$name = $userData['name'];
$rating = $userData['rating'];
$desc = $userData['description'];
$userType = $userData['userType'];

// Setting data from session
$userEmail = $_SESSION['email'];
$userGetAll = mysqli_query($conn, "SELECT profile_image,name,rating,description,userType FROM accounts WHERE email='$userEmail'");
$userRows = mysqli_fetch_array($userGetAll);
$userImg = $userRows['profile_image'];
$userRating = $userRows['rating'];

?>

<html>
<head>
<title><?php echo htmlspecialchars($name);?></title>
<link rel="stylesheet" href="css\volunteerprofilepage.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter">
</head>
<body>

<header>
    <div class="left">
      <img src="Images/Helping Hands Logo.png" />
      <div class="logo-title">
        <a href="homepage.php"> HELPING <span class="multicolorlogo">HANDS</span></a>
      </div>
      <div class="searchbar">
        <input type="text" placeholder="Search" />
      </div>
    </div>
    <div class="right">
      <a href="#">Settings</a>
      <a href="#">Notifcations</a>
      <div class="img">
      <a href = "<?php echo "profile.php?userID=" . $_SESSION['userID'] ?>">
        <img src="uploaded/<?php echo $userImg ?>" alt="<?php echo $userImg ?>" style="border-radius:50vw;margin-top:1vh; cursor:pointer;" />
      </a>
        <div class="online"></div>
        <div class="rating">
          <?php echo htmlspecialchars_decode($userRating) ?>
        </div>
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
        <?php if($userType == 'organization' &&  $_SESSION['userType'] == 'volunteer'): ?>
          <li>
              <script src="js/subscriptionForm.js"></script>
              <form action="subscribe.php" method = "post" class = "subscription-form">
                <input type="hidden" name="userID" value="<?php echo $_SESSION['userID']; ?>">
                <input type="hidden" name="organizationID" value="<?php echo $userID; ?>">
                <button type="submit" class="subscribe-button">Subscribe</button>
              </form>
          </li>
        <?php endif; ?>
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