<?php

require 'connect.php'; // Connecting to database

session_start(); // Creating session

// Check if username, password, and user type are given using the POST method
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];


    // Check if the credentials are in the table, $stmt is used to store the prepared statement
   
    // Username

    // Check the user type
    if ($userType === 'volunteer') {

        $stmt = $conn->prepare("SELECT * FROM volunteers WHERE username = ?"); // Prepares SQL for a statement, the ? is the placeholder for the username

    } elseif ($userType === 'organization') {

        $stmt = $conn->prepare("SELECT * FROM organizations WHERE username = ?"); // Prepares SQL for a statement, the ? is the placeholder for the username

    } else {
        echo "Invalid user type";
    }
    

    $stmt->bind_param('s', $username); // binding the username variable to the statement as a string, this prevents SQL injection

    $stmt->execute(); // Executes the now prepared statement

    $result = $stmt->get_result(); // Stores result of the exectued statement


    // Password

    // Check the user type
    if($userType === 'volunteer'){
        if ($volunteer = $result->fetch_assoc()) { // If result is a row from the table, it is stored in $volunteer
                // Verifying the password in the row that was fetched
                if (password_verify($password, $volunteer['password'])) { 

                    // Storing username and userType in session
                    $_SESSION['username'] = $username;
                    $_SESSION['userType'] = $userType;
                    echo $_SESSION['userType'] . " " . $_SESSION['username'] . " logged in successfully";
                }
        }

        else{ // If the credentials arent in the table
            echo "Incorrect username or password";
        }
    }

    elseif($userType === 'organization'){
        if($organization = $result->fetch_assoc()) {  // If result is a row from the table, it is stored in $organization
            // Verifying the password in the row that was fetched
            if (password_verify($password, $organization['password'])) { 

                // Storing username and userType in session
                $_SESSION['username'] = $username;
                $_SESSION['userType'] = $userType;
                echo $_SESSION['userType'] . " " . $_SESSION['username'] . " logged in successfully";
            }
        }

        else{ // If the credentials arent in the table
            echo "Incorrect username or password";
        }
    }

    else {
        echo "Invalid user type";
    }

/*
    $stmt->close();
    $conn->close();
    */
}

// session_destroy(); // destroys session and clears all session data


?>