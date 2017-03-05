<?php

include_once 'database/database.php';
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];

$collectionID = $_GET['collectionID'];

$collectionIDEscaped = mysqli_real_escape_string($conn, $collectionID);

$collectionSql = "SELECT name, date
              FROM photo_collection
              WHERE collectionID = '$collectionIDEscaped'
              ";
$collectionResult = mysqli_query($conn, $collectionSql);

if (mysqli_num_rows($collectionResult) === 1) {
    $row = mysqli_fetch_assoc($collectionResult);
    $name = $row["name"];
    $date = $row["date"];
} else {
  echo "Error: Unable to find photo collection";
}

$photoSql = "SELECT photoID, photoURL, date
              FROM photo
              WHERE collectionID = '$collectionIDEscaped'
              ORDER BY date DESC;
              ";
$photoResult = mysqli_query($conn, $photoSql);

/*

if (!isset($_POST['post']) or trim($_POST['post']) == '') {
    echo "Please enter some text.";
    header("Location: ../blog.php");
}
else {
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
}
*/

?>
