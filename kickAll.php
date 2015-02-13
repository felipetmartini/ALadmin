<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin"); die; };
require 'steamauth/userInfo.php';
require 'config.php';
require 'rcon.php';
if ($_POST['token'] != $_SESSION['steamid']) { die("BLOCKED kickall-request!<br>If you just clicked a link, make sure you don't click it again.<br><a href='.'>Dashboard</a>"); }
if (empty($_POST['reason'])) { $reason = "No reason specified"; } else { $reason = $_POST['reason']; }
rcon($server_ip,$server_port,$rcon_password,"say -1 All players will be kicked by admin ".$steamprofile['personaname'].". Reason: $reason");
rcon($server_ip,$server_port,$rcon_password,"kick -1");