<?php
require "core/init.php";


if (Input::exists()):
    if (Token::check(Input::get('token'))):

       $rules = array(
           'username'=>array(
               'required'=>true,
               'type'=>'string'
           ),
           'password'=>array(
               'required'=>true,
               'type'=>'string',
           )
       );
       $validation = new Validation();
       if ($validation->check($_POST,$rules)->passed()):

           $user = new User();
          
        // $remember = (Input::get('remember') === 'on') ? true : false ;

           if ($user->login(Input::get('username'),Input::get('password'))):

            $username = escape(Input::get('username'));

             Session::flash('home',"welcom mr $username");
             Redirect::to("dash.php");

           else:
              echo 'failed';
           endif;
       else:
        $err = $validation->errors();
       endif;
    endif;
endif;


?>

<?php if (Session::exists('login')):?>
    <div class="alert alert-success"> <?php echo Session::flash('login')?> </div>
<?php endif;?>


<div class="container py-3">
    <form action="" method="post">

        <div class="mb-3">
            <label for="username" class="form-label">username</label>
            <input type="text" name="username" class="form-control" value="<?php echo Input::get('username') ?>" autocomplete="off">
            <?php if (isset($err['username'])) : ?> <div class="text-danger py-1"><?php echo $err['username'] ?></div> <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="password1" class="form-label">Enter Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo Input::get('password') ?>" autocomplete="off">
            <?php if (isset($err['password'])) : ?> <div class="text-danger py-1"><?php echo $err['password'] ?></div> <?php endif; ?>
        </div>

        <!-- <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="remember" value="on" id="remember">
          <label class="form-check-label" for="remember">
          Remember Me?
         </label>
       </div> -->


        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
        <div class="mb-3">
            <input type="submit" class="btn btn-success" value="Login" name="login">
        </div>

    </form>
</div>




<?php require_once "partition/footer.php";?>