<?php
include_once '../database/database.php';
session_start();

// Debugging
// include '../ChromePhp.php';
// ChromePhp::log("Hello");

// DB Connection
$connection = connectDatabase();

// Search for circle data
$circleID = $_GET['id'];
$circleDataResult = mysqli_query($connection,"  SELECT     name, description
                                                FROM       circle
                                                WHERE      circleID = '$circleID' ");

$circleData = mysqli_fetch_array($circleDataResult);

// Search for circle members
$circleMembersResult = mysqli_query($connection," SELECT      t1.firstName, t1.lastName, t1.profilephotoURL, t2.userStatus
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
                                                  ");


?>
