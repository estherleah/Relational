<?php

//session_start();
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
} else {
  echo "Error: unable to find user";
}

$blogSql = "SELECT entryID, entry, date, profilephotoURL, firstName, lastName
              FROM blog_entry AS b JOIN user AS u
              ON b.userID = '$userIDEscaped' AND b.userID = u.userID
              ORDER BY date DESC;
              ";
$blogResult = mysqli_query($conn, $blogSql);

?>
