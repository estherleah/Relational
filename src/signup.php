<?php
include_once 'database/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="text-center">
            <div class="col-sm-4 col-sm-offset-4">
                <h2>New user</h2>
                <form method="post" action="includes/newuser.php" name="newUserForm">
                    <div class="form-group">
                        <label for="firstName">First Name:</label>
                        <input class="form-control" type="text" name="firstName" id="firstName" placeholder="First name" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name:</label>
                        <input class="form-control" type="text" name="lastName" id="lastName" placeholder="Last name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm password:</label>
                        <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm password" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <select class="form-control input-medium bfh-countries" name="location" id="location" <!--data-country="GB"-->></select>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of birth:</label>
                        <div id="dob">
                            <input class="form-control" type="date" id="dob" name="dob">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <div id="gender">
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="male">Male
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="female">Female
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="other">Other
                            </label>
                        </div>
                    </div>
                    <p><input class="btn btn-default" type="submit" value="Sign Up"></a></p>
                </form>
                <p>Back to login page?</p>
                <a href="index.php"><input class="btn btn-default" type="button" value="Back"></a>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-formhelpers.min.js"></script>
</body>
</html>
