<?php
include("settings.php");
if (isset ($_GET['noadmin'])) {
    header("Location: ../?noadmin");
} else {
    header("Location: ../");
}
session_start();
unset($_SESSION['steamid']);
unset($_SESSION['authed']);
unset($_SESSION['steam_uptodate']);
?>