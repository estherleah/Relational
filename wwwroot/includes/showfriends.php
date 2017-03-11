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

/*

$testConnSql = "SELECT profilephotoURL, firstName, lastName, status, userID1, userID2, status
                FROM friendship AS f JOIN user AS u

                ";
$testConnResult = mysqli_query($conn, $testConnSql);
*/

$friendSql = "SELECT profilephotoURL, firstName, lastName, status
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              WHERE status = 1
              ORDER BY lastName DESC;
              ";
$friendResult = mysqli_query($conn, $friendSql);

//PENDING (ADDED BUT YET TO ACCEPT (on either end))
$pendingSql = "SELECT profilephotoURL, firstName, lastName, status
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              AND status = 0
              ORDER BY lastName DESC;
              ";
$pendingResult = mysqli_query($conn, $pendingSql);

/* find friends of friends
* make sure they're not already a current friend
* Randomise and limit the output (if specified)
*/

//Exclude yourself (you can't be friends with yourself)??
  //this line prevents your own account from showing up in recommendationsList
//WHERE fi.userID2 = '$userIDEscaped'
//still displays pending friendships
//check this query again at some point??? still displays yourself, friends etc

$recommendQuery = " SELECT firstName, lastName, profilephotoURL, gender,
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

                                AND NOT EXISTS (
                                  SELECT *
                                  FROM friendship AS fi
                                  WHERE fi.userID2 = fo.userID2
                                  AND fi.userID2 = '$userIDEscaped'
                                )

                                AND NOT EXISTS (
                                  SELECT *
                                  FROM friendship AS fi
                                  WHERE fi.userID1 = fo.userID1
                                  AND fi.userID1 = '$userIDEscaped'

                                )

                              )
                              ORDER BY RAND() LIMIT $friendsOfFriendsLimit
                            ;
                          ";


/*
$recommendQuery = " SELECT firstName, lastName, profilephotoURL, gender, location
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

                                AND NOT EXISTS (
                                  SELECT *
                                  FROM friendship AS fi
                                  WHERE fi.userID2 = fo.userID2
                                  AND fi.userID2 = '$userIDEscaped'


                                )
                              )
                              ORDER BY RAND() LIMIT $friendsOfFriendsLimit
                            ;
                          ";
/*
 find circle participants that user is not friends with of circles user is in
* make sure they're not already a current friend
* Randomise and limit the output (if specified) */

$recommendQuery = " SELECT firstName, lastName, profilephotoURL, gender, location
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
                              ORDER BY RAND() LIMIT $circleFriendsLimit
                            ;
                  ";

$recommendedResult = mysqli_multi_query($conn, $recommendQuery);

$numberOfRecommendations = 5;

//here ends old friendsinitialise file


// Search for circle data
/*
if(isset($_GET['id'])){
    $_SESSION['circleID'] = $_GET['id'];
    $circleID = $_SESSION['circleID'];
}

$userStatusResult = mysqli_query($conn,"  SELECT     userStatus
                                                FROM       circle_participants
                                                WHERE      userID = '$user' AND circleID = '$circleID' ", 0);

$userStatus = mysqli_fetch_array($userStatusResult)['userStatus'];

$circleDataResult = mysqli_query($conn,"  SELECT     name, description
                                                FROM       circle
                                                WHERE      circleID = '$circleID' ");

$circleData = mysqli_fetch_array($circleDataResult);
$circleName = $circleData['name'];
$circleDesc = $circleData['description'];

// Search for circle members
$circleMembersResult = mysqli_query($conn," SELECT      t1.userID, t1.firstName, t1.lastName, t1.profilephotoURL, t2.userStatus
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
*/
//---------------------------------------------------------------------------------------------------

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

    $deleteFriend1 = "   DELETE
                        FROM       friendship
                        WHERE      userID1 = '$userID1' AND userID2 = '$userID2' ";
    //NEED TO DELETE FRIENDSHIP IN BOTH DIRECTIONS
    $deleteFriend2 = "   DELETE
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
