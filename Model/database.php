<?php
/*//require_once('config.php');

//defined constants for connection
defined("DB_SERVER") ? null:define("DB_SERVER","localhost");
defined("DB_USER")   ? null:define("DB_USER","root");
defined("DB_PASS")   ? null:define("DB_PASS","");
defined("DM_NAME")   ? null:define("DB_NAME","kolaci");
//defined constant for error mod
defined("TEST_MOD")  ? null:define("TEST_MOD",TRUE);
*/

class MySQLDatabase
{
  
    private $connection;
    //public $products=array();
    protected $object_array=array();
    public $last_query;
    /*public $dsn='';
    public $db_name='kolaci';
    public $pass='';
    public $db_user='root';
    public $db_host='localhost';
    public $testMod=FALSE;*/
    protected $id='';
   // public $sql="SELECT * FROM products";
    
    /*public function __construct()
    {
        $this->open_connection();
    }
    
    // create connection with database
    public function open_connection()
    {
        $this->dsn=sprintf('mysql:host=%s;dbname=%s',$this->db_host,$this->db_name);
        if($this->testMod)
        {
           $this->connection=new PDO($this->dsn,$this->db_user,$this->pass,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
                echo "jedan";
           
        }
        else
        {
            $this->connection=new PDO($this->dsn,$this->db_user,$this->pass);
            echo "Dva";
        }
        
    }
    */
     
    public function query($sql)
    {
        $stmt=$this->connection->prepare($sql);
        if($this->id)
        {
            $stmt->execute(array($this->id));
        }
        else
        {
            $stmt->execute();
        }
        echo $this->confirm_query($stmt);
        return $stmt;
    }
   
   // check function query for errors
    private function confirm_query($result)
    {

        $error=$result->errorInfo();
        if($error[2]!='')
        {   
            $output='Greska:'. $error[2] ."</br>";
            //$output.="Poslednji upit je: ". $this->last_query;
            
            //die($output);
            return $output;
        }
    }
    
    //fetch query
    public function fetch_array($result)
    {
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    
    //collect all data from table
    public function find_all($table)
    {
        //global $database;
        $result=$this->find_by_sql("SELECT * FROM ".$table);
        return $result;
    }
    
    //find data by specify query
    public function find_by_sql($sql="")
    {
        
        $result=$this->query($sql);
        
        if($this->id)
        {
            $row=$this->fetch_array($result);
            return $row;
        }
        else
        {
            while($row=$this->fetch_array($result))
            {
               $this->object_array[]=$row;
                }
            return $this->object_array;
        }

    }
    
    public function find_by_id($id,$table)
    {
        $this->id=$id;
        $result_array=$this->find_by_sql("SELECT * FROM ".$table. " WHERE id=?");
        return $result_array;
    }
    
    
    
    
}
//$database=new MySQLDatabase();
?>