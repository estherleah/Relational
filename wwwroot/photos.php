<?php
include_once 'database/database.php';
session_start();
include 'header.php';
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
  <!-- Content -->
  <div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header"><?php echo $name ?></h1>
            <b>Date created: <?php echo $date?></b>
        </div>
    </div>
    <div class="row">
          <div class="col-xs-12">
              <h3>Add photos</h3>
          </div>
    </div>
    <div class="row">
          <div class="col-xs-12">
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control" id="name">
            </div>
            <button class="btn btn-primary pull-right" id="postSubmit" type="button">Add</button>
          </div>
    </div>

    <div class="row">
          <div class="col-xs-12">
              <h3>Existing photos</h3>
          </div>
    </div>
    <div class="row" id="existingPhotos">
    <?php
    if (mysqli_num_rows($photoResult) > 0) {
        while ($row = mysqli_fetch_assoc($photoResult)) {
            ?>
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <a class="thumbnail" data-toggle="modal" data-target="#photoModal-<?php echo $row["photoID"]?>">
                        <img class="img-responsive" src="<?php echo $row["photoURL"] ?>" alt="">
                    </a>
                    <div class="text-muted">
                        <small><?php echo $row["date"] ?></small>
                    </div>
                </div>
                <!-- Modal -->
                <div id="photoModal-<?php echo $row["photoID"]?>" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?php echo $row["date"] ?></h4>
                      </div>
                      <div class="modal-body">
                        <img src="<?php echo $row["photoURL"] ?>" alt="">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>

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
  <script src="js/addPhoto.js"></script>
</body>
</html>
