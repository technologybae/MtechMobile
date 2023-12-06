<?php
@session_start();
error_reporting(0);
$lang = $_SESSION['lang'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="assets/fonts/barlow/stylesheet.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<title>Mtech Mobile</title>
<style>
.ar {
text-align: right;
<?php if($lang == 1) {echo "display: none;";} ?>
}

.direction {
<?php if($lang == 1) {echo " direction: ltr;";} else { echo "direction: rtl;";} ?>
}

.direction-ltr {
direction: ltr !important;
}

.direction-rtl {
direction: rtl !important;
}

.en {
text-align: left;
<?php if($lang == 2) {echo "display: none;";} ?>
}

.form-label{
display: grid;
}

.enBtn {
<?php if ($lang == 2) {
echo "display: none;";
} ?>
}

.arBtn {
<?php if ($lang == 1) {
echo "display: none;";
} ?>
}
.form_list p{
display: flex !important;
}
</style>
</head>

<body>
<?php
include("header.php");
?>
<form id="Form_voucher">
<section>

<div class="slide-form justify-content-center">
<div id="saveSalesForm"></div>
<div class="slide-box glass">
<div class="content">
<h2 class="heading_fixed enBtn">Receipt Voucher</h2>
<h2 class="heading_fixed arBtn"><?= getArabicTitle('Receipt Voucher') ?></h2>
</div>
<div class="content_form">
<div class="form_list">
<div class="mb-3">
<label for="" class="form-label"><span class="en">Branch</span><span class="ar"> <?= getArabicTitle('Branch') ?></span></label>
<div>
<select class="form-select direction" name="Bid" id="Bid">
<?php

	if ($_SESSION['isAdmin'] == '1') {
		$Bracnhes = Run("Select * from " . dbObject . "Branch order by BName ASC");
	} else {
		$Bracnhes = Run("Select " . dbObject . "Branch.Bid," . dbObject . "Branch.BName from " . dbObject . "Branch Inner JOIN " . dbObject . "EMP  On " . dbObject . "EMP.BID = " . dbObject . "Branch.Bid where " . dbObject . "EMP.WebCode = '" . $_SESSION['code'] . "' ");
	}

	while ($getBranches = myfetch($Bracnhes)) {
		$selected = "";
		//if ($_GET['branc'] != '') 
		{
			if ($getBranches->ismain == '1') {
				$selected = "Selected";
			}
		}
	?>
		<option value="<?php echo $getBranches->Bid; ?>" <?php echo $selected; ?>><?php echo $getBranches->BName; ?></option>
	<?php
	}

	?>
</select>
</div>
</div>
<div class="mb-3 overflow-hidden">
<button type="button" class="btn btn-success btn-actions float-end submit-next enBtn" onclick="next(this);">Next <i class="fa fa-arrow-right icon-font"></i></button>
<button type="button" class="btn btn-success btn-actions float-end submit-next arBtn" onclick="next(this);"><i class="fa fa-arrow-right icon-font"></i> <?= getArabicTitle('Next') ?></button>
</div>
</div>
</div>
<div class="m-5"></div>
</div>

<div class="slide-box slided glass">
<div class="content">
<h2 class="heading_fixed enBtn">Receipt Voucher</h2>
<h2 class="heading_fixed arBtn"><?= getArabicTitle('Receipt Voucher') ?></h2>
</div>
<div class="content_form">
<div class="form_list">
<div class="mb-3">

<?php /*?><label for="" class="form-label">Receipt # :</label> <?= $Bno ?><?php */ ?></div>
<div class="mb-3">
<label for="" class="form-label"><span class="en">Date :</span><span class="ar"><?= getArabicTitle('Date') ?> :</span></label>
<input value="<?= date("Y-m-d H:i:s") ?>" id="bill_date_time" name="bill_date_time" type="datetime-local" class="form-control direction">
</div>
<div class="mb-3">
<label for="" class="form-label"><span class="en">Reference no :</span><span class="ar"><?= getArabicTitle('Reference no') ?> :</span></label>
<input type="number" class="form-control direction" name="RefNo1" id="RefNo1">
</div>
<div class="mb-3">
<label for="" class="form-label"><span class="en">Sales Man :</span><span class="ar"><?= getArabicTitle('Sales Man') ?> :</span></label>
<div>
<select class="form-select direction" id="salesMan" name="EmpID" aria-label="sales-men">
<?php
if ($_SESSION['isAdmin'] == '1') {
$SalesMan = Run("select  Cid Id,CCode + ' - ' + Cname CName from Emp Where  isnull(IsDeleted,0)=0  order by Cid");
} else {
$SalesMan = Run("select  Cid Id,CCode + ' - ' + Cname CName from Emp Where  isnull(IsDeleted,0)=0 and webCode = '" . $_SESSION['code'] . "'  order by Cid");
}


while ($getSalesMan = myfetch($SalesMan)) {
$selected = "";

?>
<option value="<?php echo $getSalesMan->Id; ?>" <?php echo $selected; ?>><?php echo $getSalesMan->CName; ?></option>
<?php
}

?>
</select>
</div>
</div>
<div class="mb-3 overflow-hidden">
<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i> Back</button>
<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="prev(this);"><?= getArabicTitle('Back') ?> <i class="fa fa-arrow-right icon-font"></i></button>

<button type="button" class="btn btn-success btn-actions float-end submit-next enBtn" onclick="validateRefrenceNo(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
<button type="button" class="btn btn-success btn-actions float-end submit-next arBtn" onclick="validateRefrenceNo(this)"><i class="fa fa-arrow-left icon-font"></i> <?= getArabicTitle('Next') ?></button>
</div>
</div>
</div>
<div class="m-5"></div>
</div>

<div class="slide-box slided glass">
<div class="content">
<h2 class="heading_fixed enBtn">Receipt Voucher</h2>
<h2 class="heading_fixed arBtn"><?= getArabicTitle('Receipt Voucher') ?></h2>
<p id="fetchProductDetails"></p>
</div>
<div class="content_form">
<div class="form_list">

<div class="mb-3">
<label for="" class="form-label"><span class="en">Customer</span><span class="ar"><?= getArabicTitle('Customer') ?></span></label>
<div>
<select id="customer_id" name="customer_id" class="js-states form-control direction">

</select>
</div>
</div>

<!-- <div class="mb-3 overflow-hidden">
<button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back</button>
<button type="button" class="btn btn-success btn-actions float-end submit-next" onclick="customerCheck(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
</div> -->

<div class="mb-3 overflow-hidden">
<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i> Back</button>
<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="prev(this);"><?= getArabicTitle('Back') ?> <i class="fa fa-arrow-right icon-font"></i></button>

<button type="button" class="btn btn-success btn-actions float-end submit-next enBtn" onclick="customerCheck(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
<button type="button" class="btn btn-success btn-actions float-end submit-next arBtn" onclick="customerCheck(this)"><i class="fa fa-arrow-left icon-font"></i> <?= getArabicTitle('Next') ?></button>
</div>
</div>
</div>
<input type="hidden" name="row_count" id="row_count" value="1">
</div>

<div class="slide-box slided glass">
<div class="content">
<h2 class="heading_fixed enBtn">Receipt Voucher</h2>
<h2 class="heading_fixed arBtn"><?= getArabicTitle('Receipt Voucher') ?></h2>
</div>
<div class="content_form">
<div class="form_list">
<div id="customerCheck">

</div>

<div class="mb-3 overflow-hidden">
<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back</button>
<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="prev(this);"><?= getArabicTitle('Back') ?>&nbsp;<i class="fa fa-arrow-right icon-font"></i></button>

<button type="button" class="btn btn-success btn-actions float-end submit-next enBtn" id="finishSave" onclick="saveVoucher(this)">Next <i class="fa fa-arrow-right"></i></button>
<button type="button" class="btn btn-success btn-actions float-end submit-next arBtn" id="finishSave" onclick="saveVoucher(this)"><i class="fa fa-arrow-left"><?= getArabicTitle('Next') ?></i></button>
</div>
</div>
</div>

</div>





<div class="slide-box slided glass">
<div id="saveVoucher">
<button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back
</button>

</div>
</div>
</div>
</section>
</form>

<!-- Modal -->
<div class="modal fade" id="emailpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLongTitle" style="text-align: center">Send Email</h5>
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                    <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
</div>
<div id="sendemailform"></div>
<form action="javascript:sendemailform()">
<div class="modal-body">
<label>Email</label>
<input type="email" name="email" id="email" placeholder="Enter Email" class="form-control" required>
<input type="hidden" name="bill_id" id="bill_id">
<input type="hidden" name="b_id" id="b_id">

<label class="mt-2">Language</label>
<select class="form-control ">
<option value="1">English</option>
<option value="2">Arabic</option>
</select>
</div>
<div class="modal-footer">
<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<button type="submit" class="btn btn-primary">Send</button>
</div>
</form>
</div>
</div>
</div>

<div class="modal fade" id="ignismyModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" role="dialog">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h2>Email Notification</h2>
</div>
<div class="modal-body">
<div class="thank-you-pop" style="text-align: center;">
<img style="height: 50% !important; width: 15% !important;" src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="">
<h1>Email Sent!</h1>
<!--                            <p>Your submission is received and we will contact you soon</p>-->
<!--                            <h3 class="cupon-pop">Your Id: <span>12345</span></h3>-->
</div>
</div>

</div>
</div>
</div>
<?php

include("footer.php");

?>
</body>
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="includes/receipt/js.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

</html>