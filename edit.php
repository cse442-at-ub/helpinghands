<?php
require 'connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$email = $_SESSION['email'];
$userType = $_SESSION['userType'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = mysqli_real_escape_string($conn, $_POST['profile-name']);

  $sql = "UPDATE accounts SET name = '$name' WHERE email = '$email'";

  if ($conn->query($sql) === TRUE) {
    if ($userType === 'volunteer') {
      header("Location: volunteerprofilepage.php");
    }
    else {
      header("Location: organisationprofilepage.php");
    }
  } else {
      echo "Error updating record: " . $conn->error;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $desc = mysqli_real_escape_string($conn, $_POST['edit-description']);

  $sql = "UPDATE accounts SET description = '$desc' WHERE email = '$email'";

  if ($conn->query($sql) === TRUE) {
    if ($userType === 'volunteer') {
      header("Location: volunteerprofilepage.php");
    }
    else {
      header("Location: organisationprofilepage.php");
    }
    
  } else {
      echo "Error updating record: " . $conn->error;
  }
}

if ($_FILES['imgInp']['error'] === UPLOAD_ERR_OK) {
  $file_name = basename($_FILES["imgInp"]["name"]);
  $target_dir = "uploaded/";
  $target_file = $target_dir . $file_name;

  if (move_uploaded_file($_FILES["imgInp"]["tmp_name"], $target_file)) {
    $sql = "UPDATE accounts SET profile_image = '$file_name' WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
      if ($userType === 'volunteer') {
        header("Location: volunteerprofilepage.php");
      }
      else {
        header("Location: organisationprofilepage.php");
      }
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>

