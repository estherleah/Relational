<?php
include_once 'database/database.php';
session_start();
include 'header.php';
include 'includes/initialisePhoto.php';
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
    <button class="btn btn-primary pull-left" onclick="back()">Back</button>
    <script>
      function back() {
          window.history.back();
      }
    </script>
    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">Date created: <?php echo $date?></h1>
            <button type="button"
               class="btn btn-danger pull-right btnRemove"
               role="button"
               data-id="<?php echo $photoID?>"
               data-url="<?php echo $photoURL?>"
               >
               Remove
            </button>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <img class="img-responsive img-rounded center-block" src="<?php echo $photoURL?>">
        </div>
      </div>

      <div class="row" id="entry">
          <div class="col-xs-12">
              <h2 class="text-center">Comments</h2>
          </div>
          <div class="col-xs-2">
              <img src="<?php echo $profilephotoURL ?>" class="img-circle center-block" width="100%"/>
          </div>
          <div class="col-xs-10">
            <textarea class="form-control" rows='3' id="postText"></textarea>
            <button type="button"
               class="btn btn-primary pull-right btnPost"
               role="button"
               data-photoid="<?php echo $photoID?>"
               >
               Post
            </button>
          </div>
      </div>

      <div class="row" id="previousposts">
      <?php
      if (mysqli_num_rows($commentResult) > 0) {
          while ($row = mysqli_fetch_assoc($commentResult)) {
              ?>

                  <div class="col-xs-2">
                      <img src="<?php echo $row["profilephotoURL"] ?>" class="img-circle center-block" width="50%"/>
                  </div>
                  <div class="col-xs-10">
                      <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                      <!--button class="btn btn-danger btn-xs pull-right" type="button">Delete</button-->
                      <div class="text-muted">
                          <small><?php echo $row["date"] ?></small>
                      </div>
                      <div><?php echo $row["comment"] ?></div>
                  </div>

              <?php
          }
      }
      ?>
      </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/photo.js"></script>
</body>
</html>
