<?php
include_once '../database/database.php';
session_start();

// Debugging
// include '../ChromePhp.php';
// ChromePhp::log("Hello");

// Search for circle data
$circleID = $_GET['id'];

// Retrieve user status
$userStatusResult = mysqli_query($conn,"  SELECT     userStatus
                                          FROM       circle_participants
                                          WHERE      userID = '$user' ", 0);

$userStatus = mysqli_fetch_array($userStatusResult)['userStatus'];

function isAdmin() {
    $isAdmin = false;
    if($userStatus == 1) { $isAdmin = true; }
    return $isAdmin;
}

// Retrieve circle data
$circleDataResult = mysqli_query($conn,"  SELECT     name, description
                                          FROM       circle
                                          WHERE      circleID = '$circleID' ");

$circleData = mysqli_fetch_array($circleDataResult);

// Search for circle members
$circleMembersResult = mysqli_query($conn," SELECT      t1.firstName, t1.lastName, t1.profilephotoURL, t2.userStatus
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

?>
