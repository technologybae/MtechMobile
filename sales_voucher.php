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
			display: flex;
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

		.form-check{
			margin-left: 0;
		}

		.form-check .form-check-input{
			float: none;
			margin-left: 0;
		}
	</style>
</head>

<body>
	<?php
	include("header.php");
	?>
	<form id="sales_voucher">
		<section>

			<div class="slide-form justify-content-center">
				<div id="saveSalesForm"></div>
				<div class="slide-box glass direction">
					<div class="content">
						<h2 class="heading_fixed enBtn">Sales Voucher</h2>
						<h2 class="heading_fixed arBtn"><?= getArabicTitle('Sales Voucher') ?></h2>
					</div>
					<div class="content_form">
						<div class="form_list">
							<div class="mb-3">
								<label for="" class="form-label"><span class="en">Branch</span><span class="ar"> <?= getArabicTitle('Branch') ?></span></label>
								<div>
									<select class="form-select direction" name="Bid" id="Bid" aria-label="sales-men" onChange="loadBanks(this.value)">
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
							<!-- <div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="loadPage('sales_voucher_type.php');"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back</button>
								<button type="button" class="btn btn-success btn-actions float-end submit-next" onclick="next(this);loadBanks(Bid.value)">Next <i class="fa fa-arrow-right icon-font"></i></button>
							</div> -->

							<div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="loadPage('sales_voucher_type.php');"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back</button>
								<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="loadPage('sales_voucher_type.php');"><i class="fa fa-arrow-right icon-font"></i>&nbsp;<?= getArabicTitle('Back') ?></button>

								<button type="button" class="btn btn-success btn-actions float-end submit-next enBtn" onclick="next(this);loadBanks(Bid.value)">Next <i class="fa fa-arrow-right icon-font"></i></button>
								<button type="button" class="btn btn-success btn-actions float-end submit-next arBtn" onclick="next(this);loadBanks(Bid.value)"><?= getArabicTitle('Next') ?> <i class="fa fa-arrow-left icon-font"></i></button>
							</div>
						</div>
					</div>
					<div class="m-5"></div>
				</div>
				<div class="slide-box slided glass direction">
					<div class="content">
						<h2 class="heading_fixed enBtn">Sales Voucher</h2>
						<h2 class="heading_fixed arBtn"><?= getArabicTitle('Sales Voucher') ?></h2>
					</div>
					<div class="content_form">
						<div class="form_list">

							<div class="mb-3">
								<label for="" class="form-label"><span class="en">Date :</span><span class="ar"><?= getArabicTitle('Date') ?> :</span></label>
								<input value="<?= date("Y-m-d H:i:s") ?>" id="bill_date_time" name="bill_date_time" type="datetime-local" class="form-control direction">
							</div>
							<div class="mb-3">
							<label for="" class="form-label"><span class="en">Reference No :</span><span class="ar"><?= getArabicTitle('Reference No') ?> :</span></label>
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
							<!-- <div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back</button>
								<button type="button" class="btn btn-success btn-actions float-end submit-next" onclick="validateRefrenceNo(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
							</div> -->

							<div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i> Back</button>
								<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="prev(this);"><i class="fa fa-arrow-right icon-font"></i> <?= getArabicTitle('Back') ?></button>

								<button type="button" class="btn btn-success btn-actions float-end submit-next enBtn" onclick="validateRefrenceNo(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
								<button type="button" class="btn btn-success btn-actions float-end submit-next arBtn" onclick="validateRefrenceNo(this)"><?= getArabicTitle('Next') ?> <i class="fa fa-arrow-left icon-font"></i></button>
							</div>
						</div>
					</div>
					<div class="m-5"></div>
				</div>

				<div class="slide-box slided glass direction">
					<div style="margin-top: 0px!important;" class="content">
						<h2 class="heading_fixed enBtn">Sales Voucher</h2>
						<h2 class="heading_fixed arBtn"><?= getArabicTitle('Sales Voucher') ?></h2>
						<p id="fetchProductDetails"></p>
					</div>
					<div class="content_form">
						<div class="form_list">
							<div class="mb-3">
							<label for="" class="form-label"><span class="en">Code</span><span class="ar"><?= getArabicTitle('Code') ?></span></label>
								<input type="text" class="form-control direction" onKeyUp="fetchProductDetailsFromCode(this.value)" id="Pcode" name="Pcode">
							</div>
							<div class="mb-3">
								<label for="" class="form-label"><span class="en">Search Items</span><span class="ar"><?= getArabicTitle('Search Items') ?></span></label>
								<div id="getProductList">
									<select id="product" name="product" class="js-states form-control direction" onChange="setmyValue(this.value,'Pcode');fetchProductUnits(this.value)">
									</select>
								</div>
							</div>



							<div class="mb-3">
								<label for="" class="form-label"><span class="en">Unit</span><span class="ar"><?= getArabicTitle('Unit') ?></span></label>
								<div id="loadUnits">
									<select class="form-select direction" name="unit_id" id="unit_id" aria-label="unit_id">
										<option value="">Please Select Unit</option>
									</select>
								</div>

								<input type="hidden" name="unit" id="unit" readonly class="form-control">

							</div>



							<div class="mb-3">
								<div class="row">
									<div class="col-6">
										<label for="" class="form-label"><span class="en">QTY</span><span class="ar"><?= getArabicTitle('QTY') ?></span></label>
										<input type="text" onKeyUp="calculateSingleVatTotal(this.value)" value="1" name="qty" id="qty" class="form-control direction">
										<input type="hidden" value="0" name="openStock" id="openStock" class="form-control">
									</div>
									<div class="col-6">
										<label for="" class="form-label"><span class="en">Price</span><span class="ar"><?= getArabicTitle('Price') ?></span></label>
										<input type="text" name="Sprice" id="Sprice" class="form-control direction" readonly onKeyUp="Pricecalculations(this.value,'vatSprice');">
										<input type="hidden" name="isVat" id="isVat" class="form-control" readonly>
										<input type="hidden" id="CostPrice" class="form-control" value="0" readonly>
										<input type="hidden" id="costTotal" class="form-control" value="0" readonly>
									</div>
								</div>


							</div>




							<div class="mb-3">
								<div class="row">
									<div class="col-6 ">
										<label for="" class="form-label"><span class="en">Vat %</span><span class="ar"><?= getArabicTitle('Vat %') ?></span></label>
										<input type="text" name="vatPer" id="vatPer" class="form-control direction" readonly value="0">
									</div>
									<div class="col-6">
										<label for="" class="form-label"><span class="en">Vat Amount</span><span class="ar"><?= getArabicTitle('Vat Amount') ?></span></label>
										<input type="text" name="vatAmt" id="vatAmt" class="form-control direction" readonly value="0">
									</div>


								</div>

							</div>


							<div class="mb-3">
								<label for="" class="form-label"><span class="en">Total</span><span class="ar"><?= getArabicTitle('Total') ?></span></label>
								<input type="text" name="vatSprice" id="vatSprice" class="form-control direction" readonly>
							</div>

							<!-- <div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back</button>

								<button type="button" class="btn btn-success btn-actions  submit-next custom-finish" onclick="generateRow2(this)">Finish <i class="fa fa-arrow-right icon-font"></i></button>

								<button type="button" class="btn btn-success btn-actions  submit-next float-end" onclick="generateRow(this)">Add <i class="fa fa-arrow-right icon-font"></i></button>
							</div> -->

							<div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i> Back</button>
								<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="prev(this);"><i class="fa fa-arrow-right icon-font"></i> <?= getArabicTitle('Back') ?></button>

								<button type="button" class="btn btn-success btn-actions submit-next enBtn" onclick="generateRow2(this)">Finish <i class="fa fa-arrow-right icon-font"></i></button>
								<button type="button" class="btn btn-success btn-actions submit-next arBtn" onclick="generateRow2(this)"><?= getArabicTitle('Finish') ?> <i class="fa fa-arrow-left icon-font"></i></button>

								<button type="button" class="btn btn-success btn-actions submit-next float-end enBtn" onclick="generateRow(this)">Add <i class="fa fa-arrow-right icon-font"></i></button>
								<button type="button" class="btn btn-success btn-actions submit-next float-end arBtn" onclick="generateRow(this)"> <?= getArabicTitle('Add') ?> <i class="fa fa-arrow-left icon-font"></i></button>
							</div>


							<div class="mb-3">

								<div class="row">
									<div class="col-12">
										<table class="table direction">
											<thead>
												<tr>
													<th><span class="en">Product</span><span class="ar"> <?= getArabicTitle('Product') ?></span></th>
													<th><span class="en">Qty</span><span class="ar"> <?= getArabicTitle('Qty') ?></span></th>
													<th><span class="en">Price</span><span class="ar"> <?= getArabicTitle('Price') ?></span></th>
													<th><span class="en">Actions</span><span class="ar"> <?= getArabicTitle('Actions') ?></span></th>
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

				<div class="slide-box slided glass direction">
					<div class="content">
						<h2 class="heading_fixed enBtn">Sales Voucher</h2>
						<h2 class="heading_fixed arBtn"><?= getArabicTitle('Sales Voucher') ?></h2>
					</div>
					<div class="content_form">
						<div class="form_list">
							<div id="add_row">

							</div>

							<!-- <div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="addMoreRows(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Add More</button>
								<button type="button" class="btn btn-success btn-actions float-end submit-next" onclick="calculateAllTotals(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
							</div> -->

							<div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="addMoreRows(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Add More</button>
								<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="addMoreRows(this);"><i class="fa fa-arrow-right icon-font"></i>&nbsp;<?= getArabicTitle('Add More') ?></button>

								<button type="button" class="btn btn-success btn-actions float-end submit-next enBtn" onclick="calculateAllTotals(this)">Next <i class="fa fa-arrow-right"></i></button>
								<button type="button" class="btn btn-success btn-actions float-end submit-next arBtn" onclick="calculateAllTotals(this)"><?= getArabicTitle('Next') ?> <i class="fa fa-arrow-left"></i></button>
							</div>
						</div>
					</div>

				</div>
				<div class="slide-box slided glass direction">
					<div class="content">
						<h2 class="heading_fixed enBtn">Sales Voucher</h2>
						<h2 class="heading_fixed arBtn"><?= getArabicTitle('Sales Voucher') ?></h2>
					</div>
					<div class="content_form ">
						<div class="form_list">
							<div class="mb-3">
								<!-- <span>Total:</span> <span id="span_total"></span> -->
								<!-- <label for="" class="form-label"><span class="en">Total :</span><span class="ar"><?= getArabicTitle('Total') ?> :</span></label><span id="span_total"></span> -->
								<label for="" class="form-label"><span class="en">Total : </span><span class="ar"><?= getArabicTitle('Total') ?> : </span><span id="span_total"></span></label>
								<input type="hidden" id="total" name="total">
							</div>

							<div class="mb-3">
								<!-- <span>Disc% :</span> -->
								<span> <span class="en">Disc% :</span> <span class="ar"><?= getArabicTitle('Disc') ?>% :</span></span>
								<input type="text" id="disPer" name="disPer" value="0" class="form-control" onKeyUp="calculateWholeDiscountAmount(this.value)">
							</div>
							<div class="mb-3">
								<!-- <span>Disc Amount :</span> -->
								<span> <span class="en">Disc Amount :</span> <span class="ar"><?= getArabicTitle('Disc Amount') ?> :</span></span>
								<input type="text" id="disAmt" name="disAmt" value="0" class="form-control" onKeyUp="calculateWholeDiscountper(this.value)">
							</div>
							<div class="mb-3">
								<!-- <span>Net Total :</span> <span id="span_netTotal"></span> -->
								<label for="" class="form-label"><span class="en">Net Total : </span><span class="ar"><?= getArabicTitle('Net Total') ?> :</span><span id="span_netTotal"></span></label>
								<input type="hidden" id="netTotal" name="netTotal" value="0">
							</div>
							<div class="mb-3">
								<!-- <span>Total Vat :</span> <span id="span_totVat"></span> -->
								<label for="" class="form-label"><span class="en">Total Vat : </span><span class="ar"><?= getArabicTitle('Total Vat') ?> :</span><span id="span_totVat"></span></label>
								<input type="hidden" id="totVat" name="totVat" value="0">
							</div>
							<div class="mb-3">
								<!-- <span>Grand Total :</span> <span id="span_grandTotal"></span> -->
								<label for="" class="form-label"><span class="en">Grand Total : </span><span class="ar"><?= getArabicTitle('Grand Total') ?> :</span><span id="span_grandTotal"></span></label>
								<input type="hidden" id="grandTotal" name="grandTotal" value="0">
							</div>

							<!-- <div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back</button>
								<button type="button" class="btn btn-success btn-actions float-end submit-next" onclick="paymentScreen(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
							</div> -->
							<div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i> Back</button>
								<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="prev(this);"><i class="fa fa-arrow-right icon-font"></i> <?= getArabicTitle('Back') ?></button>

								<button type="button" class="btn btn-success btn-actions float-end submit-next enBtn" onclick="paymentScreen(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
								<button type="button" class="btn btn-success btn-actions float-end submit-next arBtn" onclick="paymentScreen(this)"><?= getArabicTitle('Next') ?> <i class="fa fa-arrow-left icon-font"></i></button>
							</div>
						</div>
					</div>
					<div class="m-5"></div>
				</div>

				<div class="slide-box slided glass direction">
					<div class="content">
						<h2 class="heading_fixed enBtn">Sales Voucher</h2>
						<h2 class="heading_fixed arBtn"><?= getArabicTitle('Sales Voucher') ?></h2>
					</div>
					<div class="content_form">
						<div class="form_list">
							<div class="mb-3">
								<!-- <span>Grand Total :</span> <span id="payment_screen_total"> -->
								<label for="" class="form-label"><span class="en">Grand Total : </span><span class="ar"><?= getArabicTitle('Grand Total') ?> :</span> <span id="payment_screen_total"></span></label>
							</div>
							<div class="mb-3" style="display: none;">
								<!-- <span>Remaining :</span> <span id="payment_screen_remaining"> -->
								<label for="" class="form-label"><span class="en">Remaining : </span><span id="payment_screen_remaining"></span><span class="ar"><?= getArabicTitle('Remaining') ?> :</span></label>
							</div>
							<div class="row mb-3">
								<div class="mb-3 col-6">
									<div class="form-check">
										<input class="form-check-input SPType" onClick="checkBankValue()" checked type="radio" name="SPType" id="cash" value="1">
										<label class="form-check-label" for="cash">
											<span class="en">Cash</span>
											<span class="ar"><?= getArabicTitle('Cash') ?></span>
										</label>
									</div>
								</div>
								<div class="mb-3 col-6">
									<div class="form-check">
										<input class="form-check-input SPType" type="radio" name="SPType" id="credit" onClick="checkBankValue()" value="2">
										<label class="form-check-label" for="credit">
											<span class="en">Credit</span>
											<span class="ar"><?= getArabicTitle('Credit') ?></span>
										</label>
									</div>
								</div>


								<div class="mb-3">
									<!-- <label for="" class="form-label add_icon">Customer</label> -->
									<label for="" class="form-label add_icon"><span class="en">Customer</span><span class="ar"><?= getArabicTitle('Customer') ?></span></label>

									<div>
										<select id="customer_id" name="customer_id" class="js-states form-control">

										</select>
									</div>
								</div>
								<div class="mb-3">
									<!-- <label for="" class="form-label add_icon">Shop Name</label> -->
									<label for="" class="form-label"><span class="en">Shop Name</span><span class="ar"><?= getArabicTitle('Shop Name') ?></span></label>
									<input type="text" name="CustomerName" id="CustomerName" class="form-control">

								</div>

								<div class="mb-3">

									<div id="cashCreditOption">

									</div>
								</div>







							</div>


							<!-- <div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back</button>
								<button type="button" class="btn btn-success btn-actions float-end submit-next" id="finishSave" onclick="customerValidation(this);">Finish & Save <i class="fa fa-arrow-right icon-font"></i></button>
							</div> -->

							<div class="mb-3 overflow-hidden">
								<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i> Back</button>
								<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="prev(this);"><i class="fa fa-arrow-right icon-font"></i> <?= getArabicTitle('Back') ?></button>

								<button type="button" class="btn btn-success btn-actions float-end submit-next enBtn" id="finishSave" onclick="customerValidation(this);">Finish & Save <i class="fa fa-arrow-right icon-font"></i></button>
								<button type="button" class="btn btn-success btn-actions float-end submit-next arBtn" id="finishSave" onclick="customerValidation(this);"><?= getArabicTitle('Finish & Save') ?> <i class="fa fa-arrow-left icon-font"></i></button>
							</div>
						</div>
					</div>
				</div>

				<div class="slide-box slided glass direction" id="saveFinalStep">

				</div>
			</div>
		</section>
	</form>

	<!-- Modal -->
    <div class="modal fade direction" id="emailpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title enBtn" id="exampleModalLongTitle" style="text-align: center">Send Email</h5>
                    <h5 class="modal-title arBtn" id="exampleModalLongTitle" style="text-align: center"><?= getArabicTitle('Send Email') ?></h5>
                    <!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                    <!--                    <span aria-hidden="true">&times;</span>-->
                    <!--                </button>-->
                </div>
                <div id="sendemailform"></div>
                <form action="javascript:sendemailform()">
                    <div class="modal-body">
                        <label for="" class="form-label mt-2"><span class="en">Email</span><span class="ar"> <?= getArabicTitle('Email') ?></span></label>
                        <input type="email" name="email direction" id="email" placeholder="Enter Email" class="form-control" required>
                        <input type="hidden" name="bill_id" id="bill_id">
                        <input type="hidden" name="b_id" id="b_id">

                        <label for="" class="form-label mt-2"><span class="en">Language</span><span class="ar"> <?= getArabicTitle('Language') ?></span></label>
                        <select class="form-control direction" name="email_lang" id="email_lang">
                            <option value="1">English</option>
                            <option value="2">Arabic</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                        <button type="submit" class="btn btn-primary enBtn">Send</button>
                        <button type="submit" class="btn btn-primary arBtn"><?= getArabicTitle('Send') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade direction" id="printpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title enBtn" id="exampleModalLongTitle" style="text-align: center">Print Bill</h5>
                    <h5 class="modal-title arBtn" id="exampleModalLongTitle" style="text-align: center"><?= getArabicTitle('Print Bill') ?></h5>

                </div>
                <form action="javascript:Print_details()">
                    <div class="modal-body">

                        <input type="hidden" name="bill_id_print" id="bill_id_print">
                        <input type="hidden" name="b_id_print" id="b_id_print">

                        <label for="" class="form-label mt-2"><span class="en">Language</span><span class="ar"> <?= getArabicTitle('Language') ?></span></label>
                        <select class="form-control direction" id="print_language" name="print_language">
                            <option value="1">English</option>
                            <option value="2">Arabic</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                        <button type="submit" class="btn btn-primary enBtn">Send</button>
                        <button type="submit" class="btn btn-primary arBtn"><?= getArabicTitle('Send') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade direction" id="ignismyModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="enBtn">Email Notification</h2>
                    <h2 class="arBtn"><?= getArabicTitle('Email Notification') ?></h2>
                </div>
                <div class="modal-body">
                    <div class="thank-you-pop" style="text-align: center;">
                        <img style="height: 50% !important; width: 15% !important;" src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="">
                        <h1 class="enBtn">Email Sent!</h1>
                        <h1 class="arBtn">!<?= getArabicTitle('Email Sent') ?></h1>
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
<script src="includes/sales/js.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

</html>