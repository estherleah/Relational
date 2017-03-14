<?php
include_once 'database/database.php';
session_start();
include 'includes/showcircle.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CircleMembers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include 'header.php'; ?>
<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="text-center">
            <div class="col-md-8 col-sm-offset-2 jumbotron">
                <a href="circle.php?id=<?php echo $circleID; ?>" class="btn btn-link pull-left" role="button">Back</a>
                <h2>Members</h2>
                <?php
                while ($row = mysqli_fetch_array($circleMembersResult)) {
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $thisUserID = $row['userID'];
                    $thisUserStatus = $row['userStatus'];
                    $profilePhotoURL = $row["profilephotoURL"];
                    ?>
                    <div class="circleMember row">
                        <!-- <div class="row"> -->
                        <?php if($userStatus >= 2 && $userStatus > $thisUserStatus && $user != $thisUserID) { ?>
                            <button type="button"
                               class="btn btn-danger btnChangeCircleMemberStatus btnRemove"
                               role="button"
                               data-id="<?php echo $thisUserID ?>"
                               >
                               Remove
                           </button>
                        <?php } ?>
                        <?php if($userStatus == 3 && $thisUserStatus == 2) { ?>
                            <a class="btn btn-default btnChangeCircleMemberStatus btnMOwner"
                               role="button"
                               data-id="<?php echo $thisUserID ?>"
                               >
                               Make Owner
                           </a>
                        <?php } ?>
                        <?php if($userStatus == 3 && $thisUserStatus == 2) { ?>
                            <a class="btn btn-default btnChangeCircleMemberStatus btnRAdmin"
                               role="button"
                               data-id="<?php echo $thisUserID ?>"
                               >
                               Revoke Admin Rights
                           </a>
                        <?php } ?>
                        <?php if($userStatus >= 2 && $thisUserStatus == 1) { ?>
                            <a class="btn btn-default btnChangeCircleMemberStatus btnMAdmin"
                               role="button"
                               data-id="<?php echo $thisUserID ?>"
                               >
                               Make Admin
                           </a>
                        <?php } ?>
                        <!-- </div> -->
                        <img class="circleMemberPhoto" src="<?php echo $profilePhotoURL ?>" />
                        <span class="circleMemberName">
                            <?php echo $firstName;?> <?php echo $lastName; ?>
                        </span>
                        </br>
                        <span class="circleMemberStatus">
                            <?php
                                if($thisUserStatus == 2) { ?>Admin<?php }
                                else if($thisUserStatus == 3) { ?>Owner<?php }
                            ?>
                        </span>
                    </div>
                    <?php
                }
                ?>
                <!-- Include Modals -->
                <!-- <script> $(function(){ $("#includeModals").load("includes/modals.html"); }); </script>
                <div id="includeModals"></div> -->

                <!-- Info Dialog -->
                <div class="modal fade" id="infoModal" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Remove user from circle</h4>
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
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/circles.js"></script>
</body>
</html>
