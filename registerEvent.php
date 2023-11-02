<?php


require 'connect.php'; // Connecting to database



// Check if username and eventID are given using the POST method
if (isset($_POST['user']) && isset($_POST['eventID'])) {
    $user = $_POST["user"];
    $eventID = $_POST["eventID"];
    
    try {
        // Check if the user is already registered
        $stmt = $conn->prepare("SELECT * FROM eventRegistrations WHERE user = ? AND eventID = ?");
        $stmt->execute([$user, $eventID]);

        if ($stmt->rowCount() > 0) {
            echo "You are already registered for this event.";
            exit;
        }

        // Register the user for the event
        $stmt = $conn->prepare("INSERT INTO eventRegistrations (user, eventID) VALUES (? , ?)");
        $stmt->execute([$user, $eventID]);

        echo "You have successfully registered for the event.";

    } catch(PDOException $error) {
        echo "Error: " . $error->getMessage(); // echos error message
    }
}

?>