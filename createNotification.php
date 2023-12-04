<?php

require 'connect.php'; // Connecting to database

session_start();

if(isset($_SESSION['userID']) && isset($_POST['organizationID']) && isset($_POST['eventID']) && isset($_POST['message'])){ // Checking if user is logged in and params are set
    $userID = $_SESSION['userID'];
    $orgID = $_POST['organizationID'];
    $eventID = $_POST['eventID'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO notifications (userID, organizationID, eventID, message) VALUES (?, ?, ?, ?)"); // Preparing SQL statement
    $stmt->bind_param("iiis", $userID, $orgID, $eventID, $message);

    if($stmt->execute()){
        echo "Notification created successfully";
    } else { // if an error occurs
        echo "Error: " . $conn->error;
    }

}

?>