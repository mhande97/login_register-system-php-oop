<?php
session_start();

$GLOBALS['config'] = array(

    'mysql'=> array(
        'host'=>'127.1.0.0',
        'username'=>'root',
        'password'=>'',
        'dbname'=>'shop',
    )
    ,
    'remember'=> array(
        'cookie_name'=> 'hash',
        'cookie_expiry'=>604800,
    )
    ,
    'session'=>array(
        'session_name'=>'user',
    )
) ;


spl_autoload_register(function($class){

    require "classes/". $class . ".php"; 
    
});

require "functions/Sanitize.php";
require "partition/header.php";



