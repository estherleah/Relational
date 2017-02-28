<?php
include_once '../database/database.php';
session_start();

// Debugging
// include '../ChromePhp.php';
// ChromePhp::log("Hello");

// DB Connection
$connection = connectDatabase();

// !! Inefficient to use join in this case, another solution would be preferrable
// Search for circle memberships of user
$userIDEscaped = mysqli_real_escape_string($conn, $user);
$circleResult = mysqli_query($connection,"  SELECT     circle.circleID, userID, name, description
                                            FROM       circle_participants
                                            INNER JOIN circle
                                            ON         circle_participants.circleID = circle.circleID
                                            WHERE      userID = '$userIDEscaped'
                                            ORDER BY   circleID ");

//---------------------------------------------------------------------------------------------------

// Search for circles
if($_POST) {

    // !! Order by circleID probabl not the best solution. How can we get the most relevant entires?
    $q = mysqli_real_escape_string($connection,$_POST['search']);
    $strSQL_Result = mysqli_query($connection," SELECT    name,
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
