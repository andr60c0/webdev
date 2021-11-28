<?php
require_once('globals.php');
session_start();

//Validation

// Validate name
if( ! isset( $_POST['update_username'] ) ){ _res(400,['info' => 'Name is required']);} 
if( strlen($_POST['update_username'] ) < _NAME_MIN_LEN ){ _res(400,['info' => 'Name min '._NAME_MIN_LEN.' character']);}  
if( strlen($_POST['update_username'] ) > _NAME_MAX_LEN ){ _res(400,['info' => 'Name max '._NAME_MAX_LEN.' character']);}  

//Validate last name
if( ! isset( $_POST['update_user_lastName'] ) ){ _res(400,['info' => 'Last name is required']); } 
if( strlen($_POST['update_user_lastName'] ) < _NAME_MIN_LEN ){ _res(400,['info' => 'Last name min '._NAME_MIN_LEN.' character']); } 
if( strlen($_POST['update_user_lastName'] ) > _NAME_MAX_LEN ){ _res(400,['info' => 'Last name max '._NAME_MAX_LEN.' character']); } 

//Validate email
if (! isset($_POST['update_user_email']) ){ _res(400,['info' => 'Email is required']);}
if(! filter_var($_POST['update_user_email'], FILTER_VALIDATE_EMAIL) ){_res(400,['info' => 'Email is invalid']);}        

//Validate password
if( ! isset( $_POST['update_user_password'] ) ){ _res(400,['info' => 'Password is required']); } 
if(strlen($_POST['update_user_password'])< _PASSWORD_MIN_LEN ){_res(400,['info' => 'Password should have at least '._PASSWORD_MIN_LEN.' characters']);}
if(strlen($_POST['update_user_password'])> _PASSWORD_MAX_LEN ){_res(400,['info' => 'Password should not have more than '._PASSWORD_MAX_LEN.' characters']);}

//Validate phonenumber
if( ! isset( $_POST['phonenumber'] ) ){ _res(400,['info' => 'Phonenumber is required']); } 
if(strlen($_POST['phonenumber']) != _PHONENUMBER_LEN ){_res(400,['info' => 'Phonenumber should be '._PHONENUMBER_LEN.' numbers']);}


try {
    $db = _db();
}catch(Exception $ex){
    _res(500, ['info'=>'system under maintenance', 'error'=>__LINE__]);

}

try {
         
    $sessionEmail = $_SESSION['user_email'];
    $newUsername = $_POST['update_username'];
    $newUserLastName = $_POST['update_user_lastName'];
    $newUserEmail = $_POST['update_user_email'];
    $newPassword = $_POST['update_user_password'];
    $newPhonenumber = $_POST['update_user_phonenumber'];

   
    $q = $db->prepare("UPDATE users SET user_name = :newUsername, user_lastname = :newLastName, user_email = :newEmail, user_password = :newPassword, user_phonenumber = :newPhonenumber WHERE user_email = '$sessionEmail'");
    $q -> bindValue(":newUsername", $newUsername);
    $q -> bindValue(":newLastName", $newUserLastName);
    $q -> bindValue(":newEmail", $newUserEmail);
    $q -> bindValue(":newPassword", $newPassword);
    $q -> bindValue(":newPhonenumber", $newPhonenumber);

    $q -> execute();
    $row = $q -> fetch();
    // echo $newUsername;

    //Updating the session
    $_SESSION['user_name'] = $_POST['update_username'];
    $_SESSION['user_lastname'] = $_POST['update_user_lastName'];
    $_SESSION['user_email'] = $_POST['update_user_email'];
    $_SESSION['user_password'] = $_POST['update_user_password'];
    $_SESSION['user_phonenumber'] = $_POST['update_user_phonenumber'];
    _res(200, ['info' => 'user updated']);

} catch(Exception $ex){
    _res(500, ['info'=>'system under maintenance', 'error'=>__LINE__]);
}