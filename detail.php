<?php
require_once('./Includes/header.php');
require_once('./core/init.php');
require ('./View/View.php');


//require_once('./Includes/text.php');
//$products=DB::getInstance()->getAll('products');
//$product=$products->results();
	
	if($_GET['id']){
		$id=$_GET['id'];
	}else{
		$id='';
		
	}
	

$productuno=DB::getInstance()->get('products',array('id','=',$id));
$details=$productuno->results();
//print_r($productuno);
//print_r($details[0]);
$view=new View();



?>

		
	<div class="content">	
	<br/>
	<div class="product-list">
		<h2>Product Details</h2>
		<br/>
		<?php echo $view->displayDetail($details);?>
	</div><!-- product-list -->
<br class="clear-all"/>
</div><!-- content -->
	

<?php
include_once('./Includes/footer.php');
?>