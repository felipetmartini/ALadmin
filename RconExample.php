<?php
include 'rcon.php';
include 'config.php';
echo rcon($server_ip,$server_port+1,$rcon_password,"Players");