<?php









function getSalePrintTemplateNew($Billno,$Bid,$LanguageId)
{
	
$Bid = $Bid;
$Bid = !empty($Bid) ? $Bid: '1';
$Billno = $Billno;
$Billno = !empty($Billno) ? $Billno: '0';
$sBid = !empty($sBid) ? $sBid: '1';
$LanguageId = $LanguageId;
$LanguageId = !empty($LanguageId) ? $LanguageId: '1';
$abc = "Exec ".dbObject."SPSalesReturnSelectWeb @SrchBy=1,@Billno=$Billno,@Bid=$Bid,@sBid=1,@LanguageId=$LanguageId,@FRecNo=0,@ToRecNo=1";

$storeProcedure = Run($abc);
$myFetch = myfetch($storeProcedure);
$Billno = $myFetch->BillNo;
$SPType = $myFetch->SPType;
$CSID = $myFetch->CSID;
$customer = '';
if($CSID!='')
{
$customer = getCustomerDetails($CSID)->CName;
}
$typ = "Cash";
if($SPType!='1')
{
$typ = "Credit";
}
$html = '<table style=" margin: 0 auto; border: 1px solid gray; border-spacing: 8px 1px;">
<tr>
<td colspan="2" style="padding: 20px;">
</td>
<th colspan="2"  style="font-size: 25px; font-weight: 600;">
<span style="background: #cfe2f3; padding: 4px;">Mtech</span>
</th>
</tr>
<tr>
<th style="text-align: left; padding: 8px " >Invoice No</th>
<td style="background: #cfe2f3; color: #606060; padding: 8px;">'.$myFetch->sbBillno.'</td>
<th style="text-align: left; padding: 8px " >Ref No</th>
<td style="background: #cfe2f3; color: #606060; padding: 8px;">'.$myFetch->RefNo.'</td>
</tr>
<tr>
<th style="text-align: left; padding: 8px " >Issue Date</th>
<td style="background: #cfe2f3; padding: 8px;">'.DateVal($myFetch->BillDate).'</td>
<th style="text-align: left; padding: 8px " >Branch</th>
<td style="background: #cfe2f3; padding: 8px;">
'.$myFetch->BranchName.'
</td>
</tr>
<tr>
<th style="text-align: left; padding: 8px " >Type</th>
<td style="background: #cfe2f3; padding: 8px;">
'.$typ.'
</td>
<th style="text-align: left; padding: 8px " >Customer</th>
<td style="background: #cfe2f3; padding: 8px;">
'.$customer.'
</td>	
</tr>
<tr>
<th style="text-align: left; padding: 8px " >Shop Name</th>
<td style="background: #cfe2f3; padding: 8px;">
'.$myFetch->CustomerName.'
</td>	
</tr>
<tr>
<td colspan="8">
<table style=" margin: 0 auto; border: 1px solid gray; border-spacing: 8px 1px;">
<tr style="height: 40px; background: #cfe2f3;">
<th style="text-align: center;">
Item
</th>
<th style="text-align: center;">
Qty
</th>
<th style="text-align: center;">
Price
</th>
<th style="text-align: center;">
Total
</th>
<th style="text-align: center;">
VAT %
</th>
<th style="text-align: center;">
Vat Amt
</th>
<th style="text-align: center;">
GrandTotal</th>
</tr>';
$qtyTot = 0;
$PriceTot = 0;
$TotalTot = 0;
$vatperTot = 0;
$vatamtTot = 0;
$GrTotal = 0;
$detQuery = "EXECUTE ".dbObject."SPSalReturnDetailSelectWeb @Billno=$Billno,@Bid=$Bid,@sBid=$sBid,@SrchBy=1,@FRecNo=0,@ToRecNo=1";
$detailsSp = Run($detQuery);	
while($getDetails = myfetch($detailsSp))
{
$qtyTot = $qtyTot+$getDetails->Qty;
$PriceTot = $PriceTot+$getDetails->Price;
$TotalTot = $TotalTot+$getDetails->Total;
$vatperTot = $vatperTot+$getDetails->vatPer;
$vatamtTot = $vatamtTot+$getDetails->vatAmt;
$GrTotal = $GrTotal+$getDetails->vatPTotal;
$html .='<tr><td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;">'.$getDetails->PCode.'-'.$getDetails->PName.'</td><td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;">'.$getDetails->Qty.'</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;">'.AmtValue($getDetails->Price).'
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;">'.AmtValue($getDetails->Total).'
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;">'.AmtValue($getDetails->vatPer).'
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;">'.AmtValue($getDetails->vatAmt).'
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;">'.AmtValue($getDetails->vatPTotal).'
</td>
</tr>';

}








$html.='
</tr><tr>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;">
Totals
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px; font-weight: bold">
'.$qtyTot.'
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;font-weight: bold">
'.AmtValue($PriceTot).'
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;font-weight: bold">
'.AmtValue($TotalTot).'
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;font-weight: bold">
'.AmtValue($vatperTot).'
</td><td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;font-weight: bold">
'.AmtValue($vatamtTot).'
</td><td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;font-weight: bold">'.AmtValue($GrTotal).'
</td>	
</tr>
<tr>
<td style="border-bottom: solid; padding-top: 20px;" colspan="8"></td>
</tr>';


$html .= '<tr>
<td style="text-align: right; border: 1px solid #dfe3e7; height: 30px;" colspan="6">
Total
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;font-weight: bold">'.AmtValue($myFetch->Total).'
</td>	
</tr>
<tr>
<td style="text-align: right; border: 1px solid #dfe3e7; height: 30px;" colspan="6">
Discount %
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;font-weight: bold">'.AmtValue($myFetch->DisPer).'
</td>	
</tr>
<tr>
<td style="text-align: right; border: 1px solid #dfe3e7; height: 30px;" colspan="6">
Discount
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;font-weight: bold">'.AmtValue($myFetch->Discount).'
</td>	
</tr>
<tr>
<td style="text-align: right; border: 1px solid #dfe3e7; height: 30px;" colspan="6">
Net Total
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;font-weight: bold">'.AmtValue($myFetch->NetTotal).'
</td>	
</tr>
<tr>
<td style="text-align: right; border: 1px solid #dfe3e7; height: 30px;" colspan="6">
Vat
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;font-weight: bold">'.AmtValue($myFetch->totalVat).'
</td>	
</tr>
<tr>
<td style="text-align: right; border: 1px solid #dfe3e7; height: 30px;" colspan="6">
Grand Total
</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;font-weight: bold">'.AmtValue($myFetch->vatPTotal).'
</td>	
</tr>
<tr>
<td style="border-bottom: solid; padding-top: 20px;" colspan="8"></td>
</tr></table>';

if($myFetch->SPType=='1')
{
$qs = "EXECUTE ".dbObject."SPSalRetPaymentSelectWeb  @Billno=$Billno,@Bid=$Bid,@sBid=$sBid";
$paY = Run($qs);
$html .='
<tr>
<td colspan="8">
<table style="width: 100%;">
<tr style="height: 40px; background: #cfe2f3;">
<th style="text-align: center;">
Name
</th>
<th style="text-align: center;">
Amount
</th>
<th style="text-align: center;">
Remaining
</th></tr>
';		

while($getPayment = myfetch($paY))	
{

$html .='<tr>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;">'.$getPayment->snameArb.'</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;">'.AmtValue($getPayment->amount).'</td>
<td style="text-align: center; border: 1px solid #dfe3e7; height: 30px;">'.AmtValue($getPayment->remAmount).'</td></tr>';


}
}



$html .='
</table></table>
</td>
</tr>
</table>';

return $html;



}







?>