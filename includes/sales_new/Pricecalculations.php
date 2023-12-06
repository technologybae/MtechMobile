<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
$vvl = addslashes(trim($_POST['vvl']));
$tp = addslashes(trim($_POST['tp']));
$vatPer = addslashes(trim($_POST['vatPer']));
$vatAmt = addslashes(trim($_POST['vatAmt']));
$qty = $_POST['qty'];
if($tp=='vatSprice')
{
$Sprice = $vvl*$qty;
  $abx = "Exec ".dbObject."GetVatValueFromSalPrice @vatPer=$vatPer,@SPrice=$Sprice";
$NewSp = Run($abx);
$getV = myfetch($NewSp);
$vatAmt = round($getV->vatAmt,2);	
 $VatSPrice = round($getV->VatSPrice,2);
?>
<script>
$( document ).ready(function() {
$("#vatSprice").val('<?=$VatSPrice?>');
$("#vatPer").val('<?=$vatPer?>');
$("#vatAmt").val('<?=$vatAmt?>');
});
</script>

<?php
}


if($tp=='Sprice')
{/*
$vatSPrice = $vvl;
$NewSp = Run("Exec ".dbObject."GetVatValueFromVatAddedPrice @vatPer=$vatPer,@vatSPrice=$vatSPrice");
$getV = myfetch($NewSp);
//$vatAmt = round($getV->vatAmt,2);	
$SPrice = round($getV->SPrice,2);
?>
<script>
$( document ).ready(function() {
$("#SPrice").val('<?=$SPrice?>');
$("#vatPer").val('<?=$vatPer?>');
$("#vatAmt").val('<?=$vatAmt?>');
});
</script>

<?php
*/}


?>





