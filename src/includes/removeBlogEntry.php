<?php
  include_once '../database/database.php';
  session_start();

  $entryID = $_POST["entryid"];

  // remove entry from DB
  $entryIDEscaped = mysqli_real_escape_string($conn, $entryID);
  $entryDeleteSql = "DELETE FROM blog_entry
                      WHERE entryID = '$entryIDEscaped';
                    ";

  if (mysqli_query($conn, $entryDeleteSql)) {
      echo "Blog entry deleted";
  } else {
      echo "Error: " . $entryDeleteSql . "<br>" . mysqli_error($conn);
  }
?>
