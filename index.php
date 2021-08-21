<?php
require "core/init.php";
















$DB = DB::getInstace();



/**
 * Get(selcted_fieled,table,join,where,and,or,ordfieled,ordering,params = array())
 */
// $result = $DB->Get("*","users","","WHERE username = ?","","OR username = ? ","userID","",
//                   $params = array('ossama','mhande')
//                   );

/**
 * Delete(table,condition,params = array())
 */

$Obj = $DB->Delete("users","userID = ?",array(37));

if ($Obj->Error()):
    echo "no user";
else:
    echo "OK!";
endif;

$res = $Obj->Result();

var_dump($res);
