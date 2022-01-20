<?php require_once('__connection.php');?>
<?php 
    if ($_SESSION["loggedIn"] && isset($_POST["movie_number"])){
        $ID = $_SESSION["ID"];
        $movie_number = $_POST["movie_number"];
        $status_query = "SELECT status FROM user_status WHERE user_number = $ID AND movie_number = $movie_number; ";
        $result = mysqli_query($conn, $status_query);
        $status_result = $result->fetch_assoc();
        print_r($status_result["status"]);
    }
    
?>