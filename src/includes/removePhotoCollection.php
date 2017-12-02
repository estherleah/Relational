<?php

include_once '../database/database.php';
session_start();

$collectionID = $_POST["collectionid"];

// remove collection from DB
$collectionIDEscaped = mysqli_real_escape_string($conn, $collectionID);
$collectionDeleteSql = "DELETE FROM photo_collection
                    WHERE collectionID = '$collectionIDEscaped';
                  ";

if (mysqli_query($conn, $collectionDeleteSql)) {
    echo "Photo collection deleted";
} else {
    echo "Error: " . $collectionDeleteSql . "<br>" . mysqli_error($conn);
}

?>
