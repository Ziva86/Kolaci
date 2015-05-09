<?php 
// results of products search
require_once('./Includes/header.php');
require_once('./Includes/text.php');
require_once('./core/init.php');
require ('./View/View.php');
		
// do search
if(isset($_GET['keyword'])){
			
	$validate=new Validate();
	$validation=$validate->check($_GET,array(
		'keyword'=>array(
				//'require'=>true,
				'valid_field'=>'/^[a-z]+$/i'
				)
				));
				
			if($validate->passed()){
				$productTable = new Products();
				$search =(string)$_GET['keyword'];
				$products = $productTable->getProductsByTitleOrDescription($search);
				$product=$productTable->data();
					if(!count($product)){
						$message_nodata='Nema podataka';
					}
			}else{
				$error=$validate->errors();
				$productTable=DB::getInstance()->getfields('products',array('id','title','link'));
				$product=$productTable->results();
			}
			
		}
		if(isset($_GET['title']) && !empty($_GET['title'])){
				// convert to data type int for safety purposes
				$id = (int) $_GET['title'];
				$productTable = new Products();
				$products = $productTable->getProductsById($id);
				$product=$productTable->data();
		}
		
		
		if(empty($_GET['keyword'] )&& empty($_GET['title'])){
			
			//Session::flash('home','You must enter a value in the field.');
			Redirect::to('products');
		}
				
					


$view=new View();


//sort($titles,SORT_STRING);

$maxProducts=count($product);
$page=(isset($_GET['page']))?(int)$_GET['page']:0;
$prev=($page==0)?0:$page-1;
$next=$page+1;
$linesPerPage=6;

//check status cookie

if(isset($_COOKIE['status']))
{
	if($_COOKIE['status']=='SUCCESS')
	{
		$message='Added item to cart, thanks.';
	}
	elseif($_COOKIE['status']=='UNSET')
	{
		$message='Sorry: either ID, quantity or price was not  set!';
	}
	else
	{
		$message='Sorry: enable to add item to cart.';
	}
}


?>


<div id="leftnav">
	<div class="search">
		<?php
			if(!empty($error['keyword'])){echo $error['keyword'];}
			echo $view->searchForm();
		?>
		
		<p class="width180">
		   <?php echo aboutUs();?>
		</p>
	</div>
</div><!-- leftnav -->


<div id="rightnav">

	<div class="product-list">
		<h2>Our Products</h2>
		<?php if(isset($message_nodata)){echo $message_nodata;}else{ ?>
		
		<a class="pages" href="products.php?page=<?php echo $prev; ?>">&lt;prev</a>
		&nbsp;|&nbsp;
		<a class="pages" href="products.php?page=<?php echo $next; ?>">next&gt;</a>
		<?php }echo ($message)? "&nbsp&nbsp;<b>$message</b>" : '';?>
			<ul>
			<?php echo $view->displayProducts($page,$linesPerPage,$maxProducts,$product);?>	
			</ul>
	</div><!-- product-list -->
	
	
</div><!-- rightnav -->


	<?php require_once('./Includes/footer.php');?>
	

