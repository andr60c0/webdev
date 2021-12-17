<?php

require_once(__DIR__.'/globals.php');
require_once('components/header.php');

if( !isset($_GET['key'])){
    echo "<div class='center_container'>
            <p>mmmm....suspicious (key is missing)</p>
        </div>";
    exit();
}

if( strlen($_GET['key']) != 32 ){
    echo "<div class='center_container'>
            <p>mmmm....suspicious (key is not 32 chars)</p>
        </div>";
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
    echo "<div class='center_container'>
    <p>mmmm....suspicious (keys don't match)</p>
</div>";
    exit();
}

$q2 = $db->prepare('UPDATE users SET verified = :verified WHERE user_id = :user_id');
  $q2->bindValue(":verified", 1);
  $q2->bindValue(":user_id", $_GET['id']);
  $q2->execute();
  echo "<div class='center_container'>
            <p>Your email has been verified. <a href='user'>Back to home</a></p>
        </div>"  ;
require_once('components/footer.php');
?>

