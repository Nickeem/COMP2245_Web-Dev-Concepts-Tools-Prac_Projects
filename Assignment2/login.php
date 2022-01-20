<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="js/index.js"></script>
    <title>home</title>
  </head>
  <body>
      <div class="home-container">
          <div class="sign-in-box box">
            <div class="top-bar">
              <h3>User Sign In</h3>
              <i class="fas fa-times"></i>
            </div>
            <form action="__sign_in.php" method="POST" name="signin-form" id="signin-form" onsubmit="return checkSignIn()">
              <p>Username</p>
              
              <input type="text" name="username" id="username" >
              <p>Password</p>
              <input type="password" name="password" id="password">
              <div class="form-buttons">
                <input type="submit" value="Submit">
              </div>

              
            </form>
            <div class="alert-text"></div>
          </div>
          <div class="register-box box">
            <div class="top-bar">
              <h3>Register New User</h3>
              <i class="fas fa-times"></i>
            </div>

            <form action="__register.php" method="post" name="register-form" id="register-form" onsubmit="return registrationVal()">
              <p>UserName</p>
              <input type="text" name="new_username" id="new_username" required>
              <p>Full Name</p>
              <input type="text" name="full_name" id="full_name" class="max-width" required>
              <p>Password</p>
              <input type="password" name="new_password" id="new_password" required>
              <p>Confirm Password</p>
              <input type="password" name="" id="new_password_check" required>  
              <div class="form-buttons">
                <input type="button" value="Clear" class="clear_btn">
                <input type="submit" value="Submit">
              </div>
            </form>
            <div class="alert-text"></div>
          </div>
          <div class="titles">
            <h1>Movie FansApp</h1>
            <h2>The number one movie tracking website</h2>
          </div>
          <div class="home-buttons">
            <button class="signin_button">Sign In</button>
            <button class="register_buttton">Register</button>
          </div>
      </div>
      <script>
        var user_notFound = false;
        var username_used = false;
        var success_registered = false;
        <?php
          session_start();
          if (isset($_SESSION["user_notFound"]))
          {
            echo "user_notFound = true;\n";
          }
          elseif (isset($_SESSION["username_used"]))
          {
            echo "username_used = true;\n";
          }
          elseif (isset($_SESSION["registered"]))
          {
            echo "success_registered = true;\n";
          }
          unset($_SESSION["user_notFound"]);
          unset($_SESSION["username_used"]);
          unset($_SESSION["registered"]);

        ?>
        var signIn_btn = document.querySelector(".signin_button");
        var register_btn = document.querySelector(".register_buttton");
        if (user_notFound) {
          signIn_btn.classList.add("active-button");
          document.querySelector(".sign-in-box .alert-text").innerHTML = "";
          document.querySelector(".sign-in-box").style.display = "block";
          enableSignInError();
        }
        else if (success_registered) {
          signIn_btn.classList.add("active-button");
          document.querySelector(".sign-in-box .alert-text").innerHTML = "Sucessfully Registered. Sign In";
          document.querySelector(".sign-in-box").style.display = "block";
        }
        else if (username_used)
        {
          document.querySelector(".register_buttton").classList.add("active-button"); 
          document.querySelector(".register-box").style.display = "block";
          enableRegisError("Username is already being used");
        }
        
        
        signIn_btn.addEventListener( "click", (e) => {
          register_btn.classList.remove("active-button");
          signIn_btn.classList.add("active-button");
          document.querySelector(".register-box").style.display = "none";
          document.querySelector(".sign-in-box").style.display = "block";
        });

        
        register_btn.addEventListener("click", (e) => {
          signIn_btn.classList.remove("active-button");
          register_btn.classList.add("active-button"); 
          document.querySelector(".sign-in-box").style.display = "none"; // ckose box if open
          document.querySelector(".register-box").style.display = "block";
        });

        let clear_btn = document.querySelector("#register-form .clear_btn");
        clear_btn.addEventListener("click", (e) => {
          clearRegisFields()
        });
        
        function closeBox_ALT(e) {
          signIn_btn.classList.remove("active-button");
          register_btn.classList.remove("active-button");
          document.querySelector(".sign-in-box ").style.display = "none";
          clearRegisFields()
          closeBox(e);
        }
        

        let close_elements = document.getElementsByClassName("fa-times");
        for (let elem of close_elements) {
          elem.addEventListener("click", closeBox_ALT);
      }

      function clearRegisFields() {
        document.getElementById("new_username").value = "";
          document.getElementById("full_name").value = "";
          document.getElementById("new_password").value = "";
          document.getElementById("new_password_check").value = "";
          document.querySelector(".register-box .alert-text").innerHTML = "";
      }
      function removeAllHighlights() {
        document.getElementById("new_username").classList.remove("highlight-error");
        document.getElementById("full_name").classList.remove("highlight-error");
        document.getElementById("new_password").classList.remove("highlight-error");
        document.getElementById("new_password_check").classList.remove("highlight-error");
        
      }
      function highlightRegisError(e, message) {
        e.target.classList.add("highlight-error");
        document.querySelector(".register-box .alert-text").innerHTML = message;
      }
      function removeRegisError(e) {
        e.target.classList.remove("highlight-error");
      }
      let username = document.getElementById("new_username");
      username.addEventListener("focusout", (e) => {
        let check = validateUsername(username.value);
        if (!check.valid) {
          highlightRegisError(e, check.message);
        }
        else {
          removeRegisError(e)
        }
      });
      let fullName = document.getElementById("full_name");
      fullName.addEventListener("focusout", (e) => {
        let check = validateName(fullName.value);
        if (!check.valid) {
          highlightRegisError(e, check.message);
        }
        else {
          removeRegisError(e)
        }
      });
      var new_password = document.getElementById("new_password");
      new_password.addEventListener("focusout", (e) => {
        let check = validatePassword(new_password.value);
        if (!check.valid) {
          highlightRegisError(e, check.message);
        }
        else {
          removeRegisError(e)
        }
      });
      /*let password_check = document.getElementById("new_password_check");
      password_check.addEventListener("focusout", (e) => {
        if (password_check.value == "")
        {
          highlightRegisError(e, "Field is empty");
        }
        else if (password_check.value != new_password.value)
        {
          highlightRegisError(e, "Passwords must match");
        }
        else {
          removeRegisError(e)
        }
      }); */
      </script>
  </body>
</html>
