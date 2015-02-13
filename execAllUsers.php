<?php
    require 'steamauth/steamauth.php';
    if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin");die; }
    if (!isset($_POST['cmd']) and !isset($_POST['token'])) { die("Don't mess with this, buddy."); };
    require 'SourceQuery/SourceQuery.class.php';    
    $squery = new SourceQuery;
    require 'config.php';
    $squery->connect($server_ip,$server_port,3,SourceQuery :: SOURCE);
    function rcon () {
        // NOPE
    }
    if ($_POST["cmd"] == "kickall") { rcon("kick *"); echo "All players kicked."; }
    elseif ($_POST["cmd"] == "lock") { rcon("lock"); echo "Server has been locked."; }
    elseif ($_POST["cmd"] == "unlock") { rcon("unlock"); echo "Server has been unlocked."; }
    elseif ($_POST["cmd"] == "restart") { rcon("restart"); echo "Server is restarting..."; }
    elseif ($_POST["cmd"] == "quit") { rcon("shutdown"); echo "Server is shutting down..."; }
    else { echo "Unknown command"; }
?>