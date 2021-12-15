<?php
$_title = 'Reset Password';
require_once(__DIR__.'/components/header.php');
?> 

    <h1>Welcome to Zillow</h1>
    <p>Here you can reset your password.</p>
    <form id="form_forgot_password" onsubmit ="return false">
        <label for="password">New Password</label><br>
        <input name="password" type="password" placeholder="Enter password"><br>
        <label for="repeat_password">Confirm Password</label><br>
        <input name="repeat_password" type="password" placeholder="Confirm password"><br>
        <p class="error"></p>
        <p class="message"></p>
        <button class="reset_password_button" onclick="resetPassword()">Send</button>
    </form>


    <script>
        async function resetPassword(){
        const form = event.target.form;
        console.log(form)
        let conn = await fetch("./apis/api-reset-password", {
            method : "POST",
            body: new FormData(form)
        })
        let res = await conn.json()
        if (!conn.ok){
            document.querySelector(".error").textContent = res.info
        } else if (conn.ok){
            document.querySelector(".message").textContent = 'Your password has been reset!';
        }
        //    console.log(res)
        }
    </script>

<?php

require_once(__DIR__.'/components/footer.php');
?>    