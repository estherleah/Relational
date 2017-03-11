<?php
  include_once '../database/database.php';
  session_start();

  $commentID = $_POST["commentid"];

  // remove entry from DB
  $commentIDEscaped = mysqli_real_escape_string($conn, $commentID);
  $commentDeleteSql = "DELETE FROM photo_comment
                      WHERE commentID = '$commentIDEscaped';
                    ";

  if (mysqli_query($conn, $commentDeleteSql)) {
      echo "Photo comment deleted";
  } else {
      echo "Error: " . $commentDeleteSql . "<br>" . mysqli_error($conn);
  }
?>
