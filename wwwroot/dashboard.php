<?php
include_once 'database/database.php';
session_start();
include 'header.php';

/**
 * Created by PhpStorm.
 * User: Esther Leah
 * Date: 15/02/2017
 * Time: 13:33
 */
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

<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="row text-center">
            <div class="col-sm-6 col-sm-offset-3">
                <h2><?php echo $name?></h2>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading"><?php echo $name?></div>
                <div class="panel-body">Profile picture</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Blog</div>
                <div class="panel-body">Most recent blog posts</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Circles</div>
                <div class="panel-body">Circles</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Photos</div>
                <div class="panel-body">Most recent photo collection</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>