<?php require_once('__connection.php');?>
<?php

    if ($_SESSION["loggedIn"] && isset($_POST["movie_number"]) && isset($_POST["poster_path"]) &&isset($_POST["movie_title"]) && isset($_POST["movie_overview"]) && isset($_POST["status"]))
    {
        $movie_number = $_POST["movie_number"];
        $poster_path = $_POST["poster_path"];
        $movie_title = $_POST["movie_title"];
        $movie_overview = $_POST["movie_overview"];
        $status = $_POST["status"]; 

        $ID = $_SESSION["ID"];

        $check_query = "SELECT * FROM user_status WHERE user_number = $ID AND movie_number = $movie_number; ";
        $result = mysqli_query($conn, $check_query);
        $result_rows = mysqli_num_rows($result);
        if($result_rows > 0)
        {
            $update_query = "UPDATE user_status SET status = '$status' WHERE user_number = $ID and movie_number = $movie_number;" ;
            $success = mysqli_query($conn, $update_query);
            {
                //$_SESSION["movieStatusUpdated"] = true;
                //$_SESSION["movie_num_updated"] = $movie_number;
                print_r($status);
            }
        }
        else
        {
            $insert_query = "INSERT INTO user_status (user_number, movie_number, status, poster_path, original_title, overview) VALUES ($ID, $movie_number, '$status', '$poster_path', \"$movie_title\", \"$movie_overview\");";
            $success = mysqli_query($conn, $insert_query);
            if ($success)
            {
                //$_SESSION["movieStatusUpdated"] = true;
                //$_SESSION["movie_num_updated"] = $movie_number;
                print_r($status);
            }
        }
        //header("Location: home.php");
    }
    else {
        print_r("fields not set");
        //header("Location: home.php");
    }
?>