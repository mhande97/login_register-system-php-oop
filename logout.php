<?php
require "core/init.php";


$user = new User();
$user->Logout();
Redirect::to('login.php');
exit();