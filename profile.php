<?php
include "core/init.php";

if (!Session::exists(Config::get('session/session_name'))):
    Redirect::to('register.php');
endif;



$user = new User();






?>







<div class="cotainer">

    
    <h1 class="text-center">Profile</h1>
    <?php if ($user->isLoggedIn()):
           $data = $user->data();
    ?>
      <ul class="list-group">
          <li class="list-group-item">
            <?php echo $data->username ?>
          </li>
          <li class="list-group-item">
             <?php echo $data->email ?>
          </li>
          <li class="list-group-item">
             <?php echo $data->fullname ?>
          </li>
          <li class="list-group-item">
             <?php echo $data->registerdate ?>
          </li>
      </ul>
      <?php endif;?>
</div>






















<?php require_once "partition/footer.php";?>
