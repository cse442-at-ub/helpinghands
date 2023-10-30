<!DOCTYPE html>
<html>
<head>
<title>ProfilePage</title>
<link rel="stylesheet" href="css\organisationprofilepage.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter">
</head>
<body>

<?php
  require 'connect.php';
  session_start();
  $username = $_SESSION['username'];
  $getimg = mysqli_query($conn,"SELECT profile_image FROM volunteers WHERE username='$username'");
  $rows=mysqli_fetch_array($getimg);
  $img = $rows['profile_image'];
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
                    <img src="uploaded/<?php echo $img?>" alt="<?php echo $img ?>"/>
                        <div class="rating">4.8</div>
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
        </ul>
    </nav>
    <div class="first_box">
            <img src="uploaded/<?php echo $img?>" alt="<?php echo $img ?>"/>
            <div class="ratings">4.92/5</div>
    </div>
    <div class="second_box">

        <h5>Description</h5>
        <p>HomeAid operates through 19 Affiliates in 13 states as a leading non-profit developer of housing and programmatic facilities for people experiencing or at risk of homelessness</p>
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
       <h2 class="history">This organisation has no previous events</h2>
    </div>



     <div class="first_box mt_4">
      
            <h1 class="heading">Comments</h1>
               <img class="hideall" src="Images/png-transparent-arrow-expand-expand-less-expandless-top-up-navigation-set-arrows-part-one-icon.png" onclick="showall(this)" data-box="comments">
              <button class="showall d_none" onclick="hideall(this)" data-box="comments" >Show All</button>
            
    </div>
    <div class="second_box hidden" id="comments">
       <h2 class="history">No comments</h2>
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

</body>
</html>
  