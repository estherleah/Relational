<?php
include_once 'database/database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create a Circle</title>
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
                <h2>New Circle</h2>
                <form method="post" action="includes/newcircle.php" name="newCircleForm">
                    <div class="form-group">
                        <label for="firstName">Circle Name</label>
                        <input class="form-control" type="text" name="circleName" id="circleName" placeholder="Take a descriptive name">
                    </div>
                    <div class="form-group">
                        <label for="exampleTextarea">Circle Description</label>
                        <textarea class="form-control" type="text" name="circleDesc" id="circleDesc" rows="3" placeholder="Let others know what your circle is about"></textarea>
                    </div>
                    <p><input class="btn btn-default" type="submit" value="Create Circle"></a></p>
                </form>
                <a href="circles.php"><input class="btn btn-default" type="button" value="Back"></a>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
