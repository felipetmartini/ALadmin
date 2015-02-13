<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin");die; }
require 'config.php';
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
if (empty($_POST['vehic_name']) or empty($_POST['vehic_type']) or empty($_POST['vehic_side'])) {
    die("Not all parameters set.");
}
mysqli_query($con, "INSERT INTO vehicles(side,classname,type,pid,alive,plate,color,inventory) VALUES ('".$_POST['vehic_side']."','".$_POST['vehic_name']."','".$_POST['vehic_type']."','".$_POST['steamid']."',0,133700,0,'\"[]\"')");