<?php
include_once 'database/database.php';
session_start();
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CircleChat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

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
//select the message database

//attempt a different query - want to get everything ever posted in circle/chat
//ON b.userID = '$userIDEscaped' AND b.userID = u.userID


$messageSQL = "SELECT message, date, profilephotoURL, firstName, lastName
              FROM message JOIN user
              ON message.userID = user.userID
              ORDER BY date ASC;
              ";
/*

$messageSQL = "SELECT message, date, firstName, lastName,
              FROM message, user
              WHERE  message.userID = user.userID
              ORDER BY date ASC;
              ;"
              */

$messageResult = mysqli_query($conn, $messageSQL);
?>

<body>
<!-- Content -->
<div class="container">
    <div class="row" id="entry">
        <div class="col-xs-12">
            <h2 class="text-center">Magic Circle Chat for <?php echo $name ?></h2>
        </div>

        <?php
        if (mysqli_num_rows($messageResult) > 0) {
            while ($row = mysqli_fetch_assoc($messageResult)) {
                ?>
                <div class="row" id="previousposts">
                  <div class="col-xs-2">
                      <img src="<?php echo $row["profilephotoURL"] ?>" class="img-circle center-block" width="50%"/>
                  </div>
                    <div class="col-xs-10">
                        <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                        <div><?php echo $row["message"] ?></div>
                        <div class="text-muted"><small><?php echo $row["date"] ?></small>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>

        <div class="col-xs-10 col-xs-offset-1">
            <form method="post" action="includes/chatProcess.php">
                <textarea name="post" class="form-control" rows='3' id="postText"></textarea>
                <input class="btn btn-primary pull-right" type="submit" value="Send message">
            </form>
        </div>
    </div>

</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
