<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
$Billno = $_POST['SBBillno'];

$Bid = $_POST['Bid'];
$Bid = !empty($Bid) ? $Bid: '1';

$Billno = !empty($Billno) ? $Billno: '0';

$LanguageId = $_POST['LanguageId'];
$LanguageId = !empty($LanguageId) ? $LanguageId: '1';
$storeProcedure = Run("Exec [dbo].[SPSalesSelectWeb] @SrchBy=1,@Billno=$Billno,@Bid=$Bid,@sBid=1,@LanguageId=$LanguageId,@FRecNo=0,@ToRecNo=1");
$myFetch = myfetch($storeProcedure);
$CSID = $myFetch->CSID;
	if($CSID)
	{
		$qu = Run("Select Email from CustFile where Cid = '".$CSID."'");
		$getCData = myfetch($qu);
		$email = $getCData->Email;
	}

?>
<div class="content">
<h2 class="heading_fixed">Sales Voucher</h2>
</div>
<div class="content_form" >


<div class="mb-3">
<label for="" class="form-label">Generated BillNo :</label>
<b><?=$Billno?></b></div>
	
	
	
<div class="mb-3">
<a href="#" onclick="openPopup('<?=$Billno?>','<?=$Bid?>','<?=$email?>')"  class="btn btn-light d-block p-3">
<span class="icons_d"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
Email</a>
</div>
<div class="mb-3">
<a href="javascript:openPrintPopup('<?=$Billno?>','<?=$Bid?>');"   class="btn btn-light d-block p-3">
<span class="icons_d"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
Watsapp</a>
</div>
<div class="mb-3">
<a href="javascript:openPrintPopup('<?=$Billno?>','<?=$Bid?>');"   class="btn btn-light d-block p-3">

	
	

<span class="icons_d"><i class="fa fa-print" aria-hidden="true"></i></span>
Print</a>
</div>
<div>
<div class="mb-3 overflow-hidden">
<button type="button" class="btn btn-info btn-actions float-start back text-white"
onclick="location.reload()"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Generate New
</button>
</div>
</div>
</div>
