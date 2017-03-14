<?php
include_once 'database/database.php';
session_start();
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
  <?php include 'header.php'; ?>
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
            <?php if($currentUser) { ?>
            <button type="button"
               class="btn btn-danger btn-xs pull-right btnRemovePhoto"
               role="button"
               data-photoid="<?php echo $photoID?>"
               data-photourl="<?php echo $photoURL?>"
               >
               Remove Photo
            </button>
            <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <img class="img-responsive img-rounded center-block" src="<?php echo $photoURL?>">
        </div>
      </div>

      <div class="row" id="likes">
        <div class="col-xs-12">
          <p><?php echo $annotationLikesCount . " likes" ?></p>
          <button type="button"
             class="btn <?php echo $buttonClass?> pull-left btnLike"
             role="button"
             data-photoid="<?php echo $photoID?>"
             data-annotationtype="<?php echo 0?>"
             >
             <span class="glyphicon <?php echo $buttonGlyphicon?>"></span>
              <?php echo $buttonText?>
          </button>
        </div>
      </div>

      <div class="row" id="entry">
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
                <div class="row">
                  <div class="col-xs-2">
                      <img src="<?php echo $row["profilephotoURL"] ?>" class="img-circle center-block" width="50%"/>
                  </div>
                  <div class="col-xs-10">
                      <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                      <?php if($currentUser || ($row["userID"] == $user)) { ?>
                      <button type="button"
                         class="btn btn-danger btn-xs pull-right btnRemoveComment"
                         role="button"
                         data-commentid="<?php echo $row["commentID"]?>"
                         >
                         Remove
                      </button>
                      <?php } ?>
                      <div class="text-muted">
                          <small><?php echo $row["date"] ?></small>
                      </div>
                      <div><?php echo $row["comment"] ?></div>
                  </div>
                </div>
              <?php
          }
      }
      ?>
      </div>

      <!-- Confirmation Dialog -->
      <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Are you sure?</h4>
            </div>
            <div class="modal-body">
              <span class="message"></span>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btnCancel" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btnConfirm" data-dismiss="modal">Confirm</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/photo.js"></script>
</body>
</html>
