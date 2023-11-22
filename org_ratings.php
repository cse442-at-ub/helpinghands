<?php
session_start();
// connect to database
require 'connect.php';


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get the userID of the user logged in
$rater_email = $_SESSION['email'];

// Get user input from the form
$email = $_POST['rating-email'];
$rating = $_POST['quantity'];

$idQuery = "SELECT userID FROM accounts WHERE email = '$rater_email'";
$idResult = $conn->query($idQuery);

if ($idResult->num_rows > 0) {
    // Get the rater's userID
    $raterIdResult = $conn->query($idQuery);
    $rater_userID = $raterIdResult->fetch_assoc()['userID'];
}

// Check if the user already exists in the accounts table
$userQuery = "SELECT userID FROM accounts WHERE email = '$email'";
$userResult = $conn->query($userQuery);

if ($userResult->num_rows > 0) {
    // Get the user ID
    $userIdResult = $conn->query($userQuery);
    $userId = $userIdResult->fetch_assoc()['userID'];
}

if (empty($rating)) {
    // Set session variable to indicate rating validation failure
    $_SESSION['rating_validation_status'] = 'failure';
    
    // Redirect back to organization_ratings.php
    header("Location: organization_ratings.php");
    exit();
}

if ($rater_email === $email) {
    $_SESSION['rater_email_status'] = 'failure';

    header("Location: organization_ratings.php");
    exit();
}

// Check if the user already rated the target user
$checkRatingQuery = "SELECT * FROM ratings WHERE rater_id = ? AND user_id = ?";
$stmtCheck = $conn->prepare($checkRatingQuery);
$stmtCheck->bind_param("ss", $rater_userID, $userId);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    // Set session variable to indicate failure (user already rated)
    $_SESSION['rating_submission_status'] = 'failure';
} 
else {
    // Check if the user already exists in the accounts table
    $userQuery = "SELECT userID FROM accounts WHERE email = '$email'";
    $userResult = $conn->query($userQuery);

    if ($userResult->num_rows > 0) {
        // Get the user ID
        $userIdResult = $conn->query($userQuery);
        $userId = $userIdResult->fetch_assoc()['userID'];
        // Insert the rating into the ratings table
        $insertRatingQuery = "INSERT INTO ratings (user_id, rating, rater_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertRatingQuery);
        $stmt->bind_param("iii", $userId, $rating, $rater_userID);
        $stmt->execute();

        // Calculate and update the average rating in the accounts table
        $updateAverageQuery = "UPDATE accounts SET rating = (SELECT AVG(rating) FROM ratings WHERE user_id = '$userId') WHERE userID = '$userId'";
        $conn->query($updateAverageQuery);

        // Set session variable to indicate success
        $_SESSION['rating_submission_status'] = 'success';
    }   
    else {
        // Set session variable to indicate failure
        $_SESSION['rating_submission_status'] = 'failure';
    }
}

// Close the database connection
$conn->close();

// Redirect
header("Location: organization_ratings.php");
exit();
?>