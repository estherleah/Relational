<?php

$user = $_SESSION['user'];

$collectionID = $_GET['collectionID'];

$collectionIDEscaped = mysqli_real_escape_string($conn, $collectionID);

$collectionSql = "SELECT name, date, userID
              FROM photo_collection
              WHERE collectionID = '$collectionIDEscaped'
              ";
$collectionResult = mysqli_query($conn, $collectionSql);

if (mysqli_num_rows($collectionResult) === 1) {
    $row = mysqli_fetch_assoc($collectionResult);
    $name = $row["name"];
    $date = $row["date"];
    $collectionUserID = $row["userID"];
} else {
  echo "Error: Unable to find photo collection";
}

if($collectionUserID == $user) {
  // current user
  $currentUser = True;
} else {
  // another user
  $currentUser = False;
}

$photoSql = "SELECT photoID, photoURL, date
              FROM photo
              WHERE collectionID = '$collectionIDEscaped'
              ORDER BY date DESC;
              ";
$photoResult = mysqli_query($conn, $photoSql);

?>
