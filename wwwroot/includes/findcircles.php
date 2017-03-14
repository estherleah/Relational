<?php
ini_set('display_errors',0);
if (!isset($_SESSION)) {
    session_start();
}
$user = $_SESSION['user'];
$name = $_SESSION['name'];
include_once '../database/database.php';

// Debugging
// include '../ChromePhp.php';
// ChromePhp::log("Hello");

// !! Inefficient to use join in this case, another solution would be preferrable
// Search for circle memberships of user
$userIDEscaped = mysqli_real_escape_string($conn, $user);
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
    $strSQL_Result = mysqli_query($conn," SELECT    name,
                                                          description
                                                FROM      circle
                                                WHERE     name LIKE '%$q%' OR description LIKE '%$q%'
                                                ORDER BY  circleID
                                                LIMIT     5 ");

    // Iterate through results and display them
    while ($row = mysqli_fetch_array($strSQL_Result)) {
        $name = $row['name'];
        $des = $row['description'];
        ?>
        <div class="show" align="left";>
            <img src="<?php echo $photo ?>" style="width:50px; height:50px; float:left; margin-right:10px;" />
            <span class="name" style="line-height:50px;"><?php echo $name; ?></span>
        </div>
        <?php
    }

}
?>
