<?php
require '../config.php';
require 'steamauth.php';
if (in_array($_SESSION["steamid"],$admins)) {
    $_SESSION['authed'] = true;
    header("Location: ../dashboard.php");
} else {
    header("Location: logout.php?noadmin");
}