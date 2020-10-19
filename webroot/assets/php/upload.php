<?php
unset($_POST['submit']);
$jfile = dirname(__FILE__).'/../data.json';
file_put_contents($jfile, json_encode($_POST));
$target_dir = "assets/img/";
$cover_img = $target_dir . basename($_FILES["cover_img"]["name"]);
$profile_img = $target_dir . basename($_FILES["profile_img"]["name"]);
$uploadOk = 1;
$imageFileType1 = strtolower(pathinfo($cover_img,PATHINFO_EXTENSION));
$imageFileType2 = strtolower(pathinfo($profile_img,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check1 = getimagesize($_FILES["cover_img"]["tmp_name"]);
  $check1 = getimagesize($_FILES["profile_img"]["tmp_name"]);
  if($check1 !== false || $check2 !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($cover_img) || file_exists($profile_img)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["cover_img"]["size"] > 500000 || $_FILES["profile_img"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" && $imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg" && $imageFileType2 != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
// set path to file
  if (move_uploaded_file($_FILES["cover_img"]["tmp_name"], "../img/cvr_img." . $imageFileType1) && move_uploaded_file($_FILES["profile_img"]["tmp_name"], "../img/pro_pic." . $imageFileType2)) {
    echo "The files ". htmlspecialchars( basename( $_FILES["cover_img"]["name"])) ." and ". htmlspecialchars( basename( $_FILES["profile_img"]["name"])) ." have been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
