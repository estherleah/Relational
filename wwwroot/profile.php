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
                if ( $currentUser) {
                    ?>
                    <!-- Change profile picture -->
                    <form action="includes/addProfilePic.php" method="post" enctype="multipart/form-data" style="padding-bottom:50px;">
                        <input id="fileToUpload" type="file" class="pull-left" name="fileToUpload" style="padding-bottom:10px;">
                        <input type="submit" class="btn btn-primary pull-left" value="Change profile picture" name="submit">
                    </form>
                    <?php
                }
                ?>
                <!-- logic: if you are logged in as a friend you should not see the add button on the profile-->
                <!-- the boolean in there works now need to return the result of a query checking that n results = 0-->

                  <!--ADD BUTTON DIV STARTS HERE -->
                  <div class = "row" id = "addButton">
                    <div align = "center">

                    <?php
                        if ((mysqli_num_rows($areFriends) <= 0) and $user != $thisUserID) {
                            ?>
                            <p>
                <button type="button"
                   class="btn btn-primary btnAdd"
                   role="button"
                   data-id="<?php echo $thisUserID ?>"
                   >
                   Add friend
               </button>
               <?php
             }
             ?>
           </div> <!--centrediv ends here-->
         </div> <!--entire addbutton div ends here -->

         <!--ACCEPT BUTTON DIV STARTS HERE -->
         <div class = "row" id = "acceptButton">
           <div align = "center">
           <?php
               if (mysqli_num_rows($requestTo) != 0) {
                   ?>
                   <p>
       <button type="button"
          class="btn btn-primary btnAccept"
          role="button"
          data-id="<?php echo $thisUserID ?>"
          >
          Accept request
      </button>
      <?php
    }
    ?>
    </div> <!--center div ends here-->
</div> <!--ACCEPT div ends here -->


         <!--PENDING BUTTON DIV STARTS HERE -->
         <div class = "row" id = "cancelButton">
           <div align = "center">
           <?php
               if (mysqli_num_rows($requestFrom) != 0) {
                   ?>
                   <p>
       <button type="button"
          class="btn btn-danger btnCancel"
          role="button"
          data-id="<?php echo $thisUserID ?>"
          >
          Cancel request
      </button>
      <?php
    }
    ?>
    </div> <!--center div ends here-->
</div> <!--PENDING div ends here -->

  <!--DELETE BUTTON STARTS HERE-->
  <div class = "row" id = "cancelButton">
      <div align = "center">
      <?php
          if (mysqli_num_rows($areFriends2) != 0) {
              ?>
              <p>
    <button type="button"
     class="btn btn-danger btnDelete"
     role="button"
     data-id="<?php echo $thisUserID ?>"
     >
     Unfriend
    </button>
    <?php
    }
    ?>
    </div> <!--center div ends here-->
</div> <!--DELETE div ends here -->


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
                Gender: <?php echo $thisUserGender ?><br>
                Date of Birth: <?php echo substr($thisUserDOB, 8, 2) . "." .  substr($thisUserDOB, 5, 2) . "." .  substr($thisUserDOB, 0, 4); ?><br>
                Country: <span class="bfh-countries" data-country="<?php echo $thisUserLocation ?>"></span><br>
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
<script src="js/bootstrap-formhelpers.min.js"></script>
<script src="js/blog.js"></script>
<script src="js/profile.js"></script>
</body>
</html>
