<?php

class DB {

            private static $_instance = NULL;

            private $_pdo,
            $_query,
            $_result,
            $_error = false,
            $_count = 0;


        private function __construct()
        {
            try {
                $this->_pdo = new PDO(
                                        "mysql:host=".Config::get('mysql/host').
                                        ";dbname=".Config::get('mysql/dbname'),
                                        Config::get('mysql/username'),
                                        Config::get('mysql/password')
                                        
                                        );
                $this->_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        }



        public static function getInstace()
        {
            if (!isset(self::$_instance)):
                self::$_instance = new DB();
            endif;

            return self::$_instance;
        }

        /**
         * public Query method v0.1
         * method that execute the Arrived Query
         * Accept Parameters
         * $sql = represent the query string to be executed
         * $params = array Holds values that will be bind with sql query
         */
        public function Query($sql,$params = array())
        {
            $this->_error = false;

           
            if ($this->_query = $this->_pdo->prepare($sql)):
                $x = 1;

                /** @in Case there is parameters to Set*/
                if (count($params)):

                    foreach ($params as $param):

                    $this->_query->bindValue($x,$param);
                    $x++;

                    endforeach;
                endif;


                if ($this->_query->execute()):

                    $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                    $this->_count = $this->_query->rowCount();

                else:
                    
                    $this->_error = true;
                endif;
            else:
                
            endif;
           
           return $this;

            
        }

        /**
         * public Get method v0.1
         * method that Form the Get Query
         * Accept Parameters
         * $colums = "*",
         * $table,
         * $join=NULL,
         * $where = NULL,
         * $and=NULL,
         * $or=NULL,
         * $ordFieled,
         * $ordering="ASC",
         * $params = array()
         */
        public function Get(
                            $selected_fieled = "*",
                            $table,
                            $join=NULL,
                            $where = NULL,
                            $and=NULL,
                            $or=NULL,
                            $ordFieled,
                            $ordering="ASC",
                            $params = array()
                            )
        {
         
            $sql = "SELECT $selected_fieled FROM $table $join $where $and $or ORDER BY $ordFieled $ordering";

          if (!$this->Query($sql,$params)->_error):
            return $this;
          endif;
          
        }
        
        public function first() {
            $data = $this->Result();
            return $data[0];
        }
    
        /**
         * Insert method v0.1
         * insert data on the database
         * accept paramerter
         * $table = the table to insert
         * $fields = an array hold fields_name as keys and value
         */
        public function Insert($table,$fields = array())
        {
            if (count($fields)):

                // forming the sql query string
                $keys = array_keys($fields);
                 
                $columns = "`" . implode("`,`",$keys) . "`";
                $Que_mark = "";
                  
                foreach ($fields as $item):
                    $Que_mark .= "?,";
                endforeach;
                $Que_mark = trim($Que_mark,",");
                
                
               $sql = "INSERT INTO $table($columns) VALUES ($Que_mark)";

               if (!$this->Query($sql,$fields)->_error):
                   return $this;
               endif;
           
               endif;
               return false;
        }
          /**
           * update method v0.1
           * update data on the database
           * Accept Parameters
           * $table = the table to update
           * $fields = an array hold fields_name as keys and value[update]
           * $where = row will be updated
           */
        public function Update($table,$fields,$where = array('itemID' => 0 ))
        {
            
            if (count($fields) && count($where)):
                

                // $keys = array_keys($fields);
                $where_key = array_keys($where)[0];
               

                $Set = "";
                foreach ($fields as $key => $value):
                    $Set .= $key . " = ? ," ;
                endforeach;
                $Set = trim($Set,",");
                 

                $sql = "UPDATE $table SET $Set WHERE $where_key = ?";

               
                 $fields = array_merge($fields,$where);
                 

                if (!$this->Query($sql,$fields)->_error):
                    return $this;
                endif;
               
            endif;

            return false;
        }

        /**
         * delete method v0.1
         * Accept Parameters
         * $table = the table to delete from
         * $condition = [where clasure]
         * $params = array Holds values that will be bind with sql query
         */
        public function Delete($table,$condition,$params = array(0))
        {
            $sql = "DELETE FROM $table WHERE $condition";
            
             if (!$this->Query($sql,$params)->_error):
                return $this;
             endif;
        }

        
         public function Result()
         {
             return $this->_result;
         }

         public function Count()
         {
            return $this->_count;
         }

         public function Error()
         {
            return $this->_error;
         }

}


