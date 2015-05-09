<?php
require_once('./Includes/header.php');
require_once('./Includes/text.php');
require_once('./core/init.php');
require_once('./View/View.php');


$products=DB::getInstance()->getfields('products',array('id','title','link'));
$product=$products->results();

//print_r($product);
$view=new View();


//require_once('./Model/Products.php');
//$products=new Products();
/*$product=$products->getProducts();*/

//$product=$products->find_all('products');
//$titles=$products->getSpecifyData('title');
/*$nn=$products->find_by_id(3,'products');
echo '<pre>';
print_r($nn);
echo '</pre>';
*/
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
else
{
	$message='';
}



?>


<div id="leftnav">
	<div class="search">

		<?php echo $view->searchForm();?>

		<p class="width180">
		   <?php echo aboutUs();?>
		</p>
	</div>
</div><!-- leftnav -->


<div id="rightnav">

	<div class="product-list">
		<h2>Our Products</h2>
		<a class="pages" href="products?page=<?php echo $prev; ?>">&lt;prev</a>
		&nbsp;|&nbsp;
		<a class="pages" href="products?page=<?php echo $next; ?>">next&gt;</a>
		<?php echo ($message)? "&nbsp&nbsp;<b>$message</b>" : '';?>
			<ul>
			<?php echo $view->displayProducts($page,$linesPerPage,$maxProducts,$product);?>	
			</ul>
	</div><!-- product-list -->
	
	
</div><!-- rightnav -->


	<?php require_once('./Includes/footer.php');?>
	

