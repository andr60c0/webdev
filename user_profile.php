<?php
$_title = 'User Profile';
session_start();
// if(!isset($_SESSION['user_name'])){
//   header('Location: index');
//   exit();
// }

require_once(__DIR__.'/components/header.php');

?>

  <nav class="user_nav">
      <a href="user">Profile</a>
      <a href="items">Items</a>
      <a class="active_link" href="user_profile">User Profile</a>
      <a href="logout">Logout</a>
  </nav><br>
  <div class="user-container">
  <div class="form_container">
  <h1>User profile</h1>

  <form id="update_user_form" onsubmit ="return false">
  
  <label for="update_username">First Name: </label>
  <input type="text" name="update_username" value="<?= $_SESSION['user_name']?> "><br>
  <label for="update_user_lastName">Last Name: </label>
  <input type="text" name="update_user_lastName" value="<?= $_SESSION['user_lastname']?> "><br>
  <label for="update_user_email">Email: </label>
  <input type="text" name="update_user_email" value="<?= $_SESSION['user_email']?> "><br>
  <label for="update_user_phonenumber">Phonenumber: </label>
  <input type="text" name="update_user_phonenumber" value="<?= $_SESSION['user_phonenumber']?> "><br>
  <label for="update_user_password">Password: </label>
  <input type="password" name="update_user_password" value="<?= $_SESSION['user_password']?> "><br>
  <p class="error"></p>
  <button class="update_button" onclick="update_user()">Update</button>
</form>
 
  </div>
  </div>
  <script>
   async function update_user(){
      const form = event.target.form
      console.log(form)
      let conn = await fetch("./apis/api-update-user.php", {
        method: "POST",
        body: new FormData(form)
      })

      let res = await conn.json()
      // console.log(res)
      // if( conn.ok ){ location.href = "user" }
      if (!conn.ok){
        console.log("conn not okay");
           document.querySelector(".error").textContent = res.info
       } else if (conn.ok){
         console.log("conn ok");
         document.querySelector(".error").textContent = "User updated!";
       }
        // if( conn.ok ){ location.href = "user" }
        
    }
</script>
  <?php

require_once(__DIR__.'/components/footer.php');
?>   