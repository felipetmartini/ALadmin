<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin");die; }
require 'steamauth/userInfo.php';
require 'config.php';
if (!isset($_POST['cmd'])) { die("No command supplied."); }
require 'rcon.php';
$resp = rcon($server_ip,$server_port,$rcon_password,$_POST['cmd']);
?>