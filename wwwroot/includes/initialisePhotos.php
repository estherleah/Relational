<?php

$userIDEscaped = mysqli_real_escape_string($conn, $user);

$userSql = "SELECT firstName, lastName, profilephotoURL
              FROM user
              WHERE userID = '$userIDEscaped';
              ";
$userResult = mysqli_query($conn, $userSql);

if (mysqli_num_rows($userResult) === 1) {
    $row = mysqli_fetch_assoc($userResult);
    $fullName = $row["firstName"] . " " . $row["lastName"];
    $profilephotoURL = $row["profilephotoURL"];
}

$photoCollectionSql = "SELECT name, date, profilephotoURL, firstName, lastName
              FROM photo_collection AS p JOIN user AS u
              ON p.userID = '$userIDEscaped' AND p.userID = u.userID
              ORDER BY date DESC;
              ";
$photoCollectionResult = mysqli_query($conn, $photoCollectionSql);

?>
