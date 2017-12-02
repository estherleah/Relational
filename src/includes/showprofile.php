<?php
include 'includes/Relationship.php';
if (!isset($_SESSION)) {
    session_start();
}

$user = $_SESSION['user'];
$name = $_SESSION['name'];

global $thisUserData;

if (isset($_GET['id'])) {
    $thisUserID = $_GET['id'];
} else {
    $thisUserID = $user;
}

$userAndThisUser = new Relationship($user, $thisUserID);

// Check if current user or visitor
$currentUser = $userAndThisUser->areSame();

if ($userAndThisUser->shareContent(0)) {
    $thisUserIDEscaped = mysqli_real_escape_string($conn, $thisUserID);

    $blogSql = "  SELECT entryID, entry, date
                  FROM blog_entry AS b
                  WHERE b.userID = '$thisUserIDEscaped'
                  ORDER BY date DESC ";

    $blogResult = mysqli_query($conn, $blogSql);
}

// Get user's data
$thisUserData = mysqli_fetch_array(mysqli_query($conn, " SELECT   firstName, lastName, dob, gender, location, profilephotoURL
                                                         FROM     user
                                                         WHERE    userID = '$thisUserIDEscaped' ", 0));

// Set local variables
$thisUserFullName = $thisUserData['firstName'] . " " . $thisUserData['lastName'];
$thisUserDOB = $thisUserData['dob'];
$thisUserGender = $thisUserData['gender'];
$thisUserLocation = $thisUserData['location'];
$thisUserProfilePic = $thisUserData['profilephotoURL'];

// Get user's circles
$thisUserCircles = mysqli_query($conn, " SELECT   circleID, name
                                        FROM     circle
                                        WHERE    circleID
                                        IN (
                                            SELECT   circleID
                                            FROM     circle_participants
                                            WHERE    userID = '$thisUserIDEscaped'
                                        )
                                        LIMIT 5 ");
// Get user's friends
$thisUserFriends = mysqli_query($conn, " SELECT  userID, profilephotoURL, CONCAT(firstName, ' ', lastName) AS fullName
                                        FROM    user
                                        WHERE   userID
                                        IN      (
                                                    SELECT userID2
                                                    FROM friendship
                                                    WHERE userID1 = '$thisUserIDEscaped' AND status = 1
                                                )
                                        ORDER BY RAND()
                                        LIMIT 5 ");
// Get user's photo collections
$thisUserPhotoCollections = mysqli_query($conn, " SELECT pcol.collectionID, pcol.name, pcol.date, pcol.privacyID, u.profilephotoURL, u.firstName, u.lastName, COUNT(p.photoID) AS count
                                                    FROM photo_collection AS pcol
                                                    LEFT JOIN photo AS p ON pcol.collectionID = p.collectionID
                                                    JOIN user AS u ON pcol.userID = u.userID
                                                    WHERE pcol.userID = '$thisUserIDEscaped'
                                                    GROUP BY pcol.collectionID
                                                    ORDER BY date DESC
                                                    LIMIT 5 ");

$areFriends = mysqli_query($conn, "SELECT *
                                    FROM friendship
                                    WHERE (userID1 = '$user'
                                            AND userID2 = '$thisUserID')
                                    ");

$areFriends2 = mysqli_query($conn, "SELECT *
                                    FROM friendship
                                    WHERE (userID1 = '$user'
                                    AND userID2 = '$thisUserID'
                                    AND status = '1')
                                    ");

$requestFrom = mysqli_query($conn, "SELECT *
                                    FROM friendship
                                    WHERE (userID1 = '$user'
                                            AND userID2 = '$thisUserID'
                                            AND originUserID = '$user'
                                            AND status = '0')
                                    ");

$requestTo = mysqli_query($conn, "SELECT *
                                    FROM friendship
                                    WHERE (userID1 = '$user'
                                    AND userID2 = '$thisUserID'
                                    AND originUserID = '$thisUserID'
                                    AND status = '0')
                                                                        ");

function showCircles()
{
    global $thisUserCircles;
    while ($row = mysqli_fetch_array($thisUserCircles)) {
        $circleID   = $row['circleID'];
        $circleName = $row['name']; ?>
            <a href="circle.php?id=<?php echo $circleID ?>" class="circleName"><?php echo $circleName; ?></a></br>
        <?php

    }
};

function showFriends()
{
    global $thisUserFriends;
    while ($row = mysqli_fetch_array($thisUserFriends)) {
        $friendID = $row['userID'];
        $friendFullName = $row['fullName'];
        $friendPhoto    = $row['profilephotoURL']; ?>
            <div style="margin:10px; overflow:auto;">
                <a href="profile.php?id=<?php echo $friendID ?>">
                    <img src="<?php echo $friendPhoto ?>" style="width:50px; height:50px; float:left; margin-right:10px;" />
                    <p class="friendName"><?php echo $friendFullName; ?></p>
                </a>
            </div>
        <?php
    }
};

function showPhotoCollection()
{
    global $thisUserPhotoCollections;
    global $userAndThisUser;
    while ($row = mysqli_fetch_array($thisUserPhotoCollections)) {
        if($userAndThisUser->shareContent($row['privacyID'])){
            ?>
                <div class="col-xs-12 ">
                  <div class="thumbnail">
                    <b><?php echo $row["name"]?></b>
                    <a  href="photos.php?collectionID=<?php echo $row["collectionID"]?>">
                      <div class="">
                        <h1><?php echo $row["count"]?></h1>
                        <p>photo(s)</p>
                      </div>
                    </a>
                    <div class="text-muted">
                        <small><?php echo $row["date"] ?></small>
                    </div>
                  </div>
                </div>
            <?php
        }
    }
};

?>
