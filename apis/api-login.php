<?php
require_once(__DIR__.'/../globals.php');

// Validate email

//Checking if the email is passed
if ( ! isset($_POST['email']) ) {_res(400, ['info' => 'Email required']);
}

//Checking if the email entered is valid
if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ _res(400,['info' => 'Email is invalid' ]);
}

//Connecting to the db

try {
    $db = _db();
} catch(Exception $ex){
    _res(500, ['info'=>'system under maintenance', 'error'=>__LINE__]);

}

try{
$q = $db ->prepare('SELECT * FROM users WHERE user_email = :user_email');
$q->bindValue(':user_email', $_POST['email']);
$q->execute();
$row = $q -> fetch();
if (! $row){
    _res(400, ['info' => 'Wrong credentials', 'error' =>__LINE__]);
}

$password = $_POST['password'];
$hashed_password = $row['user_password'];

if (!password_verify($password, $hashed_password)){
    _res(400, ['info' => 'Wrong password', 'error' => __LINE__]);
}

 //Success
 session_start();
 $_SESSION['user_name'] = $row['user_name'];
 $_SESSION['user_email'] = $row['user_email'];
 $_SESSION['user_lastname'] = $row['user_lastname'];
 $_SESSION['user_phonenumber'] = $row['user_phonenumber'];
 //  $_SESSION['user_password'] = $row['user_password'];
 _res(200, ['info' => 'success login']);


}catch(Exception $ex) {
    _res(500, ['info' => 'System under maintenance','error' => __LINE__]);
}

