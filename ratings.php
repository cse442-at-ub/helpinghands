<?php
// connect to database
require 'connect.php';


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from the form
$email = $_POST['rating-email'];
$rating = $_POST['quantity'];

// Check if the user already exists in the accounts table
$userQuery = "SELECT userID FROM accounts WHERE email = '$email'";
$userResult = $conn->query($userQuery);

// Get the user ID
$userIdResult = $conn->query($userQuery);
$userId = $userIdResult->fetch_assoc()['userID'];

// Insert the rating into the ratings table
$insertRatingQuery = "INSERT INTO ratings (user_id, rating) VALUES (?, ?)";
$stmt = $conn->prepare($insertRatingQuery);
$stmt->bind_param("ii", $userId, $rating);
$stmt->execute();


// Calculate and update the average rating in the accounts table
$updateAverageQuery = "UPDATE accounts SET rating = (SELECT AVG(rating) FROM ratings WHERE user_id = '$userId') WHERE userID = '$userId'";
$conn->query($updateAverageQuery);

// Close the database connection
$conn->close();

// Redirect
header("Location: ratings.html");
exit();
?>