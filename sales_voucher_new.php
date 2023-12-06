<?php
@session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="assets/fonts/barlow/stylesheet.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<title>Mtech Mobile</title>
</head>

<body>
<?php
include("header.php");
?>
<form id="sales_voucher">
<section>

<div class="slide-form justify-content-center">
<div id="saveSalesForm"></div>
<div class="slide-box  glass">
<div  class="content">
<h2 class="heading_fixed">Sales Voucher</h2>
</div>
<div class="content_form">
<div class="form_list">
<div class="mb-3">
<label for="" class="form-label">Branch </label>
<div>
<select class="form-select" name="Bid" id="Bid" aria-label="sales-men" onChange="loadBanks(this.value)">
<?php


if($_SESSION['isAdmin']=='1')
{
$Bracnhes = Run("Select * from " . dbObject . "Branch order by BName ASC");
}
else
{
$Bracnhes = Run("Select ".dbObject."Branch.Bid,".dbObject."Branch.BName from " . dbObject . "Branch
Inner JOIN ".dbObject."EMP  On ".dbObject ."EMP.BID = ".dbObject."Branch.Bid
where ".dbObject."EMP.WebCode = '".$_SESSION['code']."' "); 
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
<option value="<?php echo $getBranches->Bid; ?>" <?php echo $selected; ?> ><?php echo $getBranches->BName; ?></option>
<?php
}

?>
</select>
</div>
</div>
<div class="mb-3 overflow-hidden">

<button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="loadPage('sales_voucher_type.php');"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back
</button>	


<button type="button" class="btn btn-success btn-actions float-end submit-next"
onclick="next(this);loadBanks(Bid.value)">Next <i class="fa fa-arrow-right icon-font"></i></button>
</div>
</div>
</div>
<div class="m-5"></div>
</div>
<div class="slide-box slided glass">
<div  class="content">
<h2 class="heading_fixed">Sales Voucher</h2>
</div>
<div class="content_form">
<div class="form_list">

<div class="mb-3">
<label for="" class="form-label">Date :</label>
<input value="<?= date("Y-m-d H:i:s") ?>" id="bill_date_time"
name="bill_date_time"  type="datetime-local"
class="form-control"></div>
<div class="mb-3">
<label for="" class="form-label"> Reference no </label>
<input type="number" class="form-control" name="RefNo1" id="RefNo1">
</div>
<div class="mb-3">
<label for="" class="form-label">Sales Man </label>
<div>
<select class="form-select" id="salesMan" name="EmpID" aria-label="sales-men">
<?php
if($_SESSION['isAdmin']=='1')
{
$SalesMan = Run("select  Cid Id,CCode + ' - ' + Cname CName from Emp Where  isnull(IsDeleted,0)=0  order by Cid");
}
else
{
$SalesMan = Run("select  Cid Id,CCode + ' - ' + Cname CName from Emp Where  isnull(IsDeleted,0)=0 and webCode = '".$_SESSION['code']."'  order by Cid");   
}


while ($getSalesMan = myfetch($SalesMan)) {
$selected = "";

?>
<option value="<?php echo $getSalesMan->Id; ?>" <?php echo $selected; ?> ><?php echo $getSalesMan->CName; ?></option>
<?php
}

?>
</select>
</div>
</div>
<div class="mb-3 overflow-hidden">
<button type="button" class="btn btn-info btn-actions float-start back text-white"
onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back
</button>
<button type="button" class="btn btn-success btn-actions float-end submit-next"
onclick="validateRefrenceNo(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
</div>
</div>
</div>
<div class="m-5"></div>
</div>

<div class="slide-box slided glass">
<div style="margin-top: 0px!important;" class="content">
<h2 class="heading_fixed">Sales Voucher</h2>
<p id="fetchProductDetails"></p>
</div>
<div class="content_form">
<div class="form_list">
<div class="mb-3">
<label for="" class="form-label"> Code </label>
<input type="text" class="form-control" onKeyUp="fetchProductDetailsFromCode(this.value)" id="Pcode" name="Pcode">
</div>
<div class="mb-3">
<label for="" class="form-label add_icon">Search Items</label>
<div id="getProductList">
<select id="product" name="product" class="js-states form-control"
onChange="setmyValue(this.value,'Pcode');fetchProductUnits(this.value)">
</select>
</div>
</div>



<div class="mb-3">
<label for="" class="form-label">Unit </label>
<div id="loadUnits">
<select class="form-select" name="unit_id" id="unit_id" aria-label="unit_id" >
<option value="">Please Select Unit</option>
</select>
</div>

<input type="hidden" name="unit" id="unit" readonly class="form-control">

</div>



<div class="mb-3">
<div class="row">
	<div class="col-6">
	<label for="" class="form-label"> QTY </label>
<input type="text" onKeyUp="calculateSingleVatTotal(this.value)" value="1" name="qty" id="qty" class="form-control">
<input type="hidden"  value="0" name="openStock" id="openStock" class="form-control">
	</div>
	<div class="col-6">
	<label for="" class="form-label"> Price </label>
<input type="text" name="Sprice" id="Sprice" class="form-control" readonly onKeyUp="Pricecalculations(this.value,'vatSprice');">
<input type="hidden" name="isVat" id="isVat" class="form-control" readonly>
	</div>
	</div>
	
	
</div>




<div class="mb-3">
	<div class="row">
		<div class="col-6 ">
	<label for="" class="form-label"> Vat %  </label>
<input type="text" name="vatPer" id="vatPer" class="form-control" readonly value="0">
	</div>	
<div class="col-6">
<label for="" class="form-label"> Vat Amount  </label>
<input type="text" name="vatAmt" id="vatAmt" class="form-control" readonly value="0">
</div>	

	
	</div>

</div>	


<div class="mb-3">
<label for="" class="form-label"> Total  </label>
<input type="text" name="vatSprice" id="vatSprice" class="form-control" readonly>
</div>	

<div class="mb-3 overflow-hidden">
<button type="button" class="btn btn-info btn-actions float-start back text-white"
onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back
</button>

	<button type="button" class="btn btn-success btn-actions  submit-next custom-finish"
onclick="generateRow2(this)" >Finish <i class="fa fa-arrow-right icon-font"></i></button>
	
	<button type="button" class="btn btn-success btn-actions  submit-next float-end"
onclick="generateRow(this)">Add <i class="fa fa-arrow-right icon-font"></i></button>
</div>
	
	
	<div class="mb-3">

	<div class="row">
	<div class="col-12">
<table class="table">
	<thead>
	<tr>
		
	<th>Product</th>	
	<th>Qty</th>	
	<th>Price</th>	

	</tr>
	</thead>
	<tbody id="NewRows">

	</tbody>
		
</table>	
	
	</div>	
	</div>	
	

	
	
	</div>
</div>
</div>
<input type="hidden" name="row_count" id="row_count" value="1">

	
	
	
</div>

<div class="slide-box slided glass">
<div class="content">
<h2 class="heading_fixed">Sales Voucher</h2>
</div>
<div class="content_form">
<div class="form_list" >
<div id="add_row">

</div>

<div class="mb-3 overflow-hidden">
<button type="button" class="btn btn-info btn-actions float-start back text-white"
onclick="addMoreRows(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Add More
</button>
<button type="button" class="btn btn-success btn-actions float-end submit-next"
onclick="calculateAllTotals(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
</div>
</div>
</div>

</div>
<div class="slide-box slided glass">
<div class="content">
<h2 class="heading_fixed">Sales Voucher</h2>
</div>
<div class="content_form">
<div class="form_list">
<div class="mb-3">
<span>Total:</span>  <span id="span_total"></span><input type="hidden" id="total" name="total">
</div>




<div class="mb-3">
<span>Disc% :</span> 
<input type="text" id="disPer" name="disPer" value="0" class="form-control" onKeyUp="calculateWholeDiscountAmount(this.value)"> 
</div>
<div class="mb-3">
<span>Disc Amount :</span> 
<input type="text" id="disAmt" name="disAmt" value="0" class="form-control"   onKeyUp="calculateWholeDiscountper(this.value)"> 
</div>
<div class="mb-3">
<span>Net Total :</span> <span id="span_netTotal"></span>
<input type="hidden" id="netTotal" name="netTotal" value="0"> 
</div>
<div class="mb-3">
<span>Total Vat :</span> <span id="span_totVat"></span>
<input type="hidden" id="totVat" name="totVat" value="0"> 
</div>
<div class="mb-3">
<span>Grand Total :</span> <span id="span_grandTotal"></span>
<input type="hidden" id="grandTotal" name="grandTotal" value="0"> 
</div>

<div class="mb-3 overflow-hidden">
<button type="button" class="btn btn-info btn-actions float-start back text-white"
onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back
</button>
<button type="button" class="btn btn-success btn-actions float-end submit-next"
onclick="paymentScreen(this)">Next <i class="fa fa-arrow-right icon-font"></i>
</button>
</div>
</div>
</div>
<div class="m-5"></div>
</div>



<div class="slide-box slided glass">
<div class="content">
<h2 class="heading_fixed">Sales Voucher</h2>
</div>
<div class="content_form">




<div class="form_list">


<div class="mb-3">
<span>Grand Total :</span> <span id="payment_screen_total">
</div>
<div class="mb-3" style="display: none;">
<span>Remaining :</span> <span id="payment_screen_remaining">
</div>
<div class="row mb-3">
<div class="mb-3 col-6">
<div class="form-check">
<input class="form-check-input SPType" onClick="checkBankValue()" checked type="radio" name="SPType" id="cash"
value="1">
<label class="form-check-label" for="cash">
Cash
</label>
</div>
</div>
<div class="mb-3 col-6">
<div class="form-check">
<input class="form-check-input SPType" type="radio" name="SPType" id="credit" onClick="checkBankValue()"
value="2">
<label class="form-check-label" for="credit">
Credit
</label>
</div>
</div>


<div class="mb-3">
<label for="" class="form-label add_icon">Customer</label>
<div>
<select id="customer_id" name="customer_id" class="js-states form-control">

</select>
</div>
</div>
<div class="mb-3">
<label for="" class="form-label add_icon">Shop Name</label>
<input type="text" name="CustomerName" id="CustomerName" class="form-control" >

</div>

<div class="mb-3">

<div id="cashCreditOption">

</div>
</div>







</div>


<div class="mb-3 overflow-hidden">
<button type="button" class="btn btn-info btn-actions float-start back text-white"
onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back
</button>
<button type="button" class="btn btn-success btn-actions float-end submit-next"
onclick="customerValidation(this);">Finish & Save <i class="fa fa-arrow-right icon-font"></i>
</button>
</div>
</div>
</div>
</div>
<div class="slide-box slided glass" id="saveFinalStep">

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
<select class="form-control " name="email_lang" id="email_lang">
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
<div class="modal fade" id="printpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLongTitle" style="text-align: center">Print Bill</h5>

</div>
<form action="javascript:Print_details()">
<div class="modal-body">

<input type="hidden" name="bill_id_print" id="bill_id_print">
<input type="hidden" name="b_id_print" id="b_id_print">

<label class="mt-2">Language</label>
<select class="form-control" id="print_language" name="print_language">
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
<script src="includes/sales_new/js.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

</html>