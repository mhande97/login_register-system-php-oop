<?php
  require_once "core/init.php";


  if (Input::exists()):
    $rules = array(
        'username'=> array(
            'required'=> true,
            'min'=> 5,
            'max'=>15,
            'unique'=>'users',
            'type'=>'string',
        ),
        'password'=> array(
         'required'=> true,
         'min'=> 5,
         'max'=>15,
         'type'=>'string',

        ),
        'password2'=> array(
         'required'=> true,
         'match'=> 'password',
         'type'=>'string',

        ),
        'email'=> array(
         'required'=> true,
         'type'=>'email',
         'validate'=>true,
        ),
    );


  $validation = new Validation();
 //if the validation check is not passsed
  if(!$validation->check($_POST,$rules)->passed()):

     foreach ($validation->errors() as $err):
         echo $err . "<br>";
     endforeach;

  endif;
     
  else:
        echo "set the method";
  endif;


?>











<div class="container py-3">
<form action="" method="post">

<div class="mb-3">
<label for="username" class="form-label">username</label>
<input type="text" name="username" class="form-control" value="<?php echo Input::get('username')?>" autocomplete="off">
</div>
<div class="mb-3">
<label for="password1" class="form-label">Enter Password</label>
<input type="password" name="password" class="form-control" value="<?php echo Input::get('password')?>" autocomplete="off">
</div>
<div class="mb-3">
<label for="password2" class="form-label">Enter Password Again</label>
<input type="password" name="password2" class="form-control" value="<?php echo Input::get('password2')?>" autocomplete="off">
</div>
<div class="mb-3">
<label for="email" class="form-label">Email</label>
<input type="email" name="email" class="form-control" value="<?php echo Input::get('email')?>" autocomplete="off">
</div>
<div class="mb-3">
    <input type="submit" class="btn btn-success" value="Register" name="register">
</div>

</form>
</div>
















<?php require_once "partition/footer.php";?>