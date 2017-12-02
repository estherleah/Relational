<?php
ini_set('display_errors',0);
include_once '../database/database.php';
if (!isset($_SESSION)) {
    session_start();
}

$user = $_SESSION['user'];
$name = $_SESSION['name'];
$userIDEscaped = mysqli_real_escape_string($conn, $user);

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

$testConnSql = "SELECT profilephotoURL, firstName, lastName, userID1, userID2, status
                FROM friendship AS f INNER JOIN user AS u
                ON f.userID2 = u.userID AND f.userID1 = '$user'
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

$requestedSql = "SELECT profilephotoURL, firstName, lastName, userID, status, originUserID
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              AND status = 0
              AND originUserID != '$userIDEscaped'
              ORDER BY lastName DESC
              ";
$requestedResult = mysqli_query($conn, $requestedSql);

$pendingSql = "SELECT profilephotoURL, firstName, lastName, userID, status, originUserID
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              AND status = 0
              AND originUserID = '$userIDEscaped'
              ORDER BY lastName DESC
              ";
$pendingResult = mysqli_query($conn, $pendingSql);

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

$viewString = "matches" . $user;
$getView = "SELECT * FROM '$viewString'";
$getViewResult = mysqli_query($conn, $getView);


$photoView = "SELECT profilephotoURL, firstName, lastName, u.userID, matches
              FROM $viewString AS view
              INNER JOIN user AS u ON view.userID = u.userID
              ORDER BY view.matches DESC
              ";

$photoViewResult = mysqli_query($conn, $photoView);


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

function acceptReq(){

  $userID1 = $_SESSION['user'];
  $userID2 = $_POST['id'];

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

function addFriend(){

  $userID1 = $_SESSION['user'];
  $userID2 = $_POST['id'];

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
  $viewString = $_POST['id'];

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
