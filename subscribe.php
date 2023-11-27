<?php

require 'connect.php'; // Connecting to database


// Check if userID and organizationID are given using the POST method
if(isset($_POST['userID']) && isset($_POST['organizationID'])){
    $userID = $_POST['userID'];
    $organizationID = $_POST['organizationID'];

    // Checking if subscription already exists
    $stmt = $conn->prepare('SELECT * FROM subscriptions WHERE userID = ? AND organizationID = ?');
    $stmt->bind_param('ii', $userID, $organizationID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0){ // If subscription exists, unsubscribe
        $deleteStmt = $conn->prepare('DELETE FROM subscriptions WHERE userID = ? AND organizationID = ?');
        $deleteStmt->bind_param('ii', $userID, $organizationID);
        $deleteStmt->execute();

        echo "unsubscribed successfully";
    } else { // If subscription doesn't exist, subscribe
        $insertStmt = $conn->prepare('INSERT INTO subscriptions (userID, organizationID) VALUES (?, ?)');
        $insertStmt->bind_param('ii', $userID, $organizationID);
        $insertStmt->execute();

        echo "subscribed successfully";
    }
}


?>