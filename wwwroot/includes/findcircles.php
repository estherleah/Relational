<?php
ini_set('display_errors',0);
include '../database/database.php';
if (!isset($_SESSION)) {
    session_start();
}
$user = $_SESSION['user'];
$name = $_SESSION['name'];
//include_once '../database/database.php';

// Debugging
// include '../ChromePhp.php';
// ChromePhp::log("Hello");

// !! Inefficient to use join in this case, another solution would be preferrable
// Search for circle memberships of user
$userIDEscaped = mysqli_real_escape_string($conn, $user);

$userSql = "SELECT firstName, lastName, profilephotoURL
              FROM user
              WHERE userID = '$userIDEscaped';
              ";
$userResult = mysqli_query($conn, $userSql);

if (mysqli_num_rows($userResult) === 1) {
    $row = mysqli_fetch_assoc($userResult);
    $fullName = $row["firstName"] . " " . $row["lastName"];
    $profilephotoURL = $row["profilephotoURL"];
}

$circleResult = mysqli_query($conn,"  SELECT     circle.circleID, userID, name, description
                                            FROM       circle_participants
                                            INNER JOIN circle
                                            ON         circle_participants.circleID = circle.circleID
                                            WHERE      userID = '$userIDEscaped'
                                            ORDER BY   circleID ");

//---------------------------------------------------------------------------------------------------

// Search for circles
if($_POST) {

    // !! Order by circleID probably not the best solution. How can we get the most relevant entries?
    $q = mysqli_real_escape_string($conn,$_POST['search']);
    $strSQL_Result = mysqli_query($conn," SELECT    circleID, name, description
                                          FROM      circle
                                          WHERE     name LIKE '%$q%' OR description LIKE '%$q%'
                                          ORDER BY  circleID
                                          LIMIT     5 ");

    // Iterate through results and display them
    while ($row = mysqli_fetch_array($strSQL_Result)) {
        $circleID = $row['circleID'];
        $name = $row['name'];
        $des = $row['description'];
        ?>
        <div class="show" align="left";>
            <!-- <img src="<?php echo $photo ?>" style="width:50px; height:50px; float:left; margin-right:10px;" /> -->
            <span class="name" style="line-height:50px;"><?php echo $name; ?></span>
            <span class="cid" style="visibility:hidden;"><?php echo $circleID; ?></span>
        </div>
        <?php
    }

}
?>
