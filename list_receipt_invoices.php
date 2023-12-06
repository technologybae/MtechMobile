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
				<form method="get">

					<div class="slide-box glass">
						<div class="content">
							<h2 class="heading_fixed enBtn">Receipt Voucher</h2>
                            <h2 class="heading_fixed arBtn"><?= getArabicTitle('Receipt Voucher') ?></h2>
						</div>
						<div class="content_form">
							<div class="form_list" id="printInvoice">
								<div class="mb-3">
									<label for="" class="form-label"><span class="en">Branch</span><span class="ar"> <?= getArabicTitle('Branch') ?></span></label>
									<div>
										<select class="form-select direction" name="Bid" id="Bid">
											<?php


											if ($_SESSION['isAdmin'] == '1') {
												$Bracnhes = Run("Select * from " . dbObject . "Branch order by BName ASC");
												echo '<option value="" >All</option>';
											} else {
												$Bracnhes = Run("Select " . dbObject . "Branch.Bid," . dbObject . "Branch.BName from " . dbObject . "Branch
Inner JOIN " . dbObject . "EMP  On " . dbObject . "EMP.BID = " . dbObject . "Branch.Bid
where " . dbObject . "EMP.WebCode = '" . $_SESSION['code'] . "' ");
											}




											while ($getBranches = myfetch($Bracnhes)) {
												$selected = "";
												if ($_GET['Bid'] == '') {
													if ($getBranches->ismain == '1') {
														$selected = "Selected";
													}
												}
												if ($_GET['Bid'] != '') {
													if ($getBranches->Bid == $_GET['Bid']) {
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
								<div class="mb-3">
									<label for="" class="form-label"><span class="en">Bill no</span><span class="ar"> <?= getArabicTitle('Bill no') ?></span></label>
									<input type="number" class="form-control direction" name="Billno" id="Billno" value="<?php echo $_GET['Billno']; ?>">
								</div>
								<div class="mb-3">
									<label for="" class="form-label"><span class="en">Inv No</span><span class="ar"> <?= getArabicTitle('Inv No') ?></span></label>
									<input type="text" class="form-control direction" name="sbBillno" id="sbBillno" value="<?php echo $_GET['sbBillno']; ?>">
								</div>

								<div class="mb-3">
                                    <label for="" class="form-label"><span class="en">Customer</span><span class="ar"> <?= getArabicTitle('Customer') ?></span></label>

									<div>
										<select id="customer_id" name="customer_id" class="js-states form-control direction">
											<?php
											if ($_GET['customer_id'] != '') {
												$query = Run("Select * from " . dbObject . "CustFile where Cid = '" . $_GET['customer_id'] . "'");
												$CustomerName = myfetch($query);
											?>
												<option value="<?= $_GET['customer_id'] ?>" selected><?= $CustomerName->CCode ?>-<?= $CustomerName->CName ?></option>
											<?php
											}

											?>
										</select>
									</div>
								</div>

								<div class="mb-3 overflow-hidden">
									<button type="button" class="btn btn-danger btn-actions float-end submit-next enBtn" onClick="loadPage('list_receipt_invoices.php')">Clear</button>
									<button type="button" class="btn btn-danger btn-actions float-end submit-next arBtn" onClick="loadPage('list_receipt_invoices.php')"><?= getArabicTitle('Clear') ?></button>

									<button type="submit" class="btn btn-success btn-actions float-end submit-next enBtn">Submit <i class="fa fa-arrow-right icon-font"></i></button>
									<button type="submit" class="btn btn-success btn-actions float-end submit-next arBtn"><i class="fa fa-arrow-left icon-font"></i> <?= getArabicTitle('Submit') ?></button>
								</div>


								<?php
								if ($_SESSION['isAdmin'] == '1') {
									$condition = 'Where Bid <> 0';
								} else {
									$Bracnhes = Run("Select " . dbObject . "Branch.Bid," . dbObject . "Branch.BName from " . dbObject . "Branch
Inner JOIN " . dbObject . "EMP  On " . dbObject . "EMP.BID = " . dbObject . "Branch.Bid
where " . dbObject . "EMP.WebCode = '" . $_SESSION['code'] . "' ");
									$getB = myfetch($Bracnhes);
									$bbid = $getB->Bid;
									$condition = 'Where Bid = ' . $bbid;
								}
								include('newpagination/paginator.class.php');
								$Bid = $_GET['Bid'];
								if ($Bid != '') {
									$condition = " Where Bid=" . $Bid;
								}



								//s$SrchBy = !empty($_GET['SrchBy']) ? $_GET['SrchBy']: 0;
								$Billno = !empty($_GET['Billno']) ? $_GET['Billno'] : 0;
								if ($Billno != 0) {
									$condition .= " And BillNO=" . $Billno;
								}

								$sbBillno = !empty($_GET['sbBillno']) ? $_GET['sbBillno'] : 0;
								if ($sbBillno != 0) {
									$condition .= " And sbBillno='" . $sbBillno . "'";
								}
								$customer_id = !empty($_GET['customer_id']) ? $_GET['customer_id'] : 0;
								if ($customer_id != 0) {
									$condition .= " And CustomerID='" . $customer_id . "'";
								}



								$pages = new Paginator;

								$rf = Run("Select count(BillNO) as totalrec from Receipt   $condition");
								$tolrec = myfetch($rf)->totalrec;

								$pages->default_ipp = 20;
								$pages->items_total = $tolrec;
								$pages->mid_range = 9;
								$pages->paginate();

								//$initialLimit = ",".$pages->limit;
								$OrderBy = "Order by Receipt.BillNO DESC";

								$qpt = "Select * from Receipt $condition  $OrderBy " . $pages->limit . "";
								$result = Run($qpt);
								?>
								<div class="mb-3">
									<!-- Listing -->
									<table class="table table-striped table-bordered dt-responsive table-hover direction">

										<?php
										if ($pages->items_total > 0) { ?>
											<thead>
												<tr>
													<th>#</th>
													<th><span class="en">Inv</span><span class="ar"> <?= getArabicTitle('Inv') ?></span></th>
													<th><span class="en">Date</span><span class="ar"> <?= getArabicTitle('Date') ?></span></th>
													<th><span class="en">Customer</span><span class="ar"> <?= getArabicTitle('Customer') ?></span></th>
													<th><span class="en">Amount</span><span class="ar"> <?= getArabicTitle('Amount') ?></span></th>
												</tr>
											</thead>
											<tbody>
												<?php
												while ($single  =   myfetch($result)) {


													$CSID = $single->CustomerID;
													if ($CSID) {
														$qu = Run("Select Email from CustFile where Cid = '" . $CSID . "'");
														$getCData = myfetch($qu);
														$email = $getCData->Email;
														$query = Run("Select * from " . dbObject . "CustFile where Cid = '" . $CSID . "'");
														$CustomerName = myfetch($query)->CName;
													}
												?>
													<tr>
														<td style="float: left"><?= $single->BillNO ?>
															<a href="#" style="width: fit-content;float: left" onclick="openPopup('<?= $single->BillNO ?>','<?= $single->BId ?>','<?= $email ?>')">
																<span class=""><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
															</a>

															<a href="includes/receipt/print.php?Billno=<?= $single->BillNO ?>&Bid=<?= $single->BId ?>&LanguageId=1" target="_blank" style="width: fit-content; float: left">
																<span class=""><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
															</a>

															<a href="includes/receipt/print.php?Billno=<?= $single->BillNO ?>&Bid=<?= $single->BId ?>&LanguageId=1" target="_blank" style="width: fit-content; float: left">
																<span class=""><i class="fa fa-print" aria-hidden="true"></i></span>
															</a>



														</td>
														<td><?= $single->sbBillno ?></td>
														<td><?= DateValue($single->BillDate) ?></td>
														<td><?= $CustomerName ?></td>
														<td><?= AmountValue($single->NetTotal) ?></td>

													</tr>
												<?php
													$cnt++;
												}
											} else {
												?>
												<tr>
													<td colspan="5" class="text-center">
														<h2><strong>No Record(s) Found..</strong></h2>
													</td>
												</tr>
											<?php

											}

											?>


											</tbody>

									</table>

									<!-- /Listing -->

									<div class="clearfix"></div>



									<!-- bottom pagination -->

									<div class="row marginTop">

										<div class="col-sm-12 paddingLeft pagerfwt">

											<?php if ($pages->items_total > 0) { ?>

												<?php echo $pages->display_pages(); ?>

												<?php echo $pages->display_items_per_page(); ?>

												<?php echo $pages->display_jump_menu(); ?>

											<?php } ?>

										</div>

										<div class="clearfix"></div>

									</div>

									<!-- /bottom pagination -->
								</div>
							</div>
						</div>
						<div class="m-5"></div>
					</div>
				</form>
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