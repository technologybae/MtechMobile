<?php
session_start();
error_reporting(0);
include("../../config/connection.php");

$queryForMax = Run("Select max(BillNO) as bno from Receipt");
$BillNO = myfetch($queryForMax)->bno+1;
$BillDate = addslashes(trim($_POST['bill_date_time']));
$BillDate = !empty($BillDate) ? $BillDate: date("Y-m-d H:i:s");

$Total = !empty($_POST['total']) ? $_POST['total']: 0;
$disPer = !empty($_POST['disPer']) ? $_POST['disPer']: 0;
$CSID = addslashes(trim($_POST['customer_id']));
$CustomerID = !empty($CSID) ? $CSID: 0;

$query = Run("Select * from ".dbObject."CustFile where Cid = '".$CustomerID."'");
$CustomerName = myfetch($query)->CName;
$Discount = !empty($_POST['disAmt']) ? $_POST['disAmt']: 0;
$NetTotal = !empty($_POST['netTotal']) ? $_POST['netTotal']: 0;


$Bid = addslashes(trim($_POST['Bid']));
$Bid = !empty($_POST['Bid']) ? $_POST['Bid']: 0;

$aab = "select sum(Credit-Debit) as custBalance from V_CustBalance where cid='".$CustomerID."' and bid = '".$Bid."'";
$query1 = Run($aab);
$custBalance = myfetch($query1)->custBalance;
$customer_Balance = round($custBalance,2);

$Cbal = $customer_Balance-$Total;





$sbid = "2";
$bQ = Run("Select * from " . dbObject . "Branch where Bid = '".$Bid."'");
$getBData = myfetch($bQ);
if($getBData->ismain=='1')
{
$sbid = "1";
}


$posid = "1";
$RefNo1 = $_POST['RefNo1'];
$RefNo1 = !empty($RefNo1) ? $RefNo1: '0';

$EmpID = $_POST['EmpID'];
$UserID = !empty($EmpID) ? $EmpID: '0';

$salesMan = addslashes(trim($_POST['EmpID']));
$SalesmanID = !empty($salesMan) ? $salesMan: '0';

$bnkid = !empty($_POST['bnkid']) ? $_POST['bnkid']: '0';

$sbBillno = $BillNO."-S".$sbid."-M".$Bid;
$prePareInsert = "INSERT INTO Receipt
(BillNO,BillDate,Comment ,Total,CustomerID ,RecNo ,CustomerName,[Discount%],Discount ,NetTotal ,BId,PayType ,UserID,SalesmanID,AccTransID ,AccFiscalYear,AccCompanyId,bnkid,IsPublished,salBillno,ISSMSSEND,sbid,sbBillno,IsDeleted,Cbal)
VALUES
(".$BillNO.",'".$BillDate."','".$RefNo1."' ,'".$Total."','".$CustomerID."' ,'' ,'".$CustomerName."','".$disPer."','".$Discount."' ,'".$NetTotal."' ,'".$Bid."','1' ,'".$_SESSION['id']."','".$SalesmanID."','' ,'','','".$bnkid."','0','','','".$sbid."','".$sbBillno."','','".$Cbal."')";
$FIns = Run($prePareInsert);
//////////// Details Data///////////////

$counter =1;
$AutoNo =1;
$nrows = $_POST['nrows'];

while($counter<$nrows)
{
$InvoiceNo =  !empty($_POST['InvoiceNo'.$counter]) ? $_POST['InvoiceNo'.$counter]: '0';	

$InvoiceDate  = !empty($_POST['InvoiceDate'.$counter]) ? $_POST['InvoiceDate'.$counter]: '';		

$billAmount  = !empty($_POST['billAmount'.$counter]) ? $_POST['billAmount'.$counter]: '0';

$salSubInv  = !empty($_POST['sbBillno'.$counter]) ? $_POST['sbBillno'.$counter]: '';

$payingAmount  = !empty($_POST['payingAmount'.$counter]) ? $_POST['payingAmount'.$counter]: '0';



$Remaining  = !empty($_POST['Remaining'.$counter]) ? $_POST['Remaining'.$counter]: '0';




if($payingAmount>0)
{

/// Multiple Insertions//////////

$queryII  = "INSERT INTO [RecieptDetails]
([BillNo],[BillDate],[CustomerID],[InvoiceNo],[InvoiceDate],[PaidAmount],[RecNo],[CustomerName],[AutoNo],[Bid],[PayType] ,[UserID],[SalesmanID],[billAmount] ,[IsPublished],[rRetAmt],[sbid],[sbBillno] ,[salSubInv],[IsDeleted]) 
Values
(".$BillNO.",'".$BillDate."','".$CustomerID."','".$InvoiceNo."','".$InvoiceDate."','".$NetTotal."','','".$CustomerName."','1','".$Bid."','1' ,'".$_SESSION['id']."','".$SalesmanID."','0' ,'0','','".$sbid."','".$sbBillno."' ,'".$salSubInv."','0')";
$F2 = Run($queryII);

$AutoNo++;	

}



$counter++;	
}
if($nrows==1)
{
$NetTotal = !empty($_POST['netTotal']) ? $_POST['netTotal']: 0;

$queryII  = "INSERT INTO [RecieptDetails]
([BillNo],[BillDate],[CustomerID],[InvoiceNo],[InvoiceDate],[PaidAmount],[RecNo],[CustomerName],[AutoNo],[Bid],[PayType] ,[UserID],[SalesmanID],[billAmount] ,[IsPublished],[rRetAmt],[sbid],[sbBillno] ,[salSubInv],[IsDeleted]) 
Values
(".$BillNO.",'".$BillDate."','".$CustomerID."','0',NULL,'".$NetTotal."','','".$CustomerName."','".$AutoNo."','".$Bid."','99' ,'".$_SESSION['id']."','".$SalesmanID."','".$billAmount."' ,'0','','".$sbid."','".$sbBillno."' ,'".$salSubInv."','')";
$F2 = Run($queryII);	


}



/// Export WEb///

$insertion2 = "EXECUTE [InsertExportDet]
@FMBid =$Bid
,@FSBid=$sbid
,@UValue=$BillNO
,@tbleName='ReceiptExportWeb'
,@sTyp=1
,@IsSuccess =1
";
	$insertion2 = Run($insertion2);
?>



<script>
$( document ).ready(function() {
<?php
if($BillNO!='')
{
?>
saveFinalStep('<?=$BillNO?>','<?=$Bid?>');
<?php
}
?>

});

</script>









