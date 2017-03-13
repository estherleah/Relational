<?php
include_once 'database/database.php';
session_start();
include 'header.php';
include 'includes/showfriends.php';
$user = $_SESSION['user'];
$name = $_SESSION['name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src = "js/friends.js"></script>


<!-- Content -->
<!--CONTAINER BEGINS HERE-->
<div class="container">
  <!--trying to split the page in half OK i did it-->

    <!--div class="col-*-*"-->
        <div class="text-center">


            <div class="row">
              <div class="col-xs-2">
                <img src="<?php echo $profilephotoURL ?>" class="img-circle center-block" width="80%"/>
              </div>
              <div class="col-xs-7">
                  <h1 class="page-header"><?php echo $fullName ?>'s Friends</h1>
                  <h4><?php echo "Friendship is magic" ?></h4>
              </div>

            </div>

            <!--ROW BEGINS HERE -->
            <div class = "row">
            <div class="col-xs-5 jumbotron">

                <!--EXISTING FRIENDS ATTEMPT 2-->

                <h3>Existing friends</h3>
                <?php echo "Here are your friends" ?>
                <?php
                while ($row = mysqli_fetch_array($friendResult)) {
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $thisUserID = $row['userID'];
                    $thisUserStatus = $row['status'];
                    $profilePhotoURL = $row["profilephotoURL"];
                    ?>

                    <div class="existingFriends row">

                            <button type="button"
                               class="btn btn-danger btnChangeCircleMemberStatus btnDelete"
                               role="button"
                               data-id="<?php echo $thisUserID ?>"
                               >
                               Unfriend
                           </button>

                        <!-- </div> -->
                        <img class="circleMemberPhoto" src="<?php echo $profilePhotoURL ?>" />

                        <span class="circleMemberName">
                            <?php echo $firstName;?> <?php echo $lastName; ?>
                        </span>

                        </br>
                        <span class="circleMemberStatus">
                          <?php
                              echo "Friend" ?>
                        </span>
                        <p>
                        <p>
                    </div>
                    <?php
                }
                ?>
                <!--END OF existing attempt 2-->

                <!--TRY TO DO PENDING FRIEND REQUESTS HERE-->

                <h3>Pending requests</h3>
                <?php echo "Here are your pending requests" ?>
                <?php
                while ($row = mysqli_fetch_array($pendingResult)) {
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $thisUserID = $row['userID'];
                    $thisUserStatus = $row['status'];
                    $profilePhotoURL = $row["profilephotoURL"];
                    ?>

                    <div class="pendingFriends row">

                            <button type="button"
                               class="btn btn-danger btnChangeCircleMemberStatus btnCancelReq"
                               role="button"
                               data-id="<?php echo $thisUserID ?>"
                               >
                               Cancel
                           </button>

                        <!-- </div> -->
                        <img class="circleMemberPhoto" src="<?php echo $profilePhotoURL ?>" />
                        <span class="circleMemberName">
                            <?php echo $firstName;?> <?php echo $lastName; ?>
                        </span>
                        </br>
                        <span class="circleMemberStatus">
                          <?php
                              echo "Request sent" ?>
                        </span>
                        <p>
                    </div>
                    <?php
                }
                ?>
                <!--END OF PENDING REQUEST-->
              </div>

              <div class="col-xs-5 col-xs-offset-1 jumbotron">

                <!--START OF FRIEND RECOMMENDATIONS-->
                <h3>Suggested Friends</h3>
                <?php echo "Search for friends" ?>
                <!-- THIS IS FROM "VERYOLDFRIENDS.PHP"-->
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
                  <!--I haven't figured out how to join the queries so I will just do separate sections for now-->
                <div class ="text-center"><b>Friends of friends (both existing and pending)</b><p></div>

                                <?php
                                while ($row = mysqli_fetch_array($recommendedResult1)) {
                                    $firstName = $row['firstName'];
                                    $lastName = $row['lastName'];
                                    $thisUserID = $row['userID'];

                                    $profilePhotoURL = $row["profilephotoURL"];
                                    ?>

                                    <div class="recommendedFriends row">

                                            <button type="button"
                                               class="btn btn-primary btnChangeCircleMemberStatus btnAdd"
                                               role="button"
                                               data-id="<?php echo $thisUserID ?>"
                                               >
                                               Add
                                           </button>

                                        <!-- </div> -->

                                        <img class="circleMemberPhoto" src="<?php echo $profilePhotoURL ?>" />

                                        <span class="circleMemberName">
                                            <?php echo $firstName;?> <?php echo $lastName; ?>
                                        </span>
                                        <br>
                                        <span class="circleMemberStatus">
                                          <?php
                                              echo "Friend of a friend" ?>
                                        </span>

                                        </br>
                                        <p>

                                    </div>
                                    <?php
                                }
                                ?>

                                <!--members of circles you are in who aren't friends with you-->

                                <div class ="text-center"><b>People in the same circles as you</b><p></div>

                                                <?php
                                                while ($row = mysqli_fetch_array($recommendedResult2)) {
                                                    $firstName = $row['firstName'];
                                                    $lastName = $row['lastName'];
                                                    $thisUserID = $row['userID'];

                                                    $profilePhotoURL = $row["profilephotoURL"];
                                                    ?>

                                                    <div class="recommendedFriends row">

                                                            <button type="button"
                                                               class="btn btn-primary btnChangeCircleMemberStatus btnAdd"
                                                               role="button"
                                                               data-id="<?php echo $thisUserID ?>"
                                                               >
                                                               Add
                                                           </button>

                                                        <!-- </div> -->

                                                        <img class="circleMemberPhoto" src="<?php echo $profilePhotoURL ?>" />

                                                        <span class="circleMemberName">
                                                            <?php echo $firstName;?> <?php echo $lastName; ?>
                                                        </span>
                                                        <br>
                                                        <span class="circleMemberStatus">
                                                          <?php
                                                              echo "Fellow circle member" ?>
                                                        </span>

                                                        </br>
                                                        <p>

                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <!--PEOPLE IN THE SAME LOCATION (NOT ALREADY FRIENDS)-->

                                                <div class ="text-center"><b>People near you (location)</b><p></div>

                                                                <?php
                                                                while ($row = mysqli_fetch_array($recommendedResult3)) {
                                                                    $firstName = $row['firstName'];
                                                                    $lastName = $row['lastName'];
                                                                    $thisUserID = $row['userID'];

                                                                    $profilePhotoURL = $row["profilephotoURL"];
                                                                    ?>

                                                                    <div class="recommendedFriends row">

                                                                            <button type="button"
                                                                               class="btn btn-primary btnChangeCircleMemberStatus btnAdd"
                                                                               role="button"
                                                                               data-id="<?php echo $thisUserID ?>"
                                                                               >
                                                                               Add
                                                                           </button>

                                                                        <!-- </div> -->

                                                                        <img class="circleMemberPhoto" src="<?php echo $profilePhotoURL ?>" />

                                                                        <span class="circleMemberName">
                                                                            <?php echo $firstName;?> <?php echo $lastName; ?>
                                                                        </span>
                                                                        <br>
                                                                        <span class="circleMemberStatus">
                                                                            <?php
                                                                                echo "Same location" ?>


                                                                        </span>

                                                                        </br>
                                                                        <p>

                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>



                                <!--END OF RECS-->


                <!-- Include Modals -->
                <!-- <script> $(function(){ $("#includeModals").load("includes/modals.html"); }); </script>
                <div id="includeModals"></div> -->

                <!-- Info Dialog -->
                <div class="modal fade" id="infoModal" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">testing something something</h4>
                      </div>
                      <div class="modal-body">
                        <span class="message"></span>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload(true);">Close</button>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

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
                        <button type="button" class="btn btn-primary btnConfirm" data-dismiss="modal" onclick="window.location.reload(true);">Confirm</button>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
          </div> <!--the div for the row I put both columns in ends here-->
        </div>
    </div>

</div>
<!--CONTAINER ENDS HERE-->
</body>
</html>
