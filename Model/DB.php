<?php
class DB{
    private static $_instance=null;
    private $_pdo,
            $_testMod=true,//for testing purpose, after set $_testMod=false
            $_query,
            $_count,
            $_error=false,
            $_results;
    
    
    private function __construct(){
        if($this->_testMod){
            try{
                $this->_pdo=new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'),array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
            // echo "jedan";
            }catch(Exception $e){
                die($e->getMessage());
            }
        }else{
            try{
                $this->_pdo=new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
            echo "dva";
            }catch(Exception $e){
                die($e->getMessage());
            }
        }
    }
    
    public function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance=new DB;
        }
        return self::$_instance;
    }
    
    public function query($sql,$params=array()){
        $this->_error=false;
        
        if($this->_query=$this->_pdo->prepare($sql)){
            if(count($params)){
                $x=1;
                foreach($params as $param){
                    $this->_query->bindValue($x,$param);
                    $x++;
                }
            }
            if($this->_query->execute()){
                $this->_results=$this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count=$this->_query->rowCount();
            }else{
                $this->_error=true;
            }
        }
        return $this;
    }
    
    private function action($action,$table,$where=array()){
        if(count($where===3)){
            $operators=array('=','>','<','>=','<=');
            
            $field=$where[0];
            $operator=$where[1];
            $value=$where[2];
            
            if(in_array($operator,$operators)){
                $sql="{$action} FROM {$table} WHERE {$field} {$operator} ?";
                
                if(!$this->query($sql,array($value))->error()){
                    return $this;
                }
        }
        return false;
    }
}
    
    public function get($table,$where){
        return $this->action("SELECT * ",$table,$where);
    }
    
    
    public function getAll($table){
        $sql="SELECT * FROM {$table}";
        return $this->query($sql);
    }
    
    public function getfields($table,$fields=array()){
        
        if(count($fields)){
            $value='';
            $x=1;
            foreach($fields as $field){
                $value.=$field;
                if($x<count($fields)){
                    $value.=' ,';
                }
                $x++;
            }
            $sql="SELECT {$value} FROM {$table}";
           // print_r($sql);
            if(!$this->query($sql,$fields)->error()){
                //echo "Uspesno";
                return $this->query($sql);
            }
        }
        return false;
    }
    
    public function insert($table,$fields=array()){
        if(count($fields)){
            $keys=array_keys($fields);
            $values='';
            $x=1;
            
            foreach($fields as $field){
                $values.=' ? ';
                if($x<count($fields)){
                    $values.=' ,';
                }
                $x++;
            }
            
            $sql="INSERT INTO {$table} (`".implode('`, `',$keys)."`)VALUES({$values})";
            
            if(!$this->query($sql,$fields)->error()){
                //echo "Uspesno";
                return true;
            }
            
        }
        echo $values;
        print_r ($keys);
       return false; 
    }
    
    public function update($table,$id,$fields){
        $set='';
        $x=1;
        
        foreach($fields as $name=>$value){
            $set.="{$name} = ?";
            if($x<count($fields)){
                $set.=', ';
            }
            $x++;
        }
        $sql="UPDATE {$table} SET {$set} WHERE id={$id}";
        if(!$this->query($sql,$fields)->error()){
            return true;
        }
        return false;
    }
    
    public function delete($table,$where){
        return $this->action('DELETE',$table,$where);
    }
    
    
    public function error(){
        return $this->_error;
    }
    
    public function results(){
        return $this->_results;
    }
    
    public function first(){
        return $this->results();
    }
    
    public function count(){
        return $this->_count;
    }
    
    

/**
 * multidimensional_array_rand()
 * 
 * @param array $array
 * @param integer $limit
 * @return array
 */
public function multidimensional_array_rand( $array, $limit = 2 ) {
    
    uksort( $array, 'callback_rand' );

  return array_slice( $array, 0, $limit, true ); 
}

/**
 * callback_rand()
 * 
 * @return bool
 */
/*public function callback_rand() { 
  
  return rand() > rand();

}*/
    
    
    
    
    
    
    
}

?>