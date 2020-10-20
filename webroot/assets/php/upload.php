<?php

  $webroot = $_SERVER['DOCUMENT_ROOT'];

  $cover_img = $target_dir . basename($_FILES["cover_img"]["name"]);
  $profile_img = $target_dir . basename($_FILES["profile_img"]["name"]);
  $_POST['cvrimg'] = $cover_img;
  $_POST['propic'] = $profile_img;

  $imageFileType1 = strtolower(pathinfo($cover_img,PATHINFO_EXTENSION));
  $imageFileType2 = strtolower(pathinfo($profile_img,PATHINFO_EXTENSION));

  $uploadOk = 1;

  // getimagesize will confirm the file is an actual image
  if(isset($_POST["submit"])) {
    $check1 = getimagesize($_FILES["cover_img"]["tmp_name"]);
    $check2 = getimagesize($_FILES["profile_img"]["tmp_name"]);
    if($check1 !== false && $check2 !== false) {
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
    if (move_uploaded_file($_FILES["cover_img"]["tmp_name"], $webroot . "/" . $cover_img) && move_uploaded_file($_FILES["profile_img"]["tmp_name"], $webroot . "/" . $profile_img)) {

      // remove submit from json and add image paths
      unset($_POST['submit']);

      // old json file method
      // $jfile = dirname(__FILE__).'/../data.json';
      // file_put_contents($jfile, json_encode($_POST));

      // new api call
      //  all of this can go away once we implement uploads on the api

      //API Url
      $url = 'http://localhost:5000';

      $options = array(
        'http' => array(
        'method'  => 'POST',
        'content' => json_encode( $_POST ),
        'header'=>  "Content-Type: application/json")
      );

      $context  = stream_context_create( $options );
      $result = file_get_contents( $url, false, $context );
      $response = json_decode( $result );

      // redirect back to index
      header("Location: /");

    } else {
      echo "Sorry, there was an error uploading your files.";
    }
  }

?>
