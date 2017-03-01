<?php


//I don't think the problem is here either
$userIDEscaped = mysqli_real_escape_string($conn, $user);
$circleIDEscaped = mysqli_real_escape_string($conn, $circleID);


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
//select the message database
//attempt a different query - want to get everything ever posted in circle/chat
//ON b.userID = '$userIDEscaped' AND b.userID = u.userID

$messageSQL = "SELECT message, date, profilephotoURL, firstName, lastName, circleID
              FROM message
               JOIN user
              ON message.userID = user.userID
               WHERE circleID = '$circleIDEscaped'

              ORDER BY date ASC;
              ";

$messageResult = mysqli_query($conn, $messageSQL);
?>
