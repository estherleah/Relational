<?php
include_once 'database/database.php';
include 'includes/initialiseCircleChat.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CircleChat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>



<body>
<!-- Content -->
<div class="container">
    <div class="row" id="message">
      <div class="row" id="headerrow">
      <div class="col-xs-10">
        <!--this should echo circleID instead of name, fix later-->
          <h2 class="text-centre">Group Chat</h2>
      </div>
    </div>

        <?php
        if (mysqli_num_rows($messageResult) > 0) {
            while ($row = mysqli_fetch_assoc($messageResult)) {
                ?>
                <div class="row" id="previousmessages">
                  <div class="col-xs-4">
                      <img src="<?php echo $row["profilephotoURL"] ?>" class="img-circle center-block" width="50%"/>
                  </div>
                    <div class="col-xs-16">
                      <div class = "text-left">
                        <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                        <div><?php echo $row["message"] ?></div>
                        <div class="text-muted"><small><?php echo $row["date"] ?></small>
                        </div>
                      </div>
                    </div>
                </div>


                <?php
            }
        }
        ?>
        </div>

        <div class="row" id="newmessage">
           <div class="col-xs-16">
             <textarea class="form-control" rows='3' id="messageText"></textarea>
             <button class="btn btn-primary pull-right" id="messageSubmit" type="button">Send</button>
           </div>
       </div>
       </div>

</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/chatprocess.js"></script>
</body>
</html>
