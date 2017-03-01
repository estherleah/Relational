<?php

// Adapted from https://www.w3schools.com/php/php_file_upload.asp
include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];

//echo var_dump($_POST);
//echo var_dump($_FILES);
$collectionId = $_POST["id"];

//echo "collectionId: " . $collectionId;

$target_dir = "../uploads/$user/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    $userDirExists = file_exists($target_dir);

    if (!$userDirExists) {
      $userDirExists = mkdir($target_dir);
    }
    if ($userDirExists && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // Add entry to DB
        $date = date("Y-m-d H:i:s");
        $collectionIdEscaped = mysqli_real_escape_string($conn, $collectionId);
        $photoUrlEscaped = mysqli_real_escape_string($conn, $target_file);
        $dateEscaped = mysqli_real_escape_string($conn, $date);
        $photoInsertSql = "INSERT INTO photo (collectionID, photoURL, date)
                        VALUES ('$collectionIdEscaped', '$photoUrlEscaped', '$dateEscaped')";
        if (mysqli_query($conn, $photoInsertSql)) {
            echo "Photo URL added to database";
        } else {
            echo "Error: " . $photoInsertSql . "<br>" . mysqli_error($conn);
        }
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>
