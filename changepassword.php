<?php

require "core/init.php";




// if (Session::exists('login')):
//      echo Session::flash('login');
// endif;

if (Input::exists()):
    if (Token::check(Input::get('token'))):

       $rules = array(
           'oldPass'=>array(
               'required' => true,
               'exist'    =>true,
               'type'     => 'string'
           ),
           'newPass'=>array(
               'required' => true,
               'min'      => 5,
               'max'      => 15,
               'type'     =>'string',
           ),
           'newPass2'=>array(
               'required'=> true,
               'match'   =>'newPass',
               'type'    =>'string',
        )
       );
       $validation = new Validation();
       if ($validation->check($_POST,$rules)->passed()):
        $user = new user();
        try {
            $user->update(array(
                'password'=>password_hash(Input::get('newPass'),PASSWORD_DEFAULT),
            ));
            Session::flash('home','your password is updated succesfully');
            Redirect::to('dash.php');
        } catch (Exception $e) {
            die($e->getMessage() . $e->getLine() . $e->getFile());
        }
           
       else:
        $err = $validation->errors();
       endif;
    endif;
endif;


?>




<div class="container py-3">
    <form action="" method="post">

        <div class="mb-3">
            <label for="password1" class="form-label">Old Password</label>
            <input type="password" name="oldPass" class="form-control" value="<?php echo Input::get('oldPass') ?>" autocomplete="off">
            <?php if (isset($err['oldPass'])) : ?> <div class="text-danger py-1"><?php echo $err['oldPass'] ?></div> <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="password1" class="form-label">New Password</label>
            <input type="password" name="newPass" class="form-control" value="<?php echo Input::get('newPass') ?>" autocomplete="off">
            <?php if (isset($err['newPass'])) : ?> <div class="text-danger py-1"><?php echo $err['newPass'] ?></div> <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="password1" class="form-label">Confirm new Password</label>
            <input type="password" name="newPass2" class="form-control" value="<?php echo Input::get('newPass2') ?>" autocomplete="off">
            <?php if (isset($err['newPass2'])) : ?> <div class="text-danger py-1"><?php echo $err['newPass2'] ?></div> <?php endif; ?>
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
        <div class="mb-3">
            <input type="submit" class="btn btn-success" value="change" name="changePass">
        </div>

    </form>
</div>




<?php require_once "partition/footer.php";?>