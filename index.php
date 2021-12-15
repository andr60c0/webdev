<?php
$_title = 'Welcome';

require_once(__DIR__.'/components/header.php');
?>    
<div class="login-container">
<div class="form_container">
  <h1>Welcome to Zillow</h1>
<div class="button_container">
<a class="active_link" href="index">Sign in</a>
<a href="signup">New account</a>

</div>

<form onsubmit="return false">
<label for="email">Email</label><br>
    <input name="email" type="text" placeholder="Enter email"><br>
    <label for="password">Password</label><br>
    <input name="password" type="password" placeholder="Enter password"><br>
    <a href="forgot-password" class="reset_password">Forgot your password?</a>
    <p class="error"></p>
    <button class="login_button"onclick="login()">Sign in</button>
  
  </form>
  </div>
  </div>
  <script>
    async function login(){
      const form = event.target.form
      console.log(form)
      let conn = await fetch("./apis/api-login", {
        method: "POST",
        body: new FormData(form)
      })

      let res = await conn.json()
      // console.log(res)
      // if( conn.ok ){ location.href = "user" }
      if (!conn.ok){
           document.querySelector(".error").textContent = res.info
       } else if (conn.ok){location.href = "user"}
        // if( conn.ok ){ location.href = "user" }
        
    }

  </script>

<?php

require_once(__DIR__.'/components/footer.php');
?>    

