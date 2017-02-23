
<?php
//if user1 adds user2 - you insert 1 2 0
//but you also need to make user2 'get' the request so you also insert 2 1 0

include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];
$addFriendID = $_POST['addFriendID'];

    $userIdEscaped = mysqli_real_escape_string($conn, $user);
    $addFriendIDEscaped = mysqli_real_escape_string($conn, $addFriendID);

       if (isset($_POST['Add'])){

         $addFriendSql = "INSERT INTO friendship (userID1, userID2, status)
                         VALUES ('$userIdEscaped', '$addFriendIDEscaped', 0)";
                         //reverse
        $addFriendSql2 = "INSERT INTO friendship (userID1, userID2, status)
                          VALUES ('$addFriendIDEscaped', '$userIdEscaped', 0)";


//do a second query to insert friendships both ways

       if (mysqli_query($conn, $addFriendSql)) {
         if (mysqli_query($conn, $addFriendSql2)) {
             echo "Friend added!";
             header("Location: ../friends.php");
         } else {
             echo "Error: " . $addFriendSql2 . "<br>" . mysqli_error($conn);
         }
       } else {
           echo "Error: " . $addFriendSql . "<br>" . mysqli_error($conn);
       }

      }
 ?>
