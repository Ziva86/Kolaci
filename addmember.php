<?php
//print_r($GLOBALS);
include_once('./Includes/header.php');
include_once('./core/init.php');
$user=new User();
/*
if(!$user->isLoggedIn()){
	Redirect::to('index.php');
}*/

if(Input::exists()){
	if(Token::check(Input::get('token'))){
	
	$validate=new Validate();
	$validation=$validate->check($_POST,array(
				'username'=>array(
					       'require'=>true,
					       'min'=>2,
					       'max'=>50,
					       'valid_field'=>'/^[a-z0-9,.]+$/i',
					       'unique'=>'users'
					       ),
				'firstname'=>array(
						'require'=>true,
						'min'=>2,
						'max'=>50,
						'valid_firstname'=>'/^[a-z]+$/i'
						),
				'lastname'=>array(
						'require'=>true,
						'min'=>2,
						'max'=>50,
						'valid_field'=>'/^[a-z]+$/i'
						),
				'address'=>array(
						'require'=>true,
						'min'=>2,
						'max'=>80,
						'valid_field'=>'/^[a-z0-9, ]+$/i'
						),
				'city'=>array(
						'require'=>true,
						'min'=>2,
						'max'=>40,
						'valid_field'=>'/^[a-z]+$/i'
						),
				'email'=>array(
					       'require'=>true,
					       'min'=>2,
					       'max'=>50,
					       'valid_email'=>'/^[a-z][a-z0-9._-]+@(\w+\.)+[a-z]{2,6}$/i'
					       ),
				'postcode'=>array(
						'require'=>true,
						'equal'=>5,
						'valid_field'=>'/^[0-9]+$/i'
						),
				'telephone'=>array(
						'require'=>true,
						'min'=>2,
						'max'=>12,
						'valid_field'=>'/^0[0-9]{1,3}\/\d{3}-\d{4}$|^0[0-9]{1,3}\/\d{3}-\d{3}/'
						),
				'password'=>array(
						'require'=>true,
						'min'=>6
						),
				'password_again'=>array(
						'require'=>true,
						'matches'=>'password'
                                          )
					));
	
	
	
	if($validate->passed()){
		 $salt=Hash::salt(32);
		try{
			$birth=Input::get('dobyear').Input::get('dobmonth').Input::get('dobday');
			$user->create(array(
						'birth'=>$birth,
						'username'=>Input::get('username'),
						'first_name'=>Input::get('firstname'),
						'last_name'=>Input::get('lastname'),
						'address'=>Input::get('address'),
						'city'=>Input::get('city'),
						'email'=>Input::get('email'),
						'post_code'=>Input::get('postcode'),
						'telephone'=>Input::get('telephone'),
						'password'=>Hash::make(Input::get('password'),$salt),
						'salt'=>$salt,
						'groups'=>1,
						'joined'=>date('Y-m-d H:i:s')
						
						));
			Session::flash('home','You have been registered and can now log in.');
			Redirect::to('index.php');
			
		}catch(Exception $e){
			die($e->getMessage());
		}
		
	}else{
		$error=$validate->errors();
		//print_r($error);
	}

	}
}

?>

	<div class="product-list">
		
		<h2>Sign Up</h2>
		<br/>
		
		<b>Please enter your information.</b><br/><br/>
		<?php //if($mailStatus) echo '<br/><b class="mail">'.$mailStatus.'</b><br/>';?>
		<form action="addmember.php" method="post">
			<p>
				<label>Birthday: </label>
				<select name="dobyear">
					<?php
						$year=date('Y');
						if(Input::get('dobyear')){echo '<option>'.Input::get('dobyear').'</option>';}
					?>
					
					<?php for($x=$year;$x>($year-120);$x--):?>
					<option><?php echo $x?></option>
					<?php endfor;?>
				</select>
				<select name="dobmonth">
					<?php $month=array(1=>'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Nov','Dec');?>
					<?php
						if(Input::get('dobmonth'))
						{
						   printf('<option value="%02d">%s</option>',Input::get('dobmonth'),$month[(int) Input::get('dobmonth')]);
						}
					
					?>
					<?php
						for($x=1; $x<12; $x++):
						printf('<option value="%02d">%s</option>',$x,$month[$x]);
						echo PHP_EOL;  
					?>
					<?php endfor;?>
				</select>
				<select name="dobday">
					<?php if(Input::get('dobday')){echo '<option>'.Input::get('dobday').'</option>';} ?>
					<?php for($x=1; $x<32; $x++):?>
					<option><?php echo $x;?></option>
					<?php endfor;?>
				</select>
				<?php //if($error['dob']) echo $error['dob'];?>
			</p>
			<p>
				<label for="username">User Name: </label>
				<input type="text" name="username" id="username" value="<?php echo htmlspecialchars(Input::get('username'));?>"  autocomplete="off"/>
				<?php if(!empty($error['username'])){echo $error['username'];} ?>

			<p>
			<p>
				<label for="firstname">First Name: </label>
				<input type="text" name="firstname" id="firstname" value="<?php echo htmlspecialchars(Input::get('firstname'));?>" autocomplete="off"/>
				<?php if(!empty($error['firstname'])){echo $error['firstname'];} ?>
			<p>
			<p>
				<label for="lastname">Last Name: </label>
				<input type="text" name="lastname" id="lastname" value="<?php echo htmlspecialchars(Input::get('lastname'));?>" autocomplete="off"/>
				<?php if(!empty($error['lastname'])){echo $error['lastname'];} ?>
			<p>
			<p>
				<label for="address">Address: </label>
				<input type="text" name="address" id="address" value="<?php echo htmlspecialchars(Input::get('address'));?>" autocomplete="off"/>
				<?php if(!empty($error['address'])) echo $error['address'];?>
			<p>
			<p>
				<label for="city">City: </label>
				<input type="text" name="city" value="<?php echo htmlspecialchars(Input::get('city'));?>"/>
				<?php if(!empty($error['city'])) echo $error['city'];?>
			<p>
			<p>
				<label for="postcode">Postcode: </label>
				<input type="text" name="postcode" id="postcode" value="<?php echo htmlspecialchars(Input::get('postcode'));?>" />
				<?php if(!empty($error['postcode'])) echo $error['postcode'];?>
			<p>
			<p>
				<label for="email">Email: </label>
				<input type="text" name="email" id="email" value="<?php echo htmlspecialchars(Input::get('email'));?>"  autocomplete="off"/>
				<?php if(!empty($error['email'])){echo $error['email'];} ?>

			<p>
			<p>
				<label for="telephone">Telephone: </label>
				<input type="text" name="telephone" id="telephone" value="<?php echo htmlspecialchars(Input::get('telephone'));?>" />
				<?php if(!empty($error['telephone'])) echo $error['telephone'];?>
			<p>
			<p>
				<label for="password">Password: </label>
				<input type="password" name="password" id="password" value="" />
				<?php if(!empty($error['password'])) echo $error['password'];?>
			<p>
			<p>
				<label for="password_again">Password Again: </label>
				<input type="password" name="password_again" id="password_again" value="" />
				<?php if(!empty($error['password_again'])) echo $error['password_again'];?>
			<p>
				<input type="hidden" name="token" value="<?php echo Token::generate();?>">
			<p>
				<input type="reset" name="clear" value="Clear" class="button"/>
				<input type="submit" name="submit" value="Submit" class="button marL10"/>
			<p>
		</form>
	</div><!-- product-list -->




<?php
include_once('./Includes/footer.php');
?>