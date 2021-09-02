<?php


class User{

     private $_db = null ,
             $_data = null,
             $_sessionName, 
             $_cookieName;
      public $isLoggedIn;

    



     public function __construct($user = null)
     {
        $this->_db = DB::getInstace();
        $this->_sessionName = Config::get('session/session_name');
      //   $this->_cookieName = Config::get('remember/cookie_name');
  
      if (!$user):

         if (Session::exists($this->_sessionName)):
            $user = Session::get($this->_sessionName);
            $this->isLoggedIn = ($this->find($user))? true : false;
         endif;
      else:
           $this->isLoggedIn = ($this->find($user))? true : false;
      endif;
     }


    public function Create($fields = array())
    {
       if (!$this->_db->Insert('users',$fields)):
        throw new Exception('there is a problem in creating your account !');
       endif;
    }

    public function find($user)
    {
      $field = (is_numeric($user)) ? 'userID' : 'username';

     
       $get = $this->_db->Get(array(
            'columns'=>'*',
            'table'=>'users',
            'join'=>'',
            'where'=>"WHERE {$field} = ? ",
            'and'=>'',
            'or'=>'',
            'orderfield'=>'userID',
            'ordering'=>'ASC',
        ),array($user)); 
      
      
   
      if ($get->Count()):
         $this->_data = $get->first();
         return true;
      else:
         return false;
      endif;
    }
    public function login($username = null,$password = null,$remember = false)
    {
          $user = $this->find($username);

             if ($user):
               $verify = password_verify($password,$this->data()->password);
               if ($verify):
                  
                  Session::put($this->_sessionName,$this->data()->userID);

               //   if ($remember):
               //     $hash = Hash::unique();
               //     $checkHash = $this->_db->get('*','users_session','','WHERE user_id = ?','','','id','ASC',array($this->data()->userID)); 

               //     if (!$checkHash->Count()):
               //        $this->_db->Insert('users_session',array(
               //           'user_id'=>$this->data()->userID,
               //           'hash'=>$hash,
               //        ));
               //     else:
               //       $hash = $checkHash->first()->hash;
               //     endif;
               //    //  Cookie::put($this->_cookieName,$hash,Config::get('remember/cookie_expiry'));
               //   endif;

                  return true;

               endif;
             
             endif;
             
          return false;
    }
    public function update($field = array(),$id = null)
    {
       $id = $this->data()->userID;
      
       if (!$this->_db->update('users',$field,array('userID'=>$id))):
         throw new Exception('there is a problem in updating !');
       endif;
    }



    public function Logout()
    {

      // $this->_db->delete('users_session','user_id = ?',array(Session::get($this->_sessionName)));
      Session::delete($this->_sessionName);
      // Cookie::delete($this->_cookieName);

    }
    public function data()
    {
       return $this->_data;
    }

    public function isLoggedIn()
    {
       return $this->isLoggedIn;
    }















}