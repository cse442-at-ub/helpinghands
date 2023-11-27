<?php


require 'connect.php'; // Connecting to database
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $volunteerId = $_POST['volunteer_id'];
    $eventId = $_POST['event_id'];

    // Retrieve event times from the events table
    $query = "SELECT start_time, end_time FROM events WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();

    // Calculate hours
    $startTime = new DateTime($event['start_time']);
    $endTime = new DateTime($event['end_time']);
    $interval = $startTime->diff($endTime);
    $hours = $interval->h + ($interval->days * 24); // assuming no event lasts more than 24 hours

    // Insert into registered_events
    $insertQuery = "INSERT INTO registered_events (volunteer_id, event_id, start_time, end_time, hours) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iissi", $volunteerId, $eventId, $event['start_time'], $event['end_time'], $hours);
    $insertStmt->execute();
}


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

?>