<?php
require_once(__DIR__.'/../globals.php');
session_start();

try{
    $db = _db();
}catch(Exception $ex){
    _res(500, ['info'=>'System under maintenence', 'error'=> __LINE__]);
}
try{
    $q = $db->prepare('SELECT * FROM items WHERE item_id = :item_id');
    $q->bindValue(':item_id', $_POST['item_id']);
    $q->execute();
    $item = $q->fetch();

    $_SESSION['item_name'] = $item['item_name'];
    $_SESSION['item_description'] = $item['item_description'];
    $_SESSION['item_price'] = $item['item_price'];
    $_SESSION['item_image'] = $item['item_image'];


    //Success
    echo(json_encode($item));

}catch(Exception $ex){
    _res(500, ['info'=>'System under maintenence', 'error'=> __LINE__]);
}





