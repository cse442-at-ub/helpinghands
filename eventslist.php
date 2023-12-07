<?php
require('connect.php');
session_start();

if (!isset($_SESSION['email']) || $_SESSION['userType'] != 'organization') {
    header('location: signin.html');
}

$email = $_SESSION['email'];

// Fetch events for the user
$sql = "SELECT eventID, titles FROM events WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

$events = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter">
    <link rel="stylesheet" href="css/eventslist.css">
    <title>My Events</title>
</head>

<body>
    <div class="header">
        <a class="back-button" href="organisationprofilepage.php">< Back</a>
    </div>
    <h2>My Events</h2>

    <div class="event-container">
        <?php foreach ($events as $event) : ?>
            <div class="event-card">
                <p class="event-title"><?php echo htmlspecialchars($event['titles']); ?></p>
                <a class="edit-link" href="editeventlisting.php?eventID=<?php echo $event['eventID']; ?>">Edit</a>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>