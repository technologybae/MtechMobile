<?php
session_start();
@error_reporting(0);
include("config/connection.php");
include("config/main_connection.php");

if(empty($_SESSION['id']))
{
printf("<script>location.href='index.php?value=logout'</script>");
die();
}

//////////// Query To Get Logged In user Details From his own Database/////////
//  $qst = "Select * from ".dbObject."Emp_Web where customer_code = '".$_SESSION['customer_code']."'";
//$query = Run($qst);
//$loggedRec = myfetch($query);
//$img = $loggedRec->img;
//if($img=='')
//{
//	$img ="MtechSuperAdmin/user_images/noimage.png";
//}
 $page_url = basename($_SERVER['PHP_SELF']);
 $_SESSION['is_completed'];

//if($_SESSION['is_completed']!='1')
//{
//	
//	if($page_url != 'profile.php')
//	{
//	printf("<script>location.href='profile.php'</script>");
//}
//
//}
///// Get Main Database Records//////
$myq2 = RunMain("Select * from ".dbObjectMain."Users where email = '".$_SESSION['email']."'");

$mymaster = myfetchMain($myq2);
?>
<header>
<div class="header-container">
<div class="logo">
	<a href="home.php">
<figure>Mtech</figure></a>
</div>
	
	
	
<a href="home.php" class="home" alt="Home"><i class="fa fa-home" aria-hidden="true"></i></a>	
	
<a href="logout.php" class="logout" alt="Logout"><i class="fa fa-sign-out" aria-hidden="true"></i></i></a>

<button type="button" data-toggle="modal" data-target="#exampleModal" onclick="showModal()" class="langButton"><img src="assets/img/globe.png" alt=""></button>
</div>
</header>