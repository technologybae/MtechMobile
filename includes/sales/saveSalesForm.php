<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
include("../../config/main_connection.php");
include("../../config/main_functions.php");
include("../../Lib/qrCode/qrlib.php");
$getLoginUserCompanyData = getLoginUserCompanyData($_SESSION['id']);
$Bid = addslashes(trim($_POST['Bid']));
$CSID = addslashes(trim($_POST['customer_id']));
$SPType = addslashes(trim($_POST['SPType']));
$posid = "1";
$RefNo1 = $_POST['RefNo1'];
$RefNo1 = !empty($RefNo1) ? $RefNo1: '0';

$EmpID = $_POST['EmpID'];
$EmpID = !empty($EmpID) ? $EmpID: '0';

$bill_date_time = addslashes(trim($_POST['bill_date_time']));
$salesMan = addslashes(trim($_POST['salesMan']));
$salesMan = !empty($salesMan) ? $salesMan: '0';

$CustomerName = addslashes(trim($_POST['CustomerName']));
$CustomerName = !empty($CustomerName) ? $CustomerName: '';
$total = addslashes(trim($_POST['total']));
$TdisPer = addslashes(trim($_POST['disPer']));
$TdisAmt = addslashes(trim($_POST['disAmt']));
$TnetTotal = addslashes(trim($_POST['netTotal']));
$TtotVat = addslashes(trim($_POST['totVat']));
$TgrandTotal = addslashes(trim($_POST['grandTotal']));
//$Bank = addslashes(trim($_POST['Bank']));
$row_count = addslashes(trim($_POST['row_count']));
$counter =1;
$autono =1;
$vatPerTotal = 0;
$SalDetail = '';




$IsNoVat  = 0;
$IsFixedVat   = 0;
$FixedVatPer    = 15;
$RowTotal    = 0;
$ToalRowAmtVatable    = 0;
$ToalRowAmtNoVat    = 0;

$sbid = "2";
$bQ = Run("Select * from " . dbObject . "Branch where Bid = '".$Bid."'");
$getBData = myfetch($bQ);
if($getBData->ismain=='1')
{
	$sbid = "1";
}



while($counter<=$row_count)
{
$Pid = $_POST['Pid'.$counter];	
$Pid = !empty($Pid) ? $Pid: '0';
$Uid = $_POST['Uid'.$counter];	
$Uid = !empty($Uid) ? $Uid: '0';

 $PCode = $_POST['PCode'.$counter];	
$PCode = !empty($PCode) ? $PCode: '0';

$region = $_SESSION['region'];
if($region=='1')
{
$sp = "EXECUTE ".dbObject."GetProductSearchByCodeUnitWebP  @pCode='$PCode' ,@bid='$Bid',@uid='$Uid'";
}
if($region=="2")
{
$sp = "EXECUTE ".dbObject."GetProductSearchByCodeUnitWeb @pCode='$PCode' ,@bid='$Bid',@uid='$Uid'";
}
	
$QueryMax = Run($sp);
$getDetails = myfetch($QueryMax);	



$qty = $_POST['qty'.$counter];	
$qty = !empty($qty) ? $qty: '0';

$Sprice = $_POST['Sprice'.$counter];	
$Price = !empty($Sprice) ? $Sprice: '0';

$Total = $Price*$qty;
$Discount = 0;



$netT = $_POST['netT'.$counter];
$NetTotal = !empty($netT) ? $netT: '0';



// $cpp = 	$getDetails->level3;
// $cst = 	$getDetails->PPrice;



// $cst = !empty($cst) ? $cst: '0';
// $cpp = !empty($cpp) ? $cpp: '0';

$costTotal = $_POST['costTotal'.$counter];	
$costTotal = !empty($costTotal) ? $costTotal: '0';	

$CostPrice = $_POST['CostPrice'.$counter];	
$CostPrice = !empty($CostPrice) ? $CostPrice: '0';	

$csp = $NetTotal-$costTotal;
$csp = !empty($csp) ? $csp: '0';

 $QtyInLowQty = "dbo.GetQtyInLow(".$Uid.",".$qty.")";

	$QtyInLowQty = !empty($QtyInLowQty) ? $QtyInLowQty: '';

$CPrice = $_POST['CPrice'.$counter];	
$CPrice = !empty($CPrice) ? $CPrice: '0';

$CSID = !empty($CSID) ? $CSID: '0';
$CPrice = !empty($CPrice) ? $CPrice: '0';

$ppriceDet = $getDetails->level3;
	$ppriceDet = !empty($ppriceDet) ? $ppriceDet: '0';

$spriceDet = $Sprice;


$vatAmt = $_POST['vatAmt'.$counter]/$qty;	
$vatAmt = !empty($vatAmt) ? $vatAmt: '0';

$vatPer = $_POST['vatPer'.$counter];	
$vatPer = !empty($vatPer) ? $vatPer: '0';
$vatTotal = $vatAmt*$qty;

$vatPTotal = 	$NetTotal+$vatTotal;
$VatPrice = $vatamt+$Sprice;

$vatSprice = $_POST['vatSprice'.$counter];	
$vatSprice = !empty($vatSprice) ? $vatSprice: '0';	

$description = '';

$onlyVat = 0;
if($vatAmt!='0')
{
$onlyVat = $vatSprice;
}



if($PCode!='0' && $PCode!='')
{
//// New Sp Values///

$vvT = $vatPer*$qty;
$vatPerTotal = $vatPerTotal+$vvt;





$RowVatPriceTotal = $RowVatPriceTotal+($vatSprice*$qty);
$RowTotal  = $RowTotal +($vatSprice*$qty);
$ToalRowAmtNoVat  = $ToalRowAmtNoVat +($Sprice*$qty);
$ToalRowAmtVatable  = $ToalRowAmtVatable +($onlyVat*$qty);
$FTOtal  = $FTOtal +($NetTotal);
$FvatTotal  = $FvatTotal +($vatTotal);
$TotalCost  = $TotalCost +($getDetails->PPrice*$qty);
$Price = $Sprice;
//if($vatAmt>0)
//{
//$Price = $vatSprice;
//}
$Total = $Price*$qty;



$delimeter = 'µ';	
	
	$ppc = ''.$PCode.'';
	
 $currentRow = $Pid.",".$Uid.",''".$ppc."'',".$qty.",".$Price.",".$Total.",".$Discount.",".$NetTotal.",".$CostPrice.",".$costTotal.",".$csp.",".$QtyInLowQty.",".$CPrice.",".$CSID.",".$ppriceDet.",".$spriceDet.",".$vatPer.",".$vatAmt.",".$vatTotal.",".$vatPTotal.",".$VatPrice.",".$autono.",''".$description."''";;

$SalDetail = $SalDetail.$delimeter.$currentRow;	
$autono++;
}
$counter++;
}

$SalDetail =  ltrim($SalDetail,$delimeter);
$salPayment = '';



 $storeProcedure = "exec ".dbObject."GetSalCal @IsNoVat ='".$IsNoVat."',@IsFixedVat ='".$IsFixedVat."',@FixedVatPer ='".$FixedVatPer."',@vatPerTotal='".$vatPerTotal."',@RowVatPriceTotal='".$RowVatPriceTotal."',@RowTotal='".$RowTotal."',	@ToalRowAmtNoVat ='".$ToalRowAmtNoVat."',@ToalRowAmtVatable ='".$ToalRowAmtVatable."',@Total ='".$total."',@TotalCost ='".$TotalCost."',@DisPer='".$TdisPer."',@DisAmt ='".$TdisAmt."'";
$query = Run($storeProcedure);
$getSpData = myfetch($query);


$GProfit = $getSpData->GProfit;
$GProfit = !empty($GProfit) ? $GProfit: '0';


$NProfit = $getSpData->NProfit;
$NProfit = !empty($NProfit) ? $NProfit: '0';

$NetTotal = $getSpData->NetTotal;
$NetTotal = !empty($NetTotal) ? $NetTotal: '0';


$totalVat = $getSpData->totalVat;
$totalVat = !empty($totalVat) ? $totalVat: '0';



$vatPtotal = $getSpData->vatPtotal;
$vatPtotal = !empty($vatPtotal) ? $vatPtotal: '0';



$NoVatDisTotal = $getSpData->NoVatDisTotal;
$NoVatDisTotal = !empty($NoVatDisTotal) ? $NoVatDisTotal: '0';

$TotalAmtNoVat = $getSpData->ToalAmtNoVat;
$TotalAmtNoVat = !empty($TotalAmtNoVat) ? $TotalAmtNoVat: '0';

$VatDisTotal = $getSpData->VatDisTotal;
$VatDisTotal = !empty($VatDisTotal) ? $VatDisTotal: '0';

$ToalAmtVatable = $getSpData->ToalAmtVatable;
$ToalAmtVatable = !empty($ToalAmtVatable) ? $ToalAmtVatable: '0';

$AvgVatPer = $getSpData->AvgVatPer;
$AvgVatPer = !empty($AvgVatPer) ? $AvgVatPer: '0';

$salPayment = '';
if($SPType=='1')
{
 $bankrows = $_POST['bankrows'];
$cnt = 1;
$id =1;
$remAmount  = $TgrandTotal;
while($cnt<$bankrows)
{
$paytype = $_POST['Bank'.$cnt];	
$amount = $_POST['sal_amount'.$cnt];	
$payname = $_POST['BankName'.$cnt];	

$delimeter = 'µ';		
if($paytype!='' && $amount>0)
{

//$remAmount = $remAmount-$amount;
	$remAmount = $amount;
$remAmount = !empty($remAmount) ? $remAmount: '0';	

$currentRow = $id.",".$paytype.",".$amount.",''".$payname."'',".$remAmount;	
$salPayment = $salPayment.$delimeter.$currentRow;		
$id++;	
}
$cnt++;
}
}
 $salPayment =  ltrim($salPayment,$delimeter);
$NetTotal = $FTOtal-$TdisAmt;
$FvatTotalv = ($FvatTotal*$TdisPer)/100;
$FvatTotal = $FvatTotal-$FvatTotalv;
$saleSp = "exec ".dbObject."InsertSaleWeb
@Bid=$Bid
,@CSID=$CSID,@Comments=''
,@SPType=$SPType
,@Total=$FTOtal
,@Discount=$TdisAmt
,@DiscountPer=$TdisPer
,@NetTotal=$NetTotal
,@EmpID=$EmpID
,@PaidAmount=$TgrandTotal
,@changeAmt=0
,@GProfit=$GProfit
,@NProfit=$NProfit
,@totalCost=$TotalCost
,@totalVat=$FvatTotal
,@vatPTotal=$TgrandTotal
,@AvgVatPer=$AvgVatPer
,@NoVatDisTotal=$NoVatDisTotal
,@ToalAmtNoVat=$TotalAmtNoVat
,@VatDisTotal=$VatDisTotal
,@ToalAmtVatable=$ToalAmtVatable
,@RefNo1='".$RefNo1."'
,@posid=$posid
,@SalDetail='".$SalDetail."'
,@SalPayment='".$salPayment."'
,@sbid='".$sbid."',@CustomerName='".$CustomerName."'
,@IsExpImp=1
,@GetBill =0
,@GetNewBill =0
,@GetSBBillno =null
,@InvDTTime =0" ;
$execute = Run($saleSp);
$getData = myfetch($execute);
$SBBillno = $getData->InsertedBillno;


// Include zetca
include("../../Lib/zetca/vendor/autoload.php");

use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;


//// Generate QR Code////
 $PNG_WEB_DIR = './QrCodes/';
 $PNG_TEMP_DIR = './QrCodes/';
    
    //html PNG location prefix
    $PNG_WEB_DIR = './QrCodes/';
$vatno= $getLoginUserCompanyData->vat;
$CustomerName= $getLoginUserCompanyData->name;
$ddd = "Invoice Number: ".$SBBillno."
Sellers Name:".$CustomerName."
Vat No: ".$vatno."
Invoice Date & Time: ".date("Y-m-d H:i a",strtotime($bill_date_time))." 
Invoice Vat Total: ".$FvatTotal."
Invoice Total (with Vat): ".$TgrandTotal."
";
 if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);

$errorCorrectionLevel = 'H';
if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
$errorCorrectionLevel = $_REQUEST['level'];    

$matrixPointSize = 4;
if (isset($_REQUEST['size']))
$matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

$the_date = strtotime($bill_date_time);
date_default_timezone_set("UTC");
$date = date("Y-m-d\TH:i:s\Z", $the_date);

// data:image/png;base64, .........
$displayQRCodeAsBase64 = GenerateQrCode::fromArray([
  new Seller($CustomerName), // seller name        
  new TaxNumber($vatno), // seller tax number
  new InvoiceDate($date), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
  new InvoiceTotalAmount($TgrandTotal), // invoice total amount
  new InvoiceTaxAmount($FvatTotal) // invoice tax amount
  // TODO :: Support others tags
])->render();

function base64_to_jpeg($base64_string, $output_file) {
  // open the output file for writing
  $ifp = fopen( $output_file, 'wb' ); 

  // split the string on commas
  // $data[ 0 ] == "data:image/png;base64"
  // $data[ 1 ] == <actual base64 string>
  $data = explode( ',', $base64_string );

  // we could add validation here with ensuring count( $data ) > 1
  fwrite( $ifp, base64_decode( $data[ 1 ] ) );

  // clean up the file resource
  fclose( $ifp ); 

  return $output_file; 
}

$filename = $PNG_TEMP_DIR.'Sale-'.$SBBillno.'-'.$Bid.'-'.$_SESSION['companyId'].'.png';
file_put_contents($filename, file_get_contents($displayQRCodeAsBase64));

// $filename = $PNG_TEMP_DIR.'Sale-'.$SBBillno.'-'.$Bid.'-'.$_SESSION['companyId'].'.png';
// QRcode::png(($ddd), $filename, $errorCorrectionLevel, $matrixPointSize, 2); 

// Mobile Side Save
//// Generate QR Code////

$PNG_WEB_DIR = '../../../Mtech/vouchers/sales/QrCodes/';
$PNG_TEMP_DIR = '../../../Mtech/vouchers/sales/QrCodes/';

$filename = $PNG_TEMP_DIR.'Sale-'.$SBBillno.'-'.$Bid.'-'.$_SESSION['companyId'].'.png';
file_put_contents($filename, file_get_contents($displayQRCodeAsBase64));

   
   //html PNG location prefix

// $vatno= $getLoginUserCompanyData->vat;
// $CustomerName= $getLoginUserCompanyData->name;
// $ddd = "Invoice Number: ".$SBBillno."
// Sellers Name:".$CustomerName."
// Vat No: ".$vatno."
// Invoice Date & Time: ".date("Y-m-d H:i a",strtotime($bill_date_time))." 
// Invoice Vat Total: ".$FvatTotal."
// Invoice Total (with Vat): ".$TgrandTotal."
// ";
// if (!file_exists($PNG_TEMP_DIR))

// $errorCorrectionLevel = 'H';
// if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
// $errorCorrectionLevel = $_REQUEST['level'];    

// $matrixPointSize = 4;
// if (isset($_REQUEST['size']))
// $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

// $filename = $PNG_TEMP_DIR.'Sale-'.$SBBillno.'-'.$_SESSION['companyId'].'.png';
// QRcode::png(($ddd), $filename, $errorCorrectionLevel, $matrixPointSize, 2); 


?>


<script>
$( document ).ready(function() {
<?php
if($getData->InsertedBillno!='')
{
?>
saveFinalStep('<?=$getData->InsertedBillno?>','<?=$Bid?>');
<?php
}
?>

});

</script>