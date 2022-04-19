<?php
$servername = "localhost";
$username = "yilmazyu_admin";
$password = "147896";
$dbname = "yilmazyu_proje";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
?>