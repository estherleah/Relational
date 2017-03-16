<?php
include 'Relationship.php';
if (!isset($_SESSION)) {
    session_start();
}
$user = $_SESSION['user'];

// TEMP HACK! This will become either the current user ID or the ID of the profile being viewed
// $thisUserID = $user;

$userAndThisUser = new Relationship($user, $thisUserID);

// check if viewing the current user
$currentUser = $userAndThisUser->areSame();

if($userAndThisUser->shareContent()) {
    $thisUserIDEscaped = mysqli_real_escape_string($conn, $thisUserID);

    $blogSql = "SELECT entryID, entry, date
                  FROM blog_entry AS b
                  WHERE b.userID = '$thisUserIDEscaped'
                  ORDER BY date DESC;
                  ";
    $blogResult = mysqli_query($conn, $blogSql);
}

?>
