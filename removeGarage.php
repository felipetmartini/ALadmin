<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin");die; }
require 'config.php';
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
$query = mysqli_query($con, "DELETE FROM vehicles WHERE id='".$_POST['vehic']."'");
echo "Deleted vehicle ".$_POST['vehic']." by ".$_POST['steamid'];
?>