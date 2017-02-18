<?php
include_once 'database/database.php';
session_start();
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Friends</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<?php

$userIDEscaped = mysqli_real_escape_string($conn, $user);

$userSql = "SELECT firstName, lastName, profilephotoURL
              FROM user
              WHERE userID = '$userIDEscaped';
              ";
$userResult = mysqli_query($conn, $userSql);

if (mysqli_num_rows($userResult) === 1) {
    $row = mysqli_fetch_assoc($userResult);
    $fullName = $row["firstName"] . " " . $row["lastName"];
    $profilephotoURL = $row["profilephotoURL"];
}

$friendSql = "SELECT profilephotoURL, firstName, lastName, status
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              ORDER BY lastName DESC;
              ";
$friendResult = mysqli_query($conn, $friendSql);
?>

<body>
<!-- Content -->
<div class="container">
    <div class="row" id="heading">
        <div class="col-xs-12">
            <h2 class="text-center"><?php echo $name?>'s Friends</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
          <h3 class="text-center">Existing</h3>

          <?php
          if (mysqli_num_rows($friendResult) > 0) {
              while ($row = mysqli_fetch_assoc($friendResult)) {
                  ?>
                  <div class="row" id="existingfriend">
                    <div class="col-xs-3">
                        <img src="<?php echo $row["profilephotoURL"] ?>" class="img-circle center-block" width="100%"/>
                    </div>
                    <div class="col-xs-9">
                        <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                        <button class="btn btn-danger btn-xs pull-right" type="button">Unfriend</button>
                        <div class="text-muted">
                            <small>
                              <?php
                              $friendStatus = null;
                              if ($row["status"] == 0) {
                                $friendStatus = "Awaiting confirmation";
                              } else if ($row["status"] == 1) {
                                $friendStatus = "Confirmed request";
                              }

                             echo $friendStatus
                             ?>
                           </small>
                        </div>
                    </div>
                  </div>
                  <?php
              }
          }
          ?>
        </div>
        <div class="col-xs-2">
        </div>
        <div class="col-xs-5">
          <h3 class="text-center">Recommended</h3>
          <div class="row">
              <p>some text</p>
          </div>
          <div class="row">
              <p>some text</p>
          </div>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
