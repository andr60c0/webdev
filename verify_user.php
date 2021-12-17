<?php

require_once(__DIR__.'/globals.php');

if( !isset($_GET['key'])){
    echo "mmmm....suspicious (key is missing)";
    exit();
}

if( strlen($_GET['key']) != 32 ){
    echo "mmmm....suspicious (key is not 32 chars)";
    exit();
}

try{
    $db = _db();

}catch(Exception $ex){
    _res(500, ['info'=>'System under maintenence', 'error'=> __LINE__]);
}

$q = $db->prepare('SELECT * FROM users WHERE user_id = :user_id');
  $q->bindValue(":user_id", $_GET['id']);
  $q->execute();
  $row = $q->fetch();

// Updating the verified variable to 1 only if there is a match

if( $_GET['key'] != $row['verification_key']){
    echo "mmmm....suspicious (keys don't match)";
    exit();
}

$q2 = $db->prepare('UPDATE users SET verified = :verified WHERE user_id = :user_id');
  $q2->bindValue(":verified", 1);
  $q2->bindValue(":user_id", $_GET['id']);
  $q2->execute();
  echo "Your email has been verified. <a href='user'>Back to home</a>"  ;

?>