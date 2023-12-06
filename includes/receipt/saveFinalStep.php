<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
include("../../config/functions.php");
$Billno = $_POST['SBBillno'];

$Bid = $_POST['Bid'];
$Bid = !empty($Bid) ? $Bid : '1';

$Billno = !empty($Billno) ? $Billno : '0';

$LanguageId = $_POST['LanguageId'];
$LanguageId = !empty($LanguageId) ? $LanguageId : '1';

$lang = $_SESSION['lang'];
$enDisplay = $lang == 1 ? 'block' : 'none';
$arDisplay = $lang == 2 ? 'block' : 'none';

$storeProcedure = Run("Select * from Receipt where BillNO = '" . $Billno . "'");
$myFetch = myfetch($storeProcedure);
$CSID = $myFetch->CustomerID;
if ($CSID) {
	$qu = Run("Select Email from CustFile where Cid = '" . $CSID . "'");
	$getCData = myfetch($qu);
	$email = $getCData->Email;
}

?>
<div class="content">
	<h2 class="heading_fixed enBtn">Receipt Voucher</h2>
	<h2 class="heading_fixed arBtn"><?= getArabicTitle('Receipt Voucher') ?></h2>
</div>
<div class="content_form">


	<div class="mb-3">
		<label for="" class="form-label enBtn">Generated BillNo :<b style="display: contents;"><?= $Billno ?></b></label>
		<label for="" class="form-label arBtn"><b style="display: contents;"><?= $Billno ?></b><?= getArabicTitle('Generated BillNo') ?> :</label>
	</div>

	<div class="mb-3">
		<a href="#" onclick="openPopup('<?= $Billno ?>','<?= $Bid ?>','<?= $email ?>')" class="btn btn-light p-3 enBtn" style="background-color: #34465d; display:<?= $enDisplay?>">
			<span class="icons_d"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
			Email
		</a>

		<a href="#" onclick="openPopup('<?= $Billno ?>','<?= $Bid ?>','<?= $email ?>')" class="btn btn-light p-3 arBtn"  style="display:<?= $arDisplay; ?>;">
			<?= getArabicTitle('Email') ?>
			<span class="icons_d"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
		</a>
	</div>

	<div class="mb-3">
		<a href="includes/receipt/print.php?Billno=<?= $Billno ?>&Bid=<?= $Bid ?>&LanguageId=<?= $LanguageId ?>&CSID=<?= $CSID?>" target="_blank" class="btn btn-light p-3 enBtn" style="background-color: #34465d; display:<?= $enDisplay?>;">
			<span class="icons_d"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
			Whatsapp</a>

		<a href="includes/receipt/print.php?Billno=<?= $Billno ?>&Bid=<?= $Bid ?>&LanguageId=<?= $LanguageId ?>&CSID=<?= $CSID?>" target="_blank" class="btn btn-light p-3 arBtn"  style="display:<?= $arDisplay; ?>;">
			<?= getArabicTitle('Whatsapp') ?>
			<span class="icons_d"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
		</a>
	</div>

	<div class="mb-3">
		<a href="includes/receipt/print.php?Billno=<?= $Billno ?>&Bid=<?= $Bid ?>&LanguageId=<?= $LanguageId ?>&CSID=<?= $CSID?>" target="_blank" class="btn btn-light p-3 enBtn" style="background-color: #34465d; display:<?= $enDisplay?>;">
			<span class="icons_d"><i class="fa fa-print" aria-hidden="true"></i></span>
			Print</a>
		<a href="includes/receipt/print.php?Billno=<?= $Billno ?>&Bid=<?= $Bid ?>&LanguageId=<?= $LanguageId ?>&CSID=<?= $CSID?>" target="_blank" class="btn btn-light p-3 arBtn"  style="display:<?= $arDisplay; ?>;">
			<?= getArabicTitle('Print') ?>
			<span class="icons_d"><i class="fa fa-print" aria-hidden="true"></i></span>
		</a>
	</div>

	<div>
		<div class="mb-3 overflow-hidden">
			<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="location.reload()"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Generate New</button>
			<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="location.reload()"><?= getArabicTitle('Generate New') ?> <i class="fa fa-arrow-right icon-font"></i></button>
		</div>
	</div>
</div>