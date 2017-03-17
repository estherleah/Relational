<?php
include_once '../database/database.php';
include '../includes/Relationship.php';
session_start();

$user = $_SESSION['user'];
$name = $_SESSION['name'];

if($_POST) {
    $thisUserID = $_POST['thisuserid'];
    $userAndThisUser = new Relationship($user, $thisUserID);
    // Check if current user or visitor
    $currentUser = $userAndThisUser->areSame();
    // Check privacy setting
    if ($userAndThisUser->shareContent(0)) {

        $q = mysqli_real_escape_string($conn, $_POST['search']);
        $strSQL_Result = mysqli_query($conn," SELECT    entryID, userID, entry, date
                                              FROM      blog_entry
                                              WHERE     userID = $thisUserID AND entry LIKE '%$q%'
                                              ORDER BY  date
                                              LIMIT     5 ");

        // Iterate through results and display them
        while ($row = mysqli_fetch_array($strSQL_Result)) {
            $entryID = $row['entryID'];
            $userID = $row['userID'];
            $entry  = $row['entry'];
            $date   = $row['date'];
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <b><?php echo $date ?></b>
                    <?php if ($currentUser) { ?>
                    <button type="button"
                       class="btn btn-danger btn-xs pull-right btnRemove"
                       role="button"
                       data-entryid="<?php echo $entryID ?>"
                       >
                       Remove
                    </button>
                    <?php } ?>
                    <div><?php echo $entry ?></div>
                </div>
            </div>
            <?php
        }
    }

}
?>
