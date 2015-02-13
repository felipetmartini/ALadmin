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
        <ul><li>Server: <a href="http://<?php echo $server_ip; ?>" target="_blank" title="Open in Browser"><?php echo $server_ip.":$server_port"; ?></a></li><li>Logged in as <b><?php echo $steamprofile['personaname'] ?></b></li><li id="logout"><a href="steamauth/logout.php"><span class="icon ion-power"></span> Log out</a></li></ul></div>
    <nav role="navigation">
        <div id="logo"></div>
        <ul>
            <li><a href="dashboard.php"><span class="icon ion-clipboard"></span> Dashboard</a></li>
            <li><a href="plmng.php"><span class="icon ion-person"></span> Player Managment</a></li>
            <li class="active"><a href="svtools.php"><span class="icon ion-settings"></span> Server Tools</a></li>
            <?php if ($showDonateButton == true) { echo '<li id="donate"><a href="http://blackcetha.github.io/ALadmin/donate"><span class="icon ion-ios-paper-outline"></span> Donate</a></li>'; } ?>
        </ul>
        <div onClick="this.style.display = 'none';" id="steampowered">This page uses the SteamAPI and is therefore powered by <a href="http://steampowered.com" target="_blank">Steam</a></div>
        <div style="position: fixed; left: 3px; bottom: 3px; font-size: 10px;">&copy; 2015 <a href="http://github.com/blackcetha" target="_blank">BlackCetha</a> <a href="javascript:steampower();">Info</a></div>
    </nav>
    <!-- CONTENT GOES HERE -->
    <div class="container first"><div class="headline"><span class="icon ion-gear-b"></span> Maintenance mode</div>
    <div class="content">The current status cannot be checked by the webinterface.<br><button onClick='enableMaintMode();'>Enable maintenance mode</button> <button onClick='disableMaintMode();'>Disable maintenance mode</button></div></div>
    <div class="container" id="bans"><div class="headline"><span class="icon ion-radio-waves"></span> Manage bans</div>
    <div class="content"><a href="javascript:showBans();">Request banlist</a></div></div>
    <div class="container"><div class="headline"><span class="icon ion-pound"></span> Run command</div>
    <div class="content"><span class="warning">This can cause damage and loss of data. Be careful!</span><br>
    <input type="text" id="cmd"><input type="button" value="Send" onClick="sendCmd();">
        </div></div>
    <div class="container" id="cmd_out"><div class="headline"><span class="icon ion-share"></span> Command output</div>
    <div class="content">Waiting for output.</div></div>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script>
        function sendCmd () {
            var cmd = $('#cmd').val();
            $.post( "sendCmd.php", { "cmd" : cmd })
                .done(function( data ) {
                    $("#cmd_out > .content").html(data);
            });
        }
        function enableMaintMode () {
            if (confirm("This will kick all players and prevent new ones from joining.\nAre you sure?")) {
                $.post( "sendCmd.php", { "cmd" : "kick -1" })
                $.post( "sendCmd.php", { "cmd" : "lock" })
            }
        }
        function disableMaintMode () {
            $.post( "sendCmd.php", { "cmd" : "unlock" })
        }
        function showBans () {
            $('#bans > .content').html("<div class='load'><div class='icon ion-load-c spin'></div></div>");
            $.post( "sendCmd.php", { "cmd" : "bans" })
                .done(function( data ) {
                    $("#bans > .content").html("<a href='javascript:showBans()'>Retry</a><br>"+data+"<br><br>Revoke ban #<input type='text' id='banid'><br><button onClick='unBan()'>Unban</a>");
            });
        }
        function unBan () {
            var banid = $('#banid').val();
            $.post( "sendCmd.php", { "cmd" : "removeBan "+banid })
                .done(function( data ) {
                    showBans();
            });
        }
    </script>
</body>
</html>