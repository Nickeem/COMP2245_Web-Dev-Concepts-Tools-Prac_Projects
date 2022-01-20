<?php
    session_start();
    $serverName = "localhost";
    $name = "root";
    $password = "";
    $dbname = "comp2245";
    $conn = mysqli_connect($serverName, $name, $password, $dbname);
?>