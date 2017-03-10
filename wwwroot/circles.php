<?php
include_once 'database/database.php';
session_start();
include 'header.php';
include 'includes/findcircles.php';
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
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/circles.js"></script>

<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="text-center">
            <div class="col-sm-8 col-sm-offset-2">
                <h2>Circles</h2>
                <!-- Search Form -->
                <div class="form-group">
                    <input type="text" class="form-control search center-block" id="searchid" placeholder="Search"/>
                    <div id="result"></div>
                </div>
                <a href="createcircle.php" class="btn btn-primary btnCreateCircle" type="button">Create Circle</a>
                <br>
                <h3>Your Circles</h3>
                <div id="circles">
                    <?php
                    if (mysqli_num_rows($circleResult) > 0) {
                        // Display circles
                        while ($circle = mysqli_fetch_array($circleResult)) {
                            $circleID = $circle['circleID'];
                            $name = $circle['name'];
                            $desc = $circle['description'];
                            ?>
                            <div class="circle" align="left" ;>
                                <button class="btn btn-primary btnLeaveCircle"
                                        type="button"
                                        data-circleid="<?php echo $circleID ?>"
                                >
                                    Leave
                                </button>
                                <a href="circle.php?id=<?php echo $circleID; ?>" class="btn btn-link circleTitle"
                                   type="button"><?php echo $name; ?></a>
                                <br>
                                <span class="circleDesc"><?php echo $desc; ?></span>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <!-- Include Modals -->
                    <!-- <script> $(function(){ $("#includeModals").load("includes/modals.html"); }); </script>
                    <div id="includeModals"></div> -->

                    <!-- Confirmation Dialog -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Are you sure?</h4>
                                </div>
                                <div class="modal-body">
                                    <span class="message"></span>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btnCancel" data-dismiss="modal">Close
                                    </button>
                                    <button type="button" class="btn btn-primary btnConfirm" data-dismiss="modal"
                                            onclick="window.location.reload(true);">Confirm
                                    </button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
