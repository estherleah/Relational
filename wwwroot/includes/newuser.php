<?php
include '../database/database.php';
/**
 * Created by PhpStorm.
 * User: Esther Leah
 * Date: 02/02/2017
 * Time: 20:52
 */

// TODO: Check if the email address is already in the database before submitting the query.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>New user</title>
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
            <h2>Create an Account</h2>
            <div class="col-sm-6 col-sm-offset-3">
                <?php
                function isDataValid()
                {
                    $errorMessage = null;
                    if (!isset($_POST['firstName']) or trim($_POST['firstName']) == '')
                        $errorMessage = "You must enter your first name.";
                    else if (!isset($_POST['lastName']) or trim($_POST['lastName']) == '')
                        $errorMessage = 'You must enter your last name.';
                    else if (!isset($_POST['email']) or trim($_POST['email']) == '')
                        $errorMessage = 'You must enter your email address.';
                    else if (!isset($_POST['password']) or trim($_POST['password']) == '')
                        $errorMessage = 'You must enter your password';
                    else if (!isset($_POST['confirmPassword']) or trim($_POST['confirmPassword']) == '')
                        $errorMessage = 'You must confirm your password.';
                    else if (!isset($_POST['confirmPassword']) or (trim($_POST['password']) != trim($_POST['confirmPassword'])))
                        $errorMessage = 'Your passwords must match';
                    if ($errorMessage !== null)
                    {
                        echo <<<EOM
          <p>Error: $errorMessage</p>
EOM;
                        echo "<p><a href='../signup.php'>Return to input form</a></p>";
                        return False;
                    }
                    return True;
                }

                function getUser()
                {
                    $user = array();
                    $user["firstName"] = $_POST["firstName"];
                    $user["lastName"] = $_POST["lastName"];
                    $user["email"] = $_POST["email"];
                    $user["password"] = $_POST["password"];
                    if (isset($_POST['gender'])) {
                        $user["gender"] = $_POST['gender'];
                    }
                    if (isset($_POST['location'])) {
                        $user["location"] = $_POST['location'];
                    }
                    if (isset($_POST['dob'])) {
                        $user["dob"] = $_POST['dob'];
                    }
                    return $user;
                }

                function printUser($user)
                {
                    echo "<p>First Name: ${user['firstName']}</p>";
                    echo "<p>Last Name: ${user['lastName']}</p>";
                    echo "<p>Email: ${user['email']}</p>";
                    echo "<p>Password: ${user['password']}</p>";
                }

                function addUserToDatabase($user)
                {
                    $firstName = $user['firstName'];
                    $lastName = $user['lastName'];
                    $email = $user['email'];
                    $password = $user['password'];
                    $hash = base64_encode(sha1($password, true));
                    $sql = "INSERT INTO user (firstName, lastName, email, password, privacyID) 
                        VALUES ('$firstName', '$lastName', '$email', '$hash', 1)";
                    $conn = connectDatabase();
                    if (mysqli_query($conn, $sql)) {
                        addOptionalData($user);
                        echo "New user created successfully";
                        echo "<p><a href='../index.php'>Sign in</a></p>";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        echo "<p><a href='../signup.php'>Return to input form</a></p>";
                    }
                }

                function addOptionalData($user)
                {
                    $email = $user['email'];
                    if(isset($_POST['gender'])) {
                        $gender = $user["gender"];
                        $sql = "UPDATE `user` SET `gender`= '$gender' WHERE `email` = '$email'";
                        $conn = connectDatabase();
                        if (!(mysqli_query($conn, $sql))) {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }
                    if(isset($_POST['location'])) {
                        $location = $user["location"];
                        $sql = "UPDATE `user` SET `gender`= '$location' WHERE `email` = '$email'";
                        $conn = connectDatabase();
                        if (!(mysqli_query($conn, $sql))) {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }
                    if(isset($_POST['dob'])) {
                        $dob = $user["dob"];
                        $sql = "UPDATE `user` SET `gender`= '$dob' WHERE `email` = '$email'";
                        $conn = connectDatabase();
                        if (!(mysqli_query($conn, $sql))) {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }
                }

                if (isDataValid())
                {
                    $newUser = getUser();
                    //printUser($newUser);
                    addUserToDatabase($newUser);
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
