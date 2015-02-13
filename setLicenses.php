<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin"); die; };
require 'config.php';
$s_a_civ = "\"[";
if (empty($_POST['civ'])) {
    $s_a_civ = "\"[]\"";
} else {
    foreach ($_POST['civ'] as $key => $value) {
        $s_a_civ .= "[`$key`,";
        if ($value == "on") {
            $s_a_civ .= "1";
        } else {
            $s_a_civ .= "0";
        }
        $s_a_civ .= "],";
    }
    $s_a_civ = rtrim($s_a_civ, ',');
    $s_a_civ .= "]\"";
}
$s_a_cop = "\"[";
if (empty($_POST['cop'])) {
    $s_a_cop = "\"[]\"";
} else {
    foreach ($_POST['cop'] as $key => $value) {
        $s_a_cop .= "[`$key`,";
        if ($value == "on") {
            $s_a_cop .= "1";
        } else {
            $s_a_cop .= "0";
        }
        $s_a_cop .= "],";
    }
    $s_a_cop = rtrim($s_a_cop, ',');
    $s_a_cop .= "]\"";
}
$s_a_med = "\"[";
if (empty($_POST['med'])) {
    $s_a_med = "\"[";
} else {
    foreach ($_POST['med'] as $key => $value) {
        $s_a_med .= "[`$key`,";
        if ($value == "on") {
            $s_a_med .= "1";
        } else {
            $s_a_med .= "0";
        }
        $s_a_med .= "],";
    }
    $s_a_med = rtrim($s_a_med, ',');
    $s_a_med .= "]\"";
}
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
$s_a_civ = mysqli_real_escape_string($con,$s_a_civ);
$s_a_cop = mysqli_real_escape_string($con,$s_a_cop);
$s_a_med = mysqli_real_escape_string($con,$s_a_med);
$query = mysqli_query($con,"UPDATE players SET cop_licenses=\"$s_a_cop\", civ_licenses=\"$s_a_civ\", med_licenses=\"$s_a_med\" WHERE playerid='".$_POST['steamid']."'");
echo "Licences set.";