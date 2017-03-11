<?php
    include_once '../database/database.php';
    session_start();

    $user = $_SESSION['user'];
    $name = $_SESSION['name'];
    $entry = $_POST["post"];
    $date = date("Y-m-d H:i:s");
    $userIdEscaped = mysqli_real_escape_string($conn, $user);
    $entryEscaped = mysqli_real_escape_string($conn, $entry);
    $dateEscaped = mysqli_real_escape_string($conn, $date);

    $blogInsertSql = "INSERT INTO blog_entry (userID, entry, date)
                    VALUES ('$userIdEscaped', '$entryEscaped', '$dateEscaped')";
    if (mysqli_query($conn, $blogInsertSql)) {
        echo "New blog entry created successfully";
    } else {
        echo "Error: " . $blogInsertSql . "<br>" . mysqli_error($conn);
    }
?>
