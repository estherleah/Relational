<?php
session_start();

$user = $_SESSION['user'];
$name = $_SESSION['name'];

// DB Connection
global $thisUserData;

// Search for user data
if(isset($_GET['id'])){
    // Get userID
    $_SESSION['thisUserID'] = $_GET['id'];
    $thisUserID = $_SESSION['thisUserID'];

    // Get user data
    $thisUserData = mysqli_fetch_array(mysqli_query($conn," SELECT   firstName, lastName, dob, gender, location, profilephotoURL
                                                            FROM     user
                                                            WHERE    userID = '$thisUserID' ", 0));

} else {
    // Get user data
    $thisUserData = mysqli_fetch_array(mysqli_query($conn," SELECT   firstName, lastName, dob, gender, location, profilephotoURL
                                                            FROM     user
                                                            WHERE    userID = '$user' ", 0));
}

// Set local variables
$thisUserFullName = $thisUserData['firstName'] . " " . $thisUserData['lastName'];
$thisUserDOB = $thisUserData['dob'];
$thisUserGender = $thisUserData['gender'];
$thisUserLocation = $thisUserData['location'];
$thisUserProfilePic = $thisUserData['profilephotoURL'];

// if ($row = mysqli_fetch_assoc($thisUserData)) { $thisUserProfilePic = $thisUserData['profilephotoURL']; }
// else { echo "Unable to find profile picture"; }

?>
