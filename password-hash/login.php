<?php

// the user logs in via form with email and password

$password = $_POST['password'];
// pretend we connect to the db and get the password of a user, based on the email
// SELECT user_password FROM users WHERE user_email = :email
$hashed_password = '$2y$10$x7iAZdk8kgbGzXS4meN0ZOKrFj2kEP9SmkXbtG1IO2lmTo8ryoBua';
if (password_verify($password, $hashed_password)){
    echo 'Match';
} else {
    echo 'Wrong password';
}