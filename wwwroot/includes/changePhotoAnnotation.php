<?php
    include_once '../database/database.php';
    session_start();
    $user = $_SESSION['user'];
    $name = $_SESSION['name'];

    $photoId = $_POST["photoid"];
    $annotationType = $_POST["annotationtype"];
    $date = date("Y-m-d H:i:s");

    $photoIdEscaped = mysqli_real_escape_string($conn, $photoId);
    $annotationTypeEscaped = mysqli_real_escape_string($conn, $annotationType);
    $dateEscaped = mysqli_real_escape_string($conn, $date);
    $userIdEscaped = mysqli_real_escape_string($conn, $user);

    $userLikesSql = "SELECT *
                      FROM photo_annotation
                      WHERE photoID = '$photoIdEscaped'
                      AND userID = '$userIdEscaped'
                      AND annotationType = '$annotationTypeEscaped';
                    ";
    $userLikesResult = mysqli_query($conn, $userLikesSql);

    if (mysqli_num_rows($userLikesResult) === 1) {
      $row = mysqli_fetch_assoc($userLikesResult);
      $userLikes = True;
    } else {
      $userLikes = False;
    }

    if ($userLikes) {
      echo "Remove annotation";
      $annotationSql = "DELETE FROM photo_annotation
                        WHERE photoID = '$photoIdEscaped'
                        AND userID = '$userIdEscaped'
                        AND annotationType = 0";
    } else {
      echo "Add annotation";
      $annotationSql = "INSERT INTO photo_annotation (photoID, userID, annotationType, date)
                      VALUES ('$photoIdEscaped', '$userIdEscaped', '$annotationTypeEscaped', '$dateEscaped')";
    }

    if (mysqli_query($conn, $annotationSql)) {
        echo "Annotation changed.";
    } else {
        echo "Error: " . $annotationSql . "<br>" . mysqli_error($conn);
    }
?>
