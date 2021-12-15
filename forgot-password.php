<?php
$_title = 'Forgot Password';
require_once(__DIR__.'/components/header.php');
?> 

        <h1>Welcome to Zillow</h1>
       <p>Enter your email and you will receive an email to reset your password.</p>
        <form id="form_forgot_password" onsubmit ="return false">
            <label for="email">Email</label><br>
            <input name="email" type="text" placeholder="Enter email"><br>
            <p class="error"></p>
            <button class="forgot_password_button" onclick="forgotPassword()">Send</button>
        </form>

    
<script>
    async function forgotPassword(){
    const form = event.target.form;
    console.log(form)
       let conn = await fetch("./apis/api-forgot-password", {
           method : "POST",
           body: new FormData(form)
       })
       let res = await conn.json()
       if (!conn.ok){
           document.querySelector(".error").textContent = res.info
       } else if (conn.ok){
        document.querySelector(".error").textContent = "An email has been sent";
       }
    //    console.log(res)
    }
</script>

<?php

require_once(__DIR__.'/components/footer.php');
?>    
