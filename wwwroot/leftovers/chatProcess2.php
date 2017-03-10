<?php
include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];

if (!isset($_POST['post']) or trim($_POST['post']) == '') {
    echo "Please enter some text.";
    header("Location: ../chat2.php");
}
else {
    // temp until we maintain state
    $message = $_POST["post"];
    $date = date("Y-m-d H:i:s");

    $userIdEscaped = mysqli_real_escape_string($conn, $user);
    $messageEscaped = mysqli_real_escape_string($conn, $message);
    $dateEscaped = mysqli_real_escape_string($conn, $date);
//11 is just a placeholder value until i figure out how to make it for that specific circle
    $messageInsertSql = "INSERT INTO message (userID, message, circleID, date)
                    VALUES ('$userIdEscaped', '$messageEscaped', 11, '$dateEscaped')";

    if (mysqli_query($conn, $messageInsertSql)) {
        echo "Message sent";
        header("Location: ../chat2.php");
    } else {
        echo "Error: " . $messageInsertSql . "<br>" . mysqli_error($conn);
    }
}

?>
