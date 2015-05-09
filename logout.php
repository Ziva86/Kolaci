<?php
require_once('./core/init.php');

$user=new User();
$user->logout();
$product=new Products();
$product->unset_cart();
Redirect::to('Index');

?>