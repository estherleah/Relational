<?php
  include_once '../database/database.php';
  session_start();

//BE CAREFUL - USERID1 receives and accepts the request, USERID2 is the sender
//INSERT THE ACCEPTOR ROW FIRST THEN THE SENDER
$userID1 = $_SESSION['user'];
$userID2 = $_POST['id'];
//to update one row I would have used a normal UPDATE statement, this is sort of a 'hack'
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
