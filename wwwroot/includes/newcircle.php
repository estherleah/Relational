<?php
include_once '../database/database.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Create a Circle</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>

<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="text-center">
            <h2>New Circle</h2>
            <div class="col-sm-6 col-sm-offset-3">
            <?php
            function isDataValid(){
                $errorMessage = null;
                if (!isset($_POST['circleName']) or trim($_POST['circleName']) == '')
                    $errorMessage = "Please enter a circle name";
                else if (!isset($_POST['circleDesc']) or trim($_POST['circleDesc']) == '')
                    $errorMessage = 'Please enter a circle description';
                if ($errorMessage !== null) {
                    echo <<<EOM
      <p>Error: $errorMessage</p>
EOM;
                    echo "<p><a href='../createcircle.php'>Return to input form</a></p>";
                    return False;
                }
                return True;
            }

            function getCircle(){
                $circle = array();
                $circle["circleName"] = $_POST['circleName'];
                $circle["circleDesc"] = $_POST['circleDesc'];
                return $circle;
            }

            function addCircleToDatabase($circle){
                $user = $_SESSION['user'];
                $circleName = $circle['circleName'];
                $circleDescription = $circle['circleDesc'];
                $conn = connectDatabase();
                $sql = " INSERT INTO circle (name, description, privacyID) VALUES ('$circleName', '$circleDescription', 1) ";
                $q1 = mysqli_query($conn, $sql);
                $circle = mysqli_insert_id($conn);
                $sql1 = " INSERT INTO circle_participants (circleID, userID, userStatus) VALUES ('$circle', '$user', 3) ";
                $q2 = mysqli_query($conn, $sql1);
                if ($q1 && $q2) {
                    echo "New circle created successfully";
                    echo "<p><a href='../circles.php'>Back to circles</a></p>";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    echo "<p><a href='../createcircle.php'>Try again</a></p>";
                }
            }

            if (isDataValid()){
                $newCircle = getCircle();
                addCircleToDatabase($newCircle);
            }
            ?>
        </div>
    </div>
</div>
</div>
</body>
</html>
