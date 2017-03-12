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


$friendSql = "SELECT profilephotoURL, firstName, lastName, status
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              WHERE status = 1
              ORDER BY lastName DESC
              ";
$friendResult = mysqli_query($conn, $friendSql);

//PENDING (ADDED BUT YET TO ACCEPT (on either end))
$pendingSql = "SELECT profilephotoURL, firstName, lastName, status
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

if(isset($_POST['action']) && !empty($_POST['action'])) {
  $action = $_POST['action'];
  switch($action) {
      case 'deleteFriend' : deleteFriend(); break;
      case 'cancelReq' : cancelReq(); break;
      case 'addFriend' : addFriend(); break;
  }
}

function deleteFriend(){
    $userID1 = $_SESSION['userID'];
    $userID2 = $_POST['id'];

    $deleteFriend1 = "  DELETE
                        FROM       friendship
                        WHERE      userID1 = '$userID1' AND userID2 = '$userID2' ";
    //NEED TO DELETE FRIENDSHIP IN BOTH DIRECTIONS, POSSIBLY NEXT THESE QUERIES
    $deleteFriend2 = "  DELETE
                        FROM       friendship
                        WHERE      userID1 = '$userID2' AND userID2 = '$userID1' ";

    if (mysqli_query($GLOBALS['conn'], $deleteFriend1)) {
          if (mysqli_query($GLOBALS['conn'], $deleteFriend2)) {
            echo "Friend deleted";
          } else {
              echo "Error deleting friend " . mysqli_error($GLOBALS['conn']);
          }
    } else {
        echo "Error deleting friend: " . mysqli_error($GLOBALS['conn']);
    }
}

function cancelReq(){
  $userID1 = $_SESSION['userID'];

  $userID2 = $_POST['id'];

  $deleteFriend1 = "   DELETE
                      FROM       friendship
                      WHERE      userID1 = '$userID1' AND userID2 = '$userID2' ";
  //NEED TO DELETE FRIENDSHIP IN BOTH DIRECTIONS (BASICALLY delete request)
  $deleteFriend2 = "   DELETE
                      FROM       friendship
                      WHERE      userID1 = '$userID2' AND userID2 = '$userID1' ";

  if (mysqli_query($GLOBALS['conn'], $deleteFriend1)) {
        if (mysqli_query($GLOBALS['conn'], $deleteFriend2)) {
          echo "Friend request canceled";
        } else {
            echo "Could not cancel friend request" . mysqli_error($GLOBALS['conn']);
        }
  } else {
      echo "Could not cancel friend request" . mysqli_error($GLOBALS['conn']);
  }
}

function addFriend(){
    $circleID = $_SESSION['circleID'];

    $thisUserID = $_POST['id'];

    $addFriendRights = "      UPDATE     circle_participants
                                SET        userStatus = '1'
                                WHERE      circleID = '$circleID' AND userID = '$thisUserID' ";


    if (mysqli_query($GLOBALS['conn'], $addFriendRights)) {
        echo "You revoked admin rights for " . getName($thisUserID);
    } else {
        echo "Error revoking admin rights: " . mysqli_error($GLOBALS['conn']);
    }
}

?>
