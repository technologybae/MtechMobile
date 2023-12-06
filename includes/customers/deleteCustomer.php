<?php
session_start();
error_reporting(0);
include("../../config/connection.php");

$bid = addslashes(trim($_POST['bid']));
$CCode = addslashes(trim($_POST['CCode']));



 $insertion = "delete from CustFile where CCode='".$CCode."' and bid='".$bid."' ";
$run = Run($insertion);
if($run)
{
	?>
<script>
loadPage('list_customers.php?value=deleted');
</script>
<?php
}
?>


