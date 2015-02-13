<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin");die; }
if ($_POST['token'] != $_SESSION['steamid']) { die("BLOCKED removeCompleteGarage-request!<br>If you just clicked a link, make sure you don't click it again.<br><a href='.'>Dashboard</a>"); }
require 'config.php';
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
mysqli_query($con, "DELETE FROM vehicles WHERE pid='".$_POST['steamid']."'");
echo "All vehicles belonging to player ".$_POST['steamid']." deleted.";