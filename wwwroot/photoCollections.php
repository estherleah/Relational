<?php
include_once 'database/database.php';
session_start();
include 'includes/initialisePhotoCollections.php';
?>

<!-- Layout adapted from https://github.com/BlackrockDigital/startbootstrap-thumbnail-gallery/blob/master/index.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Photo Collections</title>
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
      <div class="col-xs-2">
        <img src="<?php echo $profilephotoURL ?>" class="img-circle center-block" width="80%"/>
      </div>
      <div class="col-xs-10 text-left">
          <h1 class="page-header"><?php echo $fullName ?>'s Photo Collections</h1>
          <h4><?php echo "A photo collection is worth a thousand words" ?></h4>
      </div>
    </div>
    <?php if($currentUser) { ?>
    <div class="row">
          <div class="col-xs-12">
              <h3>Create a new collection</h3>
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
              <h3>Existing collections</h3>
          </div>
    </div>
    <?php } ?>
    <div class="row" id="existingCollections">
    <?php
        showCollections();
    ?>
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/photoCollections.js"></script>
</body>
</html>
