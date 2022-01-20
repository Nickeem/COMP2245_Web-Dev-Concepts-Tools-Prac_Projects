/*  DONE BY NICKEEM PAYNE-DEACON    */
function toggleMenu() {
    if (window.innerWidth >= 1100) {
        return;
    }
    else {
        if (document.getElementsByClassName("menu-items")[0].style.display == "") {
            document.getElementsByClassName("menu-items")[0].style.display = "block";
        }
        else{
            document.getElementsByClassName("menu-items")[0].style.display = "";
        }
    }
}

async function boxAppear(e) {
  var alert = document.querySelector(".alert-text");
  formData = new FormData();
      await formData.append("movie_number", e.target.id)
      fetch('__movieStatus.php', {
          method: "POST",
          body:formData,
      })
      .then(response => response.text())
      .then(movie_status =>  {
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
              alert.innerHTML = "This movie is in the&nbsp <b>"+ status + "</b>&nbsplist"
          }
          else{
              alert.innerHTML = ""
          }
      });
    // set elements to contain movie data 
    document.getElementsByClassName("box-image")[0].src = e.target.src;
    document.getElementsByClassName("popup-container")[0].style.display = "block";
    document.getElementsByClassName("popup-box")[0].style.display = "grid";
    let movie_id = e.target.id;

    document.querySelector(".imdb_id").innerHTML = movies[movie_id].imbd_id;
    document.querySelector(".movie-title").innerHTML = movies[movie_id].title;
    document.querySelector(".movie-year").innerHTML = movies[movie_id].release;
    document.querySelector(".movie-runtime").innerHTML = movies[movie_id].runtime;
    document.querySelector(".movie-genre").innerHTML = movies[movie_id].genres;
    document.querySelector(".movie-overview").innerHTML = movies[movie_id].overview;
    
    // hidden input elements
    document.querySelector(".movie_number").value = e.target.id;
    document.querySelector(".poster_path").value = movies[movie_id].path;
    document.querySelector(".movie_title").value = movies[movie_id].title;
    document.querySelector(".movie_overview").value = movies[movie_id].overview;

    
  }

  function targetBoxAppear(e) {
    console.log(e.target);
    toggleMenu();
    const box_name = (e.target.innerHTML).toLowerCase().replace(/\s+/g, '') + "-box";
    console.log(document.getElementsByClassName(box_name)[0]);
    document.getElementsByClassName("popup-container")[0].style.display = "block";
    document.getElementsByClassName(box_name)[0].style.display = "block";
  }
  
  function closeBox(e) {
    //console.log(e);
    e.target.parentNode.parentNode.style.display = "none"; // eg ...-box
    if (document.getElementsByClassName("popup-container").length > 0)
    {
        document.getElementsByClassName("popup-container")[0].style.display = "none";
    }
  }

// special characters can cause sql injections

  function validateUsername(str) {
      if (str == "") {
        return {valid:false, message:"Username field is empty"};
      }
      if (/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str))
      {
          return {valid:false, message:"Username must be alpha numeric"};
      }
      return {valid:true};
  }

  function validateName(str) {
    if (str == "")
    {
      return {valid:false, message:"Full name field is empty"};
    }
    if (/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str))
    {
        return {valid:false, message:"Name must only contain letters"};
    }
    for (let character of str) { // check name for letters
        if (parseInt(character)) {
            return {valid:false, message:"Name must only contain letters"};
        }
    }
    return {valid:true};
}

  function validatePassword(password) { 
      if (/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(password))
      {
        return {valid:false, message:"Password must be alpha numeric"};
      }
      if (password.length < 6 || password.length > 12) {
        return {valid:false, message:"Password must be between 6 and 12 characters"};
      }
      let number_check = false;
      let upper_check = false;
      for (let character of password)
      {
          if (parseInt(character)) {
              number_check = true;
          } 
          else if (character == character.toUpperCase())
          {
              upper_check = true;
          }
      }
      if (!(number_check && upper_check))
      {
        return {valid:false, message:"Passwrd must contain at least 1 uppercae letter and 1 number "};
      }
      console.log("true");
      return {valid:true}
      
  }

  function enableSignInError() {
      element = document.querySelector(".sign-in-box .alert-text");
      element.innerHTML = "Username or Password are Incorrect";
  }

  function checkSignIn() {
      username = document.getElementById("username").value;
      password = document.getElementById("password").value;
      if (/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(username) || /[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(password)) {
          enableSignInError();
          return false;
      }
      return true;
  }

  function registrationVal() { // registration validation
      document.getElementById("new_username").classList.remove("highlight-error");
      document.getElementById("full_name").classList.remove("highlight-error");
      document.getElementById("new_password").classList.remove("highlight-error");
      document.getElementById("new_password_check").classList.remove("highlight-error");
      username = document.getElementById("new_username").value;
      fullName = document.getElementById("full_name").value;
      password = document.getElementById("new_password").value;
      password_check = document.getElementById("new_password_check").value;

      var error_element = document.querySelector(".register-box .alert-text");

      check = validateUsername(username);
      if (!check.valid)
      {
        error_element.innerHTML = check.message;
        document.getElementById("new_username").classList.add("highlight-error");
        //error_element.style.display = "block";
        return false;
      }
      check2 = validateName(fullName);
      if (!check2.valid)
      {
        error_element.innerHTML = check2.message;
        //error_element.style.display = "block";
        document.getElementById("full_name").classList.add("highlight-error");
        return false;
      }
      check3 = validatePassword(password);
      if (!check3.valid)
      {
        error_element.innerHTML = check3.message;
        document.getElementById("new_password").classList.add("highlight-error");
        //error_element.style.display = "block";
        return false;
      }

      // final check
      if (password != password_check || password_check == "")
      {
        error_element.innerHTML = "Passwords must match";
        document.getElementById("new_password_check").classList.add("highlight-error");
        //error_element.style.display = "block";
        return false;
      }
      return true; // all checks passed
  }

  function enableRegisError(str) 
  {
    error_element = document.querySelector(".register-box .alert-text");
    error_element.innerHTML = str;
    //error_element.style.display = "block";
  }

  function removeAllChildNodes(parent) {
    while (parent.firstChild) parent.removeChild(parent.firstChild);
  }

  function Paging(pages, queried_movies=all_keys, num_per_page=20) {
    var range_start = pages;
    var range_end = pages + 4; // 4 elements after active
    if (range_start - 5 < 1) { // cant put 5 elements before because of negative numbers
      range_end += Math.abs(range_start - 5) + 1; // add elemnents cant add to the end instead
      range_start = 1;
    } else {
      range_start -= 5;
    }

    let num_of_movies = (queried_movies).length;
    if (range_end > num_of_movies/num_per_page)
    {
      range_end = Math.floor(num_of_movies/num_per_page);
      if (num_of_movies%num_per_page > 0) {
        range_end++; 
      }
    }

    let parent = document.querySelector(".pagination");
    removeAllChildNodes(parent);
    for (let i = range_start; i <= range_end; i++) 
    {
      let node = document.createElement("div");
      node.classList.add("page_item");
      if (i == pages) {
        node.classList.add("active-page");
      }
      node.innerHTML = i;
      node.addEventListener("click", (e) =>
      {
        Paging(i, queried_movies, num_per_page);
      });
      parent.appendChild(node);
    }
    moviesFrom(pages, queried_movies, num_per_page);
  }

   /* function updatedMovieAppear(number){
    // display box with movie data updated
    const root = "https://image.tmdb.org/t/p/w500";
    document.getElementsByClassName("popup-container")[0].style.display = "block";
    document.getElementsByClassName("popup-box")[0].style.display = "grid";
    let movie_id = number;
    //console.log(e);
    document.getElementsByClassName("box-image")[0].src = root + movies[movie_id].path;
    document.querySelector(".imdb_id").innerHTML = movies[movie_id].imbd_id;
    document.querySelector(".movie-title").innerHTML = movies[movie_id].title;
    document.querySelector(".movie-year").innerHTML = movies[movie_id].release;
    document.querySelector(".movie-runtime").innerHTML = movies[movie_id].runtime;
    document.querySelector(".movie-genre").innerHTML = movies[movie_id].genres;
    document.querySelector(".movie-overview").innerHTML = movies[movie_id].overview;
    
    // hidden input elements
    document.querySelector(".movie_number").value = movie_id;
    document.querySelector(".poster_path").value = movies[movie_id].path;
    document.querySelector(".movie_title").value = movies[movie_id].title;
    document.querySelector(".movie_overview").value = movies[movie_id].overview;

    var alert = document.querySelector(".alert-text");
    if (movies[movie_id].status != "")
    {
      
      var status = "";
      if (movies[movie_id].status == "AW")
      {
        status = "Already Watch";
      }
      else if (movies[movie_id].status == "MW")
      {
        status = "Must Watch";
      }
      alert.innerHTML = "<b>" +  status + "</b>&nbsplist is updated";
    }
    else{
      alert.innerHTML = ""
    }
  }*/
