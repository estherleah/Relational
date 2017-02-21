<?php

// Parts adapted from http://php.net/manual/en/mysqli.multi-query.php

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

$friendSql = "SELECT profilephotoURL, firstName, lastName, status
              FROM friendship AS f JOIN user AS u
              ON f.userID1 = '$userIDEscaped' AND f.userID2 = u.userID
              ORDER BY lastName DESC;
              ";
$friendResult = mysqli_query($conn, $friendSql);

// if limit results is on...
$limitOn = true;
if ($limitOn) {
  $friendsOfFriendsLimit = 5;
  $circleFriendsLimit = 5;
} else { // https://dev.mysql.com/doc/refman/5.7/en/select.html
  $friendsOfFriendsLimit = 999999999999999999;
  $circleFriendsLimit = 999999999999999999;
}

/* find friends of friends
* make sure they're not already a current friend
* Randomise and limit the output (if specified)
*/
$sqlQuery = " SELECT firstName, lastName, profilephotoURL, gender, location
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
                                  WHERE fi.userID1 = '$userIDEscaped'
                                  AND fi.userID2 = fo.userID2
                                )
                              )
                              ORDER BY RAND() LIMIT $friendsOfFriendsLimit
                            ;
                          ";

/* find circle participants that user is not friends with of circles user is in
* make sure they're not already a current friend
* Randomise and limit the output (if specified)
*/
$sqlQuery .= " SELECT firstName, lastName, profilephotoURL, gender, location
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

$recommendedResult = mysqli_multi_query($conn, $sqlQuery);

//$recommendedResult = mysqli_query($conn, $sqlQuery);

$numberOfRecommendations = 2;

?>
