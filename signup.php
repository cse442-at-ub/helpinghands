<?php

require 'connect.php'; // Connecting to database

session_start(); // Creating session

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


        $sql = "INSERT INTO accounts (userID, email, password, userType) VALUES (?, ? , ?, ?)"; // preparing SQL statement
        $stmt = $conn->prepare($sql);

        $userID = newID($conn); // Generating a random, unique user ID

        $stmt->bind_param('isss', $userID, $email, $hash, $userType); // Binding variables to strings and an int to prevent SQL injection


        if($stmt->execute()){ // Checks if data was inserted into database by checking if the mysqli_result object is true
            
            // Setting the session variables
            $_SESSION['userID'] = $userID;
            $_SESSION['email'] = $email;
            $_SESSION['userType'] = $userType;

            header("Location: homepage.php"); // Redirect to homepage
            exit(); // Making sure script stops executing after redirect
        } else {
            echo "Error: " . $conn->error; // Displays error type
        }

    }

}

// Creating random + unique user IDs
function newID($conn){
    for($i = 0; $i < 5; $i++){ // Will try at most 5 times

        $randomID = rand(10000,99999); // Genereating a random 5 digit number

        // Checking if radnomID already exists in the table
        $stmt = $conn->prepare('SELECT * FROM accounts WHERE userID = ?');
        $stmt->bind_param('i', $randomID);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 0){ // If randomID isn't in the table, return it
            return $randomID;
        }
    }
}


?>