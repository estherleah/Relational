
<?php

include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];
$addFriendID = $_POST['addFriendID'];

    $userIdEscaped = mysqli_real_escape_string($conn, $user);
    $addFriendIDEscaped = mysqli_real_escape_string($conn, $addFriendID);

       if (isset($_POST['Add'])){
         
         $addFriendSql = "INSERT INTO friendship (userID1, userID2, status)
                         VALUES ('$userIdEscaped', '$addFriendIDEscaped', 0)";

       if (mysqli_query($conn, $addFriendSql)) {
           echo "Friend added!";
       } else {
           echo "Error: " . $addFriendSql . "<br>" . mysqli_error($conn);
       }

      }
 ?>
