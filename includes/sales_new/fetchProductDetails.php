<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
$code = addslashes(trim($_POST['code']));
$Bid = addslashes(trim($_POST['Bid']));
$Uid = addslashes(trim($_POST['Uid']));

$region = $_SESSION['region'];
if($region=='1')
{
$sp = "EXECUTE ".dbObject."GetProductSearchByCodeUnitWeb  @pCode='$code' ,@bid='$Bid',@uid='".$Uid."'";
}
if($region=="2")
{
$sp = "EXECUTE ".dbObject."GetProductSearchByCodeUnitWeb  @pCode='$code' ,@bid='$Bid',@uid='".$Uid."'";
}
$QueryMax = Run($sp);
$getDetails = myfetch($QueryMax);
$Pid = $getDetails->pid;
$Uid = $getDetails->UID;

////////////// Get Open Stock Of Current Product////////
 $qf = "Select * from ".dbObject."OpenStock where Pid = '".$Pid."' and Bid = '".$Bid."' and UID = '".$Uid."'";
$openStockQuery = Run($qf);
$openStock = myfetch($openStockQuery)->Qty;
$openStock = !empty($openStock) ? $openStock: '0';

//////////////////////////////////////////////



$PCode = $getDetails->pcode;
$pname = $getDetails->pname;
$ParaName = $getDetails->ParaName;
$SPrice = $getDetails->SPrice;
$vatSPrice = $getDetails->vatSPrice;
$level3 = $getDetails->level3;
$PPrice = $getDetails->PPrice;
$IsVat = $getDetails->IsVat;
$vatPer = $getDetails->vatPer;
$vatAmt = $getDetails->vatAmt;











if($IsVat=="1")
{
$SPrice = $SPrice;
$vatSprice = $vatSPrice;
$vatAmt = $vatAmt;	



$NewSp = Run("Exec ".dbObject."GetVatValueFromSalPrice @vatPer=$vatPer,@SPrice=$SPrice");
$getV = myfetch($NewSp);
$vatAmt = round($getV->vatAmt,2);	
if($vatSPrice==0)
{
$vatSprice = $getV->vatSprice;	
}


}

if($IsVat==0)
{
$vatSprice = $SPrice;
$vatAmt = 0;
$vatPer = 0;
}


?>


<script>
$( document ).ready(function() {
$("#Sprice").val('<?=$SPrice?>');
$("#Sprice").prop("readonly", false);
$("#vatSprice").val('<?=$vatSprice?>');
$("#vatSprice").prop("readonly", true);
$("#vatPer").val('<?=$vatPer?>');
$("#vatAmt").val('<?=$vatAmt?>');
$("#isVat").val('<?=$IsVat?>');
$("#qty").val('1');
$("#openStock").val('<?=$openStock?>');

<?php
if($IsVat!=0)
{
?>

Pricecalculations('<?=$vatSprice?>','Sprice')
<?php
}
?>

});
</script>


