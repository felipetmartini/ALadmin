<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin"); die; };
require 'steamauth/userInfo.php';
require 'config.php';
require 'rcon.php';
$time = $_POST['time'];
if ($_POST['multiplier'] == 0) { $multiplier = "Permanent"; $time = ""; }
elseif ($_POST['multiplier'] == 1) { $multiplier = "Minutes"; }
elseif ($_POST['multiplier'] == 60) { $multiplier = "Hours"; }
elseif ($_POST['multiplier'] == 1440) { $multiplier = "Days"; }
else { $multiplier = "UNDEFINED"; }
if (empty($_POST['reason'])) { $reason = "No reason specified"; } else { $reason = $_POST['reason']; }
rcon($server_ip,$server_port,$rcon_password,"addBan ".$_POST['guid']." ".$_POST['time']*$_POST['multiplier']." Banned $time $multiplier by ".$steamprofile['personaname'].". Reason: $reason");
echo "Banned ".$_POST['guid']." $time $multiplier. This can only be undone by editing the bans.txt on your server."
?>