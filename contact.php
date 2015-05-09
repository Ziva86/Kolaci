<?php
include_once('./Includes/header.php');
include_once('./core/init.php');

$mailStatus='';
if(Input::exists()){
    if(Token::check(Input::get('token'))){
	$validate=new Validate();
	$validation=$validate->check($_POST,array(
				    'email'=>array(
					'require'=>true,
					'valid_email'=>'/^[a-z][a-z0-9._-]+@(\w+\.)+[a-z]{2,6}$/i'
				    ),
				    'name'=>array(
					'require'=>true,
					'min'=>2,
					'max'=>50
				    ),
				    'comments'=>array(
					'require'=>true,
					'min'=>2,
					'max'=>150
				    )
  						  ));
	  if($validate->passed()){
                    require_once('PHPMailer/class.phpmailer.php');
                    $address = "b7_14875815@mareziva.byethost7.com";
                    $name=Input::get('name');
                    $mail = new PHPMailer(); // defaults to using php "mail()"
                    $body = 'Dobrodosao: '.$name;
                    //$mail->AddReplyTo($address,"Kolaci");
                    $mail->SetFrom(Input::get('email'),$name);
                    $mail->AddAddress($address, 'MARKO');
                    $mail->Subject = "Nova poruka od sajta za Kolace";
                    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                    $mail->MsgHTML(Input::get('comments'));
                    
                    if(!$mail->Send()) {
                      $mailStatus="Mailer Error: " . $mail->ErrorInfo;
                    } else {
                      $mailStatus="Message sent!";
                        Input::clear();

                    }
	  }else{
	    $error=$validate->errors();
	  }
	
    }
}

?>

	<br/>
	<div class="product-list">
		
		<h2>Sign Up</h2>
		<br/>
		
		<b>Please use this form to contact us.</b><br/><br/>
                <?php if($mailStatus) echo '<br/><b class="mail">'.$mailStatus.'</b><br/>';?>
		<form action="contact.php" method="post">
			<p>
				<label for='name'>Name: </label>
				<input type="text" name="name" id="name" value="<?php echo htmlspecialchars(Input::get('name'));?>"/>
                                <?php if(!empty($error['name'])){echo $error['name'];}?>
			<p>
			<p>
				<label for="email">Email Address: </label>
				<input type="text" name="email" id="email" value="<?php echo htmlspecialchars(Input::get('email'));?>"/>
                                <?php if(!empty($error['email'])){echo $error['email'];}?>
			<p>
			<p>
				<label for="comments">Comments / Questions: </label>
				<textarea name="comments" id="comments"><?php echo htmlspecialchars(Input::get('comments'));?></textarea>
                                <?php if(!empty($error['comments'])){echo $error['comments'];}?>
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