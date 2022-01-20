<?php include("__connection.php"); ?>
<?php
    $term = $_POST["search_term"];
    $search_query = "SELECT * FROM movies WHERE original_title LIKE '%".$term."%'";
    $results = mysqli_query($conn, $search_query);
    $result_rows = mysqli_num_rows($results);
    print_r($result_rows);
?>