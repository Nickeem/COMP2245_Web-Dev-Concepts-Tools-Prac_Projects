<?php require_once('__connection.php');?>
<?php

    if (isset($_POST["new_username"]) && isset($_POST["new_password"]) && isset($_POST["full_name"]))
    {
        $username = $_POST["new_username"];
        $query = "SELECT username FROM users WHERE username = '$username';";
        $user = mysqli_query($conn, $query);
        $result_rows = mysqli_num_rows($user);
        if ($result_rows > 0) {
            $_SESSION["username_used"] = "true";
            header("Location: login.php");
        }
        else{
            // no users with same username
            $hash_password = hash("sha256", $_POST["new_password"]);
            $fullName = $_POST["full_name"];
            $insert_query = "INSERT INTO users(username, name, password) VALUES('$username', '$fullName', '$hash_password');";
            $success = mysqli_query($conn, $insert_query);

            if (!$success)
            {
                echo "Something ain't right";
                // do something saying it was unsucessful
            }
            else
            {
                /*
                $query = "SELECT * FROM users WHERE username = '$username';";
                $rows = mysqli_query($conn, $query);
                $user = $rows->fetch_assoc();
                $_SESSION["ID"] = $user["number"];
                $_SESSION["loggedIn"] = true;
                $_SESSION["name"] = $user["name"];*/
                $_SESSION["registered"] = true;
                header("Location: home.php");

            }
        }
    }
    else
    {
        header("Location: login.php");
    }

?>