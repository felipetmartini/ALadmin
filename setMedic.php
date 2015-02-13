<?php
require 'steamauth/steamauth.php';
if (!$_SESSION['authed']) { header("Location: steamauth/logout.php?noadmin");die; }
require 'config.php';
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
$query = mysqli_query($con,"UPDATE players SET mediclevel='".$_POST['value']."' WHERE playerid=".$_POST['steamid']);
echo "Medic-Level set."
?>