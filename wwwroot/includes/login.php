<?php

include_once '../database/database.php';
session_start();

/*function isDataValid()
{
  echo "calling isDataValid";
    $errorMessage = null;
    if (!isset($_POST['email']) or trim($_POST['email']) == '')
        $errorMessage = 'You must enter your email address.';
    else if (!isset($_POST['password']) or trim($_POST['password']) == '')
        $errorMessage = 'You must enter your password';
    if ($errorMessage !== null)
    {
        echo <<<EOM
<p>Error: $errorMessage</p>
EOM;
        echo "<p><a href='../index.php'>Return to login</a></p>";
        return False;
    }
    return True;
}*/

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
    header("Location: ../dashboard.php");
    die();
}
else {
    echo "<p>Login details incorrect.</p>";
    echo "<p><a href='../index.php'>Return to login</a></p>";

    // Doesn't work on MAMP
    //header("Location: ../index.php");
    //die();
}

?>
