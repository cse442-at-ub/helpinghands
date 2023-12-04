<?php

require 'connect.php'; // Connecting to database

session_start();

if(isset($_SESSION['userID']) && isset($_POST['notificationID'])){ // Checking if user is logged in and if notificationID is sent via POST
    $userID = $_SESSION['userID'];
    $notificationID = $_POST['notificationID'];

    $stmt = $conn->prepare("UPDATE notifications set isRead = TRUE WHERE notificationID = ? AND userID = ?"); // Updating the table
    $stmt->bind_param('ii', $notificationID, $userID);
    $stmt->execute();

}

?>