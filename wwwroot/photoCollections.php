<?php
include_once 'database/database.php';
session_start();
include_once 'database/database.php';
include 'header.php';
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
  <!-- Content -->
  <div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header"><?php echo $name ?>'s Photo Collections</h1>
        </div>
    </div>
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
    <div class="row" id="existingCollections">
    <?php
    if (mysqli_num_rows($collectionResult) > 0) {
        while ($row = mysqli_fetch_assoc($collectionResult)) {
            ?>
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                  <div class="thumbnail">
                    <b><?php echo $row["name"]?></b>
                    <a  href="photos.php?collectionID=<?php echo $row["collectionID"]?>">
                      <div class="jumbotron">
                        <h1><?php echo $row["count"]?></h1>
                        <p>photo(s)</p>
                      </div>
                    </a>
                    <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                    <div class="text-muted">
                        <small><?php echo $row["date"] ?></small>
                    </div>
                  </div>
                </div>
            <?php
        }
    }
    ?>
    </div>


  </div>
  </div>




  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/addPhotoCollection.js"></script>
</body>
</html>
