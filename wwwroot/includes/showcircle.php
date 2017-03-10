<?php
//session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];

// Debugging
// include '../ChromePhp.php';
// ChromePhp::log("Hello");

// DB Connection
//$connection = connectDatabase();
global $conn;
// Search for circle data
if(isset($_GET['id'])){
    $_SESSION['circleID'] = $_GET['id'];
    $circleID = $_SESSION['circleID'];
}

// Retrieve user status
$userStatusResult = mysqli_query($conn,"  SELECT     userStatus
                                                FROM       circle_participants
                                                WHERE      userID = '$user' AND circleID = '$circleID' ", 0);

$userStatus = mysqli_fetch_array($userStatusResult)['userStatus'];

// function isAdmin() {
//     global $userStatus;
//
//     $isAdmin = false;
//     if($userStatus == 2) { $isAdmin = true; }
//     return $isAdmin;
// }

// Retrieve circle data
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

//---------------------------------------------------------------------------------------------------

if(isset($_POST['action']) && !empty($_POST['action'])) {
  $action = $_POST['action'];
  switch($action) {
      case 'removeUser' : removeUser(); break;
      case 'makeAdmin' : makeAdmin(); break;
      case 'revokeAdmin' : revokeAdmin(); break;
      case 'makeOwner' : makeOwner(); break;
      case 'deleteCircle' : deleteCircle(); break;
      case 'leaveCircle' : leaveCircle(); break;
      case 'deleteCircle' : deleteCircle(); break;
      case 'addUser' : addUser(); break;
  }
}

function removeUser(){
    global $conn;
    $circleID = $_SESSION['circleID'];

    $thisUserID = $_POST['id'];

    $removeUserFromCircle = "   DELETE
                                FROM       circle_participants
                                WHERE      circleID = '$circleID' AND userID = '$thisUserID' ";

    if (mysqli_query($conn, $removeUserFromCircle)) {
        echo "You removed " . getName($thisUserID) . " from this circle";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

function makeAdmin(){
    global $conn;
    $circleID = $_SESSION['circleID'];

    $thisUserID = $_POST['id'];

    $makeUserCircleAdmin = "    UPDATE     circle_participants
                                SET        userStatus = '2'
                                WHERE      circleID = '$circleID' AND userID = '$thisUserID' ";

    if (mysqli_query($conn, $makeUserCircleAdmin)) {
        echo "You granted admin rights for " . getName($thisUserID);
    } else {
        echo "Error granting admin rights: " . mysqli_error($conn);
    }
}

function revokeAdmin(){
    global $conn;
    $circleID = $_SESSION['circleID'];

    $thisUserID = $_POST['id'];

    $revokeAdminRights = "      UPDATE     circle_participants
                                SET        userStatus = '1'
                                WHERE      circleID = '$circleID' AND userID = '$thisUserID' ";


    if (mysqli_query($conn, $revokeAdminRights)) {
        echo "You revoked admin rights for " . getName($thisUserID);
    } else {
        echo "Error revoking admin rights: " . mysqli_error($conn);
    }
}

// Potential update anomaly: Only one of the queries gets executed
// and either no one or two people will be circle owner thereafter.
function makeOwner(){
    global $conn;
    $circleID = $_SESSION['circleID'];
    $user = $_SESSION['user'];

    $thisUserID = $_POST['id'];

    $makeUserCircleOwner = "    UPDATE     circle_participants
                                SET        userStatus = '2'
                                WHERE      circleID = '$circleID' AND userID = '$user' ";

    $revokeCircleOwnership = "  UPDATE     circle_participants
                                SET        userStatus = '3'
                                WHERE      circleID = '$circleID' AND userID = '$thisUserID' ";

    if (mysqli_query($conn, $makeUserCircleOwner) && mysqli_query($conn, $revokeCircleOwnership)) {
        echo "You passed the circle ownership to " . getName($thisUserID);
    } else {
        echo "Error passing ownership: " . mysqli_error($conn);
    }
}

function getName($id){
    global $conn;

    $thisUserID = mysqli_query($conn," SELECT   CONCAT_WS(' ', firstName, lastName) AS fullName
                                             FROM     user
                                             WHERE    userID = '$id' ", 0);

    return mysqli_fetch_array($thisUserID)['fullName'];
}

//---------------------------------------------------------------------------------------------------

function leaveCircle(){
    global $conn;
    $circleID = $_POST['circleID'];
    $userID = $_SESSION['user'];

    $leaveCircle = "   DELETE
                       FROM       circle_participants
                       WHERE      circleID = '$circleID' AND userID = '$userID' ";

    if (mysqli_query($conn, $leaveCircle)) {
        echo "You left the circle";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

function deleteCircle(){
    global $conn;
    global $circleName;
    $circleID = $_SESSION['circleID'];
    $deleteCircle = "   DELETE
                        FROM    circle
                        WHERE   circleID = '$circleID' ";

    $deleteMembers = "   DELETE
                         FROM   circle_participants
                         WHERE  circleID = '$circleID' ";

    $q1 = mysqli_query($conn, $deleteMembers);
    $q2 = mysqli_query($conn, $deleteCircle);

    if ($q1 && $q2) {
        echo "You deleted " . $circleName;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

//---------------------------------------------------------------------------------------------------

function addUser(){
    global $conn;
    $circleID = $_SESSION['circleID'];

    $newUserID = $_POST['newUserID'];

    $addMember = " INSERT IGNORE INTO circle_participants (circleID, userID, userStatus)
                   VALUES      ('$circleID', '$newUserID', 1) ";


    if (mysqli_query($conn, $addMember)) {
        echo "You added " . getName($thisUserID) . ". ";
    } else {
        echo "Error adding new user: " . mysqli_error($conn);
    }
}

?>
