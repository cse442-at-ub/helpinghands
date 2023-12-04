<?php

require 'connect.php'; // Connecting to database

session_start();


if(isset($_SESSION['userID'])){ // Checking for a user to be logged in

    // Setting up the SQL query
    $userID = $_SESSION['userID'];
    $isRead = false;
    $stmt = $conn->prepare("SELECT * FROM notifications WHERE userID = ? AND isRead = ?");
    $stmt->bind_param('ii', $userID, $isRead); // booleans in MySQL are actually really small integers, so $isRead is bound as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = $result->fetch_all(MYSQLI_ASSOC); // Fetching all of the notifications

    echo json_encode($notifications); // Returns the notificaitons as JSON

}



?>