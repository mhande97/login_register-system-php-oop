<?php
require "core/init.php";

// if (Session::exists('home')):
//      echo Session::flash('home') . "<br>";
// endif;

if (!Session::exists(Config::get('session/session_name'))):
     Redirect::to('register.php');  
endif;



?>
<a href="changepassword.php">Change Password</a>
<a href="logout.php">logout</a>








<?php require_once "partition/footer.php";?>