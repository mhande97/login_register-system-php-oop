<?php
session_start();

$GLOBALS['config'] = array(

    'mysql'=> array(
        'host'    =>'127.1.0.0',
        'username'=>'root',
        'password'=>'',
        'dbname'  =>'shop',
    )
    ,
    'remember'=> array(
        'cookie_name'  => 'hash',
        'cookie_expiry'=>604800,
    )
    ,
    'session'=>array(
        'session_name'=>'user',
        'token_name'  =>'token',
    )
) ;


spl_autoload_register(function($class){

    require "classes/". $class . ".php"; 
    
});

require "functions/Sanitize.php";

// if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))):
//   $hash = Cookie::get(Config::get('remember/cookie_name'));
//   $checkHash = DB::getInstace()->get('*','users_session','','WHERE hash = ? ','','','id','ASC',array($hash));
//   if ($checkHash->Count()):

//       $user = new User();
//   endif;
// endif;



require "partition/header.php";



