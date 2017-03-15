<?php
  include_once '../database/database.php';
  session_start();
  //THE ADDING ITSELF WORKS, NOW NEED TO STOP USERS WITH FRIENDSHIP ENTRIES FROM SEEING BUTTON 
  $userID1 = $_SESSION['user'];
  $userID2 = $_POST['id'];

  //SYMMETRIC RELATION - must work both ways
  //YES THIS WORKS NOW
    $addFriend = "INSERT INTO friendship (userID1, userID2, status, origin)
                  VALUES ('$userID1', '$userID2', '0', '$userID1'),
                        ('$userID2', '$userID1', '0', '$userID1');
                    ";

    if (mysqli_query($conn, $addFriend)) {
        echo "Friend added";
    } else {
        echo "Error adding friend" . " " . mysqli_error($conn);
    }

  ?>
