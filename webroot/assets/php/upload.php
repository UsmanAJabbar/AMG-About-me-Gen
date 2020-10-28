<?php

  $target_dir = 'assets/img/';
  $webroot = $_SERVER['DOCUMENT_ROOT'];

  $coverimg = $target_dir . basename($_FILES["coverimg"]["name"]);
  $profilepic = $target_dir . basename($_FILES["profilepic"]["name"]);

  $imageFileType1 = strtolower(pathinfo($coverimg,PATHINFO_EXTENSION));
  $imageFileType2 = strtolower(pathinfo($profilepic,PATHINFO_EXTENSION));

  $uploadOk = 1;

  // getimagesize will confirm the file is an actual image
  if(isset($_POST["submit"])) {
    $check1 = getimagesize($_FILES["coverimg"]["tmp_name"]);
    $check2 = getimagesize($_FILES["profilepic"]["tmp_name"]);
    if($check1 !== false && $check2 !== false) {
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }

  // Check file size
  if ($_FILES["coverimg"]["size"] > 500000 || $_FILES["profilepic"]["size"] > 500000) {
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
    if (move_uploaded_file($_FILES["coverimg"]["tmp_name"], $webroot . "/" . $coverimg) && move_uploaded_file($_FILES["profilepic"]["tmp_name"], $webroot . "/" . $profilepic)) {

      // remove submit from json and add image paths
      // no longer needed
      // unset($_POST['submit']);

      // old json file method
      // $jfile = dirname(__FILE__).'/../data.json';
      // file_put_contents($jfile, json_encode($_POST));

      // new api call
      //  all of this can go away once we implement uploads on the api

      //API Url
      $url = 'http://localhost:5000';

      // Create a new cURL resource
      $ch = curl_init($url);

      $data = array(
        'name' => $_POST['name-1'],
        'status' => $_POST['status'],
        'description' => $_POST['description'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'cvrimg' => $coverimg,
        'propic' => $profilepic,
        'medium' => $_POST['medium'],
        'github' => $_POST['github'],
        'twitter' => $_POST['twitter'],
        'facebook' => $_POST['facebook'],
        'instagram' => $_POST['instagram']
      );

      $payload = json_encode($data);

      // Attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      // Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      // Return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute the POST request
      $result = curl_exec($ch);

      // Close cURL resource
      curl_close($ch);
      //return $result;
      // redirect back to index
      header("Location: /");

    } else {
      echo "Sorry, there was an error uploading your files.";
    }
  }

?>
