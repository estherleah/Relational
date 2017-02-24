<?php
include_once '../database/database.php';
session_start();

// Debugging
// include '../ChromePhp.php';
// ChromePhp::log("Hello");

// DB Connection
$connection = connectDatabase();

// Search for circle data
//$circleID = $_GET['id'];
//print_r($_GET);
$_SESSION['cirlceid'] = $_GET['id'];
$circleID = $_SESSION['cirlceid'];

// Retrieve user status
$userStatusResult = mysqli_query($connection,"  SELECT     userStatus
                                                FROM       circle_participants
                                                WHERE      userID = '$user' ", 0);

$userStatus = mysqli_fetch_array($userStatusResult)['userStatus'];

// function isAdmin() {
//     global $userStatus;
//
//     $isAdmin = false;
//     if($userStatus == 2) { $isAdmin = true; }
//     return $isAdmin;
// }

// Retrieve circle data
$circleDataResult = mysqli_query($connection,"  SELECT     name, description
                                                FROM       circle
                                                WHERE      circleID = '$circleID' ");

$circleData = mysqli_fetch_array($circleDataResult);
$circleName = $circleData['name'];
$circleDesc = $circleData['description'];

// Search for circle members
$circleMembersResult = mysqli_query($connection," SELECT      t1.userID, t1.firstName, t1.lastName, t1.profilephotoURL, t2.userStatus
                                                  FROM
                                                  ( SELECT      userID, firstName, lastName, profilephotoURL
                                                    FROM        user
                                                    WHERE       userID
                                                    IN ( SELECT DISTINCT    userID
                                                         FROM               circle_participants
                                                         WHERE              circleID = '$circleID' )
                                                    ORDER BY    lastName ) t1

                                                  INNER JOIN

                                                  ( SELECT      userID, userStatus
                                                    FROM        circle_participants
                                                    WHERE       circleID = '$circleID' ) t2

                                                  ON t1.userID = t2.userID
                                                  WHERE t2.userStatus != 0
                                                  ORDER BY t2.userStatus DESC
                                                  ");

//---------------------------------------------------------------------------------------------------

if(isset($_POST['action']) && !empty($_POST['action'])) {
  $action = $_POST['action'];
  switch($action) {
      case 'removeUser' : removeUser(); break;
      case 'makeAdmin' : makeAdmin(); break;
      case 'revokeAdmin' : revokeAdmin(); break;
      case 'makeOwner' : makeOwner(); break;
  }
}

function removeUser(){
    global $connection;
    $circleID = $_SESSION['circleid'];

    $thisUserID = $_POST['id'];

    $removeUserFromCircle = "   DELETE
                                FROM       circle_participants
                                WHERE      circleID = '$circleID' AND userID = '$thisUserID' ";

    if (mysqli_query($connection, $removeUserFromCircle)) {
        echo "You removed " . getName($thisUserID) . " from this circle";
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }
}

function makeAdmin(){
    global $connection;
    $circleID = $_SESSION['circleid'];

    $thisUserID = $_POST['id'];

    $makeUserCircleAdmin = "    UPDATE     circle_participants
                                SET        userStatus = '2'
                                WHERE      circleID = '$circleID' AND userID = '$thisUserID' ";

    if (mysqli_query($connection, $makeUserCircleAdmin)) {
        echo "You granted admin rights for " . getName($thisUserID);
    } else {
        echo "Error granting admin rights: " . mysqli_error($connection);
    }
}

function revokeAdmin(){
    global $connection;
    $circleID = $_SESSION['circleid'];

    $thisUserID = $_POST['id'];

    $revokeAdminRights = "      UPDATE     circle_participants
                                SET        userStatus = '1'
                                WHERE      circleID = '$circleID' AND userID = '$thisUserID' ";


    if (mysqli_query($connection, $revokeAdminRights)) {
        echo "You revoked admin rights for " . getName($thisUserID);
    } else {
        echo "Error revoking admin rights: " . mysqli_error($connection);
    }
}

// Potential update anomaly: Only one of the queries gets executed
// and either no one or two people will be circle owner thereafter.
function makeOwner(){
    global $connection;
    $circleID = $_SESSION['circleid'];
    global $user;

    $thisUserID = $_POST['id'];

    $makeUserCircleOwner = "    UPDATE     circle_participants
                                SET        userStatus = '2'
                                WHERE      circleID = '$circleID' AND userID = '$user' ";

    $revokeCircleOwnership = "  UPDATE     circle_participants
                                SET        userStatus = '3'
                                WHERE      circleID = '$circleID' AND userID = '$thisUserID' ";

    if (mysqli_query($connection, $makeUserCircleOwner) && mysqli_query($connection, $revokeCircleOwnership)) {
        echo "You passed the circle ownership to " . getName($thisUserID);
    } else {
        echo "Error revoking admin rights: " . mysqli_error($connection);
    }
}

function getName($id){
    global $connection;

    $thisUserID = mysqli_query($connection," SELECT   CONCAT_WS(' ', firstName, lastName) AS fullName
                                             FROM     user
                                             WHERE    userID = '$id' ", 0);

    return mysqli_fetch_array($thisUserID)['fullName'];
}

?>
