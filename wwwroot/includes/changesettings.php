<?php
include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];
/**
 * Created by PhpStorm.
 * User: Esther Leah
 * Date: 27/02/2017
 * Time: 11:44
 */

function updateGender($user)
{
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
        $sql = "UPDATE `user` SET `gender`= '$gender' WHERE `userID` = '$user'";
        if (!(mysqli_query($GLOBALS['conn'], $sql))) {
            //echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
        }
        //echo $gender;
    }
}

function updateLocation($user) {
    if (isset($_POST['location'])) {
        $location = $_POST['location'];
        $sql = "UPDATE `user` SET `location`= '$location' WHERE `userID` = '$user'";
        if (!(mysqli_query($GLOBALS['conn'], $sql))) {
            //echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
        }
        //echo $location;
    }
}

function updateDOB($user) {
    if (isset($_POST['dob'])) {
        $dob = $_POST['dob'];
        $sql = "UPDATE `user` SET `dob`= '$dob' WHERE `userID` = '$user'";
        if (!(mysqli_query($GLOBALS['conn'], $sql))) {
            //echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
        }
        //echo $dob;
    }
}

function updatePrivacy($user) {
    $privacyID = 0;
    if (isset($_POST['privacy'])) {
        if (trim($_POST['privacy']) == "public") {
            $privacyID = 1;
        }
        if (trim($_POST['privacy']) == "friends of friends") {
            $privacyID = 2;
        }
        if (trim($_POST['privacy']) == "circles") {
            $privacyID = 3;
        }
        if (trim($_POST['privacy']) == "friends") {
            $privacyID = 4;
        }
        if (trim($_POST['privacy']) == "private") {
            $privacyID = 5;
        }
        $sql = "UPDATE `user` SET `privacyID`= $privacyID WHERE `userID` = '$user'";
        if (!(mysqli_query($GLOBALS['conn'], $sql))) {
            //echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
        }
        //echo $privacyID;
    }
}

if (isset($_POST['gender']) and trim($_POST['gender']) != null)
    updateGender($user);
if (isset($_POST['location']) and trim($_POST['location']) != null)
    updateLocation($user);
if (isset($_POST['dob']) and trim($_POST['dob']) != null)
    updateDOB($user);
if (isset($_POST['privacy']) and trim($_POST['privacy']) != null)
    updatePrivacy($user);

header("Location: ../settings.php");

?>
