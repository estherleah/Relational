<?php

include_once '../database/database.php';
session_start();

function isValidUser()
{
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hash = base64_encode(sha1($password, true));
    $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$hash'";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user'] = $row['userID'];
        $_SESSION['name'] = $row["firstName"] . " " . $row["lastName"];
        return True;
    }
    else {
        return False;
    }
}

if (isValidUser()) {
    header("Location: ../profile.php");
    die();
}
else {
    echo "<p>Login details incorrect.</p>";
    echo "<p><a href='../index.php'>Return to login</a></p>";
}

?>
