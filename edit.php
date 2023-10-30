<?php
require 'connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
//$userType = $_SESSION['userType'];
$username = $_SESSION['username'];

if ($_FILES['imgInp']['error'] === UPLOAD_ERR_OK) {
  $file_name = basename($_FILES["imgInp"]["name"]);
  $target_dir = "uploaded/";
  $target_file = $target_dir . $file_name;

  if (move_uploaded_file($_FILES["imgInp"]["tmp_name"], $target_file)) {
    $sql = "UPDATE volunteers SET profile_image = '$file_name' WHERE username = '$username'";

    if ($conn->query($sql) === TRUE) {
      header("Location: volunteerprofilepage.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>

