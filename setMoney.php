<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin"); die; };
require 'config.php';
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
$query = mysqli_query($con, "UPDATE players SET cash=".$_POST['cash'].", bankacc=".$_POST['bankacc']." WHERE playerid LIKE ".$_POST['steamid']);
echo "Money set."
?>