<?php
include_once 'database/database.php';
session_start();
include_once 'includes/initialiseSettings.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include 'header.php'; ?>
<!-- Content -->
<div class="container">
    <div class="col-*-*">
        <div class="text-center">
            <div class="col-sm-4 col-sm-offset-4">
                <h2>Settings</h2>
                <form method="post" action="includes/changesettings.php" name="settingsForm">
                    <div class="form-group">
                        <label for="firstName">First Name:</label>
                        <input class="form-control" type="text" name="firstName" id="firstName"
                               value="<?php echo $firstName ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name:</label>
                        <input class="form-control" type="text" name="lastName" id="lastName"
                               value="<?php echo $lastName ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input class="form-control" type="email" name="email" id="email" value="<?php echo $email ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">New password:</label>
                        <input class="form-control" type="password" name="password" id="password"
                               placeholder="New password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm new password:</label>
                        <input class="form-control" type="password" name="confirmPassword" id="confirmPassword"
                               placeholder="Confirm new password" required>
                    </div>
                    <div class="form-group">
                        <label for="privacy">Privacy:</label>
                        <select class="form-control" name="privacy" id="privacy">
                            <?php
                            if (mysqli_num_rows($privacyResult) > 0) {
                                while ($row = mysqli_fetch_assoc($privacyResult)) { ?>
                                    <option value="<?php echo $row["privacyID"] ?>" <?php if ($privacyID === $row["privacyID"]) {
                                        echo "selected";
                                    } ?>><?php echo $row["option"] ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <select class="form-control input-medium bfh-countries" name="location" id="location" data-country="<?php echo $location ?>"></select>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of birth:</label>
                        <div id="dob">
                            <input class="form-control" type="date" id="dob" name="dob" value="<?php echo $dob ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <div id="gender">
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="male" <?php if ($gender === "Male") { echo "checked"; } ?>>Male
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="female" <?php if ($gender === "Female") { echo "checked"; } ?>>Female
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="other" <?php if ($gender === "Other") { echo "checked"; } ?>>Other
                            </label>
                        </div>
                    </div>
                    <p><input class="btn btn-primary" type="submit" value="Save"></a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-formhelpers.min.js"></script>
</body>
</html>
