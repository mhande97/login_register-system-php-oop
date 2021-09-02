<?php
require "core/init.php";?>

<?php if (Session::exists('home')):?>
   <div class="container"> <div class="alert alert-success"> <?php echo Session::flash('home')?> </div></div>
<?php endif;?>

<?php if (!Session::exists(Config::get('session/session_name'))):?>
     Redirect::to('register.php');  
<?php endif;?>



<a href="changepassword.php">Change Password</a>
<a href="logout.php">logout</a>
<a href="profile.php">edite Profile</a>







<?php require_once "partition/footer.php";?>