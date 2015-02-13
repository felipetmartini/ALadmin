<?php
    require 'steamauth/steamauth.php';
    if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin");die; }
    require 'steamauth/userInfo.php';
    require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlackCetha's Altis Life Administration Interface</title>
    <link rel="stylesheet" href="global.css">
    <script>function steampower () {document.getElementById('steampowered').style.display='inline-block'}</script>
</head>
<body>
    <div id="topmenu">BlackCetha's Altis Life Administration Interface
        <ul><li>Server: <a href="http://<?php echo $server_ip; ?>" target="_blank" title="Open in Browser"><?php echo $server_ip.":".$server_port; ?></a></li><li>Logged in as <b><?php echo $steamprofile['personaname'] ?></b></li><li id="logout"><a href="steamauth/logout.php"><span class="icon ion-power"></span> Log out</a></li></ul></div>
    <nav role="navigation">
        <div id="logo"></div>
        <ul>
            <li class="active"><a href="dashboard.php"><span class="icon ion-clipboard"></span> Dashboard</a></li>
            <li><a href="plmng.php"><span class="icon ion-person"></span> Player Managment</a></li>
            <li><a href="svtools.php"><span class="icon ion-settings"></span> Server Tools</a></li>
            <?php if ($showDonateButton == true) { echo '<li id="donate"><a href="http://blackcetha.github.io/ALadmin/donate"><span class="icon ion-ios-paper-outline"></span> Donate</a></li>'; } ?>
        </ul>
        <div onClick="this.style.display = 'none';" id="steampowered">This page uses the SteamAPI and is therefore powered by <a href="http://steampowered.com" target="_blank">Steam</a></div>
        <div style="position: fixed; left: 3px; bottom: 3px; font-size: 10px;">&copy; 2015 <a href="http://github.com/blackcetha" target="_blank">BlackCetha</a> <a href="javascript:steampower();">Info</a></div>
    </nav>
    <!-- CONTENT GOES HERE -->
    <div class="container first" id="currentstats"><div class="headline"><span class="icon ion-stats-bars"></span> Current Stats<span style="float: right; margin-right: 5px;"><a href="javascript:refreshCurrentStats();">Refresh</a></span></div>
        <div class="content" id="stats"><div class="load"><div class="icon ion-load-c spin"></div></div></div></div>
    <div class="container" id="mystats"><div class="headline"><span class="icon ion-man"></span> Your stats</div>
    <div class="content"><div class="load"><div class="icon ion-load-c spin"></div></div></div></div>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#currentstats > .content').load("currentstats.php");
            $('#mystats > .content').load("mystats.php");
        });
        function refreshCurrentStats () {
            $('#currentstats > .content').html("<div class='load'><div class='icon ion-load-c spin'></div></div>");
            $('#currentstats > .content').load("currentstats.php");
        }
    </script>
</body>
</html>
