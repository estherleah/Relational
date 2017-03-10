<?php
include_once '../database/database.php';
session_start();
/**
 * Created by PhpStorm.
 * User: Esther Leah
 * Date: 02/02/2017
 * Time: 22:56
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>

<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="text-center">
            <div class="col-sm-6 col-sm-offset-3">
                <?php
                function isDataValid()
                {
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
                }

                function isValidUser()
                {
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $hash = base64_encode(sha1($password, true));
                    $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$hash'";
                    $conn = connectDatabase();
                    $result = mysqli_query($conn, $sql);
                    if ($row = mysqli_fetch_assoc($result)) {
                        $_SESSION['user'] = $row['userID'];
                        $_SESSION['name'] = $row["firstName"] . " " . $row["lastName"];
                        return True;
                    }
                    else {
                        echo "Login details incorrect";
                        return False;
                    }
                }

                if (isValidUser()) {
                    header("Location: ../dashboard.php");
                }
                else {
                    header("Location: ../index.php");
                }

                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
