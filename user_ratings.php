<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Volunteer Rating</title>
    <link rel="stylesheet" href="css/ratings.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <a href="organisationprofilepage.php" id="back-button">&lt; Back</a>
    
    <?php
    if (isset($_SESSION['rating_submission_status']) && $_SESSION['rating_submission_status'] === 'failure') {
        echo '<p style="color: red;">Error: You already rated this volunteer.</p>';
        
        // Unset the session variable to clear the status
        unset($_SESSION['rating_submission_status']);
    }

    if (isset($_SESSION['rating_validation_status']) && $_SESSION['rating_validation_status'] === 'failure') {
        echo '<p style="color: red;">Error: Rating must be a number between 1 and 5.</p>';
    
        // Unset the session variable to clear the status
        unset($_SESSION['rating_validation_status']);
    }

    if (isset($_SESSION['rater_email_status']) && $_SESSION['rater_email_status'] === 'failure') {
        echo '<p style="color: red;">Error: you cannot rate yourself.</p>';
    
        // Unset the session variable to clear the status
        unset($_SESSION['rater_email_status']);
    }

    // Check the session variable for the rating submission status
    if (isset($_SESSION['rating_submission_status'])) {
        if ($_SESSION['rating_submission_status'] === 'failure') {
            echo '<p style="color: red;">Error: Volunteer email not found.</p>';
        } elseif ($_SESSION['rating_submission_status'] === 'success') {
            echo '<p style="color: green;">Rating submitted successfully!</p>';
        }

        // Unset the session variable to clear the status
        unset($_SESSION['rating_submission_status']);
    }
    ?>

    <form id="ratings-form" action="ratings.php" method="POST" enctype="multipart/form-data">
        <label for="rating-email">Volunteer Email:</label>
        <input type="text" id="rating-email" name="rating-email" placeholder="Enter volunteer email">

        <label for="quantity">Rating (between 1 and 5):</label>
        <input type="number" id="quantity" name="quantity" min="1" max="5">
        <input type="submit" value="Submit">
    </form>

    <div id="rubric">
        <div class="rubric-item">
            <h3>1 - Poor performance</h3>
            <ul>
                <li>Needs significant improvement</li>
                <li>Consistently falls short of expectations</li>
            </ul>
        </div>

        <div class="rubric-item">
            <h3>2 - Below average</h3>
            <ul>
                <li>Meets some expectations but needs improvement</li>
                <li>Shows inconsistency in performance</li>
            </ul>
        </div>

        <div class="rubric-item">
            <h3>3 - Average performance</h3>
            <ul>
                <li>Meets basic expectations</li>
                <li>Consistently performs at an acceptable level</li>
            </ul>
        </div>

        <div class="rubric-item">
            <h3>4 - Above average</h3>
            <ul>
                <li>Exceeds expectations in some areas</li>
                <li>Consistently performs at a high level</li>
            </ul>
        </div>

        <div class="rubric-item">
            <h3>5 - Excellent performance</h3>
            <ul>
                <li>Consistently exceeds expectations</li>
                <li>Demonstrates exceptional skills and performance</li>
            </ul>
        </div>
    </div>

</body>

</html>
