<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin"); die; };
require 'config.php';
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
$ply = mysqli_real_escape_string($con,$_POST['steamid']);
$query = mysqli_query($con, "SELECT civ_licenses, cop_licenses, med_licenses, playerid, name FROM players WHERE playerid LIKE $ply");
$data = mysqli_fetch_row($query);
echo $data[4]."<hr>";
preg_match_all("/\w+/",$data[0],$pre_civ);
$i = 0;
$c = 0;
$a_l_civ = array();
while ($i < count($pre_civ[0])) {
    $val1 = $pre_civ[0][$i];
    $i++;
    $val2 = $pre_civ[0][$i];
    $a_l_civ[$c] = array($val1,$val2);
    $i++; $c++;
}
preg_match_all("/\w+/",$data[1],$pre_cop);
$i = 0;
$c = 0;
$a_l_cop = array();
while ($i < count($pre_cop[0])) {
    $val1 = $pre_cop[0][$i];
    $i++;
    $val2 = $pre_cop[0][$i];
    $a_l_cop[$c] = array($val1,$val2);
    $i++; $c++;
}
preg_match_all("/\w+/",$data[2],$pre_med);
$i = 0;
$c = 0;
$a_l_med = array();
while ($i < count($pre_med[0])) {
    $val1 = $pre_med[0][$i];
    $i++;
    $val2 = $pre_med[0][$i];
    $a_l_med[$c] = array($val1,$val2);
    $i++; $c++;
}
echo "<form id='f_l_civ'><table class='licenses'><tr><td>Civilian</td><td></td></tr>";
if (!empty($a_l_civ)) {
    foreach ($a_l_civ as $value) {
        echo "<tr><td style=\"width: 20%;\">".$value[0]."</td><td>";
        echo "<input name='".$value[0]."' type='checkbox'";
        if ($value[1] == "1") {
            echo " checked";
        }
        echo "></td></tr>";
    }
} else { echo "<tr><td colspan='2'>This player hasn't played civilian yet. <span style='float: right;'><a href='javascript:initLicense(\"$ply\",\"civ\")'>Initialize with AL defaults</a></span>"; }
echo "</table></form>";
echo "<form id='f_l_cop'><table class='licenses'><tr><td>Police</td><td></td></tr>";
if (!empty($a_l_cop)) {
    foreach ($a_l_cop as $value) {
        echo "<tr><td style=\"width: 20%;\">".$value[0]."</td><td>";
        echo "<input name='".$value[0]."' type='checkbox'";
        if ($value[1] == "1") {
            echo " checked";
        }
        echo "></td></tr>";
    }
} else { echo "<tr><td colspan='2'>This player hasn't played cop yet. <span style='float: right;'><a href='javascript:initLicense(\"$ply\",\"cop\")'>Initialize with AL defaults</a></span>"; }
echo "</table></form>";
echo "<form id='f_l_med'><table class='licenses'><tr><td>Medic</td><td></td></tr>";
if (!empty($a_l_med)) {
    foreach ($a_l_med as $value) {
        echo "<tr><td style=\"width: 20%;\">".$value[0]."</td><td>";
        echo "<input name='".$value[0]."' type='checkbox'";
        if ($value[1] == "1") {
            echo " checked";
        }
        echo "></td></tr>";
    }
} else { echo "<tr><td colspan='2'>This player hasn't played medic yet. <span style='float: right;'><a href='javascript:initLicense(\"$ply\",\"med\")'>Initialize with AL defaults</a></span></td></tr>"; }
echo "</table></form>";
echo '<input type="button" value="Set Licenses" onClick="setLicenses(\''.$ply.'\');"></form>'
?>