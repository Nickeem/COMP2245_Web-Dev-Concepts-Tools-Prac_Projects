<?php 
  session_start();
  $serverName = "localhost";
  $name = "root";
  $password = "";
  $dbname = "comp2245";
  $conn = mysqli_connect($serverName, $name, $password, $dbname);
  
  if(!isset($_SESSION["loggedIn"]) || !isset($_SESSION["ID"]) )
  {
    header("Location: login.php");
  }
?>