<?php

include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];

$photoCollectionName = $_POST["photoCollectionName"];
$photoCollectionPrivacyID = $_POST["photoCollectionPrivacyID"];
$date = date("Y-m-d H:i:s");

$userIdEscaped = mysqli_real_escape_string($conn, $user);
$photoCollectionNameEscaped = mysqli_real_escape_string($conn, $photoCollectionName);
$photoCollectionPrivacyIDEscaped = mysqli_real_escape_string($conn, $photoCollectionPrivacyID);
$dateEscaped = mysqli_real_escape_string($conn, $date);

$photoCollectionInsertSql = "INSERT INTO photo_collection (userID, name, privacyID, date)
                VALUES ('$userIdEscaped', '$photoCollectionNameEscaped', '$photoCollectionPrivacyIDEscaped', '$dateEscaped')";

if (mysqli_query($conn, $photoCollectionInsertSql)) {
    echo "New photo collection created successfully";
} else {
    echo "Error: " . $photoCollectionInsertSql . "<br>" . mysqli_error($conn);
}

 ?>
