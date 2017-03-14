<?php

if (!isset($_SESSION)) {
    session_start();
}

$blogSql = "SELECT entryID, entry, date
              FROM blog_entry AS b
              WHERE b.userID = '$thisUserIDEscaped'
              ORDER BY date DESC;
              ";
$blogResult = mysqli_query($conn, $blogSql);

?>
