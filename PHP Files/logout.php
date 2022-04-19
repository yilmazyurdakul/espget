<?php
session_start();
unset($_SESSION["active"]);
unset($_SESSION["device"]);
unset($_SESSION["records"]);
unset($_SESSION["ascdesc"]);
header("Location:login.php");
?>