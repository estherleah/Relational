<?php
include $_SERVER['DOCUMENT_ROOT'].'/database/database.php';

// DB Connection
$connection = connectDatabase();

if ($_POST) {
    // temp until we maintain state
    $userId = 1;
    $entry = $_POST["post"];
    $date = date("Y-m-d H:i:s");

    $userIdEscaped = mysqli_real_escape_string($connection, $userId);
    $entryHtmlClean = htmlspecialchars($entry);
    $entryEscaped = mysqli_real_escape_string($connection, $entryHtmlClean);
    $dateEscaped = mysqli_real_escape_string($connection, $date);

    $blogInsertSql = "INSERT INTO blog_entry (userID, entry, date)
                    VALUES ('$userIdEscaped', '$entryEscaped', '$dateEscaped')";

    if (mysqli_query($connection, $blogInsertSql)) {
        echo "New blog entry created successfully";
    } else {
        echo "Error: " . $blogInsertSql . "<br>" . mysqli_error($connection);
    }
}
