<?php

class Cart{
    private $_db;
        
        
        public function __construct(){
        $this->_db=DB::getInstance();
        
       /* $this->_sessionName=Config::get('session/session_name');
        $this->_cookieName=Config::get('remember/cookie_name');
        if(!$user){
            if(Session::exists($this->_sessionName)){
                $user=Session::get($this->_sessionName);
                if($this->find($user)){
                    $this->_isLoggedIn=true;
                    
                }else{
                    
                }
            }
        }else{
            $this->find($user);
        }*/
    }
       public function getProductsById($id){
         
         if(int($id)){
            return $this->_db->get('products',array('id','=',$id));
         }
        
       }
       
       public function addProductToCart($id,$quantity,$price){
            $details=$this->getProductsById($id);
            if($details){
                $details['qty']=$quantity;
                $details['price']=$price;
                $_SESSION['cart'][]=$details;
                $result=TRUE;
            }else
            {
                $result=FALSE;
            }
            return $result;
       }
       
       public function getShoppingCart(){
            if(isset($_SESSION['cart'])){
                return $_SESSION['cart'];
            }else{
                return array();
            }
       }
    

    
    
    
}


?>