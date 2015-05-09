<?php
//print_r($GLOBALS);
include_once('./Includes/header.php');
//include_once('./Model/database.php');
include_once('./core/init.php');
//print_r(DB::getInstance());

require ('./View/View.php');

$users=DB::getInstance()->getAll('users');
$user=$users->results();


$view=new View();

$maxMembers=count($user);
$page=(isset($_GET['page']))?(int)$_GET['page']:0;
$prev=($page==0)?0:$page-1;
$next=$page+1;
$linesPerPage=6;


?>

<div class="product-list">
	<h2>Our Members</h2>
	<br/>
		<form name="search" method="get" action="members.php" id="search">
			<input type="text" value="keywords" name="keyword" class="s0" />
			<input type="submit" name="search" value="Search Members" class="button marL10" />
			<input type="hidden" name="page" value="members" />
		</form>
	<br/><br/>
	<a class="pages" href="members?page=<?php //echo $prev; ?>">&lt;prev</a>
	&nbsp;|&nbsp;
	<a class="pages" href="members?page=<?php //echo $next; ?>">next&gt;</a>
	<table>
		<tr>
			<th>Member ID</th><th>Name</th><th>City</th><th>Phone</th>
		</tr>
		<?php echo $view->displayMembers($page,$linesPerPage,$maxMembers,$user);?>
		
			</table>
	<br/>
	<a href="addmember.php" class="abutton">&nbsp;&nbsp;&nbsp;Member Sign Up&nbsp;&nbsp;&nbsp;</a>

</div>
<br class="clear-all"/>
</div><!-- content -->
	

<?php
include_once('./Includes/footer.php');
?>
