<?php


require 'connect.php'; // Connecting to database



// Check if username and eventID are given using the POST method
if (isset($_POST['user']) && isset($_POST['eventID'])) {
    $user = $_POST["user"];
    $eventID = $_POST["eventID"];
    
    try {
        // Check if the user is already registered
        $stmt = $conn->prepare("SELECT * FROM bookmarkedEvents WHERE user = ? AND eventID = ?");
        $stmt->bind_param("si", $user, $eventID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "You are already bookmarked this event.";
            exit;
        }

        // Bookmark the event for the user
        $stmt = $conn->prepare("INSERT INTO bookmarkedEvents (user, eventID) VALUES (? , ?)");
        $stmt->execute([$user, $eventID]);

        echo "You have successfully registered for the event.";

    } catch(PDOException $error) {
        echo "Error: " . $error->getMessage(); // echos error message
    }
}

?>