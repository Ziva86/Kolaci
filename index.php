<?php
require_once('./Includes/header.php');
require_once('./Includes/text.php');
require_once('./core/init.php');
require_once('./View/View.php');

//print_r(get_declared_classes());


$products=DB::getInstance()->getfields('products',array('id','title','link'));
$product=$products->results();
$proba_list=$products->multidimensional_array_rand($product,3);


/*function callback_rand() { 
  
  return rand() > rand();
  
}
*/


$user=new User();

if($user->isLoggedIn())
{
	/*echo '<pre>';
	//print_r(session_id());
	echo '</pre>';
	echo '<pre>';
	print_r($_SESSION);
	echo '</pre>';
	//print_r($_COOKIE);*/
}

$view=new View();



//print_r($podaci->_pdo);
//print_r(DB::getInstance());
?>

	<div class="search left">

		<?php echo $view->searchForm();?>
	</div>
	
	<div class="intro left">
	    <?php echo aboutUs(); ?>
	</div>
	<br class="clear"/>
	<br/>
		
	<div class="product-list">
		<h2>Some Specials</h2>
		
		<ul class="specials">
			<?php

				foreach ($proba_list as $value):
				
			?>
				<li>
					<div class="image">
						<a href="detail?id=<?php echo $value->id;?>">
						<img src="images/<?php echo $value->link;?>.jpg" alt="<?php echo $value->title;?>" width="190" height="130"/>
						</a>
						
					</div>
					<div class="detail">
						<p class="name"><a href="detail?id=<?php echo $value->id;?>"><?php echo $value->title;?></a></p>
						<p class="view"><a href="detail?id=<?php echo $value->id;?>">purchase</a> | <a href="detail.php?id=<?php echo $value->id;?>">view details >></a></p>
					</div>
				</li>
			<?php
				
				endforeach;
				
				
			?>
			</ul>
	</div><!-- product-list -->

        	<?php require_once('./Includes/footer.php');?>
	
