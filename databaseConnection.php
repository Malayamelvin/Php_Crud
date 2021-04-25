<?php
 
    DEFINE('servername','localhost');
    DEFINE('username','root');
    DEFINE('password', '');
    DEFINE('dbname','php_crud');  

    $conn = new mysqli(servername,username,password,dbname);

    if($conn->connect_error){
        die("connention error".$conn->connect_error);
    
    }
   

?>