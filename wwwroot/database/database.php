<?php
/**
 * Connection to database
 * User: Esther Leah
 * Date: 24/01/2017
 * Time: 22:47
 */

$hostname = "localhost";
$username = "root";
$password = "root";
$database = "social_network";

// Create connection
global $conn;
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

function connectDatabase()
{
    $hostname = "localhost";
    $username = "root";
    $password = "root";
    $database = "social_network";
    $conn = mysqli_connect($hostname, $username, $password, $database);
    return $conn;
}

?>
