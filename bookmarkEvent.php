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