<?php
include_once 'database/database.php';
session_start();
include 'header.php';
include 'includes/showcircle.php';
//include 'chatcircle.php';
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
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/circles.js"></script>

<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="text-center">
            <div class="col-md-8">
                <h2><?php echo $circleData['name']; ?></h2>
                <span><?php echo $circleData['description']; ?></span>

                <!--THIS PART INCLUDES THE chatcircle.php SCRIPT-->
                <div class="col-xs-10" id = "circlechat">
                   <?php include('chatcircle.php'); ?>
                </div>
            </div>


            <div class="col-md-4">
                <h2>Members</h2>
                <?php
                while ($row = mysqli_fetch_array($circleMembersResult)) {
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $userStatus = $row['userStatus'];
                    $profilePhotoURL = $row["profilephotoURL"];
                    ?>
                    <div class="circleMember">
                        <span class="circleMemberName"><?php echo $firstName;?> <?php echo $lastName; ?></span>
                        <img src="<?php echo $profilePhotoURL ?>" style="width:50px; height:50px; float:right; margin-left:10px;" />

                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
