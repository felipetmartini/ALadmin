<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin"); die; };
require 'SourceQuery/SourceQuery.class.php';
$squery = new SourceQuery;
require 'config.php';
$squery->connect($server_ip,$server_port+1,3,SourceQuery :: SOURCE);
$sdata = $squery->GetInfo();
$on_players = $squery->GetPlayers();
$connection = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
$plys = mysqli_query($connection, "SELECT * FROM players");
$c_cash = 0;
$c_bank = 0;
$c_ply = 0;
$c_med = 0;
$c_cop = 0;
$c_civ = 0;
$c_vehc = 0;
$c_vehc_active = 0;
$c_gangs = 0;
$c_plys_in_gang = 0;
$c_g_mstmembrs = 0;
$c_gang_mny = 0;
$g_biggest = "None";
while ($row = mysqli_fetch_row($plys)) {
    $c_cash += $row[3];
    $c_bank += $row[4];
    $c_ply++;
    if ($row[6] != "\"[]\"") {
        $c_cop++;
    }
    if ($row[8] != "\"[]\"") {
        $c_med++;
    }
}
$vehicles = mysqli_query($connection,"SELECT * FROM vehicles");
while ($row = mysqli_fetch_row($vehicles)) {
    switch ($row[1]) {
        case "civ": $c_vehc_civ++; break;
        case "cop": $c_vehc_cop++; break;
    }
    if ($row[6] == true) { $c_vehc_active++; }
    $c_vehc++;
}
$gangs = mysqli_query($connection,"SELECT * FROM gangs");
while ($row = mysqli_fetch_row($gangs)) {
    $c_g_cache = 0;
    $c_gangs++;
    $c_gang_mny += $row[5];
    preg_match_all("/[0-9]\w+/",$row[3],$c_g_plys);
    foreach ($c_g_plys[0] as $value) {
        $c_plys_in_gang++;
        $c_g_cache++;
    }
    if ($c_g_cache > $c_g_mstmembrs) {
        $g_biggest = $row[2];
        $g_c_biggest = $c_g_cache;
    }
    $c_g_cache = 0;
}
echo "<b><span class='icon ion-social-usd'></span></b> <b>$c_ply</b> unique players with <b>$c_cash\$</b> cash and <b>$c_bank\$</b> on bank accounts, making it <b>".($c_cash+$c_bank)."\$</b> in total. <b>$c_cop</b> of them played cop, <b>$c_med</b> medic. <b>".$sdata['Players']."</b> out of <b>".$sdata['MaxPlayers']."</b>  players online.<br>
<b><span class='icon ion-model-s'></span></b> <b>$c_vehc</b> vehicles, <b>$c_vehc_cop</b> of them police cars, <b>$c_vehc_civ</b> civilian. <b>$c_vehc_active</b> currently in use.<br>
<b><span class='icon ion-ios-people'></span></b> <b>$c_gangs</b> gangs with <b>$c_plys_in_gang</b> players registered. A total of <b>$c_gang_mny\$</b> in gang accounts.";
if ($on_players > 0) {
    echo "<br><br><table><tr><td>Online Players:</td></tr>";
    foreach ($on_players as $value) {
        echo "<tr><td>$value0</td></tr>";
    }
    echo "</table>";
}