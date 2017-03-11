<?php
session_start();
session_destroy();
$_SESSION = array();
header("Location: ../index.php");
/**
 * Created by PhpStorm.
 * User: Esther Leah
 * Date: 15/02/2017
 * Time: 14:31
 */
?>