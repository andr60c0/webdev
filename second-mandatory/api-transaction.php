<?php
require_once('globals.php');
//Validate
if( ! isset( $_POST['from_name'] ) ){ _res(400,['info' => 'From name is required']);};
if( ! isset( $_POST['to_name'] ) ){ _res(400,['info' => 'To name is required']);} 
if( ! isset( $_POST['transfer_amount'] ) ){ _res(400,['info' => 'Transfer amount is required']);} 



try {
    $db = _db();
}catch(Exception $ex){
    _res(500, ['info'=>'system under maintenance', 'error'=>__LINE__]);

}
$db->beginTransaction();

try{

    //Begin transaction if two ur more update/delete/insert
     //$q = $db -> prepare....
    //bind value
    //$q -> execute()

    $qFrom = $db->prepare('SELECT * FROM customer WHERE name = :name');
    $qFrom->bindValue(":name", $_POST['from_name']);
    $qFrom->execute();
    $rowFrom = $qFrom -> fetch();
    $balanceFrom = $rowFrom['account_balance']; 
    // echo($balance);
    $newBalanceFrom = $balanceFrom - $_POST['transfer_amount'];
    // echo($newBalance);
   
    $qUpdateFromBalance = $db->prepare('UPDATE customer SET account_balance = :new_balance WHERE name = :name');
    $qUpdateFromBalance->bindValue(":name", $_POST['from_name']);
    $qUpdateFromBalance->bindValue(":new_balance",$newBalanceFrom);
    $qUpdateFromBalance->execute();
    $updatedFromBalance =  $qUpdateFromBalance -> fetch();
    // echo($row); 
    if (! $rowFrom){
        _res(500, ['info'=>'From user does not exist', 'error'=>__LINE__]);
        $db -> rollBack();
        exit;
    }

    $qTo = $db->prepare('SELECT * FROM customer WHERE name = :name');
    $qTo->bindValue(":name", $_POST['to_name']);
    $qTo->execute();
    $rowTo = $qTo -> fetch();
    $balanceTo = $rowTo['account_balance']; 
    // echo($balance);
    $newBalanceTo = $balanceTo + $_POST['transfer_amount'];

    $qUpdateToBalance = $db->prepare('UPDATE customer SET account_balance = :new_balance WHERE name = :name');
    $qUpdateToBalance->bindValue(":name", $_POST['to_name']);
    $qUpdateToBalance->bindValue(":new_balance",$newBalanceTo);
    $qUpdateToBalance->execute();
    $updatedToBalance =  $qUpdateToBalance -> fetch();
    // echo($row); 
    if (! $rowTo){
        _res(500, ['info'=>'To user does not exist', 'error'=>__LINE__]);
        $db -> rollBack();
        exit;
    }

    $db -> commit();

} catch(Exception $ex){
    _res(500, ['info'=>'system under maintenance', 'error'=>__LINE__]);

    //If something goes wrong - you must always rollback. You can also rollback in try{}
    //Remember to exit after rollback if you do. Example above
    $db -> rollBack();
    exit;

}