<?php
$_title = 'Home';
session_start();
if(!isset($_SESSION['user_name'])){
  header('Location: index');
  exit();
}
require_once('components/header.php');
?>

  <nav class="user_nav">
  <a class="active_link" href="user">Profile</a>
    <a href="items">Items</a>
    <a href="user_profile">User Profile</a>
    <a href="logout">Logout</a>
  </nav><br>
  <div class="user-container">
  <h1>Welcome</h1>
  <h1>
  
    <?php
    echo $_SESSION['user_name'];
    ?>
   
  </h1>
  </div>
  <?php

require_once('components/footer.php');
?>   