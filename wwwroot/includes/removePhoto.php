<?php

include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];

$photoId = $_POST["id"];
$photoUrl = $_POST["url"];

$docRoot = $_SERVER['DOCUMENT_ROOT'] . "/";
$system_path_full = $docRoot . $photoUrl;

// remove entry from DB
$photoIdEscaped = mysqli_real_escape_string($conn, $photoId);
$photoDeleteSql = "DELETE FROM photo
                    WHERE photoID = '$photoIdEscaped';
                  ";

if (mysqli_query($conn, $photoDeleteSql) && unlink($system_path_full)) {
    echo "Photo deleted";
    ;
} else {
    echo "Error: " . $photoDeleteSql . "<br>" . mysqli_error($conn);
    echo " or could not delete file from filesystem";
}

?>
