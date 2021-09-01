<?php
require_once "core/init.php";


if (Input::exists()) : 
   
  if (Token::check(Input::get('token'))) ://if the user hit submit btn
        $rules = array(
                'username'=> array(
                'required' => true,
                'min'      => 5,
                'max'      => 15,
                'unique'   => 'users',
                'type'     => 'string',
            ),
            'password'=> array(
                'required' => true,
                'min'      => 5,
                'max'      => 15,
                'type'     => 'string',

            ),
            'password2'=> array(
                'required' => true,
                'match'    => 'password',
                'type'     => 'string',

            ),
            'email'=> array(
                'required' => true,
                'type'     => 'email',
                'validate' => true,
            ),
        );

        $validation = new Validation();
        //if the validation check is passsed
        if ($validation->check($_POST, $rules)->passed()) :

            
            $user_data = array(
                'username' => Input::get('username'),
                'password' => password_hash(Input::get('password'),PASSWORD_DEFAULT),
                'email'    => Input::get('email'),
            );

            $user = new User();
            try {
               
                $user->Create($user_data);

                // Session::flash('login', 'You registred succesfully !');
                Redirect::to("login.php");
               

            } catch (Exception $e) {
                die($e->getMessage() . $e->getLine() . $e->getFile());
            }
           

        else :
            $err = $validation->errors();
        endif;


    endif;
//   else:
//     echo "set the method";
endif;
?>











<div class="container py-3">
    <div class="text-center py-3">
         <a href="login.php" class="btn text-info">Login</a>
    </div>
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

        <div class="mb-3">
            <label for="password2" class="form-label">Enter Password Again</label>
            <input type="password" name="password2" class="form-control" value="<?php echo Input::get('password2') ?>" autocomplete="off">
            <?php if (isset($err['password2'])) : ?> <div class="text-danger py-1"><?php echo $err['password2'] ?></div> <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo Input::get('email') ?>" autocomplete="off">
            <?php if (isset($err['email'])) : ?> <div class="text-danger py-1"><?php echo $err['email'] ?></div> <?php endif; ?>
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
        
        <div class="mb-3">
            <input type="submit" class="btn btn-success" value="Register" name="register">
        </div>

    </form>
</div>
















<?php require_once "partition/footer.php"; ?>