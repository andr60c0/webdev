<?php

//TODO: Verify the key (must be 32 characters)
if (! isset($_GET['key']) ){
    echo "mmmm....suspicious (key is missing)";
    exit();
}
if( strlen($_GET['key']) != 32 ){
    echo "mmmm....suspicious (key is not 32 chars)";
    exit();
}

//TODO: Connect to DB
$data = json_decode(file_get_contents("data.json"), true);
// echo $json_data ->verification_key; //JSON
// echo $json_data["verification_key"];

//TODO: Update the verified variable to 1 if there is a match
if ($_GET["key"] != $data["verification_key"]){
    echo "mmmm....suspicious (keys don't match)";
    exit();
} 

$data["verified"] = 1; // update command
// UPDATE users SET verified = 1 where verified = 0 AND verified_key = "1222";

file_put_contents("data.json", json_encode($data));
//TODO: Say congrats to the user
echo "Congrats, you are verified";


 
?>