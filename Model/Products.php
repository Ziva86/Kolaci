<?php
class Products
{
   
   private $_db,
           $_data,
           $_sessionName;
        
        
      public function __construct(){
          $this->_db=DB::getInstance();
          $this->_sessionName=Config::get('session/cart_name');
         //print_r($this->data());
      } 
      public function getProductsById($id){
         
         if((int)$id){
            $data=$this->_db->get('products',array('id','=',$id));
            if($data->count()){
                $this->_data=$data->results();
                return true;
            }
         }
          return false;
         
       }
       
      public function addProductToCart($id,$quantity,$price,$link,$title){
            //$this->getProductsById($id);
            //$details=$this->data();
           // print_r($details);
            $value=array();
            if( $this->getProductsById($id)){
                //$value['productID']=$id;
                $value['link']=$link;
                $value['title']=$title;
                $value['qty']=$quantity;
                $value['price']=$price;
               // Session::put($this->_sessionName,$id,$value);
               $_SESSION[$this->_sessionName][$id]=$value;
                $result=TRUE;
            }else
            {
                $result=FALSE;
            }
            return $result;
      }
       
      public function getShoppingCart(){
            
            if(Session::exists($this->_sessionName)){
                  //Session::get($this->_sessionName);
                return $_SESSION[$this->_sessionName];
            }else{
                return array();
            }
      }
      
      public function data(){
         return $this->_data;
      }
      
      public function results(){
         return $this->_db;
      }

      
      public function unset_cart(){
             
         if(Session::exists($this->_sessionName)){
            unset($_SESSION[$this->_sessionName]);
        }


      }
      
      
      	/*
	 * Removes purchase from basket
	 * @param int $productID
	 * @return boolean $success
	 */
	public function delProductFromCart($productID)
	{
		$removed = FALSE;
		if (isset($_SESSION['cart'])) {
			foreach ($_SESSION['cart'] as $key => $row) {
				if ($key == $productID) {
					unset($_SESSION['cart'][$key]);
					$removed = TRUE;
					break;
				}
			}
		}
		return $removed;
	}
        
         /*
	 * Updates purchase from basket
	 * @param int $productID
	 * @param int $qty
	 * @return boolean $success
	 */
	public function updateProductInCart($productID, $qty)
	{
		$updated = FALSE;
		if (isset($_SESSION['cart'])) {
			foreach ($_SESSION['cart'] as $key => $row) {
				if ($key == $productID) {
					$_SESSION['cart'][$key]['qty'] = $qty;
					$updated = TRUE;
					break;
				}
			}
		}
		return $updated;
	}
        
        	/*
	 * Returns array of arrays where each sub-array = 1 database row of products
	 * Searches title and description fields
	 * @param string $search
	 * @return array $row[] = array('title' => title, 'description' => description, etc.)
	 */
	public function getProductsByTitleOrDescription($search)
	{
		// strip out any unwanted characters to help prevent SQL injection
		$search = strip_tags($search);
		$search = str_ireplace(array("'",'-','"',';'), '', $search);
		$search = "'%" . $search . "%'";
		//$pdo = $this->getPdo();
		$sql = 'SELECT * FROM `products` WHERE '
			  . '`title` LIKE ' . $search
			  . ' ORDER BY `title`';
		/*$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$content = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$content[] = $row;
		}*/

		$data=$this->_db->query($sql);
                  if($data->count()){
                  $this->_data=$data->results();
                  return true;
            }


	}


      
    
    
}





?>