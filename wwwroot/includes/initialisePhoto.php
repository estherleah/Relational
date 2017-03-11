<?php

// setup
$user = $_SESSION['user'];
$userIDEscaped = mysqli_real_escape_string($conn, $user);

$photoID = $_GET['photoID'];
$photoIDEscaped = mysqli_real_escape_string($conn, $photoID);

// get current user information
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

// get photo
$photoSql = "SELECT p.photoURL, p.date, pcol.userID
              FROM photo AS p JOIN photo_collection AS pcol
              ON p.photoID = '$photoIDEscaped' AND p.collectionID = pcol.collectionID;
              ";
$photoResult = mysqli_query($conn, $photoSql);

if (mysqli_num_rows($photoResult) === 1) {
    $row = mysqli_fetch_assoc($photoResult);
    $photoURL = $row["photoURL"];
    $date = $row["date"];
    $photoUserID = $row["userID"];
} else {
  echo "Error: Unable to find photo";
}

// check whether the photo is the current user's
if($photoUserID == $user) {
  // current user
  $currentUser = True;
} else {
  // another user
  $currentUser = False;
}

// get comments
$commentSql = "SELECT pcom.userID, pcom.commentID, pcom.comment, date, u.profilephotoURL, u.firstName, u.lastName
              FROM photo_comment AS pcom JOIN user AS u
              ON pcom.photoID = '$photoIDEscaped' AND pcom.userID = u.userID
              ORDER BY date DESC;
              ";
$commentResult = mysqli_query($conn, $commentSql);

// get annotation
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
