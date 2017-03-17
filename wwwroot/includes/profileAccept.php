<?php
  include_once '../database/database.php';
  session_start();

$userID1 = $_SESSION['user'];
$userID2 = $_POST['id'];

$acceptReq = "  INSERT INTO friendship (userID1, userID2, status, originUserID)
                VALUES ('$userID1','$userID2','1','$userID2'), ('$userID2','$userID1','1','$userID2')
                ON DUPLICATE KEY UPDATE status = 1
                ";

if (mysqli_query($GLOBALS['conn'], $acceptReq)) {

        echo "You are now friends!";
      } else {
        echo "Could not accept friend request" . mysqli_error($GLOBALS['conn']);
      }

      ?>
