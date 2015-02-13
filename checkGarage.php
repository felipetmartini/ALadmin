<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin");die; }
require 'config.php';
$con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
$query = mysqli_query($con, "SELECT * FROM vehicles WHERE pid='".$_POST['steamid']."'");
echo $_POST['name']."<hr>";
if (mysqli_num_rows($query) < 1) {
    echo "This player has no vehicles.";
} else {
    echo "<table><tr><td>Vehicle-Name</td><td>Type</td><td>Role</td><td></td></tr>";
    while ($row = mysqli_fetch_row($query)) {
        echo "<tr><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[1]."</td><td>";
        if ($row[6] == "1") {
            echo "Currently in use";
        } else {
            echo "<a href='javascript:removeGarage(\"".$_POST['steamid']."\",\"".$row[0]."\");checkGarage(\"".$_POST['steamid']."\")'>Delete</a>";
        }
        echo "</td></tr>";
    }
    echo "</table>";
}
echo "<br><a href='javascript:removeCompleteGarage(\"".$_POST['steamid']."\");'>Delete all vehicles of this player</a><br><br>
    Add vehicles:<br>
    <input type='text' id='vehic_name' placeholder='Vehicle ID'><select id='vehic_type'><option value='Car'>Car</option><option value='Air'>Air</option><option value='Ship'>Ship</option></select><select id='vehic_side'><option selected value='civ'>Civ</option><option value='cop'>Cop</option><option value='med'>Medic</option></select><select><option onClick='$(\"#vehc_name\").val(\"\");' selected></option>";
    foreach ($default_vehicles as $value) {
        echo "<option onClick='$(\"#vehic_name\").val(\"".$value[0]."\");document.getElementById(\"vehic_type\").selectedIndex = ".$value[1].";document.getElementById(\"vehic_side\").selectedIndex = ".$value[2].";'>".$value[0]."</option>";
    }
    echo "</select> <input type='button' onClick='addGarage(\"".$_POST['steamid']."\");checkGarage(\"".$_POST['steamid']."\");' value='Add Vehicle'>";
?>