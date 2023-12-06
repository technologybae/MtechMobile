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
							<h2 class="heading_fixed enBtn">List Customers</h2>
							<h2 class="heading_fixed arBtn"><?= getArabicTitle('List Customers') ?></h2>
						</div>
						<div class="content_form">
							<div class="form_list" id="printInvoice">
								<div class="mb-3">
									<label for="" class="form-label"><span class="en">Code</span><span class="ar"> <?= getArabicTitle('Code') ?></span></label>
									<input type="text" class="form-control direction" name="CCode" id="CCode" value="<?php echo $_GET['CCode']; ?>">
								</div>
								<div class="mb-3">
									<label for="" class="form-label"><span class="en">Name</span><span class="ar"> <?= getArabicTitle('Name') ?></span></label>
									<input type="text" class="form-control direction" name="CName" id="CName" value="<?php echo $_GET['CName']; ?>">
								</div>
								<div class="mb-3">
									<label for="" class="form-label"><span class="en">Branch</span><span class="ar"> <?= getArabicTitle('Branch') ?></span></label>
									<div>
										<select class="form-select direction" name="Bid" id="Bid">
											<?php


											if ($_SESSION['isAdmin'] == '1') {
												$Bracnhes = Run("Select * from " . dbObject . "Branch order by BName ASC");
											} else {
												$Bracnhes = Run("Select " . dbObject . "Branch.Bid," . dbObject . "Branch.BName from " . dbObject . "Branch
Inner JOIN " . dbObject . "EMP  On " . dbObject . "EMP.BID = " . dbObject . "Branch.Bid
where " . dbObject . "EMP.WebCode = '" . $_SESSION['code'] . "' ");
											}




											while ($getBranches = myfetch($Bracnhes)) {
												$selected = "";
												if ($_GET['Bid'] == $getBranches->Bid) {
													$selected = "Selected";
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
									<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="loadPage('customers.php');"><i class="fa fa-arrow-left icon-font"></i> Back</button>
									<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="loadPage('customers.php');"><?= getArabicTitle('Back') ?> <i class="fa fa-arrow-right icon-font"></i></button>

									<button type="button" class="btn btn-danger btn-actions float-end submit-next enBtn" onClick="loadPage('list_customers.php')">Clear</button>
									<button type="button" class="btn btn-danger btn-actions float-end submit-next arBtn" onClick="loadPage('list_customers.php')"><?= getArabicTitle('Clear') ?></button>

									<button type="submit" class="btn btn-success btn-actions float-end submit-next enBtn">Submit <i class="fa fa-arrow-right icon-font"></i></button>
									<button type="submit" class="btn btn-success btn-actions float-end submit-next arBtn"><i class="fa fa-arrow-left icon-font"></i> <?= getArabicTitle('Submit') ?></button>
								</div>
								<?php
								$condition = 'Where Cid <> 0';
								include('newpagination/paginator.class.php');


								//s$SrchBy = !empty($_GET['SrchBy']) ? $_GET['SrchBy']: 0;
								$CCode = !empty($_GET['CCode']) ? $_GET['CCode'] : 0;
								if ($CCode != 0) {
									$condition .= " And CCode=" . $CCode;
								}

								$CName = !empty($_GET['CName']) ? $_GET['CName'] : '';
								if ($CName != '') {
									$condition .= " And CName LIKE '%" . $CName . "%'";
								}

								$Bid = !empty($_GET['Bid']) ? $_GET['Bid'] : '';
								if ($Bid != '') {
									$condition .= " And Bid = '" . $Bid . "'";
								}


								$pages = new Paginator;

								$rf = Run("Select count(CCode) as totalrec from CustFile   $condition");
								$tolrec = myfetch($rf)->totalrec;

								$pages->default_ipp = 20;
								$pages->items_total = $tolrec;
								$pages->mid_range = 9;
								$pages->paginate();

								//$initialLimit = ",".$pages->limit;
								$OrderBy = "Order by Cid DESC";

								$qpt = "Select * from CustFile $condition  $OrderBy " . $pages->limit . "";
								$result = Run($qpt);
								?>
								<div class="mb-3">
									<!-- Listing -->
									<table class="table table-striped table-bordered dt-responsive table-hover direction">

										<?php
										if ($pages->items_total > 0) {
										?>
											<thead>
												<tr>
													<th><span class="en">CCode</span><span class="ar"> <?= getArabicTitle('CCode') ?></span></th>
													<th><span class="en">CName</span><span class="ar"> <?= getArabicTitle('CName') ?></span></th>
													<th><span class="en">Balance</span><span class="ar"> <?= getArabicTitle('Balance') ?></span></th>
													<th><span class="en">Actions</span><span class="ar"> <?= getArabicTitle('Actions') ?></span></th>
												</tr>
											</thead>
											<tbody>
												<?php
												$bQuery = "Select " . dbObject . "Branch.Bid," . dbObject . "Branch.BName from " . dbObject . "Branch
Inner JOIN " . dbObject . "EMP  On " . dbObject . "EMP.BID = " . dbObject . "Branch.Bid
where " . dbObject . "EMP.WebCode = '" . $_SESSION['code'] . "' ";
												$Bracnhes = Run($bQuery);
												$getBid = myfetch($Bracnhes)->Bid;
												$Bid = !empty($_GET['Bid']) ? $_GET['Bid'] : '';
												if ($Bid != '') {
													$getBid = $Bid;
												}

												while ($single = myfetch($result)) {

													// 	   $aab = "select sum(Credit-Debit) as custBalance from V_CustBalance where cid='".$single->Cid."' and bid = '".$getBid."'";
													// $query1 = Run($aab);
													//  $custBalance = myfetch($query1)->custBalance;
													// $customer_Balance = round($custBalance,2);
													$aab = "	EXEC " . dbObject . "GetCustomerBalalance @bid='$getBid',@dt='',@dt2='',@Cids='$single->Cid',@LanguageId ='2',@IsIncludingZeroBal ='1',@OrderBy ='CCode',@UserId ='0',@CustAreaId ='0',@IsCombined ='1',@DataType=3,@FRecNo=0,@ToRecNo=15  ";
													$query1 = Run($aab);
													$custBalance = myfetch($query1)->Balance;
													$customer_Balance = round($custBalance, 2);
												?>
													<tr>
														<td><?= $single->CCode ?></td>
														<td><?= $single->CName ?></td>
														<td><?= $customer_Balance ?></td>
														<td style="float: left">
															<a href="update_customer.php?CCode=<?= $single->CCode ?>&bid=<?= $single->bid ?>" style="width: fit-content;float: left">
																<span class=""><i class="fa fa-pencil" aria-hidden="true"></i></span>
															</a>
															<a href="#" onclick="deleteCustomer('<?= $single->CCode ?>','<?= $single->bid ?>')" style="width: fit-content; float: left">
																<span class=""><i class="fa fa-trash" aria-hidden="true"></i></span>
															</a>
														</td>
													</tr>
												<?php
													$cnt++;
												}
											} else {
												?>
												<tr>
													<td colspan="4" class="text-center">
														<h2><strong>No Record(s)
																Found..</strong></h2>
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

	<div class="m-5" id="customerFormData"></div>
	<?php
	include("footer.php");
	?>
</body>
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="includes/customers/js.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

</html>
<script>
	$("#Bid").select2({});
</script>