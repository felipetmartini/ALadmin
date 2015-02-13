<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin"); die; };
require 'config.php';
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
$ply = mysqli_real_escape_string($con,$_POST['steamid']);
$query = mysqli_query($con, "SELECT cash, bankacc, playerid, name FROM players WHERE playerid LIKE $ply");
$data = mysqli_fetch_row($query);
echo $data[3]."<hr>";
echo '<form id="moneyControl">Cash: <input type="text" id="cash" value="'.$data[0].'" placeholder="'.$data[0].' (Doubleclick)" required ondblclick="this.value=\''.$data[0].'\'"> Account: <input type="text" id="bankacc" value="'.$data[1].'" required placeholder="'.$data[1].' (Doubleclick)" ondblclick="this.value=\''.$data[1].'\'"><input type="button" onClick="javascript:setMoney(\''.$data[2].'\')" value="Set Money"></form>';
?>