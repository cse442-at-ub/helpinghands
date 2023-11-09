<?php

require 'connect.php'; // Connecting to database


// Check if email, password, and user type are given using the POST method
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['userType'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];


    // Checking if email is already in the database
    $stmt = $conn->prepare('SELECT * FROM accounts WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { // If the email already exists in the database

        echo "This email already belongs to an account"; // Retruns error message

    } else { // Otherwise, create account

        $hash = password_hash($password, PASSWORD_DEFAULT); // Hashing the password


        $sql = "INSERT INTO accounts (email, password, userType) VALUES (? , ?, ?)"; // preparing SQL statement
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('sss', $email, $hash, $userType); // Binding variables to strings to prevent SQL injection


        if($stmt->execute()){ // Checks if data was inserted into database by checking if the mysqli_result object is true
            echo "New record created successfully";
        } else {
            echo "Error: " . $conn->error; // Displays error type
        }

    }

}


?>