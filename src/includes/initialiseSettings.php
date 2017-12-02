<?php

$user = $_SESSION['user'];

$userIDEscaped = mysqli_real_escape_string($conn, $user);

$settingsSql = "SELECT email, firstName, lastName, dob, gender, location, privacyID
                FROM user
                WHERE userID = '$userIDEscaped';
                ";

$settingsResult = mysqli_query($conn, $settingsSql);

if (mysqli_num_rows($settingsResult) === 1) {
    $row = mysqli_fetch_assoc($settingsResult);
    $email = $row["email"];
    $firstName = $row["firstName"];
    $lastName = $row["lastName"];
    $dob = $row["dob"];
    $gender = $row["gender"];
    $location = $row["location"];
    $privacyID = $row["privacyID"];
} else {
  echo "Error: Unable to find user";
}

$privacySQL = "SELECT *
                FROM privacy_settings;
                ";

$privacyResult = mysqli_query($conn, $privacySQL);

?>
