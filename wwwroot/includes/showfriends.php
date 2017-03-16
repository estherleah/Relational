<?php
ini_set('display_errors',0);
include_once '../database/database.php';
if (!isset($_SESSION)) {
    session_start();
}

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
$requestedSql = "SELECT profilephotoURL, firstName, lastName, userID, status, originUserID
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              AND status = 0
              AND originUserID != '$userIDEscaped'
              ORDER BY lastName DESC
              ";
$requestedResult = mysqli_query($conn, $requestedSql);


//PENDING (ADDED BUT THE OTHER PARTY HAS YET TO ACCEPT
$pendingSql = "SELECT profilephotoURL, firstName, lastName, userID, status, originUserID
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              AND status = 0
              AND originUserID = '$userIDEscaped'
              ORDER BY lastName DESC
              ";
$pendingResult = mysqli_query($conn, $pendingSql);

/*FRIENDS OF FRIENDS
* make sure they're not already a current friend
* Randomise and limit the output (if specified)
*/
//Exclude yourself (you can't be friends with yourself)??
  //this currently (mostly) works but it shows pending friends in your recs... if your friends are friends with htem
//THIS IS THE NEW AND UPDATED FRIENDS OF FRIENDS QUERY FIXED 14 MAR
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
                               	AND userID2 = '$userIDEscaped'

                            )
                            AND userID != '$userIDEscaped'

                          ";
/*
CIRCLERECS-----SHOULD BE FIXED NOW 12 MAR
 find circle participants that user is not friends with of circles user is in
* make sure they're not already a current friend
* Randomise and limit the output (if specified) */


$recommendQuery2 = " SELECT firstName, lastName, profilephotoURL, gender, location, userID
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

/*RECS BY LOCATION WORKING */

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

$collaborativeFilter = "SELECT userID, COUNT(userID) AS matches
                            FROM (
                              (SELECT DISTINCT userID2 AS userID
                              FROM friendship AS fo
                              WHERE userID1 IN
                                (SELECT userID2
                                FROM friendship
                                WHERE userID1 = '$userIDEscaped')
                              AND status = 1
                              AND fo.userID2 NOT IN
                                (SELECT userID2
                                FROM friendship
                                WHERE userID1 = '$userIDEscaped')
                              AND userID2 != '$userIDEscaped'
                              ORDER BY RAND()
                              )
                            UNION ALL
                              (SELECT DISTINCT userID
                              FROM circle_participants AS c
                              WHERE c.circleID IN
                                (SELECT circleID
                                FROM circle_participants
                                WHERE userID = '$userIDEscaped')
                              AND userID != '$userIDEscaped'
                              AND NOT EXISTS
                                (SELECT *
                                FROM friendship AS f
                                WHERE f.userID1 = '$userIDEscaped'
                                AND f.userID2 = c.userID)
                              ORDER BY RAND()
                              )
                            UNION ALL
                              (SELECT DISTINCT userID
                              FROM user AS u2
                              WHERE u2.location IN
                                (SELECT location
                                FROM user
                                WHERE userID = '$userIDEscaped')
                              AND u2.userID != '$userIDEscaped'
                              AND NOT EXISTS
                                (SELECT *
                                FROM friendship AS f
                                WHERE f.userID1 = '$userIDEscaped'
                                AND f.userID2 = u2.userID)
                              ORDER BY RAND()
                              )
                            ) result
                            GROUP BY result.userID
                            ORDER BY matches DESC


                            ";

$collaborativeFilterResult = mysqli_query($conn, $collaborativeFilter);

$recommendedResult1 = mysqli_query($conn, $recommendQuery1);
$recommendedResult2 = mysqli_query($conn, $recommendQuery2);
$recommendedResult3 = mysqli_query($conn, $recommendQuery3);

$numberOfRecommendations = 5;

//TESTING VIEWS Here
$viewString = "matches" . $user;

$getView = "SELECT * FROM $viewString";
$getViewResult = mysqli_query($conn, $getView);

//here ends old friendsinitialise file
//FUNCTIONS FOR DELETING FRIENDS ETC - DON'T THINK THE PROBLEM IS HERE

if(isset($_POST['action']) && !empty($_POST['action'])) {
  $action = $_POST['action'];
  switch($action) {
      case 'deleteFriend' : deleteFriend(); break;
      case 'acceptReq' : acceptReq(); break;
      case 'cancelReq' : cancelReq(); break;
      case 'addFriend' : addFriend(); break;
      case 'generateView': generateView(); break;
  }
}
//currently getting this error PHP Notice:  Undefined index: userID in /var/www/html/friends.php on line 215, referer: http://localhost/friends.php
//HEY THIS WORKS TOO
//DELETE A FRIEND #1
function deleteFriend(){
  $userID1 = $_SESSION['user'];
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

//THIS NOW WORKS

//ACCEPT FRIEND REQ #4
function acceptReq(){
  //BE CAREFUL - USERID1 receives and accepts the request, USERID2 is the sender
  //INSERT THE ACCEPTOR ROW FIRST THEN THE SENDER
  $userID1 = $_SESSION['user'];
  $userID2 = $_POST['id'];
//to update one row I would have used a normal UPDATE statement, this is sort of a 'hack'
  $acceptReq = "  INSERT INTO friendship (userID1, userID2, status, originUserID)
                  VALUES ('$userID1','$userID2','1','$userID2'), ('$userID2','$userID1','1','$userID2')
                  ON DUPLICATE KEY UPDATE status = 1
                  ";

  if (mysqli_query($GLOBALS['conn'], $acceptReq)) {

          echo "You are now friends!";
        } else {
          echo "Could not accept friend request" . mysqli_error($GLOBALS['conn']);
        }
}

//CANCEL FRIEND REQ #2
function cancelReq(){
  $userID1 = $_SESSION['user'];
  $userID2 = $_POST['id'];


  $cancelReq = "  DELETE FROM friendship
                      WHERE      (userID1 = '$userID1' AND userID2 = '$userID2'
                                  OR userID1 = '$userID2' AND userID2 = '$userID1')";

  if (mysqli_query($GLOBALS['conn'], $cancelReq)) {

          echo "Friend request cancelled";
        } else {
          echo "Could not cancel friend request" . mysqli_error($GLOBALS['conn']);
        }
}

#ADD FRIEND #3
//YES ADDING FRIENDS WORKS NOW - but I forgot about accepting friend requests
//intval cast isn't actually needed
function addFriend(){
//  $userIdEscaped = mysqli_real_escape_string($GLOBALS['conn'], $user);

  $userID1 = $_SESSION['user'];
//  $userID1 = intval($userID1);
  $userID2 = $_POST['id'];
//  $userID2 = intval($userID2);

//SYMMETRIC RELATION - must work both ways
//YES THIS WORKS NOW
    $addFriend = "INSERT INTO friendship (userID1, userID2, status, originUserID)
                  VALUES ('$userID1', '$userID2', '0', '$userID1'),
                        ('$userID2', '$userID1', '0', '$userID1');
                    ";

    if (mysqli_query($GLOBALS['conn'], $addFriend)) {
        echo "Friend added";
    } else {
        echo "Error adding friend" . mysqli_error($GLOBALS['conn']);
    }
}

function generateView(){

  $thisUserID = $_SESSION['user'];

  //this is the statement to generate views - I need to think about this
  //is it better to just create all the views beforehand?
  //if we run out of time i guess we can just say in the video that the views already exist
  //and get updated each time something happens

  //this concatenates matches with '$thisUserID' to name the view of matches
  $viewString = $_POST['id'];

  //oh god this actually works now
  //actually generating the view is working but the matches.concatenation isn't
  $generateView = "CREATE OR REPLACE VIEW $viewString AS
                            (SELECT userID, COUNT(userID) AS matches
                            FROM (
                              (SELECT DISTINCT userID2 AS userID
                              FROM friendship AS fo
                              WHERE userID1 IN
                                (SELECT userID2
                                FROM friendship
                                WHERE userID1 = '$thisUserID')
                              AND status = 1
                              AND fo.userID2 NOT IN
                                (SELECT userID2
                                FROM friendship
                                WHERE userID1 = '$thisUserID')
                              AND userID2 != '$thisUserID'
                              ORDER BY RAND()
                              )
                            UNION ALL
                              (SELECT DISTINCT userID
                              FROM circle_participants AS c
                              WHERE c.circleID IN
                                (SELECT circleID
                                FROM circle_participants
                                WHERE userID = '$thisUserID')
                              AND userID != '$thisUserID'
                              AND NOT EXISTS
                                (SELECT *
                                FROM friendship AS f
                                WHERE f.userID1 = '$thisUserID'
                                AND f.userID2 = c.userID)
                              ORDER BY RAND()
                              )
                            UNION ALL
                              (SELECT DISTINCT userID
                              FROM user AS u2
                              WHERE u2.location IN
                                (SELECT location
                                FROM user
                                WHERE userID = '$thisUserID')
                              AND u2.userID != '$thisUserID'
                              AND NOT EXISTS
                                (SELECT *
                                FROM friendship AS f
                                WHERE f.userID1 = '$thisUserID'
                                AND f.userID2 = u2.userID)
                              ORDER BY RAND()
                              )
                            ) result
                            GROUP BY result.userID
                            ORDER BY matches DESC

                              )
                            ";

    if (mysqli_query($GLOBALS['conn'], $generateView)) {
        echo "View created/replaced";
    } else {
        echo "Error generating view " . mysqli_error($GLOBALS['conn']);
    }
}





?>
