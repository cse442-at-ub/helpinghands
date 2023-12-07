<?php
require('connect.php');
session_start();

// Start the session and include the database connection
session_start();
include 'connect.php';

// Check if a user is logged in
if (isset($_SESSION['email'])) {
    $volunteer_id = $_SESSION['user_id'];

    // Prepare SQL query to fetch total volunteer hours
    $query = "SELECT SUM(hours_volunteered) AS total_hours FROM VolunteerHours WHERE volunteer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $volunteer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $total_hours = $data['total_hours'] ?? 0; // Default to 0 if no hours are recorded
    $stmt->close();
} else {
    // Redirect to login page or show an error if the user is not logged in
    header("Location: signin.php");
    exit();
}

if (!isset($_SESSION['email'])) {
  header('location: signin.html');
}
$user = $_SESSION['email'];
$sql = "SELECT events.*, accounts.rating, COUNT(eg.eventID) as total_reg FROM `eventRegistrations` eg INNER JOIN events on events.eventID = eg.eventID INNER JOIN accounts on accounts.email = events.username WHERE eg.user = ? GROUP BY events.eventID, accounts.rating;";
$events = $conn->prepare($sql);
$events->bind_param('s', $user);
$events->execute();
$events = $events->get_result();
?>
<!DOCTYPE html>
<html>

<head>
  <title>ProfilePage</title>
  <link rel="stylesheet" href="css/volunteerprofilepage.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter">
  <link rel="stylesheet" href="evo-calendar.min.css">
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

  //Calendar 
  $getEventID = mysqli_query($conn, "SELECT eventID FROM eventRegistrations WHERE user='$email'");
  $eventIDs = array();
  while ($rows_eventID = mysqli_fetch_array($getEventID)) {
    $eventIDs[] = $rows_eventID["eventID"];
  }

  $Titles = array();
  $Locations = array();
  $StartTimes = array();
  $EndTimes = array();
  $StartDates = array();
  $EndDates = array();
  $OrgNames = array();

  foreach ($eventIDs as $eventID) {
    $getTitle = mysqli_query($conn, "SELECT titles FROM events WHERE eventID='$eventID'");
    $getLocation = mysqli_query($conn, "SELECT location FROM events WHERE eventID='$eventID'");
    $getStartTime = mysqli_query($conn, "SELECT startTime FROM events WHERE eventID='$eventID'");
    $getEndTime = mysqli_query($conn, "SELECT endTime FROM events WHERE eventID='$eventID'");
    $getStartDate = mysqli_query($conn, "SELECT startDate FROM events WHERE eventID='$eventID'");
    $getEndDate = mysqli_query($conn, "SELECT endDate FROM events WHERE eventID='$eventID'");
    $getOrgName = mysqli_query($conn, "SELECT username FROM events WHERE eventID='$eventID'");

    $rows_Titles = mysqli_fetch_array($getTitle);
    $rows_Locations = mysqli_fetch_array($getLocation);
    $rows_StartTimes = mysqli_fetch_array($getStartTime);
    $rows_EndTimes = mysqli_fetch_array($getEndTime);
    $rows_StartDates = mysqli_fetch_array($getStartDate);
    $rows_EndDates = mysqli_fetch_array($getEndDate);
    $rows_OrgNames = mysqli_fetch_array($getOrgName);

    $Titles[] = $rows_Titles["titles"];
    $Locations[] = $rows_Locations["location"];
    $StartTimes[] = $rows_StartTimes["startTime"];
    $EndTimes[] = $rows_EndTimes["endTime"];
    $StartDates[] = $rows_StartDates["startDate"];
    $EndDates[] = $rows_EndDates["endDate"];
    $OrgNames[] = $rows_OrgNames["username"];
  }
  ?>
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
        <img src="uploaded/<?php echo $img ?>" alt="<?php echo $img ?>" style="border-radius:50vw;margin-top:1vh; cursor:pointer;" onclick="redirectToPage('<?php echo $role; ?>')" />
        <div class="online"></div>
        <div class="rating">
          <?php echo htmlspecialchars_decode($rating) ?>
        </div>
      </div>
    </div>
  </header>
  <div class="container">
    <nav>
      <ul>
        <li>
          <a href="#">Leave a comment</a>
        </li>
        <li>
          <a href="organization_ratings.php">Rate</a>
        </li>
        <li>
          <a href="#">View History</a>
        </li>
        <li>
          <a href="volunteeredit.php">Edit Profile</a>
        </li>
        <li>
          <a href="https://www-student.cse.buffalo.edu/CSE442-542/2023-Fall/cse-442d/signin.html">Logout</a>
        </li>
      </ul>
    </nav>
    <div class="first_box">
      <div class="df">
        <div class="img">
          <img src="uploaded/<?php echo $img ?>" alt="<?php echo $img ?>" />
          <div class="online"></div>
        </div>
        <h1>
          <?php echo htmlspecialchars_decode($name); ?>
        </h1>
      </div>
      <div class="ratings">
        <?php echo htmlspecialchars_decode($rating) ?>/5
      </div>
    </div>
    <div class="second_box">
      <h5>Description</h5>
      <div>
       <h3>Total Volunteer Hours: <?php echo $total_hours; ?></h3>
      </div>
      <p>
        <?php echo htmlspecialchars_decode($desc) ?>
      </p>
    </div>
    <div class="first_box mt_4">
      <h1 class="heading">Current Events</h1>
      <img class="hideall d_none"
        src="Images/png-transparent-arrow-expand-expand-less-expandless-top-up-navigation-set-arrows-part-one-icon.png"
        onclick="showall(this)" data-box="events">
      <button class="showall" onclick="hideall(this)" data-box="events">Hide All</button>
    </div>
    <div class="second_box " id="events">
      <?php while ($event = $events->fetch_assoc()) { ?>
        <div class="logo_box mt-2">
          <img src="<?php echo $event['image']; ?>">
          <div class="df">
            <div class="box_rating">
              <?php echo $event['rating']; ?>
            </div>
            <div class="pepople_rating">
              <img src="Images/people.png">
              <?php echo $event['total_reg']; ?>/<?php echo $event['volunteersRequired']; ?>
            </div>
          </div>
          <div class="date">
            <span><?php echo date('M d, Y', strtotime($event['startDate'])); ?> - <?php echo date('M d, Y', strtotime($event['endDate'])); ?></span><span><?php echo date('ha', strtotime($event['startTime'])); ?> - <?php echo date('ha', strtotime($event['endTime'])); ?></span>
          </div>
        </div>
      <?php } ?>
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
      <button class="showall d_none" onclick="hideall(this)" data-box="comments">Hide All</button>
    </div>
    <div class="second_box hidden" id="comments">
      <h2 class="history">Empty, You should volunter to fill this </h2>
    </div>
    <div class="first_box mt_4">
      <h1 class="heading">Bookmarked Events</h1>
      <img class="hideall d_none" src="Images/png-transparent-arrow-expand-expand-less-expandless-top-up-navigation-set-arrows-part-one-icon.png" onclick="showall(this)" data-box="bookmarkedEvents">
      <button class="showall" onclick="hideall(this)" data-box="bookmarkedEvents">Hide All</button>
    </div>
    <div class="second_box " id="bookmarkedEvents">
      <?php
      require 'connect.php'; // Connecting to database
      $sql6 = "SELECT startTime, endTime, startDate, endDate, eventID, volunteersRequired, username FROM events WHERE eventID IN ( SELECT eventID FROM bookmarkedEvents WHERE user='$email' )";
      $result = $conn->query($sql6);
      if ($result->num_rows > 0) {
        while ($rowEvents = $result->fetch_assoc()) {
          $eventcreator = $rowEvents["username"];
          $eventID = $rowEvents["eventID"];
          //Grabbing Registered Users count for current iteration of event
          $sqlCount = "SELECT COUNT(user) AS userCount FROM eventRegistrations WHERE eventID='$eventID'";
          $getCount = mysqli_query($conn, $sqlCount);
          $countarray = mysqli_fetch_array($getCount);
          $count = $countarray["userCount"];
          //Grabbing Profile Image, email, and rating from Accounts for current event
          $sqleventcreator = "SELECT profile_image, rating FROM accounts where email='$eventcreator'";
          $geteventcreator = mysqli_query($conn, $sqleventcreator);
          $eventcreatorarray = mysqli_fetch_array($geteventcreator);
          $image = $eventcreatorarray["profile_image"];
          $ratingevent = $eventcreatorarray["rating"];
          //Main Declaration
          echo "<div class=\"logo_box\">";
          // Image Display
          echo "<img src=\"uploaded/" . $image . "\">";
          echo "<div class=\"df\">";
          //Rating
          echo "<div class=\"box_rating\"> . $ratingEvent . </div>";
          //PEPOPLE count >:(
          echo "<div class=\"pepople_rating\">";
          echo "<img src=\"Images/people.png\">";
          echo $count . "/" . $rowEvents["volunteersRequired"];
          echo "</div></div>";
          //Date and Time
          echo "<div class=\"date\">";
          echo "<span>" . $rowEvents["startDate"] . " - " . $rowEvents["endDate"] . "</span><span>" . $rowEvents["startTime"] . " - " . $rowEvents["endTime"] . "</span>";
          echo "</div></div>";
        }
      } else {
        echo "<h2 class=\"bookmarkedEvents\">Empty, You have no bookmarked events</h2>";
      }
      ?>
    </div>

    <!--CALENDAR-->

    <div class="first_box mt_4">
      <h1 class="heading">Calendar</h1>
    </div>
  </div>

  <div id="calendarBox" style="display: block;">
    <div id="calendarContainer">
      <div id="BGBox">.</div>
      <div id="calendar"></div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>
  <script src="evo-calendar.js"></script>

  <script>
    $("#calendar").evoCalendar
      (
        {
          sidebarDisplayDefault: false,
          todayHighlight: true,
          eventDisplayDefault: false,
          firstDayOfWeek: 1,
        }
      );
    var passedArray = <?php echo json_encode($eventIDs); ?>;
    var TitlesArr = <?php echo json_encode($Titles); ?>;
    var LocationsArr = <?php echo json_encode($Locations); ?>;
    var StartTimesArr = <?php echo json_encode($StartTimes); ?>;
    var EndTimesArr = <?php echo json_encode($EndTimes); ?>;
    var StartDatesArr = <?php echo json_encode($StartDates); ?>;
    var EndDatesArr = <?php echo json_encode($EndDates); ?>;
    var OrgNamesArr = <?php echo json_encode($OrgNames); ?>;

    for (var i = 0; i < passedArray.length; i++) {
      if (OrgNamesArr[i] != null)
      {
        var orgName = OrgNamesArr[i].replace(/@.*$/, "");
      }
      else
      {
        var orgName = OrgNamesArr[i];
      }
      var dateObject = new Date(StartDatesArr[i]);
      dateObject.setDate(dateObject.getDate() + 1);
      var ActualStartDate = dateObject.toISOString().slice(0, 10);
      var dateObject2 = new Date(EndDatesArr[i]);
      dateObject2.setDate(dateObject2.getDate() + 1);
      var ActualEndDate = dateObject2.toISOString().slice(0, 10);

      var eventID = String(i + 1).padStart(7, '0');
      var eventDesc = "You have an event with " + orgName + ". Starts at " + StartTimesArr[i] + " and ends at " + EndTimesArr[i] + " At " + LocationsArr[i];

      $("#calendar").evoCalendar('addCalendarEvent', [{
        id: eventID,
        name: TitlesArr[i],
        date: [ActualStartDate, ActualEndDate],
        description: eventDesc,
        color: 'blue',
        type: 'event'
      }]);
    }

  </script>

  <!--CALENDAR-->
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