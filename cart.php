<?php
include_once('./Includes/header.php');
//include_once('./Model/database.php');
include_once('./core/init.php');

/*if(!$user->isLoggedIn()){
	unset($_SESSION['cart']);
	Redirect::to('index.php');
}*/




$products= new Products();
/*if (isset($_POST['back'])) {
	Redirect::to('products.php');
	exit;
}*/

if (isset($_POST['back'])) {
	header('Location: ?page=products');
	exit;
}

if (isset($_POST['change'])) {
	if (isset($_POST['remove'])) {
		// $key = product_id
		foreach ($_POST['remove'] as $key => $value) {
			$key = (int) $key;
			$products->delProductFromCart($key);
		}
	}
	if (isset($_POST['update'])) {
		// $key = product_id
		foreach ($_POST['update'] as $key => $value) {
			$key = (int) $key;
			$qty = (isset($_POST['qty'][$key])) ? (int) $_POST['qty'][$key] : 0;
			if ($qty) {
				$products->updateProductInCart($key, $qty);
			}
		}
	}
}




$cartList=$products->getShoppingCart();
require './View/View.php';
$view= new View();


//print_r($cartList);



?>

		
	<div class="content">
<br/>
	<div class="product-list">
		<h2>Shopping Basket</h2>
		<br/>
		<form action="#" method="POST">
		<table>
			<tr>
				<th>Item No.</th><th>Product</th>
				<th width="40%">Name</th>
				<th>Amount</th>
				<th width="10%">Price</th>
				<th width="10%">Extended</th>
				<th>&nbsp;</th>
			</tr>
			
			<?php echo $view->displayCart($cartList);?>
		</table>
		
		<br/>
		
		<p align="center">
			<input type="submit" name="back" value="Back to Shopping" class="button"/>
			<input type="submit" name="change" value="Update" class="button"/>
			<input type="submit" name="checkout" value="Checkout" class="button"/>
		<p>
		</form>
	</div>

</div><!-- content -->
	
	

<?php include_once('./Includes/footer.php'); ?>