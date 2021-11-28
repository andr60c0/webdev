<?php

$name = "A";
$_to_email = "crazystupidemail.kea@gmail.com";
//this verification variable is the one we save in the database;
// $verification_key = bin2hex(random_bytes(16));
$verification_key = "12345678901234567890123456789012";
$_message = "Thank you for signing up. <a href='http://localhost:8888/verify-user/verify-user.php?key=$verification_key'>Click here to verify your account.</a>";

require_once(__DIR__."/private/send_email.php");