<?php
include_once 'database/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- Content -->
  <div class="container">
    <div class="row">
      <div class="col-xs-4 col-xs-offset-4 text-center">
          <h2>Login</h2>
          <form method="post" action="includes/login.php" name="loginForm">
              <div class="form-group">
                  <label for="email">Email:</label>
                  <input class="form-control" type="email" name="email" id="email" placeholder="Email">
              </div>
              <div class="form-group">
                  <label for="password">Password:</label>
                  <input class="form-control" type="password" name="password" id="password" placeholder="Password">
              </div>
              <p><input class="btn btn-default" type="submit" value="Login"></p>
          </form>
          <p>Not yet a user? Sign up now.</p>
          <a href="signup.php"><input class="btn btn-default" type="button" value="Sign up"></a>
      </div>
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
