<?php

$target_dir = "assets/img/";
$cover_img = $target_dir . basename($_FILES["cover_img"]["name"]);
$profile_img = $target_dir . basename($_FILES["profile_img"]["name"]);
$uploadOk = 1;
$imageFileType1 = strtolower(pathinfo($cover_img,PATHINFO_EXTENSION));
$imageFileType2 = strtolower(pathinfo($profile_img,PATHINFO_EXTENSION));

// getimagesize will confirm the file is an actual image 
if(isset($_POST["submit"])) {
  $check1 = getimagesize($_FILES["cover_img"]["tmp_name"]);
  $check2 = getimagesize($_FILES["profile_img"]["tmp_name"]);
  if($check1 !== false || $check2 !== false) {
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
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

// if everything is ok, try to upload file
if ($uploadOk == 1) {
// set path to file
  if (move_uploaded_file($_FILES["cover_img"]["tmp_name"], "../img/cvr_img." . $imageFileType1) && move_uploaded_file($_FILES["profile_img"]["tmp_name"], "../img/pro_pic." . $imageFileType2)) {

    // store json, future ajax api call
    unset($_POST['submit']);
    $_POST['cvrimg'] = $cover_img;
    $_POST['propic'] = $profile_img;
    $jfile = dirname(__FILE__).'/../data.json';
    file_put_contents($jfile, json_encode($_POST));

  //
  // needs to redirect back to index
  //

  } else {
    echo "Sorry, there was an error uploading your files.";
  }
}

?>
