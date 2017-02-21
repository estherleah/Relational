<?php
  include_once '../database/database.php';
  session_start();

  //I think this file is broken
  //table for messages - message
  //most RECENT messages appear at the bottom
  //fields: messageID, circleID, userID, message, date
  //user table is just user
  if (isset($_POST['submit'])) {
    //$user = mysqli_real_escape_string($connection, $_POST['user']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    //select JUST the userID of the current logged in user
    $currentUser = mysql_query("SELECT userID from user where userID ='".$_SESSION['userID']."'");

    //get the current time and date not entirely sure about this
    date_default_timezone_set('Europe/London');
    $time = date('h:i:s a', time());

    //adapted old chat room, userID should be preset so remove user
    if (!isset($message) || $message == '') {
      echo "Warning: you did not enter a message."
      header("Location: ../chat.php?");

    }
    else {
      $messageInsert = "INSERT INTO message (userID, message, date)
                VALUES ('$currentUser', '$message', '$time')";
      if (!mysqli_query($conn, $messageInsert)) {
        die('Error: ' . mysqli_error($conn));
      }
      else {
        header('Location: chatProcess.php');
        exit();
      }
    }
  }
?>
