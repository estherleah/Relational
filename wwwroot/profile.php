<?php
/**
 * Created by PhpStorm.
 * User: Esther Leah
 * Date: 06/03/2017
 * Time: 13:48
 */

include_once 'database/database.php';
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
include 'header.php';

$sql = "SELECT `profilephotoURL` FROM `user` WHERE `userID` = '$user'";
$result = mysqli_query($conn, $sql);
if ($row = mysqli_fetch_assoc($result)) {
    $profile = $row['profilephotoURL'];
}
else {
    echo "Unable to find profile picture";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Photo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="row text-center">
            <div class="col-sm-6 col-sm-offset-3">
                <h2><?php echo $name ?></h2>
            </div>
        </div>
        <div class="row" id="currentPic">
            <div class="col-xs-12">
                <img class="img-responsive img-rounded center-block" src="<?php echo $profile ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-8 col-xs-10 col-md-offset-3 col-sm-offset-2 col-xs-offset-1 form-group">
                <form action="includes/addProfilePic.php" method="post" enctype="multipart/form-data">
                    <input id="fileToUpload" type="file" class="pull-left" name="fileToUpload">
                    <input type="submit" class="btn btn-primary pull-right" value="Change profile picture" name="submit">
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
