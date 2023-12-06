<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
include("../../config/functions.php");
$Bid = $_POST['Bid'];
$Bid = !empty($Bid) ? $Bid : '1';

$Billno = $_POST['Billno'];
$Billno = !empty($Billno) ? $Billno : '0';

$LanguageId = $_POST['LanguageId'];
$LanguageId = !empty($LanguageId) ? $LanguageId : '1';

$lang = $_SESSION['lang'];
$enDisplay = $lang == 1 ? 'block' : 'none';
$arDisplay = $lang == 2 ? 'block' : 'none';

$storeProcedure = Run("Select * from Receipt where BillNO = '" . $Billno . "'");
$myFetch = myfetch($storeProcedure);
$Billno = $myFetch->BillNO;
if ($Billno == '') {
	if ($_SESSION['lang'] == 1) {
		echo '<p style="margin: 0 auto; width: fit-content;">No Records Found...</p>';
	} else {
		$ara = getArabicTitle('No Records Found');
		echo '<p style="margin: 0 auto; width: fit-content;">' . $ara . '...</p>';
	}
} else {


	$CSID = $myFetch->CSID;
	if ($CSID) {
		$qu = Run("Select Email from CustFile where Cid = '" . $CSID . "'");
		$getCData = myfetch($qu);
		$email = $getCData->Email;
	}
?>
	<script>
		$('#printInvoice').html();
	</script>
	<div class="content_form">

		<div class="mb-3">
			<a href="#" onclick="openPopup('<?= $Billno ?>','<?= $Bid ?>','<?= $email ?>')" class="btn btn-light p-3 enBtn" style=" display:<?= $enDisplay?>">
				<span class="icons_d"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
				Email
			</a>

			<a href="#" onclick="openPopup('<?= $Billno ?>','<?= $Bid ?>','<?= $email ?>')" class="btn btn-light p-3 arBtn"  style=" display:<?= $arDisplay; ?>;">
				<?= getArabicTitle('Email') ?>
				<span class="icons_d"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
			</a>
		</div>

		<div class="mb-3">
			<a href="includes/receipt/print.php?Billno=<?= $Billno ?>&Bid=<?= $Bid ?>&LanguageId=<?= $LanguageId ?>" target="_blank" class="btn btn-light p-3 enBtn" style="display:<?= $enDisplay?>;">
				<span class="icons_d"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
				Whatsapp</a>

			<a href="includes/receipt/print.php?Billno=<?= $Billno ?>&Bid=<?= $Bid ?>&LanguageId=<?= $LanguageId ?>" target="_blank" class="btn btn-light p-3 arBtn"  style="display:<?= $arDisplay; ?>;">
				<?= getArabicTitle('Whatsapp') ?>
				<span class="icons_d"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
			</a>
		</div>

		<div class="mb-3">
			<a href="includes/receipt/print.php?Billno=<?= $Billno ?>&Bid=<?= $Bid ?>&LanguageId=<?= $LanguageId ?>" target="_blank" class="btn btn-light p-3 enBtn" style="display:<?= $enDisplay?>;">
				<span class="icons_d"><i class="fa fa-print" aria-hidden="true"></i></span>
				Print</a>
			<a href="includes/receipt/print.php?Billno=<?= $Billno ?>&Bid=<?= $Bid ?>&LanguageId=<?= $LanguageId ?>" target="_blank" class="btn btn-light p-3 arBtn"  style="display:<?= $arDisplay; ?>;">
				<?= getArabicTitle('Print') ?>
				<span class="icons_d"><i class="fa fa-print" aria-hidden="true"></i></span>
			</a>
		</div>

		<div class="mb-3 overflow-hidden">
			<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="location.reload()"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back</button>
			<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="location.reload()"><?= getArabicTitle('Back') ?> <i class="fa fa-arrow-right icon-font"></i></button>
		</div>
	</div>


<?php
}
?>