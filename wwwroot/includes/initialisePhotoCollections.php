<?php

$user = $_SESSION['user'];

if(isset($_GET['id'])) {
  // another user
  $thisUserID = $_GET['id'];
  $currentUser = False;
} else {
  // current user
  $thisUserID = $user;
  $currentUser = True;
}

// get user details
$thisUserIDEscaped = mysqli_real_escape_string($conn, $thisUserID);

$userSql = "SELECT firstName, lastName, profilephotoURL
              FROM user
              WHERE userID = '$thisUserIDEscaped';
              ";
$userResult = mysqli_query($conn, $userSql);

if (mysqli_num_rows($userResult) === 1) {
    $row = mysqli_fetch_assoc($userResult);
    $fullName = $row["firstName"] . " " . $row["lastName"];
    $profilephotoURL = $row["profilephotoURL"];
}

// SQL gets list of photo collections, the user who created them and the count of photos in each
// need left join on photos to include collections without any photos
$collectionSql = "SELECT pcol.collectionID, pcol.name, pcol.date, u.profilephotoURL, u.firstName, u.lastName, COUNT(p.photoID) AS count
              FROM photo_collection AS pcol
              LEFT JOIN photo AS p ON pcol.collectionID = p.collectionID
              JOIN user AS u ON pcol.userID = u.userID
              WHERE pcol.userID = '$thisUserIDEscaped'
              GROUP BY pcol.collectionID
              ORDER BY date DESC;
              ";
$collectionResult = mysqli_query($conn, $collectionSql);

?>
