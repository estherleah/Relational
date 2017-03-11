<?php
include_once 'database/database.php';
session_start();
include 'header.php';
include 'includes/showfriends.php';
include 'includes/addFriend.php';
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$userIdEscaped = $user;
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
          <div class ="text-center">These are your friends!</div>
          <p>
          <?php
          if (mysqli_num_rows($friendResult) > 0) {
              while ($row = mysqli_fetch_assoc($friendResult)) {
                  ?>
                  <div class="row" id="existingFriends">

                    <div class="col-xs-3">
                        <img src="<?php echo $row["profilephotoURL"] ?>" class="img-circle center-block" width="100%"/>
                    </div>
                    <div class="col-xs-9">
                        <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                        <button class="btn btn-danger btn-xs pull-right" type="button">Unfriend</button>
                        <div class="text-muted">
                            <small>
                              <?php
                      $friendStatus = "Confirmed request";
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

            <h3 class="text-center">Pending</h3>
            <div class ="text-center">Pending friend requests</div>
            <p>

              <?php
              if (mysqli_num_rows($pendingResult) > 0) {
                  while ($row = mysqli_fetch_assoc($pendingResult)) {
                      ?>
                      <div class="row" id="existingFriends">

                        <div class="col-xs-3">
                            <img src="<?php echo $row["profilephotoURL"] ?>" class="img-circle center-block" width="100%"/>
                        </div>
                        <div class="col-xs-9">
                            <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                            <button class="btn btn-danger btn-xs pull-right" type="button">Cancel</button>
                            <div class="text-muted">
                                <small>
                                  <?php
                          $friendStatus = "Awaiting confirmation";
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
          <h3 class="text-center">Find friends</h3>

          <div class="row">
            <form>
            <label class="checkbox">
              <input type="checkbox" name="optradio">All
            </label>
            <label class="checkbox">
              <input type="checkbox" name="optradio">Friends of friends
            </label>
            <label class="checkbox">
              <input type="checkbox" name="optradio">In same circle
            </label>
            <button class="btn btn-primary btn-xs pull-right" type="button">Filter</button>
          </form>
          </div>
          <p><p><p>
            <div class="row"></div>
          <h3 class="text-center">Results</h3>
          <p>
          <div class ="text-center">Here are some friends you could add:<p></div>


          <?php
          if ($recommendedResult) {
            $count = 0;
              do {
                  if ($result = mysqli_store_result($conn)) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="row" id="recommendedFriends">
                          <div class="col-xs-3">
                              <img src="<?php echo $row["profilephotoURL"] ?>" class="img-circle center-block" width="100%"/>
                          </div>
                          <div class="col-xs-9">
                              <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                              <?php echo $row["userID"] ?>

                              <!--button class="btn btn-primary btn-xs pull-right" name="addUser" type="button">Add</button-->

                              <form method ="POST" action ="/includes/addFriend.php">
                                <input type="hidden" name="addFriendID" value= <?php echo "". $row["userID"] .""?>>
                                <input class="btn btn-primary btn-xs pull-right" type="submit" value= "Add" >
                                  </form>



                              <div class="text-muted">
                                  <small>
                                    <?php
                                    $recommendationSource = null;
                                    if ($count == 0) {
                                      $recommendationSource = "Friends of friends";
                                    } else if ($count == 1) {
                                      $recommendationSource = "Circle participants";
                                    }
                                   echo $recommendationSource;?>
                                 </small>
                              </div>
                          </div>
                        </div>
                      <?php
                      }
                      $count++;
                      mysqli_free_result($result);
                  }
              } while (mysqli_more_results($conn) && (mysqli_next_result($conn)));
          }
          ?>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/addfriend.js"></script>
<script src="js/acceptreq.js"></script>
<script src="js/deletefriend.js"></script>
</body>
</html>
