<?php
include_once '../database/database.php';
session_start();

// Debugging
//include 'ChromePhp.php';

// DB Connection
$connection = connectDatabase();

if($_POST) {
    // If keyword has been entered, search for friends of person searched for
    if(substr($_POST['search'],0,13)=="Friends with "){
        // Remove keyword from search string
        $searchString = substr($_POST['search'],13);

        // Look up userID of entered name
        $q1 = mysqli_real_escape_string($connection, $searchString);
        $strSQL_Result1 = mysqli_query($connection," SELECT   userID
                                                     FROM     user
                                                     WHERE    CONCAT_WS(' ', firstName, lastName) LIKE '%$q1%' OR email = '$q1' ", 0);

        //ChromePhp::log($strSQL_Result1);
        //ChromePhp::log(mysqli_fetch_array($strSQL_Result1)['userID']);

        // Look up friendships of userID
        $q2 = mysqli_real_escape_string($connection, mysqli_fetch_array($strSQL_Result1)['userID']);
        $strSQL_Result2 = mysqli_query($connection," SELECT    userID2
                                                     FROM      friendship
                                                     WHERE     userID1 = '$q2' ");

        //ChromePhp::log($strSQL_Result2);
        //while ($row = mysqli_fetch_array($strSQL_Result2)) ChromePhp::log($row['userID2']);

        // Iterate thorugh friend IDs
        while ($row = mysqli_fetch_array($strSQL_Result2)) {
            $userID     = $row['userID2'];

            // Look up the corresponding name and photo
            $q3 = mysqli_real_escape_string($connection, $userID);
            $strSQL_Result3 = mysqli_query($connection," SELECT   userID,
                                                                  profilephotoURL,
                                                                  CONCAT_WS(' ', firstName, lastName) AS fullName
                                                         FROM     user
                                                         WHERE    userID = '$q3' ");

            //ChromePhp::log($strSQL_Result3);
            //ChromePhp::log(mysqli_fetch_array($strSQL_Result3));

            // Display friend
            while($friend = mysqli_fetch_array($strSQL_Result3)) {
                $friendID   = $friend['userID'];
                $fullname   = $friend['fullName'];
                $photo      = $friend['profilephotoURL'];
                ?>
                <div class="show" align="left";>
                    <img src="<?php echo $photo ?>" style="width:50px; height:50px; float:left; margin-right:10px;" />
                    <span class="name" style="line-height:50px;"><?php echo $fullname; ?></span>
                    <span class="uid" style="visibility:hidden;"><?php echo $friendID; ?></span>
                </div>
                <?php
            }
        }
    }
    // If no keyword has been entered, search for persons with similar names
    else {
        $q = mysqli_real_escape_string($connection,$_POST['search']);
        $strSQL_Result = mysqli_query($connection," SELECT    userID,
                                                              profilephotoURL,
                                                              CONCAT_WS(' ', firstName, lastName) AS fullName
                                                    FROM      user
                                                    WHERE     CONCAT_WS(' ', firstName, lastName) LIKE '%$q%' OR email = '$q'
                                                    ORDER BY  userID
                                                    LIMIT     5 ");

        // Iterate through results and display them
        while ($row = mysqli_fetch_array($strSQL_Result)) {
            $userID     = $row['userID'];
            $fullname   = $row['fullName'];
            $photo      = $row['profilephotoURL'];
            ?>
            <div class="show" align="left";>
                <img src="<?php echo $photo ?>" style="width:50px; height:50px; float:left; margin-right:10px;" />
                <span class="name" style="line-height:50px;"><?php echo $fullname; ?></span>
                <span class="uid" style="visibility:hidden;"><?php echo $userID; ?></span>
            </div>
            <?php
        }
    }
}
?>
