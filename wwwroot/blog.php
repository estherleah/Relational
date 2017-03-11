<?php
include_once 'database/database.php';
session_start();
include 'header.php';
include 'includes/initialiseBlog.php';
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
          <textarea class="form-control" rows='3' id="postText"></textarea>
          <button class="btn btn-primary pull-right" id="postSubmit" type="button">Post</button>
            <!--form method="post" action="includes/addblogpost.php">
                <textarea name="post" class="form-control" rows='3' id="postText"></textarea>
                <input class="btn btn-primary pull-right" type="submit" value="Post">
            </form-->
        </div>
    </div>

    <div class="row" id="previousposts">
    <?php
    if (mysqli_num_rows($blogResult) > 0) {
        while ($row = mysqli_fetch_assoc($blogResult)) {
            ?>
            <div class="row">
                <div class="col-xs-2">
                    <img src="<?php echo $row["profilephotoURL"] ?>" class="img-circle center-block" width="50%"/>
                </div>
                <div class="col-xs-10">
                    <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                    <!--button class="btn btn-danger btn-xs pull-right" type="button">Delete</button-->
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

</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/blogentry.js"></script>
</body>
</html>
