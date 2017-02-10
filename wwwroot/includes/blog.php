<!-- Layout adapted from http://packetcode.com/article/facebook-wall-design -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blog</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/blogentry.js"></script>
</head>

<?php
  include $_SERVER['DOCUMENT_ROOT'].'/database/database.php';
  //include $_SERVER['DOCUMENT_ROOT'].'/ChromePhp.php';

  // DB Connection
  $connection = connectDatabase();

  // temp until we maintain state
  $userId = 1;

  $userIdEscaped = mysqli_real_escape_string($connection, $userId);

  $userSql = "SELECT firstName, lastName, profilephotoURL
              FROM user
              WHERE userID = '$userIdEscaped';
              ";
  $userResult = mysqli_query($connection, $userSql);

  if (mysqli_num_rows($userResult) === 1) {
    $row = mysqli_fetch_assoc($userResult);
    $fullName = $row["firstName"] . " " . $row["lastName"];
    $profilephotoURL = $row["profilephotoURL"];
  }

  $blogSql = "SELECT entry, date, profilephotoURL, firstName, lastName
              FROM blog_entry AS b JOIN user AS u
              ON b.userID = '$userIdEscaped' AND b.userID = u.userID
              ORDER BY date DESC;
              ";
  $blogResult = mysqli_query($connection, $blogSql);
 ?>

<body>
    <div class="container" id="top">
        <div class="row" id="entry">
            <div class="col-xs-12">
                <h1>Blog Entries for <?php echo $fullName ?></h1>
            </div>
            <div class="col-xs-2">
                <img src="<?php echo $profilephotoURL ?>" class="img-circle" width="100%" />
            </div>
            <div class="col-xs-10">
                <textarea class="form-control" rows='3' id="postText"></textarea>
                <button class="btn btn-primary pull-right" id="postSubmit" type="button">Post</button>
            </div>
        </div>
        <?php
        if (mysqli_num_rows($blogResult) > 0) {
          while($row = mysqli_fetch_assoc($blogResult)) {
            ?>
            <div class="row" id="previousposts">
                <div class="col-xs-2">
                    <img src="<?php echo $row["profilephotoURL"] ?>" class="img-circle" width="100%" />
                </div>
                <div class="col-xs-10">
                    <b><?php echo $row["firstName"] . " " . $row["lastName"] ?></b>
                    <button class="btn btn-danger btn-xs pull-right" type="button">Delete</button>
                    <div class="text-muted"> <small><?php echo $row["date"] ?></small></div>
                    <div><?php echo $row["entry"] ?></div>
                </div>
            </div>
            <?php
          }
        }
         ?>
    </div>
</body>

</html>
