<?php



class Validation 
{
   private $_passed = false,$_errors = array(),$_db = null;

    public function __construct()
    {
        $this->_db = DB::getInstace();
    }

    public function check($source,$fields = array())
    {
        
            foreach ($fields as $field => $rules):

               
                $value = escape($source[$field],$rules['type']);
               
               foreach ($rules as $rule => $rule_val):

                  if ($rule === "required" && empty($value)):
                    $this->addError("$field is required",$field);
                  endif;
                  if (!empty($value)):
                    switch ($rule) {
                    case 'exist':
                        $check = $this->_db->Get('password','users','','WHERE userID = ?','','','userID','',array(Session::get(Config::get('session/session_name'))));
                           if ($check->Count()):
                            $pass = $check->first()->password;
                            (!password_verify($value,$pass))? $this->addError("the $field is wrong!",$field): "" ;
                           endif;
                        break;
                        
                    case 'min':
                        (strlen($value) < $rule_val) ? $this->addError("the $field must contain at least $rule_val character!",$field): "" ;
                        break;

                    case 'max':
                        (strlen($value) > $rule_val) ? $this->addError("the $field must not Exceeds $rule_val charactere!",$field): "" ;
                        break;

                    case 'match':
                           ($value != $source[$rule_val]) ? $this->addError("the $rule_val is not match !",$field): "" ;
                        break;
                    
                    case 'unique':
                           $check = $this->_db->Get('username','users','','WHERE username = ?','','','userID','',array($value));
                           ($check->Count())?$this->addError("this $field is already exists !",$field) : "";               
                        break;
                    case 'validate':
                        (!filter_var($value,FILTER_VALIDATE_EMAIL)) ? $this->addError("this $field is not valid !",$field) : "" ;
                        break;
                    default:
                       
                        break;
                       }
                  endif;    

               endforeach;
            endforeach;

            if (empty($this->errors())):
                $this->_passed = true;
            endif;
           
            return $this;
    }

    public function passed()
    {
        return $this->_passed;
    }
    public function addError($error,$field)
    {
        $this->_errors[$field] = $error;
    }
    public function errors()
    {
        return $this->_errors;
    }

}