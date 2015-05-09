<?php
require_once('./core/init.php');
$message='';
$username='';
//$clan='';

if(Session::exists('home')){
    $message=Session::flash('home');
}
$user=new User();

if($user->isLoggedIn())
{
    $username=$user->data()->username;
   
}

  ($username)? $clan='username':$clan='guest';
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Kolaci |</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name ="description" content ="Kolaci">
<meta name="keywords" content="">
<link rel="stylesheet" href="css/main.css" type="text/css">
<link rel="shortcut icon" href="images/favicon.ico?v=2" type="image/x-icon" />
</head>
<body>
        <div id="wrapper">
	<div id="maincontent">		
	<div id="header">
		<div id="logo" class="left">
			<a href="index"><img src="images/logo1.jpg" height=62px alt="SweetsComplete.Com"/></a>
		</div>
		<div class="right marT10">
			<b>
                        <?php foreach(Pages::page($clan) as $value){ echo $value;}?>
			<!--<a href="logout.php" >Logout</a> |<a href="login.php" >Login</a> |<a href="addmember.php" >Add Member</a> |<a href="members.php" >Our Members</a> |<a href="cart.php" >Shopping Cart</a>-->
                        </b>
                        <p><?php echo ($username)? "Welcome ".$username : "Welcome Guest.";?></p>
		</div>
		<ul class="topmenu">
		<li><a href="index">Početna</a></li>
		<li><a href="products">Proizvodi</a></li>
		<li><a href="about">O Nama</a></li>
		<li><a href="contact">Kontakt</a></li>
		</ul>
		<br>
		<div class="banner"><p></p></div>
		<br class="clear"/>
	</div> <!-- header -->
        <?php print_r ($message);?>
        <div class="content">