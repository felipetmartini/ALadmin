<?php
require 'steamauth/steamauth.php';
if (!$_SESSION['authed']) { header("Location: steamauth/logout.php?noadmin");die; }
require 'config.php';
$connection = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
if (isset($_GET['steamid'])) {
    $ply = mysqli_query($connection, "SELECT * FROM players WHERE playerid='".$_GET['steamid']."'");
} else {
    $ply = mysqli_query($connection, "SELECT * FROM players WHERE playerid='".$_SESSION['steamid']."'");
}
$d_ply = mysqli_fetch_row($ply);
preg_match_all("/`(.*?)`/",$d_ply[13],$p_aliases);
$i = 0;
foreach ($p_aliases[1] as $value) {
    $alias .= str_replace("`","",$value);
    if ($i == 0) { $alias .= ", "; }
    $i++;
}
$alias = rtrim($alias, ', ');
if (isset($_GET['steamid'])) {
    $vehc = mysqli_query($connection, "SELECT COUNT(*) FROM vehicles WHERE pid='".$_GET['steamid']."'");
} else {
    $vehc = mysqli_query($connection, "SELECT COUNT(*) FROM vehicles WHERE pid='".$_SESSION['steamid']."'");
}
$d_vehc = mysqli_fetch_row($vehc);
if (empty($alias)) { echo "You're not registered in the database."; } else {
    echo "You played as <b>$alias</b>.<br>You have <b>".$d_ply[3]."\$</b> cash and <b>".$d_ply[4]."\$</b> on your bank account.<br>You currently own <b>".$d_vehc[0]."</b> vehicles.";
}