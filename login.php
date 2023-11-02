<?php

require 'connect.php'; // Connecting to database

session_start(); // Creating session

// Check if email and password are given using the POST method
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    // Check if the credentials are in the table
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE email = ?"); // Prepares SQL for a statement, the ? is the placeholder for the email

    $stmt->bind_param('s', $email); // binding the username variable to the statement as a string, this prevents SQL injection

    $stmt->execute(); // Executes the now prepared statement

    $result = $stmt->get_result(); // Stores result of the exectued statement

        if ($account = $result->fetch_assoc()) { // If result is a row from the table, it is stored in $account
                // Verifying the password in the row that was fetched
                if (password_verify($password, $account['password'])) { 

                    $userType = $account['userType'];

                    // Storing username and userType in session
                    $_SESSION['email'] = $email;
                    $_SESSION['userType'] = $userType;
                    echo $_SESSION['userType'] . " " . $_SESSION['email'] . " logged in successfully";
                }
        }

        else{ // If the credentials arent in the table
            echo "Incorrect email or password";
        }
/*
    $stmt->close();
    $conn->close();
    */
}

// session_destroy(); // destroys session and clears all session data


?>