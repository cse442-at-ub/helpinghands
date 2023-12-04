<?php

require 'connect.php'; // Connecting to database

session_start();

$data = json_decode(file_get_contents('php://input'), true); // Receiving data from JSON POST body

if(isset($_SESSION['userID']) && isset($data['notificationID'])){ // Checking if user is logged in and if notificationID is sent via POST
    $userID = $_SESSION['userID'];
    $notificationID = $data['notificationID'];

    $stmt = $conn->prepare("UPDATE notifications set isRead = TRUE WHERE notificationID = ? AND userID = ?"); // Updating the table
    $stmt->bind_param('ii', $notificationID, $userID);
    $stmt->execute();

}

?>