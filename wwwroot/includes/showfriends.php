<?php
include_once '../database/database.php';
session_start();

// Debugging
// include '../ChromePhp.php';
// ChromePhp::log("Hello");

//THIS PART IS FROM OLD initialiseFriends findcircles
// Parts adapted from http://php.net/manual/en/mysqli.multi-query.php
//CURRENT user check that they aren't in friendship.userID2
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$userIDEscaped = $user;

$userSql = "SELECT firstName, lastName, profilephotoURL
              FROM user
              WHERE userID = '$userIDEscaped';
              ";
$userResult = mysqli_query($conn, $userSql);

if (mysqli_num_rows($userResult) === 1) {
    $row = mysqli_fetch_assoc($userResult);
    $fullName = $row["firstName"] . " " . $row["lastName"];
    $profilephotoURL = $row["profilephotoURL"];
}
//FRIEND (STATUS = 1 i.e friend accepted)
//this test query now works for mutual friendships

$testConnSql = "SELECT profilephotoURL, firstName, lastName, userID1, userID2, status
                FROM friendship AS f INNER JOIN user AS u
                ON f.userID2 = u.userID AND f.userID1 = $user
                WHERE (f.userID1 = 1) AND (f.status = 1)
                ORDER BY firstName DESC;
                ";
$testConnResult = mysqli_query($conn, $testConnSql);


$friendSql = "SELECT profilephotoURL, firstName, lastName, userID, status
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              WHERE status = 1
              ORDER BY lastName DESC
              ";
$friendResult = mysqli_query($conn, $friendSql);

//PENDING (ADDED BUT YET TO ACCEPT (on either end))
$pendingSql = "SELECT profilephotoURL, firstName, lastName, userID, status
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              AND status = 0
              ORDER BY lastName DESC
              ";
$pendingResult = mysqli_query($conn, $pendingSql);

/*FRIENDS OF FRIENDS
* make sure they're not already a current friend
* Randomise and limit the output (if specified)
*/
//Exclude yourself (you can't be friends with yourself)??
  //this currently (mostly) works but it shows pending friends in your recs... if your friends are friends with htem

$recommendQuery1 = " SELECT firstName, lastName, profilephotoURL, gender,
                            location, userID
                            FROM user
                            WHERE userID IN
                              (SELECT DISTINCT userID2
                              FROM friendship AS fo
                              WHERE userID1 IN
                                (SELECT userID2
                                  FROM friendship
                                  WHERE userID1 = '$userIDEscaped'
                                )

                                AND status = 1
                                AND fo.userID2 NOT IN
                             	(SELECT userID2
                                 FROM friendship
                                 WHERE userID1 = '$userIDEscaped')
                               	AND userID != '$userIDEscaped'

                            )

                          ";

/*
CIRCLERECS-----SHOULD BE FIXED NOW 12 MAR
 find circle participants that user is not friends with of circles user is in
* make sure they're not already a current friend
* Randomise and limit the output (if specified) */


$recommendQuery2 = " SELECT firstName, lastName, profilephotoURL, gender, location
                            FROM user
                            WHERE userID IN
                              (SELECT DISTINCT userID
                              FROM circle_participants AS c
                              WHERE c.circleID IN
                                (SELECT circleID
                                  FROM circle_participants
                                  WHERE userID = '$userIDEscaped'
                                 )

                               AND userID != '$userIDEscaped'

                               AND NOT EXISTS (
                                  SELECT *
                                  FROM friendship AS f
                                  WHERE f.userID1 = '$userIDEscaped'
                                  AND f.userID2 = c.userID
                                )
                               )
                  ";

/*RECS BY LOCATION*/

$recommendQuery3 = " SELECT * FROM `user` as u WHERE u.userID IN
                      				(SELECT DISTINCT userID
                                       FROM user AS u2
                                       WHERE u2.location IN
                                           (SELECT location
                                            FROM user
                                            WHERE userID = '$userIDEscaped'
                                                       )
                                             AND u.userID != '$userIDEscaped'
                                             AND NOT EXISTS (
                                                              SELECT *
                                                              FROM friendship AS f
                                                              WHERE f.userID1 = '$userIDEscaped'
                                                              AND f.userID2 = u2.userID
                                                            )
                                                          )
                  ";



$recommendedResult1 = mysqli_query($conn, $recommendQuery1);
$recommendedResult2 = mysqli_query($conn, $recommendQuery2);
$recommendedResult3 = mysqli_query($conn, $recommendQuery3);

$numberOfRecommendations = 5;

//here ends old friendsinitialise file
//FUNCTIONS FOR DELETING FRIENDS ETC - DON'T THINK THE PROBLEM IS HERE

if(isset($_POST['action']) && !empty($_POST['action'])) {
  $action = $_POST['action'];
  switch($action) {
      case 'deleteFriend' : deleteFriend(); break;
      case 'cancelReq' : cancelReq(); break;
      case 'addFriend' : addFriend(); break;
  }
}
//currently getting this error PHP Notice:  Undefined index: userID in /var/www/html/friends.php on line 215, referer: http://localhost/friends.php

//DELETE A FRIEND #1
function deleteFriend(){
  $userID1 = $user;
  $userID2= $_POST['id'];

    $deleteFriend = "  DELETE FROM friendship
                        WHERE      (userID1 = '$userID1' AND userID2 = '$userID2')
                                    OR (userID1 = '$userID2' AND userID2 = '$userID1')";

    if (mysqli_query($GLOBALS['conn'], $deleteFriend)) {
            echo "Friend deleted";
          } else {
              echo "Error deleting friend " . mysqli_error($GLOBALS['conn']);
          }
}
//CANCEL FRIEND REQ #2
function cancelReq(){
  $userID1 = $_SESSION['userID'];
  $thisUserID= $_POST['id'];
  $userID2 = $thisUserID;

  $cancelReq = "  DELETE FROM friendship
                      WHERE      (userID1 = '$userID1' AND userID2 = '$userID2'
                                  OR userID1 = '$userID2' AND userID2 = '$userID1')";

  if (mysqli_query($GLOBALS['conn'], $cancelReq)) {

          echo "Friend request canceled";
        } else {
            echo "Could not cancel friend request" . mysqli_error($GLOBALS['conn']);
        }
}
#ADD FRIEND #3
function addFriend(){
  $userIdEscaped = mysqli_real_escape_string($GLOBALS['conn'], $user);

  $userID1 = $userIDEscaped;
  $thisUserID= $_POST['id'];
  $userID2 = $thisUserID;


    $addFriend = "INSERT INTO friendship (userID1, userID2, status)
                  VALUES ($userID1, $userID2, 0),
                          (1, 1, 0);
                  ";

    if (mysqli_query($GLOBALS['conn'], $addFriend)) {
        echo "Friend added";
    } else {
        echo "Error adding friend" . mysqli_error($GLOBALS['conn']);
    }
}

?>
