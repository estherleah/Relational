<?php

$hostname = "localhost";
$username = "root";
$password = "root";
$database = "social_network";

// Create connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
