<?php

include_once 'database/database.php';
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];

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

// SQL gets list of photo collections, the user who created them and the count of photos in each
$collectionSql = "SELECT pcol.collectionID, pcol.name, pcol.date, u.profilephotoURL, u.firstName, u.lastName, COUNT(p.photoID) AS count
              FROM photo_collection AS pcol
              JOIN photo AS p ON pcol.collectionID = p.collectionID
              JOIN user AS u ON pcol.userID = u.userID
              WHERE pcol.userID = 1
              GROUP BY pcol.collectionID
              ORDER BY date DESC;
              ";
$collectionResult = mysqli_query($conn, $collectionSql);

?>
