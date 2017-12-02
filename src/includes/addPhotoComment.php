<?php
    include_once '../database/database.php';
    session_start();
    $user = $_SESSION['user'];
    $name = $_SESSION['name'];

    $photoId = $_POST["photoid"];
    $comment = $_POST["post"];
    $date = date("Y-m-d H:i:s");
    $photoIdEscaped = mysqli_real_escape_string($conn, $photoId);
    $userIdEscaped = mysqli_real_escape_string($conn, $user);
    $commentEscaped = mysqli_real_escape_string($conn, $comment);
    $dateEscaped = mysqli_real_escape_string($conn, $date);
    $commentInsertSql = "INSERT INTO photo_comment (photoID, userID, comment, date)
                    VALUES ('$photoIdEscaped', '$userIdEscaped', '$commentEscaped', '$dateEscaped')";
    if (mysqli_query($conn, $commentInsertSql)) {
        echo "New comment created successfully";
    } else {
        echo "Error: " . $commentInsertSql . "<br>" . mysqli_error($conn);
    }
?>
