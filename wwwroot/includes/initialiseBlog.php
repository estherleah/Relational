<?php
include 'Relationship.php';
if (!isset($_SESSION)) {
    session_start();
}
$user = $_SESSION['user'];

// TEMP HACK! This will become either the current user ID or the ID of the profile being viewed
// $thisUserID = $user;

// check if viewing the current user
if ($thisUserID == $user) {
  $currentUser = True;
} else {
  $currentUser = False;
}

$userAndThisUser = new Relationship($user, $thisUserID);

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
