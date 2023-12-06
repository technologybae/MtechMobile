<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
$code = addslashes(trim($_POST['code']));
$Bid = addslashes(trim($_POST['Bid']));

$region = $_SESSION['region'];
if($region=='1')
{
$sp = "EXECUTE ".dbObject."GetProductSearchByCode @pCode='$code' ,@bid='$Bid'";
}
if($region=="2")
{
$sp = "EXECUTE ".dbObject."Getproductsearchbycodeweb @pCode='$code' ,@bid='$Bid'";
}
$QueryMax = Run($sp);
$getDetails = myfetch($QueryMax);
$Pid = $getDetails->pid;
$Uid = $getDetails->UID;
//$Uid = 2;
$que = "Select ppc.uid, paraname from productpricecode ppc, units U, 
product P where ppc.pid=p.pid and ppc.uid=u.paraid and ppc.bid='".$Bid."' and pcode='".$code."'";
$qst = Run($que);
?>
<select class="form-select" name="unit_id" id="unit_id" aria-label="unit_id" onChange="LoadUnitPrice(this.value,'<?=$code?>')">
<option value="">Please Select Unit</option>
<?php
while($loadUnits = myfetch($qst))
{
$selected = "";
	
if($Uid==$loadUnits->uid)
{
$selected = "Selected";
?>
<script>
$("#unit").val('<?=$loadUnits->paraname?>');
</script>
<?php
}
?>	
<option value="<?=$loadUnits->uid?>"  <?=$selected?> ><?=$loadUnits->paraname?></option>	
<?php	
}


?>	
	
</select>

<script>
fetchProductDetails('<?php echo $code ?>','<?=$Uid?>');

</script>


