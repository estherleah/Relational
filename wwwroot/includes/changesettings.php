<?php
include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];
$userIDEscaped = mysqli_real_escape_string($conn, $user);

function updateFirstName($user)
{
   if (isset($_POST['firstName'])) {
       $firstNameEscaped = mysqli_real_escape_string($GLOBALS['conn'], $_POST['firstName']);
       $sql = "UPDATE `user` SET `firstName`= '$firstNameEscaped' WHERE `userID` = '$user'";
       if (!(mysqli_query($GLOBALS['conn'], $sql))) {
           echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
       }
   }
}

function updateLastName($user)
{
   if (isset($_POST['lastName'])) {
       $lastNameEscaped = mysqli_real_escape_string($GLOBALS['conn'], $_POST['lastName']);
       $sql = "UPDATE `user` SET `lastName`= '$lastNameEscaped' WHERE `userID` = '$user'";
       if (!(mysqli_query($GLOBALS['conn'], $sql))) {
           echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
       }
   }
}

function updateEmail($user)
{
   if (isset($_POST['email'])) {
       $emailEscaped = mysqli_real_escape_string($GLOBALS['conn'], $_POST['email']);
       $sql = "UPDATE `user` SET `email`= '$emailEscaped' WHERE `userID` = '$user'";
       if (!(mysqli_query($GLOBALS['conn'], $sql))) {
           echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
       }
   }
}

function updatePassword($user)
{
   if (isset($_POST['password'])) {
       $passwordHash = base64_encode(sha1($_POST['password'], true));
       $sql = "UPDATE `user` SET `password`= '$passwordHash' WHERE `userID` = '$user'";
       if (!(mysqli_query($GLOBALS['conn'], $sql))) {
           echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
       }
   }
}

function updateGender($user)
{
    if (isset($_POST['gender'])) {
        $genderEscaped = mysqli_real_escape_string($GLOBALS['conn'], $_POST['gender']);
        $sql = "UPDATE `user` SET `gender`= '$genderEscaped' WHERE `userID` = '$user'";
        if (!(mysqli_query($GLOBALS['conn'], $sql))) {
            echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
        }
    }
}

function updateLocation($user) {
    if (isset($_POST['location'])) {
        $locationEscaped = mysqli_real_escape_string($GLOBALS['conn'], $_POST['location']);
        $sql = "UPDATE `user` SET `location`= '$locationEscaped' WHERE `userID` = '$user'";
        if (!(mysqli_query($GLOBALS['conn'], $sql))) {
            echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
        }
    }
}

function updateDOB($user) {
    if (isset($_POST['dob'])) {
        $dobEscaped = mysqli_real_escape_string($GLOBALS['conn'], $_POST['dob']);
        $sql = "UPDATE `user` SET `dob`= '$dobEscaped' WHERE `userID` = '$user'";
        if (!(mysqli_query($GLOBALS['conn'], $sql))) {
            echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
        }
    }
}

function updatePrivacy($user) {
    if (isset($_POST['privacy'])) {
        $privacyIDEscaped = mysqli_real_escape_string($GLOBALS['conn'], $_POST['privacy']);
        $sql = "UPDATE `user` SET `privacyID`=$privacyIDEscaped WHERE `userID` = '$user'";
        if (!(mysqli_query($GLOBALS['conn'], $sql))) {
            echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
        }
    }
}

if (isset($_POST['firstName']) and trim($_POST['firstName']) != null)
    updateFirstName($userIDEscaped);
if (isset($_POST['lastName']) and trim($_POST['lastName']) != null)
    updateLastName($userIDEscaped);
if (isset($_POST['email']) and trim($_POST['email']) != null)
    updateEmail($userIDEscaped);
if (isset($_POST['password']) and isset($_POST['confirmPassword']) and ($_POST['password'] === $_POST['confirmPassword']))
    updatePassword($userIDEscaped);
if (isset($_POST['gender']) and trim($_POST['gender']) != null)
    updateGender($userIDEscaped);
if (isset($_POST['location']) and trim($_POST['location']) != null)
    updateLocation($userIDEscaped);
if (isset($_POST['dob']) and trim($_POST['dob']) != null)
    updateDOB($userIDEscaped);
if (isset($_POST['privacy']) and trim($_POST['privacy']) != null)
    updatePrivacy($userIDEscaped);

header("Location: ../profile.php");

?>
