<?php
include 'includes/Relationship.php';
$user = $_SESSION['user'];

if(isset($_GET['id'])) {
  // another user
  $thisUserID = $_GET['id'];
  $currentUser = False;
} else {
  // current user
  $thisUserID = $user;
  $currentUser = True;
}

$userAndThisUser = new Relationship($user, $thisUserID);

// get user details
$thisUserIDEscaped = mysqli_real_escape_string($conn, $thisUserID);

$userSql = "SELECT firstName, lastName, profilephotoURL
              FROM user
              WHERE userID = '$thisUserIDEscaped';
              ";
$userResult = mysqli_query($conn, $userSql);

if (mysqli_num_rows($userResult) === 1) {
    $row = mysqli_fetch_assoc($userResult);
    $fullName = $row["firstName"] . " " . $row["lastName"];
    $profilephotoURL = $row["profilephotoURL"];
}

// SQL gets list of photo collections, the user who created them and the count of photos in each
// need left join on photos to include collections without any photos
$collectionSql = "SELECT pcol.collectionID, pcol.name, pcol.date, pcol.privacyID, u.profilephotoURL, u.firstName, u.lastName, COUNT(p.photoID) AS count
              FROM photo_collection AS pcol
              LEFT JOIN photo AS p ON pcol.collectionID = p.collectionID
              JOIN user AS u ON pcol.userID = u.userID
              WHERE pcol.userID = '$thisUserIDEscaped'
              GROUP BY pcol.collectionID
              ORDER BY date DESC;
              ";
$collectionResult = mysqli_query($conn, $collectionSql);

$privacySQL = "SELECT *
                FROM privacy_settings;
                ";

$privacyResult = mysqli_query($conn, $privacySQL);

function showCollections(){
    global $userAndThisUser;
    global $collectionResult;
    if (mysqli_num_rows($collectionResult) > 0) {
        while ($row = mysqli_fetch_assoc($collectionResult)) {
            if($userAndThisUser->shareContent($row['privacyID'])){
                ?>
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                      <div class="thumbnail">
                        <b><?php echo $row["name"]?></b>
                        <a  href="photos.php?collectionID=<?php echo $row["collectionID"]?>">
                          <div class="jumbotron">
                            <h1><?php echo $row["count"]?></h1>
                            <p>photo(s)</p>
                          </div>
                        </a>
                        <div class="text-muted">
                            <small><?php echo $row["date"] ?></small>
                        </div>
                      </div>
                    </div>
                <?php
            }
        }
    }
}

?>
