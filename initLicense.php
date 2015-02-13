<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin"); die; };
require 'config.php';
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
if ($_POST['side'] == "civ") { $licenses = $default_licenses_civ; }
elseif ($_POST['side'] == "cop") { $licenses = $default_licenses_cop; }
elseif ($_POST['side'] == "med") { $licenses = $default_licenses_med; }
else { $licenses = '"[]"'; }
$licenses = mysqli_real_escape_string($con,$licenses);
$query = mysqli_query($con,"UPDATE players SET ".$_POST['side']."_licenses='$licenses' WHERE playerid='".$_POST['steamid']."'");
echo 'Initialised '.$_POST['side'].'-Licenses. <a href="javascript:checkLicenses(\''.$_POST['steamid'].'\')">Reload</a>';