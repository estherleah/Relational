<?php
include_once 'database/database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include 'header.php'; ?>
<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
            <div class="text-center">
                <h2>Search</h2>
                <div class="form-group">
                <input type="text" class="form-control search" id="searchid" placeholder="Search" />
                <div id="result"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/search.js"></script>
</body>
</html>
