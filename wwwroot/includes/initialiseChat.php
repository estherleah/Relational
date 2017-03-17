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

$messageSQL = "SELECT message, date, profilephotoURL, firstName, lastName
              FROM message JOIN user
              ON message.userID = user.userID
              ORDER BY date ASC;
              ";

$messageResult = mysqli_query($conn, $messageSQL);
?>
