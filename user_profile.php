<?php
$_title = 'User Profile';
session_start();

require_once(__DIR__.'/components/header.php');

?>

<nav class="nav">
    <div></div>
    <div class="nav_logo">
      <img src="assets/logo.svg" alt="logo">
    </div>
    <div class="menulinks">
      <a href="user">Home</a>
      <a class="active_link" href="user_profile">Profile</a>
      <a href="logout">Logout</a>
    </div>
  </nav>
  <div class="user_profile user-container">
    <div class="form_container">
      <h3 class="header">Update user information</h3>

      <form id="update_user_form" onsubmit ="return false">
        <label for="update_username">First Name</label><br>
        <input type="text" name="update_username" value="<?= $_SESSION['user_name']?> "><br>
        <label for="update_user_lastName">Last Name</label><br>
        <input type="text" name="update_user_lastName" value="<?= $_SESSION['user_lastname']?> "><br>
        <label for="update_user_email">Email</label><br>
        <input type="text" name="update_user_email" value="<?= $_SESSION['user_email']?> "><br>
        <label for="update_user_phonenumber">Phonenumber</label><br>
        <input type="text" name="update_user_phonenumber" value="<?= $_SESSION['user_phonenumber']?> "><br>
        <p class="user_info_error"></p>
        <button class="update_button" onclick="updateUser()">Update user info</button>
      </form>

      <h3 class="header">Change Password</h3>
      <form id="form_change_password" onsubmit ="return false">
        <label for="password">New Password</label>
        <input name="password" type="password" placeholder="Enter password"><br>
        <label for="repeat_password">Confirm Password</label>
        <input name="repeat_password" type="password" placeholder="Confirm password"><br>
        <p class="update_password_error"></p>
        <button class="reset_password_button" onclick="updatePassword()">Update Password</button>
      </form>
    </div>
  </div>
  <script> 
   async function updateUser(){
      const form = document.querySelector("#update_user_form");
      console.log(form);
      let conn = await fetch("./apis/api-update-user", {
        method: "POST",
        body: new FormData(form)
      })

      let res = await conn.json()
      // console.log(res)
      // if( conn.ok ){ location.href = "user" }
      if (!conn.ok){
        console.log("conn not okay");
        document.querySelector(".user_info_error").textContent = res.info
      } else if (conn.ok){
        console.log("conn ok");
        document.querySelector(".user_info_error").textContent = "User info updated!";
      }
        // if( conn.ok ){ location.href = "user" }
        
    }
    async function updatePassword(){
      const form = event.target.form;
      console.log(form)
      let conn = await fetch("./apis/api-update-password", {
            method : "POST",
            body: new FormData(form)
      })
      let res = await conn.json()
      if (!conn.ok){
        document.querySelector(".update_password_error").textContent = res.info
      } else if (conn.ok){
        document.querySelector(".update_password_error").textContent = 'Your password has been updated!';
      }
    }
</script>
  <?php

require_once(__DIR__.'/components/footer.php');
?>   