<?php
  include_once '../database/database.php';
  session_start();

$userID1 = $_SESSION['user'];
$userID2 = $_POST['id'];

$cancelReq = "  DELETE FROM friendship
                    WHERE      (userID1 = '$userID1' AND userID2 = '$userID2'
                                OR userID1 = '$userID2' AND userID2 = '$userID1')";

if (mysqli_query($GLOBALS['conn'], $cancelReq)) {

        echo "Friend request cancelled";
      } else {
        echo "Could not cancel friend request" . mysqli_error($GLOBALS['conn']);
      }
  ?>
