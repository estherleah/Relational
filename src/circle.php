<?php
include_once 'database/database.php';
session_start();
include 'includes/showcircle.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Circle</title>
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
            <div class="col-md-8 jumbotron">
                <h2><?php echo $circleName ?></h2>
                <p><?php echo $circleDesc ?></p></br>
                <?php
                    if ($userStatus == 3) {
                        ?>
                        <button class="btn btn-danger btnDeleteCircle" type="button"> Delete Circle </button>
                        <?php
                    }
                ?>
                <!--THIS PART INCLUDES THE chatcircle.php SCRIPT-->
                <div class="col-xs-20" id="circlechat">
                   <?php include('chatcircle.php'); ?>
                </div>
            </div>
            <div class="col-md-4 members">
                <a class="btn btn-link" href="circlemembers.php?id=<?php echo $circleID; ?>" role="button"><h3>Members</h3></a>
                <?php
                while ($row = mysqli_fetch_array($circleMembersResult)) {
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $thisUserStatus = $row['userStatus'];
                    $profilePhotoURL = $row["profilephotoURL"];
                    ?>
                    <div class="circleMember">

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
                <button class="btn btn-primary btnAddMember" type="button"> + </button>
            </div>

            <!-- Info Dialog -->
            <div class="modal fade" id="infoModal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Added user to circle</h4>
                  </div>
                  <div class="modal-body">
                    <span class="message"></span>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default btnClose" data-dismiss="modal">Close</button>
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
                    <button type="button" class="btn btn-primary btnConfirm" data-dismiss="modal" >Confirm</button>
                    <!-- onclick="window.location.reload(true);" -->
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- Invite Dialog -->
            <div class="modal fade" id="inviteModal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Invite new Members</h4>
                  </div>
                  <div class="modal-body">
                    <span class="message"></span>
                    <!-- Search Form -->
                    <div class="form-group">
                        <input type="text" class="form-control inviteSearch" id="inviteSearch" placeholder="Search Friends" />
                        <div id="inviteResult"></div>
                    </div>

                    <div id="inviteStaging">

                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default btnCancelInvite" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btnInvite" data-dismiss="modal" >Invite</button>
                    <!-- onclick="window.location.reload(true);" -->
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/circles.js"></script>
</body>
</html>
