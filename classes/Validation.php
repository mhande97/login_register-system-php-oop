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
                    $this->addError("$field is required");
                  endif;
                  if (!empty($value)):
                    switch ($rule) {

                    case 'min':
                        (strlen($value) < $rule_val) ? $this->addError("the $field must contain at least 5 character!"): "" ;
                        break;
                    case 'max':
                        (strlen($value) > $rule_val) ? $this->addError("the $field must not Exceeds 20 charactere!"): "" ;
                        break;

                    case 'match':
                           ($value != $source[$rule_val]) ? $this->addError("the $rule_val is not match !"): "" ;
                        break;
                    
                    case 'unique':
                           $check = $this->_db->Get('username','users','','WHERE username = ?','','','userID','',array($value));
                           if ($check->Count()):
                              $this->addError("this $field is already exists !");
                           endif;
                        break;
                    case 'validate':
                        (!filter_var($value,FILTER_VALIDATE_EMAIL)) ? $this->addError("this $field is not valid !") : "" ;
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
    public function addError($error)
    {
        $this->_errors[] = $error;
    }
    public function errors()
    {
        return $this->_errors;
    }

}