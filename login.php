<?php
include_once('./Includes/header.php');
//include_once('./Includes/validate.php');
require_once('./core/init.php');
if(Input::exists()){
    if(Token::check(Input::get('token'))){
    $validate=new Validate();
    $validation=$validate->check($_POST,array(
				    'username'=>array(
					    'require'=>true,
					    'min'=>2,
					    'max'=>50
					    ),
				    'password'=>array(
					    'require'=>true,
					    'min'=>6,
					    'max'=>50
					    )				      
					      ));
    if($validation->passed()){
	$user=new User();
	 $remember=(Input::get('remember')==='on')? true : false;
	$login=$user->login(Input::get('username'),Input::get('password'),$remember);
	if($login){
	    Redirect::to('index.php');
	}
	else{
	    echo 'Sorry';
	}
	
    }else{
	$error=$validate->errors();
    }
    
    
    
    }   
    
}


?>


	<div class="product-list">
		
		<h2>Login</h2>
		<br/>
		
		<b>Please enter your information.</b><br/><br/>
		              
		<form action="login.php" method="POST">
			<p>
				<label for="username">Username: </label>
				<input type="text" name="username" id="username" value="<?php echo htmlspecialchars(Input::get('username'));?>" autocomplete="off"/>
                                <?php if(isset($error['username'])){echo $error['username'];}?>
			</p>
			<p>
				<label for="password">Password: </label>
				<input type="password" name="password" id="password" value="" />
                                <?php if(isset($error['password'])){echo $error['password'];}?>
			</p>
			
			            <div class="field">
                <label for="remember">
                <input type="checkbox" name="remember" id="remember">
                Remember Me.</label>

			<p>
				<input type="hidden" name="token" value="<?php echo Token::generate();?>">
			</p>
			<p>
				<input type="reset" name="clear" value="Clear" class="button"/>
				<input type="submit" name="submit" value="Submit" class="button marL10"/>
			</p>
		</form>
	</div><!-- product-list -->




<?php
include_once('./Includes/footer.php');
?>