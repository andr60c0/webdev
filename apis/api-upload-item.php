<?php
require_once(__DIR__.'/../globals.php');

//Validation

//Validate Item name
if( !isset($_POST['item_name'])){ http_response_code(400); echo 'Item name is required'; exit(); }
if(strlen($_POST['item_name']) < _ITEM_NAME_MIN_LEN){ http_response_code(400); echo 'Item name should be minimum '._NAME_MIN_LEN.' characters'; exit(); }
if(strlen($_POST['item_name']) > _ITEM_NAME_MAX_LEN){ http_response_code(400); echo 'Item name should be maximum '._NAME_MAX_LEN.' characters'; exit(); }

//Validate Item description
if( !isset($_POST['item_description'])){ http_response_code(400); echo 'Item description is required'; exit(); }
if( strlen($_POST['item_description']) < _DESC_MIN_LEN){ http_response_code(400); echo 'Item description should be minimum '._DESC_MIN_LEN.' characters'; exit();}
if( strlen($_POST['item_description']) > _DESC_MAX_LEN){ http_response_code(400); echo 'Item description should be maximum '._DESC_MAX_LEN.' characters'; exit();}

//Validate Item price
if( !isset($_POST['item_price'])){ http_response_code(400); echo 'Item price is required'; exit(); }
if( strlen($_POST['item_price']) < _PRICE_MIN_LEN){ http_response_code(400); echo 'Item price should be minimum '._PRICE_MIN_LEN.' characters'; exit();}
if( strlen($_POST['item_price']) > _PRICE_MAX_LEN){ http_response_code(400); echo 'Item price should be maximum '._PRICE_MAX_LEN.' characters'; exit();}

//Validate Item image
if( !isset($_POST['item_image'])){ http_response_code(400); echo 'Item image link is required'; exit(); }
if( strlen($_POST['item_image']) < _IMAGE_MIN_LEN){http_response_code(400); echo 'Item image link should be minimum '._IMAGE_MIN_LEN.' characters'; exit();}
if( strlen($_POST['item_image']) > _IMAGE_MAX_LEN){ http_response_code(400); echo 'Item image link should be maximum '._IMAGE_MAX_LEN.' characters'; exit();}

try{
    $db = _db();
}catch(Exception $ex){
    _res(500, ['info'=>'System under maintenence', 'error'=> __LINE__]);
}
try{
    
    $item_id = bin2hex(random_bytes(16));
    $q = $db->prepare('INSERT INTO items VALUES(:item_id, :item_name, :item_description, :item_price, :item_image)');
    $q->bindValue(':item_id', $item_id);
    $q->bindValue(':item_name', $_POST['item_name']);
    $q->bindValue(':item_description', $_POST['item_description']);
    $q->bindValue(':item_price', $_POST['item_price']);
    $q->bindValue(':item_image', $_POST['item_image']);
    $q->execute();
    echo $item_id;

}catch(Exception $ex){
    http_response_code(500);
    echo 'System under maintainance';
    exit();
  }
  