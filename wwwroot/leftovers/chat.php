<?php include 'database.php';
session_start();
include 'header.php';
?>
<?php
//table for messages - message
//most RECENT messages appear at the bottom
//fields: messageID, circleID, userID, message, date
//user table is just user
  $getMessages = "SELECT * FROM message ORDER BY messageID DESC";
  $messages = mysqli_query($conn, $getMessages);
  //$currentUser = mysql_query("SELECT firstName, lastName from user where userID ='".$_SESSION['userID']."'");
  //reusing that bit of code from blog.php to get current user
  $userIDEscaped = mysqli_real_escape_string($conn, $user);
  $userSql = "SELECT firstName, lastName
                FROM user
                WHERE userID = '$userIDEscaped';
                ";
  $current = mysqli_query($conn, $userSql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Exclusive Circle Chat!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

  <body>
    <div id="container">
      <header>
        <h1>Members-only chat</h1>
      </header>
      <div id="messages">
        <ul>
          <?php while($row = mysqli_fetch_assoc($messages)) : ?>
            <li class="message">
              <span><?php echo $row['date'] ?> --- </span>
              <strong>

                <?php echo "User ".$row['userID']?></strong>
              : <?php echo $row['message'] ?>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
      <div id="input">
        <?php if (isset($_GET['error'])) : ?>
          <?php echo "ERROR"; ?>
        <?php endif; ?>
        <form method="post" action="includes/chatProcess.php">
          <input type="text" id="newmessage" name="message" placeholder="Type something here"/>
          <input id="show-btn" type="submit" name="submit" value="Send"/>
        </form>
      </div>
    </div>
  </body>
</html>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
