<!--  DONE BYB NICKEEM PAYNE-DEACON -->
<?php include_once('__validation.php');?>
<?php
  $ID = $_SESSION["ID"];
  $query = "SELECT * FROM user_status WHERE user_number = $ID AND status = 'MW';";
  $results = mysqli_query($conn, $query);
  $num_of_MW = mysqli_num_rows($results);
  
?>

<!DOCTYPE html> 
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/watched.css">
    
    <script src="js/index.js"></script>
    <title>Must Watch</title>
  </head>
  <body>
    <header>
      <div class="header-layout">
          <div><i class="fa fa-film" aria-hidden="true"></i><p>
              My Must Watch List <?php echo "(".$num_of_MW. ")"; ?>
          </p>
          </div>
          <div class="navigation">
            <i class="fa fa-bars" aria-hidden="true"></i>
            <div class="menu-items">
              <div><a href="home.php">Home</a></div> 
            </div>
          </div>
      </div>
    </header>
    <main>
      
    </main>
    <div class="pagination"></div>



    <script>
      <?php
        echo "const movies = {";
        while ($row = mysqli_fetch_assoc($results))
        {
        //var_dump($row);
          $movieID = $row["movie_number"];
          $movie_query = "SELECT * FROM movies WHERE number = $movieID;";
          $movie_result = mysqli_query($conn, $movie_query);
          $result_rows = mysqli_num_rows($movie_result);
          if ($result_rows > 0) {
            $movie = $movie_result->fetch_assoc();
            echo "$movieID".": {";
            echo "path:'".$movie["poster_path"]."', title:`".$movie["original_title"]."`, overview:`".$movie["overview"]."`";
            echo "},\n";
         }
         
        }
        echo "};";
      ?>
      var all_keys = [];
      for (let movie in movies)
      { 
        all_keys.push(movie);
      }
      Paging(1, all_keys, 4); // 4 elements per page

      var menu_bars = document.getElementsByClassName("fa-bars")[0];
      menu_bars.onclick = toggleMenu;

      function moviesFrom(page, queried_movies=all_keys, num_per_page=4)
      {
        let parent = document.querySelector("main");
        removeAllChildNodes(parent);

        const root = "https://image.tmdb.org/t/p/w500";
        let num_of_movies = (queried_movies).length;

        var range_end = (page*num_per_page) - 1;
        var range_start = range_end - (num_per_page-1);
        if (range_end > num_of_movies)
        {
          range_end = num_of_movies-1;
        }
        console.log(range_end);
        for(let i = range_start; i <= range_end; i++)
        {
          let container = document.createElement("div");
          let poster = document.createElement('img');
          let info_container = document.createElement('div');
          let title = document.createElement("h1");
          let overview = document.createElement("p");
          poster.src = root + movies[all_keys[i]].path;
          title.innerHTML = movies[all_keys[i]].title;
          overview.innerHTML = movies[all_keys[i]].overview;
          info_container.classList.add("info");
          info_container.appendChild(title);
          info_container.appendChild(overview);
          container.appendChild(poster);
          container.appendChild(info_container);
          parent.appendChild(container);

        }
      } 

    </script>
      
  </body>
</html>