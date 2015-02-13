<?php
require 'steamauth/steamauth.php';
if (!$_SESSION['authed']) { header("Location: steamauth/logout.php?noadmin");die; }
require 'config.php';
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
$query = mysqli_query($con,"SELECT mediclevel, name FROM players WHERE playerid=\"".$_POST['steamid']."\"");
$data = mysqli_fetch_row($query);
echo $data[1]."<hr>Medic level: <select id='medlvl'>";
for ($i=0;$i<8;$i++) {
    echo "<option " ;
    if ($data[0] == $i) {
        echo "selected ";
    }
    echo "value='$i'>$i</option>";
}
echo "</select><br><input type='button' onClick='setMedLvl(\"".$_POST['steamid']."\");' value='Set Medic-Level'>";
?>