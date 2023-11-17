<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Organization Rating</title>
    <link rel="stylesheet" href="css/ratings.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <a href="volunteerprofilepage.php" id="back-button">&lt; Back</a>
    
    <?php
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

    <form id="ratings-form" action="org_ratings.php" method="POST" enctype="multipart/form-data">
        <label for="rating-email">Organization Email:</label>
        <input type="text" id="rating-email" name="rating-email" placeholder="Enter volunteer email">

        <label for="quantity">Rating (between 1 and 5):</label>
        <input type="number" id="quantity" name="quantity" min="1" max="5">
        <input type="submit" value="Submit">
    </form>

    <div id="rubric">
    <div class="rubric-item">
        <h3>1 - Unsatisfactory Experience</h3>
        <ul>
            <li>Significant room for improvement in the volunteer experience</li>
            <li>Organization consistently falls short of expectations</li>
        </ul>
    </div>

    <div class="rubric-item">
        <h3>2 - Below Average Experience</h3>
        <ul>
            <li>Meets some expectations but requires notable improvement</li>
            <li>Shows inconsistency in providing a positive volunteering experience</li>
        </ul>
    </div>

    <div class="rubric-item">
        <h3>3 - Average Experience</h3>
        <ul>
            <li>Meets basic expectations for a volunteer experience</li>
            <li>Consistently provides an acceptable level of support and engagement</li>
        </ul>
    </div>

    <div class="rubric-item">
        <h3>4 - Above Average Experience</h3>
        <ul>
            <li>Exceeds expectations in some aspects of the volunteer experience</li>
            <li>Consistently provides a high level of support and engagement</li>
        </ul>
    </div>

    <div class="rubric-item">
        <h3>5 - Outstanding Experience</h3>
        <ul>
            <li>Consistently exceeds expectations in every aspect</li>
            <li>Demonstrates exceptional commitment to volunteers and their impact</li>
        </ul>
    </div>
</div>

</body>

</html>
