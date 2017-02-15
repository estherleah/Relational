<?php
include_once 'database/database.php';
session_start();
include 'header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/search.js"></script>

<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="col-md-6 col-sm-offset-3">
            <div class="text-center">
                <h2>Search</h2>
                <div class="form-group">
                <input type="text" class="form-control search" id="searchid" placeholder="Search" />
                </div>
                <div id="result"></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>