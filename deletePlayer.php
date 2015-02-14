<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin"); die; };
require 'steamauth/userInfo.php';
require 'config.php';
if ($_POST['token'] != $_SESSION['steamid']) { die("BLOCKED delete-request!<br>If you just clicked a link, make sure you don't click it again.<br><a href='.'>Dashboard</a>"); }
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
mysqli_query($con,"DELETE FROM players WHERE playerid='".$_POST['steamid']."' LIMIT 1");
mysqli_query($con,"DELETE FROM vehicles WHERE pid='".$_POST['steamid']."'");
mysqli_query($con,"DELETE FROM houses WHERE pid='".$_POST['steamid']."'");
$query = mysqli_query($con,"SELECT id, members, owner FROM gangs WHERE members LIKE '%".$_POST['steamid']."%'");
$data = mysqli_fetch_row($query);
if ($data[2] == $_POST['steamid']) {
    mysqli_query($con,"DELETE from gangs WHERE owner='".$_POST['steamid']."'");
} else {
    preg_match_all("/([0-9])\w+/",$data[1],$g_pids);
    $g_after = "\"[";
    foreach($g_pids[0] as $value) {
        if ($value != $_POST['steamid']) {
            $g_after .= "`$value`,";
        }
    }
    $g_after = rtrim($g_after, ',');
    $g_after .= "]\"";
    mysqli_query($con,"UPDATE gangs SET members='$g_after' WHERE id='".$data[0]."'");
}
?>
