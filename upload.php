<?php
$dir = "uploaded/";
$image_file = $dir . basename($_FILES["image-input"]["name"]);
$file_type = strtolower(pathinfo($image_file,PATHINFO_EXTENSION));
$continue = 1;

//check to see if image file valid
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["image-input"]["tmp_name"]);
  if($check !== false) {
    $continue = 1;
  } else {
    $continue = 0;
    echo "file is not an image";
  }
}

//check to see if file already exists in directory
if (file_exists($image_file)) {
  $continue = 0;
  echo " error: file already exists";
}

//check the size of the image (change value "50000" to change file size)
if ($_FILES["image-input"]["size"] > 500000) {
  $continue = 0;
  echo " error: file too large";
}

//check to see if the file is a valid type
if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ) {
  $continue = 0;
  echo " error: invalid file type";
}

if ($continue == 0) {
  echo " error: file not uploaded ";
// if all tests pass, try to upload the file
} else {
  if (move_uploaded_file($_FILES["image-input"]["tmp_name"], $image_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["image-input"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
