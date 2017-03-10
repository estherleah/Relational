<?php
include_once 'database/database.php';
session_start();
/**
 * Login page
 * User: Esther Leah
 * Date: 24/01/2017
 * Time: 22:11
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="text-center">
            <div class="col-sm-4 col-sm-offset-4">
                <h2>Login</h2>
                <form method="post" action="includes/login.php" name="loginForm">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <p><input class="btn btn-default" type="submit" value="Login"></p>
                </form>
                <p>Not yet a user? Sign up now.</p>
                <a href="signup.php"><input class="btn btn-default" type="button" value="Sign up"></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>