<?php
include_once 'database/database.php';
session_start();
include 'header.php';
/**
 * Created by PhpStorm.
 * User: Esther Leah
 * Date: 21/02/2017
 * Time: 15:11
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Settings</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap-formhelpers.min.js"></script>
    <script src="js/bootstrap-formhelpers-countries.js"></script>
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
                <h2>Settings</h2>
                <form method="post" action="includes/changesettings.php" name="settingsForm">
                    <!--<div class="form-group">
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
                    </div>-->
                    <div class="form-group">
                        <label for="privacy">Privacy:</label>
                        <select class="form-control" name="privacy" id="privacy">
                            <option value="public">Public</option>
                            <option value="friends of friends">Friends of friends</option>
                            <option value="circles">Circles</option>
                            <option value="friends">Friends</option>
                            <option value="private">Private</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <select class="form-control input-medium bfh-countries" name="location" id="location" <!--data-country="$location"-->></select>
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
                    <p><input class="btn btn-default" type="submit" value="Change"></a></p>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
