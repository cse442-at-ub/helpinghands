<?php
require('connect.php');
session_start();

$event_id = isset($_GET['eventID']) ? intval($_GET['eventID']) : 0;

$query = "SELECT username FROM events WHERE eventID='$event_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $user = $row['username'];
    }
    else {
        echo "no match";
    }

    mysqli_free_result($result);
}

if (isset($_POST['edit-event'])) {
    if ($user != $_SESSION['email']) {
        header("Location: signin.html");
        exit();
    }
    $continue = 1;
    $title = $_POST['title'];
    $location = $_POST['location'];
    $start_date = $_POST['startdate'];
    $end_date = $_POST['enddate'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $event_type = $_POST['event_type'];
    $categories = $_POST['categories'];
    $description = $_POST['description'];
    $volunteers = $_POST['total_volunteers'];
    $age = $_POST['age_range'];
    $cut_of_date = $_POST['last_date'];
    if (empty($title)) {
        $continue = 0;
        $errors .= 'Title Required. ';
    }
    if (empty($location)) {
        $continue = 0;
        $errors .= 'Location Required. ';
    }
    if (empty($start_date)) {
        $continue = 0;
        $errors .= 'Start Date Required. ';
    }
    if (empty($end_date)) {
        $continue = 0;
        $errors .= 'End Date Required. ';
    }
    if (empty($start_time)) {
        $continue = 0;
        $errors .= 'Start Time Required. ';
    }
    if (empty($end_time)) {
        $continue = 0;
        $errors .= 'End Time Required. ';
    }
    if (empty($event_type)) {
        $continue = 0;
        $errors .= 'Event Type Required. ';
    }
    if (empty($categories)) {
        $continue = 0;
        $errors .= 'Categories Required. ';
    }
    if (empty($description)) {
        $continue = 0;
        $errors .= 'Description Required. ';
    }
    if (empty($volunteers)) {
        $continue = 0;
        $errors .= 'Volunters Required. ';
    }
    if (empty($cut_of_date)) {
        $continue = 0;
        $errors .= 'Cut Of Date Required. ';
    }
    if (empty($age)) {
        $continue = 0;
        $errors .= 'Age Range Required. ';
    }
    if (!empty($_FILES["image_input"]["tmp_name"])) {
        if (is_uploaded_file($_FILES['image_input']['tmp_name'])) {
            $dir = "uploaded/";
            $image_file = $dir . basename($_FILES["image_input"]["name"]);
            $file_type = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));
      
            $check = getimagesize($_FILES["image_input"]["tmp_name"]);
            if ($check !== false) {
               $continue = 1;
            } else {
               $continue = 0;
               $errors .= 'File is not a image. ';
            }
      
            //check the size of the image (change value "50000" to change file size)
            if ($_FILES["image_input"]["size"] > 500000) {
               $continue = 0;
               $errors .= " error: file too large";
            }
      
            //check to see if the file is a valid type
            if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif") {
               $continue = 0;
               $errors .= " error: invalid file type";
            }
            if ($continue === 1) {
                move_uploaded_file($_FILES["image_input"]["tmp_name"], $image_file);
            }
        }
    }

    if ($continue == 1) {
        $sql = "UPDATE events SET titles=?, location=?, startTime=?, endTime=?, startDate=?, endDate=?, description=?, volunteersRequired=?, cutoffDate=?, age=?, username=?, categories=?, type=?";
        $params = 'sssssssisisss';

        // Check if an image is uploaded
        if (!empty($_FILES["image_input"]["tmp_name"])) {
            $sql .= ', image=?';
            $params .= 's';
        }

        $sql .= ' WHERE eventID=?';
        $params .= 'i';

        $res = $conn->prepare($sql);
    
        // Create an array of parameters dynamically
        $paramArray = [&$params, &$title, &$location, &$start_time, &$end_time, &$start_date, &$end_date, &$description, &$volunteers, &$cut_of_date, &$age, &$_SESSION['email'], &$categories, &$event_type];

        // Check if an image is uploaded, and if so, add it to the parameter array
        if (!empty($_FILES["image_input"]["tmp_name"])) {
            $image_file = "uploaded/" . basename($_FILES["image_input"]["name"]);
            $paramArray[] = &$image_file;
        }

        // Add eventID to the parameter array
        $paramArray[] = &$event_id;

        // Bind parameters
        call_user_func_array([$res, 'bind_param'], $paramArray);

        // Execute the query
        $res->execute();
        $res->close();

        header("Location: eventslist.php");
    } else {
        $error_message = addslashes($errors);
        $redirect_url = "editeventlisting.php?eventID=$event_id&error_message=$error_message";
        echo "<script>window.location.href = '$redirect_url';</script>";
        exit();
    }
}
?>