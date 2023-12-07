<?php


require 'connect.php'; // Connecting to database



// Check if username and eventID are given using the POST method
if (isset($_POST['user']) && isset($_POST['eventID'])) {
    $user = $_POST["user"];
    $eventID = $_POST["eventID"];

    // Check if the user is already registered
    $stmt = $conn->prepare("SELECT * FROM bookmarkedEvents WHERE user = ? AND eventID = ?");
    $stmt->bind_param("si", $user, $eventID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "You already bookmarked this event.";
        exit;
    }
/*
    // Check if the event has room for the new volunteer

    // Getting the current number of registered volunteers
    $stmt = $conn->prepare("SELECT * FROM eventRegistrations WHERE eventID = ?");
    $stmt->bind_param("i", $eventID);
    $stmt->execute();
    $result = $stmt->get_result();
    $numRegistrations = $result->num_rows; // Stores the current number of registrations for the event

    // Getting the max number of volunteers
    $stmt = $conn->prepare("SELECT volunteersRequired FROM events WHERE eventID = ?");
    $stmt->bind_param("i", $eventID);
    $stmt->execute();
    $result = $stmt->get_result();
    $maxVolunteersRow = $result->fetch_assoc();
    $maxVolunteers = $maxVolunteersRow['volunteersRequired'];

    // Comparing
    if ($numRegistrations >= $maxVolunteers) {
        echo "Unfortunately, the maxinmum number of volunteers has been reached for this event";
        exit;
    }
*/


    // Register the user for the event
    $stmt = $conn->prepare("INSERT INTO bookmarkedEvents (user, eventID) VALUES (? , ?)"); // Preparing SQL statement to prevent SQL injection
    $stmt->bind_param("si", $user, $eventID);

    // Error handling
    if(!$stmt->execute()){
        echo "Error: " . $stmt->error; // echoes error message
        exit;
    }

    echo "You have successfully bookmarked the event.";

}

?>