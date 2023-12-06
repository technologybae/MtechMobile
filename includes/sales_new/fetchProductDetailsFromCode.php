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
$pname = $getDetails->pname;

if($Pid!='')
{
?>	
<script>
getProductList('<?php echo $code ?>');
fetchProductUnits('<?php echo $code ?>');
</script>	
<?php	
}


?>






