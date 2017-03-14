<?php
include_once 'database/database.php';
session_start();
include 'includes/initialisePhotos.php';
?>

<!-- Layout adapted from https://github.com/BlackrockDigital/startbootstrap-thumbnail-gallery/blob/master/index.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Photos</title>
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
            <h1 class="page-header"><?php echo $name ?></h1>
            <b>Date created: <?php echo $date ?></b>
            <?php if($currentUser) { ?>
            <button type="button"
               class="btn btn-danger btn-xs pull-right btnRemoveCollection"
               role="button"
               data-collectionid="<?php echo $collectionID?>"
               >
               Remove Collection
            </button>
            <?php } ?>
        </div>
    </div>
    <?php if($currentUser) { ?>
    <div class="row">
        <div class="col-xs-12">
            <h3>Add photos</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <form id="uploadForm" enctype="multipart/form-data">
                    <input id="fileToUpload" type="file" name="fileToUpload">
                    <button type="button"
                            class="btn btn-primary pull-right btnUpload"
                            role="button"
                            data-id="<?php echo $collectionID ?>">
                        Upload
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h3>Existing photos</h3>
        </div>
    </div>
    <?php } ?>
    <div class="row" id="existingPhotos">
        <?php
        if (mysqli_num_rows($photoResult) > 0) {
            while ($row = mysqli_fetch_assoc($photoResult)) {
                ?>
                <div class="col-lg-3 col-md-4 col-xs-6">
                    <div class="thumbnail">
                        <a href="photo.php?photoID=<?php echo $row["photoID"] ?>">
                            <img class="img-responsive" src="<?php echo $row["photoURL"] ?>">
                        </a>
                        <div class="text-muted">
                            <small><?php echo $row["date"] ?></small>
                        </div>
                    </div>
                </div>
        <?php }} ?>
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
<script src="js/photos.js"></script>
</body>
</html>
