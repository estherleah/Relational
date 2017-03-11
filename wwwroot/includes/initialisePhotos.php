<?php

$user = $_SESSION['user'];
$name = $_SESSION['name'];

$collectionID = $_GET['collectionID'];

$collectionIDEscaped = mysqli_real_escape_string($conn, $collectionID);

$collectionSql = "SELECT name, date
              FROM photo_collection
              WHERE collectionID = '$collectionIDEscaped'
              ";
$collectionResult = mysqli_query($conn, $collectionSql);

if (mysqli_num_rows($collectionResult) === 1) {
    $row = mysqli_fetch_assoc($collectionResult);
    $name = $row["name"];
    $date = $row["date"];
} else {
  echo "Error: Unable to find photo collection";
}

$photoSql = "SELECT photoID, photoURL, date
              FROM photo
              WHERE collectionID = '$collectionIDEscaped'
              ORDER BY date DESC;
              ";
$photoResult = mysqli_query($conn, $photoSql);

?>
