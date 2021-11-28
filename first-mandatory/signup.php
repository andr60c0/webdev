<?php
$_title = 'Sign up';
require_once('components/header.php');
?> 
<div class="login-container">  
<div class="form_container">
<h1>Welcome to Zillow</h1>
<div class="button_container">
<a href="index">Sign in</a>
<a class="active_link" href="signup">New account</a>

</div>
<form id="form_sign_up" onsubmit ="return false">
<label for="name">Name</label><br>
    <input name="name" type="text" placeholder="First name"><br>
    <label for="lastName">Last Name</label><br>
    <input name="lastName" type="text" placeholder="Last name"><br>
    <label for="email">Email</label><br>
    <input name="email" type="text" placeholder="Enter email"><br>
    <label for="phonenumber">Phonenumber</label><br>
    <input name="phonenumber" type="text" placeholder="Enter phonenumber"><br>
    <label for="password">Password</label><br>
    <input name="password" type="password" placeholder="Enter password"><br>
    <!-- <label for="repeat_password">Repeat Password</label><br>
    <input name="repeat_password" type="password" placeholder="Repeat password"><br> -->
    <div class="password_criteria">
        <p>At least 6 characters<br>No more than 20 characters</p>    
    </div>
    
    <p class="error"></p>
    <button class="signup_button" onclick="sign_up()">Sign up</button>
</form>
</div>
</div> 
<script>
    async function sign_up(){
    const form = event.target.form;
    console.log(form)
       let conn = await fetch("./api-signup", {
           method : "POST",
           body: new FormData(form)
       })
       let res = await conn.json()
       if (!conn.ok){
           document.querySelector(".error").textContent = res.info
       } else if (conn.ok){
        location.href = "user"
       }
       console.log(res)
    }
</script>

<?php

require_once('components/footer.php');
?>    
