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
            <li class="active"><a href="plmng.php"><span class="icon ion-person"></span> Player Managment</a></li>
            <li><a href="svtools.php"><span class="icon ion-settings"></span> Server Tools</a></li>
            <?php if ($showDonateButton == true) { echo '<li id="donate"><a href="http://blackcetha.github.io/ALadmin/donate"><span class="icon ion-ios-paper-outline"></span> Donate</a></li>'; } ?>
        </ul>
        <div onClick="this.style.display = 'none';" id="steampowered">This page uses the SteamAPI and is therefore powered by <a href="http://steampowered.com" target="_blank">Steam</a></div>
        <div style="position: fixed; left: 3px; bottom: 3px; font-size: 10px;">&copy; 2015 <a href="http://github.com/blackcetha" target="_blank">BlackCetha</a> <a href="javascript:steampower();">Info</a></div>
    </nav>
    <!-- CONTENT GOES HERE -->
    <div class="container first"><div class="headline"><span class="icon ion-search"></span> Search</div>
    <div class="content" style="text-align: center;"><form method="get" action="plmng.php"><input type="text" name="search" placeholder="UID, name, steamid, aliases" value="<?php echo $_GET['search'] ?>"><input type="submit" value="Search"><input type="button" value="Clear search" onClick="location = 'plmng.php';"></form></div></div>
    <div class="container"><div class="headline"><span class="icon ion-wrench"></span> Edit <span style="float: right; margin-right: 5px;"><a href="javascript:clearEditWindow();">Clear</a></span></div><div class="content" id="debug">Select something from the list below</div></div>
    <div class="container" id="allusers"><div class="headline"><span class="icon ion-edit"></span> Players<span style="float:right; margin-right: 5px;"><a href="javascript:kickAll();">Kick all players</a> <a href="javascript:whyKickAll()">(?)</a></span></div>
    <div class="content">
        <table class="playerlist">
        <tr><td style="width: 20%;">Name</td><td style="width: 20%;">SteamID</td><td style="width: 20%;">Actions</td></tr>
        <?php
        $con = mysqli_connect($db_ip,$db_user,$db_pass,$db_name);
        if (isset($_GET['search'])) {
            $search = mysqli_real_escape_string($con, $_GET['search']);
            $plys = mysqli_query($con,"SELECT * FROM `players` WHERE `uid` LIKE '%$search%' OR `name` LIKE '%$search%' OR `playerid` LIKE '%$search%' OR `aliases` LIKE '%$search%'");
        } else {
            $plys = mysqli_query($con,"SELECT * FROM players");
        }
        if (isset($search) and $plys == false) {
            echo "<tr><td colspan='4'>Keine Daten.</td></tr>";
        } else {
            while ($row = mysqli_fetch_row($plys)) {
                echo '<tr><td style="width: 20%;">'.$row[1].'</td><td style="width: 20%;">'.$row[2].'</td><td style="width: 20%;"><a href="javascript:checkMoney(\''.$row[2].'\')">Money</a> <a href="javascript:checkLicenses(\''.$row[2].'\')">Licenses</a> <a href="javascript:checkGarage(\''.$row[2].'\',\''.$row[1].'\')">Garage</a> <a href="javascript:checkMedLvl(\''.$row[2].'\')">Medic</a> <a href="javascript:checkCopLvl(\''.$row[2].'\')">Cop</a> <a href="javascript:displayBanWindow(\''.$row[2].'\')">Ban</a> <a href="javascript:deletePlayer(\''.$row[2].'\')">Delete</a></td></tr>';
            }
        }
    ?>
        </table>
        </div></div>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="jquery.serializejson.min.js"></script>
    <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/components/core.js"></script><script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script><script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/components/lib-typedarrays.js"></script><script src="http://peterolson.github.io/BigInteger.js/BigInteger.min.js"></script>
    <script>
        function uid2guid (uid) {
            var steamId = bigInt(uid);
            var parts = [0x42,0x45,0,0,0,0,0,0,0,0];
            for (var i = 2; i < 10; i++) {
                var res = steamId.divmod(256);
                steamId = res.quotient;
                parts[i] = res.remainder.toJSNumber();
            }
            var wordArray = CryptoJS.lib.WordArray.create(new Uint8Array(parts));
            var hash = CryptoJS.MD5(wordArray);
            return hash.toString();
        };
        function kickAll () {
            if (confirm("Kick all players?")) {
                $.post( "kickAll.php", { "token" : "<?php echo $_SESSION['steamid']; ?>" })
            }
        }
        function checkMoney (uid) {
            $.post( "checkMoney.php", { "steamid" : uid })
                .done(function( data ) {
                    $("#debug").html(data);
                });
        }
        function setMoney (uid) {
            var cash = $("#cash").val();
            var bankacc = $("#bankacc").val();
            $.post( "setMoney.php", { "steamid" : uid, "cash": cash , "bankacc" : bankacc })
                .done(function( data ) {
                    $("#debug").html(data);
                });
        }
        function checkLicenses (uid) {
            $.post( "checkLicenses.php", { "steamid" : uid })
                .done(function( data ) {
                    $("#debug").html(data);
                });
        }
        function setLicenses (uid) {
            var a_f_civ = $('#f_l_civ').serializeJSON({checkboxUncheckedValue: "off"});
            var a_f_cop = $('#f_l_cop').serializeJSON({checkboxUncheckedValue: "off"});
            var a_f_med = $('#f_l_med').serializeJSON({checkboxUncheckedValue: "off"});
            $.post( "setLicenses.php", { "steamid" : uid, "civ" :  a_f_civ, "cop" : a_f_cop, "med" : a_f_med })
                .done(function( data ) {
                    $("#debug").html(data);
                });
        }
        function initLicense (uid, side) {
            $.post( "initLicense.php", { "steamid" : uid, "side": side })
                .done(function( data ) {
                    $("#debug").html(data);
            });
        }
        function displayBanWindow (uid) {
            $.post( "banWindow.php", { "steamid" : uid })
                .done(function( data ) {
                    $("#debug").html(data);
            });
        }
        function addBan (uid) {
            if (confirm("Do you really want to ban this player?\nAt this time, bans cannot be reverted via this webinterface!")) {
                var guid = uid2guid(uid);
                var length = $("#i_time").val();
                var multiplier = $("#i_multiplier").val();
                var reason = $("#i_reason").val();
                $.post( "addBan.php", { "guid" : guid, "time": length, "multiplier": multiplier, "reason": reason })
                    .done(function( data ) {
                        $("#debug").html(data);
                });
            }
        }
        function checkMedLvl (uid) {
            $.post( "checkMedic.php", { "steamid" : uid })
                .done(function( data ) {
                    $("#debug").html(data);
            });
        }
        function setMedLvl (uid) {
            var medlvl = $('#medlvl').val();
            $.post( "setMedic.php", { "steamid" : uid, "value": medlvl })
                .done(function( data ) {
                    $("#debug").html(data);
            });
        }
        function checkCopLvl (uid) {
            $.post( "checkCop.php", { "steamid" : uid })
                .done(function( data ) {
                    $("#debug").html(data);
            });
        }
        function setCopLvl (uid) {
            var coplvl = $('#copdlvl').val();
            $.post( "setCop.php", { "steamid" : uid, "value": coplvl })
                .done(function( data ) {
                    $("#debug").html(data);
            });
        }
        function whyKickAll () {
            $("#debug").html("Kicking all players is designed for the case you need to edit many players stats. If the player you edit is still on the server, your changes would be reset.");
        }
        function deletePlayer (uid) {
            if (confirm("Do you really want to delete this player?\nThis cannot be undone and erase ALL data about him, including gangs he leads.")) {
                $.post( "deletePlayer.php", { "steamid" : uid, "token": <?php echo $_SESSION['steamid'] ?>})
                .done(function( data ) {
                    $('#debug').html("Done. Reloading page...");
                    location.reload();
            });
            }
        }
        function checkGarage (uid, name) {
            $.post( "checkGarage.php", { "steamid" : uid, "name" : name })
                .done(function( data ) {
                    $("#debug").html(data);
            });
        }
        function addGarage (uid) {
            var vehic_name = $('#vehic_name').val();
            var vehic_side = $('#vehic_side').val();
            var vehic_type = $('#vehic_type').val();
            $.post( "addGarage.php", { "steamid" : uid, "vehic_name" : vehic_name, "vehic_type" : vehic_type, "vehic_side" : vehic_side })
        }
        function removeGarage (uid, vehic) {
            $.post( "removeGarage.php", { "steamid" : uid, "vehic" : vehic })
        }
        function removeCompleteGarage (uid) {
            $.post( "removeCompleteGarage.php", { "steamid" : uid, "token" : <?php echo $_SESSION['steamid'] ?> })
                .done(function( data ) {
                    $("#debug").html(data);
            });
        }
        function clearEditWindow () {
            $('#debug').html("Select something from the list below");
        }
    </script>
</body>
</html>
