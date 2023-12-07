<?php


require 'connect.php'; // Connecting to database
session_start();



// Check if username and eventID are given using the POST method
if (isset($_POST['user']) && isset($_POST['eventID'])) {
    $user = $_POST["user"];
    $eventID = $_POST["eventID"];
    
    try {
        // Check if the event is already full
        $stmt = mysqli_query($conn, "SELECT events.eventID, events.volunteersRequired, count(eg.eventID) as total_reg FROM `events` left JOIN eventRegistrations eg on eg.eventID = events.eventID WHERE events.eventID=$eventID GROUP BY events.eventID;");
        $eventData = $stmt->fetch_assoc();
      
        if ($eventData['volunteersRequired'] == $eventData['total_reg']) {
            $_SESSION['flash'] = "Event is already full";
            header('location:homepage.php');
            exit;
        }
         // Check if the user is already registered
        $stmt = mysqli_query($conn, "SELECT * FROM eventRegistrations WHERE user = '$user' AND eventID = $eventID");
        if (mysqli_num_rows($stmt)) {
            $_SESSION['flash'] = "You are already registered for this event.";
            header('location:homepage.php');
            exit;
        }

        // Register the user for the event
        $stmt = $conn->prepare("INSERT INTO eventRegistrations (user, eventID) VALUES (? , ?)");
        $stmt->bind_param('ss', $user, $eventID);
        $stmt->execute();

        $_SESSION['flash'] = "You have successfully registered for the event.";
        header('location:homepage.php');

    } catch(PDOException $error) {
        $_SESSION['flash'] = "Error: " . $error->getMessage(); // echos error message
        header('location:homepage.php');
    }
}

$event_id = $_POST['event_id'];
$volunteer_id = $_POST['volunteer_id'];

// Fetch event start and end time
$query = "SELECT startTime, endTime FROM events WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
$stmt->close();

// Calculate hours volunteered
$startTime = new DateTime($event['startTime']);
$endTime = new DateTime($event['endTime']);
$interval = $startTime->diff($endTime);
$hours_volunteered = $interval->h + ($interval->i / 60);

// Insert volunteer hours into the database
$insertQuery = "INSERT INTO VolunteerHours (volunteer_id, event_id, hours_volunteered) VALUES (?, ?, ?)";
$insertStmt = $conn->prepare($insertQuery);
$insertStmt->bind_param("iid", $volunteer_id, $event_id, $hours_volunteered);
$insertStmt->execute();
$insertStmt->close();

// Redirect to a confirmation page or back to the homepage
header("Location: homepage.php");
exit();


?>