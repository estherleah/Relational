<?php

$user = $_SESSION['user'];
$name = $_SESSION['name'];
$userIDEscaped = mysqli_real_escape_string($conn, $user);

$photoID = $_GET['photoID'];
$photoIDEscaped = mysqli_real_escape_string($conn, $photoID);

$userSql = "SELECT firstName, lastName, profilephotoURL
              FROM user
              WHERE userID = '$userIDEscaped';
              ";
$userResult = mysqli_query($conn, $userSql);

if (mysqli_num_rows($userResult) === 1) {
    $row = mysqli_fetch_assoc($userResult);
    $fullName = $row["firstName"] . " " . $row["lastName"];
    $profilephotoURL = $row["profilephotoURL"];
} else {
  echo "Error: unable to find user";
}

$commentSql = "SELECT comment, date, profilephotoURL, firstName, lastName
              FROM photo_comment AS pc JOIN user AS u
              ON pc.photoID = '$photoIDEscaped' AND pc.userID = u.userID
              ORDER BY date DESC;
              ";
$commentResult = mysqli_query($conn, $commentSql);

$photoSql = "SELECT photoURL, date
              FROM photo
              WHERE photoID = '$photoIDEscaped'
              ";
$photoResult = mysqli_query($conn, $photoSql);

if (mysqli_num_rows($photoResult) === 1) {
    $row = mysqli_fetch_assoc($photoResult);
    $photoURL = $row["photoURL"];
    $date = $row["date"];
} else {
  echo "Error: Unable to find photo collection";
}

?>
