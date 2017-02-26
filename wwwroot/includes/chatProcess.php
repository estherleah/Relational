<?php
include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
//the problem isn't here either I think
/*
if (!isset($_POST['post']) or trim($_POST['post']) == '') {
    echo "Please enter some text. (PHP)";
    header("Location: ../chat.php");
}
else {
    // temp until we maintain state

    */
    $message = $_POST["message"];
    $date = date("Y-m-d H:i:s");

    $userIdEscaped = mysqli_real_escape_string($conn, $user);
    $messageEscaped = mysqli_real_escape_string($conn, $message);
    $dateEscaped = mysqli_real_escape_string($conn, $date);

    $messageInsertSql = "INSERT INTO message (userID, message, date)
                    VALUES ('$userIdEscaped', '$messageEscaped', '$dateEscaped')";
    //this isn't the problem
    if (mysqli_query($conn, $messageInsertSql)) {
        echo "Message sent";
    } else {
        echo "Error: " . $messageInsertSql . "<br>" . mysqli_error($conn);
    }


?>
