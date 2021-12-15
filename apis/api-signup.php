<?php
require_once(__DIR__.'/../globals.php');

// Validate name
if( ! isset( $_POST['name'] ) ){ _res(400,['info' => 'Name is required']);} 
if( strlen($_POST['name'] ) < _NAME_MIN_LEN ){ _res(400,['info' => 'Name min '._NAME_MIN_LEN.' character']);}  
if( strlen($_POST['name'] ) > _NAME_MAX_LEN ){ _res(400,['info' => 'Name max '._NAME_MAX_LEN.' character']);}  

//Validate last name
if( ! isset( $_POST['lastName'] ) ){ _res(400,['info' => 'Last name is required']); } 
if( strlen($_POST['lastName'] ) < _NAME_MIN_LEN ){ _res(400,['info' => 'Last name min 1 character']); } 
if( strlen($_POST['lastName'] ) > _NAME_MAX_LEN ){ _res(400,['info' => 'Last Name max 1 character']); } 

//Validate email
if (! isset($_POST['email']) ){ _res(400,['info' => 'Email is required']);}
if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){_res(400,['info' => 'Email is invalid']);}

// //Validate phonenumber
if( ! isset( $_POST['phonenumber'] ) ){ _res(400,['info' => 'Phonenumber is required']); } 
if(strlen($_POST['phonenumber']) != _PHONENUMBER_LEN ){_res(400,['info' => 'Phonenumber should be '._PHONENUMBER_LEN.' numbers']);}


//Validate password
if( ! isset( $_POST['password'] ) ){ _res(400,['info' => 'Password is required']); } 
if(strlen($_POST['password'])< _PASSWORD_MIN_LEN ){_res(400,['info' => 'Password should have at least '._PASSWORD_MIN_LEN.' characters']);}
if(strlen($_POST['password'])> _PASSWORD_MAX_LEN ){_res(400,['info' => 'Password should not have more than '._PASSWORD_MAX_LEN.' characters']);}

// Making sure password matches
if( ! isset($_POST['repeat_password'])){ _res(400, ['info' => 'Both password fields are required']); };
if( strlen($_POST['repeat_password']) < _PASSWORD_MIN_LEN ){ _res(400, ['info' => 'Password must be at least '._PASSWORD_MIN_LEN.' characters']); };
if( strlen($_POST['repeat_password']) > _PASSWORD_MAX_LEN ){ _res(400, ['info' => 'Password cannot be more than '._PASSWORD_MAX_LEN.' characters']); };
if($_POST['repeat_password'] !== $_POST['password']){ _res(400, ['info' => 'Passwords do not match']); };

//Connect to DB
try {
  $db = _db();
} catch(Exception $ex){
  _res(500, ['info' => 'System under maintenence', 'error' => __LINE__]);
}



try {
  //Checking if the email already exists
    $q2 = $db ->prepare('SELECT * FROM users WHERE user_email = :user_email');
    $q2 -> bindValue(":user_email", $_POST['email']);
    $q2 -> execute();
    $row = $q2 -> fetch();

    if ($row) {
       
      _res(400, ['info' => 'Email already exists']);
     
    }

    //Hashing password
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    //Verification
    $verification_key = bin2hex(random_bytes(16));
   
    //Insert data in the db
    $q = $db->prepare('INSERT INTO users VALUES(:user_id, :user_name, :user_lastname, :user_email,:user_phonenumber,:user_password, :verification_key, :verified)');
    $q -> bindValue(":user_id", null); //The db will give this automatically
    $q -> bindValue(":user_name", $_POST['name']);
    $q -> bindValue(":user_lastname", $_POST['lastName']);
    $q -> bindValue(":user_email", $_POST['email']);
    $q -> bindValue(":user_phonenumber", $_POST['phonenumber']);
    $q -> bindValue(":user_password", $password);
    $q -> bindValue(":verification_key", $verification_key);
    $q -> bindValue(":verified", 0);
    
    $q -> execute();
    $user_id = $db->lastinsertid();

    //Fetching the name to display on the user page when signup is successfull

    $q3 = $db->prepare('SELECT * FROM users WHERE user_name = :user_name');
    $q3 -> bindValue(":user_name", $_POST['name']);
    $q3 -> execute();
    $user_name = $q3 -> fetch();

    //Success    
    session_start();

    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $_POST['name'];
    $_SESSION['user_lastname'] = $_POST['lastName'];
    $_SESSION['user_email'] = $_POST['email'];
    $_SESSION['user_phonenumber'] = $_POST['phonenumber'];
    _res(200, ['info' => 'success signup']);

    $_message = "Thank you for signing up. <a href='http://localhost:8888/htdocs/verify-user.php?key=$verification_key&id=$user_id'>Click here to verify your account.</a>";
    $_to_email = $_POST['email'];
    require_once(__DIR__.'/../private/send_email.php');

} catch(Exception $ex){
    _res(500, ['info'=>'system under maintenance', 'error'=>__LINE__]);
}

