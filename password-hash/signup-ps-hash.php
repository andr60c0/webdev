<?php

// Signup
// this should come from a form/POST/

$password = $_POST['password'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
echo $password;

