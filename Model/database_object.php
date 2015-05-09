<?php
require_once('database.php');
class DatabaseObject extends MySQLDatabase
{
    
    
    //protected $table;
    protected $object_array=array();
    public function find_all($table)
    {
        //global $database;
        $result=$this->find_by_sql("SELECT * FROM ".$table);
        return $result;
    }
    
    public function find_by_sql($sql="")
    {
        //global $database;
        $result=$this->query($sql);
       //$object_array=array();
        while($row=$this->fetch_array($result))
        {
            $this->object_array[]=$row;
        }
        return $this->object_array;
    }
    

    
}
?>