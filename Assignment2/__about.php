<?php include("__connection.php"); ?>
<?php 
    if ($_SESSION["loggedIn"]){
      $ID = $_SESSION["ID"];
      $tracked_query = "SELECT * FROM user_status WHERE user_number = $ID; ";
      $mw_query = "SELECT * FROM user_status WHERE user_number = $ID AND status = 'MW'; ";
      $aw_query = "SELECT * FROM user_status WHERE user_number = $ID AND status = 'AW'; ";
    
      $tracked_result = mysqli_query($conn, $tracked_query);
      $mw_result = mysqli_query($conn, $mw_query);
      $aw_result = mysqli_query($conn, $aw_query);
    
      $tracked_number = mysqli_num_rows($tracked_result);
      $mw_number = mysqli_num_rows($mw_result);
      $aw_number = mysqli_num_rows($aw_result);
      print_r($tracked_number."-".$mw_number."-".$aw_number);
    }
?>
