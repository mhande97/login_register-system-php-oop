<?php
require "core/init.php";

/**
 * Get(selcted_fieled,table,join,where,and,or,ordfieled,ordering,params = array())
 */
// $result = $DB->Get("*","users","","WHERE username = ?","","OR username = ? ","userID","",
//                   $params = array('ossama','mhande')
//                   );

/**
 * Delete(table,condition,params = array())
 */

// $username = "ossama";




// if (!$DB->Get('username','users','','WHERE username = ? ','','','userID','',array($username))->Count()):
// $DB->Insert('users',array(
    
//     'username'=> $username,
//     'password'=>password_hash( "mahmodfadi97",PASSWORD_DEFAULT),
//     'email'=>"aass@gmail.com",
//     'fullname'=> "mahmod fadi",
//     'memberImg'=> ""

// ));
// else:
//     echo "the user is already exist";
// endif;


$DB = DB::getInstace();
 $res = $DB->Update('items',array(
         
       
       'description'=> 'shoes made by nike original',
       'price'=> '$140',
       'country_made'=> 'USA',
       'status'=> 'like new',
       'cat_id'=> 18,
       'member_id'=> 48,
       'tags'=> 'shoes_nike_airmax',
       
 ),array('itemID'=>37));

if ($res->Count()):
    echo 'the data is updated';
endif;










