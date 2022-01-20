<?php require_once('__connection.php');?>
<?php
    
    if (!$conn)
    {
        //if failed to connect
    // echo "Something ain't right";
        
    }

    if (isset($_POST["username"]) && isset($_POST["password"]))
    {

        $username = $_POST["username"];
        $hash_password = hash("sha256", $_POST["password"]);
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$hash_password';";

        $rows = mysqli_query($conn, $query);
        $result_rows = mysqli_num_rows($rows);
        if ($result_rows == 1)
        {
            //echo "We made it";
            $user = $rows->fetch_assoc();
            $_SESSION["ID"] = $user["number"];
            $_SESSION["loggedIn"] = true;
            $_SESSION["name"] = $user["name"];
            header("Location: home.php");
            // header movie viewing page
        }
        else
        {
            $_SESSION["user_notFound"] = "true";
            header("Location: login.php");
        }
        //var_dump($hash);
        
        # code...
    }
    else {
        header("Location: login.php");
    }
    

?>