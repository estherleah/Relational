<?php
include_once 'database/database.php';
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
include 'header.php';

/**
 * Created by PhpStorm.
 * User: Esther Leah
 * Date: 15/02/2017
 * Time: 13:33
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="row text-center">
            <div>
                <h1 class="page-header"><?php echo $name ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading"><?php echo $name ?></div>
                    <?php
                    $sql = "SELECT `profilephotoURL` FROM `user` WHERE `userID` = '$user'";
                    $result = mysqli_query($conn, $sql);
                    if ($row = mysqli_fetch_assoc($result)) {
                        $profile = $row['profilephotoURL'];
                    } else {
                        echo "Unable to find profile picture";
                    }
                    ?>
                    <div class="panel-body">
                        <div class="col-sm-8 col-sm-offset-2">
                            <a href="profile.php"><img class="img-responsive img-rounded center-block" src="<?php echo $profile; ?>"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Blog</div>
                    <div class="panel-body">
                    <?php
                    $sql = "SELECT `entry` FROM `blog_entry` WHERE `userID` = '$user' ORDER BY `date` DESC LIMIT 1";
                    $result = mysqli_query($conn, $sql);
                    if ($row = mysqli_fetch_assoc($result)) {
                        $entry = $row['entry'];
                        echo $entry;
                    } else {
                        echo "No blog posts";
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Circles</div>
                    <?php
                    $sql = "SELECT circle.name, circle.circleID FROM circle_participants
                            INNER JOIN circle ON circle_participants.circleID = circle.circleID
                            WHERE userID = '$user' ORDER BY circle.circleID";
                    $result = mysqli_query($conn, $sql);
                    ?>
                    <div class="panel-body">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($circle = mysqli_fetch_array($result)) {
                                $name = $circle['name'];
                                $id = $circle['circleID'];
                                ?>
                                <div><a href="circle.php?id=<?php echo $id;?>"><?php echo $name;?></a></div>
                                <?php
                            }
                        } else {
                            echo "No circles";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Friends</div>
                    <div class="panel-body">Show a list of friends</div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
