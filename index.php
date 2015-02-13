<?php 
    require 'steamauth/steamauth.php';
    if(!isset($_SESSION['steamid'])) {
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>BlackCetha\'s Altis Life Administration Interface - Login</title><link rel="stylesheet" href="login.css"></head><body><div id="header"><div>BlackCetha\'s Altis Life Administration Interface</div></div><div id="notification">Logging in through steam will automatically get us all the neccessary information about you.</div>';
if (isset($_GET['noadmin'])) {
    echo '<div id="error">You are not registered as an admin!</div>';
}
echo '<div id="loginbutton">';
        steamlogin(); //login button
    }  else {
        header("Location: steamauth/login.php");
    }     
    ?>
    </div>
</body>
</html>
