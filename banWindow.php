<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin"); die; };
require 'config.php';
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
$ply = mysqli_real_escape_string($con,$_POST['steamid']);
$query = mysqli_query($con,"SELECT name FROM players WHERE playerid='$ply'");
$data = mysqli_fetch_row($query);
echo $data[0].'<hr><form id="f_ban"><input type="number" id="i_time" min="1" value="1" name="length"><select name="time" id="i_multiplier"><option value="1" onClick="document.getElementById(\'i_time\').removeAttribute(\'disabled\');">Minutes</option><option value="60" onClick="document.getElementById(\'i_time\').removeAttribute(\'disabled\');">Hours</option><option value="1440" onClick="document.getElementById(\'i_time\').removeAttribute(\'disabled\');">Days</option><option onClick="document.getElementById(\'i_time\').disabled = \'true\';" value="0">Permanent</option></select><input type="text" placeholder="Reason" name="reason" id="i_reason"><input type="button" onClick="addBan(\''.$ply.'\');" value="Set ban">';
?>