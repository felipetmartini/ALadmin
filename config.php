<?php
$server_ip = "";   # Your server's IP
$server_port = 2302;        # Port of your server
$rcon_password = "";      # RCON/Admin password
$admins = array("76561198070627147",""); # SteamID64s of your admins
$db_ip = "";      # Adress to SQL db
$db_user = "";   # DB-user
$db_pass = "";      # DB-password
$db_name = "";   # DB-name
$showDonateButton = true; # Show the donate button?
# DEFAULT licenses
$default_licenses_civ = '[[`license_civ_driver`,0],[`license_civ_air`,0],[`license_civ_heroin`,0],[`license_civ_marijuana`,0],[`license_civ_gang`,0],[`license_civ_boat`,0],[`license_civ_oil`,0],[`license_civ_dive`,0],[`license_civ_truck`,0],[`license_civ_gun`,0],[`license_civ_rebel`,0],[`license_civ_coke`,0],[`license_civ_diamond`,0],[`license_civ_copper`,0],[`license_civ_iron`,0],[`license_civ_sand`,0],[`license_civ_salt`,0],[`license_civ_cement`,0],[`license_civ_pilzsuppe`,0],[`license_civ_moscimol`,0],[`license_civ_weizen`,0],[`license_civ_mehl`,0],[`license_civ_home`,0]]';
$default_licenses_cop = '"[[`license_cop_air`,0],[`license_cop_swat`,0],[`license_cop_cg`,0]]"';
$default_licenses_med = '"[[`license_med_air`,0]]"';
# DEFAULT Vehicles
# SYNTAX: array("name",type,side) TYPE: 0=Car, 1=Air, 2=Ship; SIDE: 0=CIV, 1=COP, 2=MEDIC
# DO NOT FORGET THE COMMA (exept the last one)
$default_vehicles = array(
    array("C_Quadbike_01_F",0,0),
    array("C_SUV_01_F","B_MRAP_01_F",0,0),
    array("C_Hatchback_01_sport_F",0,0),
    array("C_Offroad_01_F",0,0),
    array("C_Kart_01_Fuel_F",0,0),
    array("B_Heli_Light_01_F",1,0)
);
?>