<?php
include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];

if (!isset($_POST['post']) or trim($_POST['post']) == '') {
    echo "Please enter some text.";
    header("Location: ../chat.php");
}
else {
    // temp until we maintain state
    $entry = $_POST["post"];
    $date = date("Y-m-d H:i:s");

    $userIdEscaped = mysqli_real_escape_string($conn, $user);
    $entryEscaped = mysqli_real_escape_string($conn, $entry);
    $dateEscaped = mysqli_real_escape_string($conn, $date);

    $messagensertISQL = "INSERT INTO message (userID, message, date)
                    VALUES ('$userIdEscaped', '$entryEscaped', '$dateEscaped')";

    if (mysqli_query($conn, $messagensertISQL)) {
        echo "Message sent";
        header("Location: ../chat.php");
    } else {
        echo "Error: " . $messagensertISQL . "<br>" . mysqli_error($conn);
    }
}

?>
