<?php
session_start();
error_reporting(0);
include("../../config/connection.php");

$bid = addslashes(trim($_POST['Bid']));
$sbid = $bid;
$CCode = addslashes(trim($_POST['CCode']));
$CName = addslashes(trim($_POST['CName']));
$Description = addslashes(trim($_POST['Description']));
$Address = addslashes(trim($_POST['Address']));
$Contact1 = addslashes(trim($_POST['Contact1']));
$Email = addslashes(trim($_POST['Email']));

/// Double Check////// If Required////


$OpenBalance = addslashes(trim($_POST['OpenBalance']));

$Salesman = addslashes(trim($_POST['Salesman']));
$VatNo = addslashes(trim($_POST['VatNo']));
$openDebit = addslashes(trim($_POST['openDebit']));


$Is_Open_bal = '0';
	$openDate = '';
if($OpenBalance>0)
{
	$Is_Open_bal = '1';
	$openDate = date("Y-m-d H:i:s");
}
	$dateAdd = date("Y-m-d H:i:s");
	$dateEdit = date("Y-m-d H:i:s");
	$isDeleted = 0;


$insertion = "update CustFile set   CName='".$CName."', Description='".$Description."', Address='".$Address."', Contact1='".$Contact1."', Email='".$Email."', OpenBalance='".$OpenBalance."', Salesman='".$Salesman."', VatNo='".$VatNo."', openDebit='".$openDebit."' where CCode='".$CCode."' and  bid='".$bid."'  ";
//echo $insertion;
//die();
$run = Run($insertion);
if($run)
{
	?>
<script>
loadPage('list_customers.php?value=added');
</script>
<?php
}
?>


