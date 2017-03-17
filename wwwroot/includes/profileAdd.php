<?php
  include_once '../database/database.php';
  session_start();

  $userID1 = $_SESSION['user'];
  $userID2 = $_POST['id'];

    $addFriend = "INSERT INTO friendship (userID1, userID2, status, originUserID)
                  VALUES ('$userID1', '$userID2', '0', '$userID1'),
                        ('$userID2', '$userID1', '0', '$userID1');
                    ";

    if (mysqli_query($conn, $addFriend)) {
        echo "Friend added";
    } else {
        echo "Error adding friend" . " " . mysqli_error($conn);
    }

  ?>
