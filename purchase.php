<?php
include_once('./core/init.php');

$user=new User();
if(!$user->isLoggedIn()){
	
	Session::flash('home','You must be registered to have order.');
	//unset($_SESSION['cart']);
	Redirect::to('index');
}

if(isset($_GET['productID']))
{
	$id=(int) $_GET['productID'];
}
if(isset($_GET['qty']))
{
	$qty= (int) $_GET['qty'];
}
if(isset($_GET['price']))
{
	$price=(float)$_GET['price'];
}
if(isset($_GET['title']))
{
	$title=(string)$_GET['title'];
}
if(isset($_GET['link']))
{
	$link=(string)$_GET['link'];
}
if($id && $qty && $price && $title && $link)
{
	//require './Model/Products.php';
	$products = new Products();

	if($products->addProductToCart($id,$qty,$price,$link,$title))
	{
		setcookie('status','SUCCESS',time()+4,'/');
	}
	else
	{
		setcookie('status','FAILURE',time()+4,'/');
	}
}
else
{
	setcookie('status','UNSET',time()+4,'/');
}

Redirect::to('products');
exit;
?>
