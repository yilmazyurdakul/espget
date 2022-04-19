<?php
session_start();
if(!isset($_SESSION["active"])){
header("Location: login.php");
exit(); }
?>