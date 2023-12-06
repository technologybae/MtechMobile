<?php
session_start();
error_reporting(0);
include("../../config/connection.php");

$bid = addslashes(trim($_POST['Bid']));
// $sbid = $bid;

$sbid = "2";
$bQ = Run("Select * from " . dbObject . "Branch where Bid = '".$bid."'");
$getBData = myfetch($bQ);
if($getBData->ismain=='1')
{
	$sbid = "1";
}

$CName = addslashes(trim($_POST['CName']));
$Description = addslashes(trim($_POST['Description']));
$Address = addslashes(trim($_POST['Address']));
$Contact1 = addslashes(trim($_POST['Contact1']));
$Email = addslashes(trim($_POST['Email']));

/// Double Check////// If Required////


$OpenBalance = addslashes(trim($_POST['OpenBalance']));
$OpenBalance = !empty($OpenBalance) ? $OpenBalance: '0';


$Salesman = addslashes(trim($_POST['Salesman']));
$VatNo = addslashes(trim($_POST['VatNo']));
$VatNo = !empty($VatNo) ? $VatNo: '0';


$openDebit = addslashes(trim($_POST['openDebit']));
$openDebit = !empty($openDebit) ? $openDebit: '0';




$quer = 'select max(Cid) as Cid from CustFile';
$executes = Run($quer);
$Cid = myfetch($executes)->Cid+1;

$defCode = $Cid."-S".$sbid."-M".$bid;

$que = 'SELECT TOP (1) CCode from CustFile order by Cid desc';
$executes = Run($que);
$CCode = myfetch($executes)->CCode+1;
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

  $insertion = "insert into CustFile (Cid,CCode,CName,Description,Address,Contact1,Email,OpenBalance,Is_Open_bal,openDate,dateAdd,dateEdit,isDeleted,sbid,bid,Salesman,VatNo,openDebit,CCodeOld) Values ('".$Cid."','".$CCode."','".$CName."','".$Description."','".$Address."','".$Contact1."','".$Email."','".$OpenBalance."','".$Is_Open_bal."','".$openDate."','".$dateAdd."','".$dateEdit."','".$isDeleted."','".$sbid."','".$bid."','".$Salesman."','".$VatNo."','".$openDebit."','".$defCode."')";
$run = Run($insertion);
if($run)
{
	
$insertion2 = "EXECUTE [InsertExportDet]
@FMBid =$bid
,@FSBid=$sbid
,@UValue=$Cid
,@tbleName='CustFileExportWeb'
,@sTyp=1
,@IsSuccess =1
";
	$insertion2 = Run($insertion2);
	if($insertion2)
	{
	?>
<script>
loadPage('list_customers.php?value=added');
</script>
<?php
}
	}
?>


