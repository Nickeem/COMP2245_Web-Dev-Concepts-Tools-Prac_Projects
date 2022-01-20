<!--  DONE BYB NICKEEM PAYNE-DEACON -->
<?php include_once('__validation.php');?>

<!DOCTYPE html> 
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/index.js"></script>
    <title>Home</title>
  </head>
  <body>
      <header>
        <div class="header-layout">
            <div><i class="fa fa-film" aria-hidden="true"></i>
            <p>
                Movie FanApp
            </p>
            <?php echo "<p class='user-name'>".
              $_SESSION["name"]
            ."</p>"; ?>
            </div>
            <div class="navigation">
              <i class="fa fa-bars" aria-hidden="true"></i>
              <div class="menu-items">
                <p class="home-button">Home</p>
                <p class="popbox">Search</p>
                <p> <a href="MustWatch.php"> Must Watched </a></p>
                <p> <a href="alreadyWatched.php"> Already Watched </a> </p>
                <p class="popbox about-button">About Me</p>
              </div>
            </div>
        </div>
      </header>
      <div class="popup-container">
        <div class="search-box box">
          <div class="top-bar">
            <h3>Search Database</h3>
            <i class="fas fa-times"></i>
          </div>
          
            <input type="text" name="" id="" class="title-search" placeholder="Title Search">
            <button class="search-database">Submit</button>

          
          <div class="titles-found"><span class="title-results">0</span> records found</div>
          <div></div>
          
        </div>
        <div class="aboutme-box box">
          <div class="top-bar">
            <h3>About Me</h3>
            <i class="fas fa-times"></i>
          </div>
          <h1><?php echo $_SESSION["name"]; ?></h1>
          <p>Total movies you've tracked: <span class="total-tracked"></span></p>
          <p>Total movies you've tagged as Must Watch: <span class="mw_tagged"></span></p>
          <p>Total movies you've tagged as Already Watch: <span class="aw_tagged"></span></p>
          
        </div>
        <div class="popup-box box">
          <div class="top-bar">
            <h3>Movie Details</h3>
            <i class="fas fa-times"></i>
          </div>
          <div class="image-section">
            <img class="box-image" alt="">
          </div>
          <div class="description">
            <p><b>IMBD ID : </b>
             <span class="imdb_id"></span>
            </p>
            <p><b>TITLE : </b>
              <span class="movie-title"></span>
            </p>
            <p><b>YEAR RELEASE : </b>
              <span class="movie-year"></span>
            </p>
            <p><b>RUNTIME : </b>
              <span class="movie-runtime"></span>
            </p>
            <p><b>GENRES : </b>
              <span class="movie-genre"></span>
            </p>
          </div>
          <div class="overview">
            <p>
              <b>OVERVIEW:</b> 
              <span class="movie-overview"></span> 
            </p>
          </div>
          <div class="tabs">
            <form action="javascript:void(0);" method="POST" class="movie-status-form">
              <button type="submit" value="MW">Must Watch</button>
              <button type="submit" value="AW">Already Watched</button>
              <button type="submit" value="">Clear Status</button>
              <input type="hidden" name="movie_number" class="movie_number">
              <input type="hidden" name="poster_path" class="poster_path">
              <input type="hidden" name="movie_title" class="movie_title">
              <input type="hidden" name="movie_overview" class="movie_overview">
              <input type="hidden" name="status" class="status">
            </form>
          </div>
          
          <div class="alert-text">Already Watched List is Updated</div>
        </div>
      </div>
    <main class="app">
        
    </main>
    <div class="pagination"></div>
    <script>

      <?php
        // selecting movies and putting them into an object
          $ID = $_SESSION["ID"];
          $movie_query = "SELECT * FROM movies;"; 
          $results = mysqli_query($conn, $movie_query);
          if ($results) {
            echo "const movies = {";
            while ($arow = mysqli_fetch_assoc($results)) {
              // check movie status
              $movie_number = $arow["number"];


              echo $arow["number"].": {imbd_id:'".$arow["imdb_id"]."', title:`".$arow["original_title"]."`, genres:'".$arow["genres"]."',";
              echo " overview:`".$arow["overview"]."`.replace(/\uFFFD/g, ''), path:' ".$arow["poster_path"]."', release: '".$arow["release_date"]."', ";
              echo "runtime: '".$arow["runtime"]."', vote: '".$arow["vote_average"]."', count:'".$arow["vote_count"]."',";
              //echo "status: '".$status;
              echo "},\n";
            }
            echo "};";
          }
      ?>

      var movies_path = [];
      var movie_titles = [];
      var all_keys = [];
      for (let movie in movies)
      { 
        movies[movie].path = movies[movie].path.replace(/\s+/g, ''); // remove space in paths
        movie_titles.push(movies[movie].title);
        all_keys.push(movie);
      }
      Paging(1); 
     

      var menu_bars = document.getElementsByClassName("fa-bars")[0];
      menu_bars.onclick = toggleMenu;

      let popup_container = document.getElementsByClassName("popup-container")[0];
        popup_container.addEventListener("click", function (e) {
        popup_container.style.display = "none";
        document.getElementsByClassName("popup-box")[0].style.display = "none";
        document.getElementsByClassName("aboutme-box")[0].style.display = "none";
        document.getElementsByClassName("search-box")[0].style.display = "none";
      });

      let box_elements = document.querySelectorAll(".popup-container div.box");
      for (let elem of box_elements) {
          elem.addEventListener("click", function (e) {
            e.stopPropagation();
          });
      }
      
      let menu_elements = document.querySelectorAll(".menu-items p.popbox");
      for (let elem of menu_elements) {
          elem.addEventListener("click", targetBoxAppear);
      }

      let about_me = document.querySelector(".about-button");
      about_me.addEventListener("click", (e) => {
        fetch('__about.php')
            .then(response => response.text())
            .then(data => { // load about me information
                totals = data.split("-");
                document.querySelector(".total-tracked").innerHTML = totals[0];
                document.querySelector(".mw_tagged").innerHTML = totals[1];
                document.querySelector(".aw_tagged").innerHTML = totals[2];
            });
      }); 

      let close_elements = document.getElementsByClassName("fa-times");
      for (let elem of close_elements) {
          elem.addEventListener("click", closeBox);
      }
      
      var search_element = document.querySelector(".title-search");
      search_element.addEventListener("input", (e)=> {
        var matches = 0;
        var term = e.target.value;
          formData = new FormData();
          formData.append("search_term", term);
        fetch('__search.php', {
            method: "POST",
            body:formData,
        })
        .then(response => response.text())
          .then(data => {
            document.querySelector(".title-results").innerHTML= data;
            console.log(data);
          });
        });

      search_element.addEventListener("focus", (e) => {
        document.querySelector(".titles-found").style.display = "block";
      });

      
      
      let update_button_elements = document.querySelectorAll(".movie-status-form button");
      for (let element of update_button_elements)
      {
        element.addEventListener("click", (e) => {
          document.querySelector(".movie-status-form .status").value = e.target.value;
          var form_element = document.querySelector(".movie-status-form");
          var alert = document.querySelector(".alert-text");
          formData = new FormData(form_element);
            fetch('__updateUserStatus.php', {
                method: "POST",
                body:formData,
            })
            .then(response => response.text())
              .then(movie_status => {
                if (movie_status != "")
                {
                  
                  var status = "";
                  if (movie_status == "AW")
                  {
                    status = "Already Watch";
                  }
                  else if (movie_status == "MW")
                  {
                    status = "Must Watch";
                  }
                  alert.innerHTML = "<b>" +  status + "</b>&nbsplist is updated";
                }
                else{
                  alert.innerHTML = ""
                }
              });
            });
      }

      let home_button = document.querySelector(".home-button");
      home_button.addEventListener("click", (e)=> {Paging(1)});


      function moviesFrom(page, queried_movies=all_keys, num_per_page=20)
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
                
        for(let i = range_start; i <= range_end; i++)
        {
          let elem = document.createElement("img");
          elem.src = root+movies[queried_movies[i]].path;
          elem.id = queried_movies[i]; // movie's id will be used acrros pages as a unique identifier
          elem.addEventListener("click", boxAppear);
          parent.appendChild(elem);
        }
      } 
      
      document.querySelector(".search-database").addEventListener("click", searchDatabase);
      function searchDatabase() {
        let search_value = search_element.value;
        if (document.querySelector(".title-results").value == 0) {
          alert("No results found");
          return;
        } 

        parent = document.querySelector("main");
        removeAllChildNodes(parent);
        let queried_movies = [];
        for (let movie in movies)
        {      
          if (movies[movie].title.toLowerCase().includes(search_value))
          {
            queried_movies.push(movie);
          }
        }
        Paging(1, queried_movies)
      }
      
      
    </script>
  </body>
</html>
