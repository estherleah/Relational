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


<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="text-center">
            <div class="col-md-8 col-sm-offset-2 jumbotron">



                <h2><?php echo $name . "'s friends" ?></h2>
                <?php echo "Friendship is magic" ?>

                <!--EXISTING FRIENDS ATTEMPT 2-->

                <h3>Existing requests</h3>
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
                               Delete
                           </button>

                        <!-- </div> -->
                        <img class="circleMemberPhoto" src="<?php echo $profilePhotoURL ?>" />

                        <span class="circleMemberName">
                            <?php echo $firstName;?> <?php echo $lastName; ?>
                        </span>

                        </br>
                        <span class="circleMemberStatus">
                            <?php
                                if($status == 1) { ?>friends<?php }
                                else { ?>you are friends<?php }
                            ?>
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
                                if($status == 0) { ?>pending<?php }
                                else { ?>you are friends<?php }
                            ?>
                        </span>
                        <p>
                    </div>
                    <?php
                }
                ?>
                <!--END OF PENDING REQUEST-->

                <!--START OF FRIEND RECOMMENDATIONS-->
                <h3>Suggested Friends</h3>
                <?php echo "Here are some friends you could add" ?>

                                <?php
                                while ($row = mysqli_fetch_array($recommendedResult)) {
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
                                                if($status == 0) { ?>pending<?php }
                                                else if($thisUserStatus == 3) { ?>Owner<?php }
                                            ?>
                                        </span>
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
                        <h4 class="modal-title">Cancel friend request</h4>
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
        </div>
    </div>
</div>
</body>
</html>
