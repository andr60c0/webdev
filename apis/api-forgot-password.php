<?php

require_once(__DIR__.'/../globals.php');
session_start();


//Validate email
if (! isset($_POST['email']) ){ _res(400,['info' => 'Email is required']);}
if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){_res(400,['info' => 'Email is invalid']);}

// Connect to DB
try{
    $db = _db();
  
  }catch(Exception $ex){
    _res(500, ['info' => 'System under maintenence', 'error' => __LINE__]);
  }

  try{
 
    //Checking if the email exists in the database
    $q2 = $db ->prepare('SELECT * FROM users WHERE user_email = :user_email');
    $q2 -> bindValue(":user_email", $_POST['email']);
    $q2 -> execute();
    $row = $q2 -> fetch();
    $user_id = $row['user_id'];

    if (!$row) {
       
      _res(400, ['info' => 'Email does not exist in our system']);
     
    }

    // SUCCESS
    header('Content-Type: application/json');
    session_start();
    $response = ["info" => "Email has been sent"];
    // echo json_encode($response);
    $_SESSION['user_id'] = $user_id;
    
    $_message = "<a href='http://localhost:8888/reset-password.php?id=$user_id'>Click here to reset your password.</a>";
    $_to_email = $_POST['email'];
    require_once(__DIR__.'/../private/send_email.php');

    
  }catch(Exception $ex){
    http_response_code(500);
    echo 'System under maintainance';
    exit();
  }