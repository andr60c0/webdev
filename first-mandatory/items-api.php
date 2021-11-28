<?php
require_once('globals.php');

try {
    $db = _db();
}catch(Exception $ex){
    _res(500, ['info'=>'system under maintenance', 'error'=>__LINE__]);

}

try{
    $q = $db ->prepare('SELECT * FROM items');
    // $q->bindValue(':item_name', $_POST['item_name']);
    // $q->bindValue(':item_id', $_POST['item_id']);
    // $q->bindValue(':item_price', $_POST['item_price']);
    $q->execute();
    $items = $q -> fetchAll();
        
   //Success
    //  session_start();
    //  $_SESSION['user_name'] = $row['user_name'];
    // _res(200, ['info' => $row]);
    
    
    }catch(Exception $ex) {
        _res(500, ['info' => 'system under maintenance','error' => __LINE__]);
    }