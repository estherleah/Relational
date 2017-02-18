<?php
include_once 'database/database.php';
session_start();
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blog</title>
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

$blogSql = "SELECT entry, date, profilephotoURL, firstName, lastName
              FROM blog_entry AS b JOIN user AS u
              ON b.userID = '$userIDEscaped' AND b.userID = u.userID
              ORDER BY date DESC;
              ";
$blogResult = mysqli_query($conn, $blogSql);
?>

<body>
<!-- Content -->
<div class="container">
    <div class="row" id="entry">
        <div class="col-xs-12">
            <h2 class="text-center">Blog for <?php echo $name ?></h2>
        </div>
        <div class="col-xs-2">
            <img src="<?php echo $profilephotoURL ?>" class="img-circle center-block" width="100%"/>
        </div>
        <div class="col-xs-10">
            <form method="post" action="includes/addblogpost.php">
                <textarea name="post" class="form-control" rows='3' id="postText"></textarea>
                <input class="btn btn-primary pull-right" type="submit" value="Post">
            </form>
        </div>
    </div>


    <?php
    if (mysqli_num_rows($blogResult) > 0) {
        while ($row = mysqli_fetch_assoc($blogResult)) {
            ?>
            <div class="row" id="previousposts">
                <div class="col-xs-2">
                    <img src="<?php echo $row["profilephotoURL"] ?>" class="img-circle center-block" width="50%"/>
                </div>
                <div class="col-xs-10">
                    <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                    <button class="btn btn-danger btn-xs pull-right" type="button">Delete</button>
                    <div class="text-muted">
                        <small><?php echo $row["date"] ?></small>
                    </div>
                    <div><?php echo $row["entry"] ?></div>
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
