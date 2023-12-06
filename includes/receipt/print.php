<?php
use Mpdf\Mpdf;
session_start();
//error_reporting(0);
include("../../config/connection.php");
include("../../config/functions.php");
include("../../config/main_connection.php");
include("../../config/main_functions.php");
include("../../config/templates.php");
$CSID = $_REQUEST['CSID'];
$Bid = $_REQUEST['Bid'];
$Bid = !empty($Bid) ? $Bid: '2';


$Billno = $_REQUEST['Billno'];
$Billno = !empty($Billno) ? $Billno: '0';

$LanguageId = $_REQUEST['LanguageId'];
$LanguageId = !empty($LanguageId) ? $LanguageId: '1';


$storeProcedure = Run("Select * from Receipt where BillNO = '".$Billno."'");
$myFetch = myfetch($storeProcedure);
$Billno = $myFetch->BillNO;

if($Billno=='')
{
echo "No Records Found..";
}
else
{
	require '../../Lib/mpdf/vendor/autoload.php';



$sale_invoice = getReceiptPrintTemplate($Billno,$Bid,$LanguageId, $CSID);
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;

if($LanguageId=='2')
{
$mpdf->SetDirectionality('rtl');
}
$language = "en";
if($LanguageId=='2')
{
$language = "ar";

}

$mpdf->WriteHTML($sale_invoice);
//$mpdf->Output();
$mpdf->Output('RecInvoice-'.$language.'-'.$Billno.'.pdf', 'D');	
	
	
	


}
?>