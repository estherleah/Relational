<?php
include_once 'database/database.php';
session_start();
include 'includes/showprofile.php';
include 'includes/initialiseBlog.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include 'header.php'; ?>
<!-- Content -->
<div class="container">
    <div class="row">
        <div class="col-xs-3">
            <img class="img-responsive img-rounded center-block" src="<?php echo $thisUserProfilePic ?>" style="padding-bottom:25px;">
            <?php
                if ($currentUser) {
                    ?>
                    <!-- Change profile picture -->
                    <form action="includes/addProfilePic.php" method="post" enctype="multipart/form-data" style="padding-bottom:50px;">
                        <input id="fileToUpload" type="file" class="pull-left" name="fileToUpload" style="padding-bottom:10px;">
                        <input type="submit" class="btn btn-primary pull-left" value="Change profile picture" name="submit">
                    </form>
                    <?php
                }
            ?>
            <br>
            <div>
              <?php if($currentUser) { ?>
                <a href="friends.php"><h3>Friends</h3></a>
              <?php } else { ?>
                <h3>Friends</h3>
              <?php } ?>
                <?php showFriends(); ?>
            </div>
            <br>
            <div>
              <?php if($currentUser) { ?>
                <a href="circles.php"><h3>Circles</h3></a>
              <?php } else { ?>
                <h3>Circles</h3>
              <?php } ?>
                <?php showCircles(); ?>
            </div>
        </div>
        <div class="col-xs-6 jumbotron">
            <h2><?php echo $thisUserFullName ?></h2>
            <p>
                <?php
                    echo $thisUserGender;
                ?><br>
                Birthday: <?php echo substr($thisUserDOB, 8, 2) . "." .  substr($thisUserDOB, 5, 2) . "." .  substr($thisUserDOB, 0, 4); ?></br>
                Location: <?php echo $thisUserLocation ?></br>
            </p>

            <!-- Blog -->
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
            <div class="col-xs-3">
              <div>
                <?php if($currentUser) { ?>
                  <a href="photoCollections.php"><h3>Photo Collections</h3></a>
                <?php } else { ?>
                  <a href="photoCollections.php<?php echo "?id=" . $thisUserID ?>"><h3>Photo Collections</h3></a>
                <?php } ?>
                <?php showPhotoCollection(); ?>
              </div>
            </div>
          </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/blog.js"></script>
</body>
</html>
