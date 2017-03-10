<?php
$user = $_SESSION['user'];
$name = $_SESSION['name'];
// Parts adapted from http://php.net/manual/en/mysqli.multi-query.php
//CURRENT user check that they aren't in friendship.userID2
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
//FRIEND (STATUS = 1 i.e friend accepted)
$friendSql = "SELECT profilephotoURL, firstName, lastName, status
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              AND status = 1
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

// if limit results is on...
$limitOn = true;
if ($limitOn) {
  $friendsOfFriendsLimit = 4;
  $circleFriendsLimit = 5;
} else { // https://dev.mysql.com/doc/refman/5.7/en/select.html
  $friendsOfFriendsLimit = 999999999999999999;
  $circleFriendsLimit = 999999999999999999;
}

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
*/
/* find circle participants that user is not friends with of circles user is in
* make sure they're not already a current friend
* Randomise and limit the output (if specified)

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
*/
$recommendedResult = mysqli_multi_query($conn, $recommendQuery);
//$recommendedResult = mysqli_query($conn, $recommendQuery);

$numberOfRecommendations = 5;

?>
