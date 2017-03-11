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

$commentSql = "SELECT commentID, comment, date, profilephotoURL, firstName, lastName
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
  echo "Error: Unable to find photo";
}

// Check number of likes on a photo
$annotationLikesSql = "SELECT COUNT(*) AS count
                  FROM photo_annotation
                  WHERE photoID = '$photoIDEscaped'
                  AND annotationType = 0;
                  ";
$annotationLikesResult = mysqli_query($conn, $annotationLikesSql);

if (mysqli_num_rows($annotationLikesResult) === 1) {
  $row = mysqli_fetch_assoc($annotationLikesResult);
  $annotationLikesCount = $row["count"];
} else {
  echo "Error: photo annotation count error!";
}

$userLikesSql = "SELECT *
                  FROM photo_annotation
                  WHERE photoID = '$photoIDEscaped'
                  AND userID = '$userIDEscaped'
                  AND annotationType = 0;
                ";
$userLikesResult = mysqli_query($conn, $userLikesSql);

if (mysqli_num_rows($userLikesResult) === 1) {
  $row = mysqli_fetch_assoc($userLikesResult);
  $userLikes = True;
} else {
  $userLikes = False;
}

if ($userLikes) {
  $buttonClass = "btn-danger";
  $buttonGlyphicon = "glyphicon-thumbs-down";
  $buttonText = "Dislike";
} else {
  $buttonClass = "btn-primary";
  $buttonGlyphicon = "glyphicon-thumbs-up";
  $buttonText = "Like";
}

?>
