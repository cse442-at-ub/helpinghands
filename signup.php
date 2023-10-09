<?php

require 'connect.php'; // Connecting to database


// Check if username, password, and user type are given using the POST method
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    if ($userType === 'volunteer'){
        $sql = "INSERT INTO volunteers (username, password) VALUES ('$username' , '$password')";
        if($conn->query($sql) === TRUE){ // Checks if data was inserted into database by checking if the mysqli_result object is true
            echo "New record created successfully";
        } else {
            echo "Error";
         }
    } else if ($userType === 'organization'){
        $sql = "INSERT INTO organizations (username, password) VALUES ('$username' , '$password')";
        if($conn->query($sql) === TRUE){ // Checks if data was inserted into database by checking if the mysqli_result object is true
            echo "New record created successfully";
        } else {
            echo "Error";
         }
    }


}


?>