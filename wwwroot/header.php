<?php $name = $_SESSION['name'];?>
<!-- Navigation bar -->
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="profile.php"><?php echo $name ?></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="friends.php">Friends</a></li>
                <li><a href="circles.php">Circles</a></li>
                <li><a href="photoCollections.php">Photo Collections</a></li>
                <li><a href="search.php">Search</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="settings.php"><span class="glyphicon glyphicon-user"></span> Settings</a></li>
                <li><a href="includes/logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
            </ul>
        </div>
    </div>
</nav>
