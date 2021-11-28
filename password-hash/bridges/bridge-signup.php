<?php

//Never have html
//Never respond with any data
//Always and only take you somewhere else
//Validation
if(! isset($_POST['email']) ){
    
header ("Location: /signup.php");
exit();
    
}


// header ("Location: /signup-ok.php");
// exit();