<?php
session_start();

$user = $_SESSION['user'];
$name = $_SESSION['name'];

// DB Connection
global $thisUserData;

// Check if current user or visitor
if(isset($_GET['id'])){
    // Get userID
    // $_SESSION['thisUserID'] = $_GET['id'];
    // $thisUserID = $_SESSION['thisUserID'];
    $thisUserID = $_GET['id'];
} else {
    $thisUserID = $user;
}

// Get user's data
$thisUserData = mysqli_fetch_array(mysqli_query($conn," SELECT   firstName, lastName, dob, gender, location, profilephotoURL
                                                        FROM     user
                                                        WHERE    userID = '$thisUserID' ", 0));

// Get user's circles
$thisUserCircles = mysqli_query($conn," SELECT   circleID, name
                                        FROM     circle
                                        WHERE    circleID
                                        IN (
                                            SELECT   circleID
                                            FROM     circle_participants
                                            WHERE    userID = '$thisUserID'
                                        ) ");

// Get user's friends
$thisUserFriends = mysqli_query($conn," SELECT  userID, profilephotoURL, CONCAT(firstName, ' ', lastName) AS fullName
                                        FROM    user
                                        WHERE   userID
                                        IN      (
                                                    SELECT userID2
                                                    FROM friendship
                                                    WHERE userID1 = '$thisUserID' AND status = 1
                                                )
                                        ORDER BY RAND()
                                        LIMIT 5 ");
                                        echo $thisUserIDEscaped;

// Set local variables
$thisUserFullName = $thisUserData['firstName'] . " " . $thisUserData['lastName'];
$thisUserDOB = $thisUserData['dob'];
$thisUserGender = $thisUserData['gender'];
$thisUserLocation = $thisUserData['location'];
$thisUserProfilePic = $thisUserData['profilephotoURL'];

// if ($row = mysqli_fetch_assoc($thisUserData)) { $thisUserProfilePic = $thisUserData['profilephotoURL']; }
// else { echo "Unable to find profile picture"; }

// Iterate through circles and display them
function showCircles(){
    global $thisUserCircles;

    while ($row = mysqli_fetch_array($thisUserCircles)) {
        $circleID   = $row['circleID'];
        $circleName = $row['name'];
        ?>
            <a href="http://localhost:8888/circle.php?id=<?php echo $circleID ?>" class="circleName"><?php echo $circleName; ?></a></br>
        <?php
    }
};

function showFriends(){
    global $thisUserFriends;

    while ($row = mysqli_fetch_array($thisUserFriends)) {
        $friendID = $row['userID'];
        $friendFullName = $row['fullName'];
        $friendPhoto    = $row['profilephotoURL'];
        ?>
            <div style="margin:10px; overflow:auto;">
                <a href="http://localhost:8888/profile.php?id=<?php echo $friendID ?>">
                    <img src="<?php echo $friendPhoto ?>" style="width:50px; height:50px; float:left; margin-right:10px;" />
                    <p class="friendName"><?php echo $friendFullName; ?></p>
                </a>
            </div>
        <?php
    }

};

?>
