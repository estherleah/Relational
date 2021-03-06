<?php
include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];

$userIDEscaped = mysqli_real_escape_string($conn, $user);

$target_dir = "../uploads/userId-$user/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$dir = "uploads/userId-$user/";
$dir_file = $dir . basename($_FILES["fileToUpload"]["name"]);;

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        header("Location: ../profile.php");
        $uploadOk = 0;
    }
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    $dirExists = file_exists($target_dir);

    if (!$dirExists) {
        $dirExists = mkdir($target_dir, 0777, true);
    } else {
      $existingUrlSQL = "SELECT profilephotoURL
                          FROM user
                          WHERE userID = '$userIDEscaped';
      ";
      $existingUrlResult = mysqli_query($conn, $existingUrlSQL);
      $row = mysqli_fetch_assoc($existingUrlResult);
      $existingUrl = $row["profilephotoURL"];
      if ($existingUrl != 'assets/profile_default.jpg') {
        $system_path_full = "../" . $existingUrl;
        unlink($system_path_full);
      }
    }

    if ($dirExists && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // Add entry to DB
        $photoUrlEscaped = mysqli_real_escape_string($conn, $dir_file);
        $updateProfileSQL = "UPDATE `user` SET `profilephotoURL` = '$photoUrlEscaped' WHERE `user`.`userID` = '$userIDEscaped'";
        if (mysqli_query($conn, $updateProfileSQL)) {
        } else {
            echo "Error: " . $updateProfileSQL . "<br>" . mysqli_error($conn);
        }
        header("Location: ../profile.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
