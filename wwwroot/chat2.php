<?php
//table for messages - message
//most RECENT messages appear at the bottom
//fields: messageID, circleID, userID, message, date
//user table is just user
include_once 'database/database.php';
session_start();
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CircleChat<title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<?php

$userIDEscaped = mysqli_real_escape_string($conn, $user);

$userSql = "SELECT firstName, lastName
              FROM user
              WHERE userID = '$userIDEscaped';
              ";
$userResult = mysqli_query($conn, $userSql);

if (mysqli_num_rows($userResult) === 1) {
    $row = mysqli_fetch_assoc($userResult);
    $fullName = $row["firstName"] . " " . $row["lastName"];
}
//I have absolutely no idea what this is doing
//right it just gets message and date from the message table
//and firstname, lastname from the user table (using currentSession user ID)
$messageSql = "SELECT message, date, firstName, lastName
              FROM message AS b JOIN user AS u
              ON b.userID = '$userIDEscaped' AND b.userID = u.userID
              ORDER BY date DESC;
              ";
$messageResult = mysqli_query($conn, $messageSql);
?>

<body>
<!-- Content -->
<div class="container">
    <div class="row" id="message">
        <div class="col-xs-12">
            <h2 class="text-center">Welcome to the Magic Circle, <?php echo $name ?></h2>
        </div>
        <div class="col-xs-10">
            <form method="post" action="includes/chatProcess2.php">
                <textarea name="post" class="form-control" rows='3' id="enter your message here"></textarea>
                <input class="btn btn-primary pull-right" type="submit" value="Send message">
            </form>
        </div>
    </div>


    <?php
    if (mysqli_num_rows($messageResult) > 0) {
        while ($row = mysqli_fetch_assoc($messageResult)) {
            ?>
            <div class="row" id="previousMessages">
                <div class="col-xs-10">
                    <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                    <div class="text-muted">
                        <small><?php echo $row["date"] ?></small>
                    </div>
                    <div><?php echo $row["message"] ?></div>
                </div>
            </div>
            <?php
        }
    }
    ?>

</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
