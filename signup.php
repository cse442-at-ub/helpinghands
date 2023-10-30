<?php

require 'connect.php'; // Connecting to database


// Check if username, password, and user type are given using the POST method
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    $hash = password_hash($password, PASSWORD_DEFAULT); // Hashing the password


    if ($userType === 'volunteer'){
        $sql = "INSERT INTO volunteers (username, password) VALUES ('$username' , '$hash')";
        if($conn->query($sql) === TRUE){ // Checks if data was inserted into database by checking if the mysqli_result object is true
            header("Location: volunteeredit.php");
        } else {
            echo "Error: " . $conn->error; // Displays error type
         }
    } else if ($userType === 'organization'){
        $sql = "INSERT INTO organizations (username, password) VALUES ('$username' , '$hash')";
        if($conn->query($sql) === TRUE){ // Checks if data was inserted into database by checking if the mysqli_result object is true
            header("Location: volunteeredit.php");
        } else {
            echo "Error: " . $conn->error; // Displays error type
         }
    }


}


?>