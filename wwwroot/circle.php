<?php
include_once 'database/database.php';
session_start();
include 'header.php';
include 'includes/showcircle.php';
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
            <div class="col-md-8 jumbotron">
                <h2><?php echo $circleName ?></h2>
                <p><?php echo $circleDesc ?></p></br>
                <?php
                    if ($userStatus == 3) {
                        ?><button class="btn btn-danger BtnDeleteCircle" type="button">Delete Circle</button><?php
                    }
                ?>
            </div>
            <div class="col-md-4 members">
                <a class="btn btn-link" href="circlemembers.php?id=<?php echo $circleID; ?>" role="button"><h3>Members</h3></a>
                <?php
                while ($row = mysqli_fetch_array($circleMembersResult)) {
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $thisUserStatus = $row['userStatus'];
                    $profilePhotoURL = $row["profilephotoURL"];
                    ?>
                    <div class="circleMember">
                        <img class="circleMemberPhoto" src="<?php echo $profilePhotoURL ?>" />
                        <span class="circleMemberName">
                            <?php echo $firstName;?> <?php echo $lastName; ?>
                        </span>
                        </br>
                        <span class="circleMemberStatus">
                            <?php
                                if($thisUserStatus == 2) { ?>Admin<?php }
                                else if($thisUserStatus == 3) { ?>Owner<?php }
                            ?>
                        </span>
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
