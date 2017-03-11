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
  <?php if($currentUser) { ?>
    <div class="row" id="entry">
        <div class="col-xs-12">
          <textarea class="form-control" rows='3' id="postText"></textarea>
          <button class="btn btn-primary pull-right" id="postSubmit" type="button">Post</button>
        </div>
    </div>
  <?php } ?>

    <div class="row" id="previousposts">
    <?php
    if (mysqli_num_rows($blogResult) > 0) {
        while ($row = mysqli_fetch_assoc($blogResult)) {
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <b><?php echo $row["date"] ?></b>
                    <?php if($currentUser) { ?>
                    <button type="button"
                       class="btn btn-danger btn-xs pull-right btnRemove"
                       role="button"
                       data-entryid="<?php echo $row["entryID"]?>"
                       >
                       Remove
                    </button>
                    <?php } ?>
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
<script src="js/blog.js"></script>
</body>
</html>
