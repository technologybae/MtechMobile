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
							<h2 class="heading_fixed enBtn">Daily Report</h2>
							<h2 class="heading_fixed arBtn"><?= getArabicTitle('Daily Report') ?></h2>
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
								<?php
								$dd = date("Y-m-d");
								if ($_GET['vdate'] != '') {
									$dd = $_GET['vdate'];
								}
								?>
								<div class="mb-3">
									<label for="" class="form-label"><span class="en">Date</span><span class="ar"> <?= getArabicTitle('Date') ?></span></label>
									<input type="date" class="form-control direction" name="vdate" id="vdate" value="<?php echo $dd; ?>" max="<?= date("Y-m-d") ?>" data-date-format="YYYY MMMM DD">
								</div>

								<div class="mb-3 overflow-hidden">
									<button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="loadPage('home.php');"><i class="fa fa-arrow-left icon-font"></i> Back</button>
									<button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="loadPage('home.php');"><?= getArabicTitle('Back') ?> <i class="fa fa-arrow-right icon-font"></i></button>

									<button type="button" class="btn btn-danger btn-actions float-end submit-next enBtn" onClick="loadPage('list_closing.php')">Clear</button>
									<button type="button" class="btn btn-danger btn-actions float-end submit-next arBtn" onClick="loadPage('list_closing.php')"><?= getArabicTitle('Clear') ?></button>

									<button type="submit" class="btn btn-success btn-actions float-end submit-next enBtn">Submit <i class="fa fa-arrow-right icon-font"></i></button>
									<button type="submit" class="btn btn-success btn-actions float-end submit-next arBtn"><i class="fa fa-arrow-left icon-font"></i> <?= getArabicTitle('Submit') ?></button>
								</div>

								<?php
								if ($_SESSION['isAdmin'] == '1') {
									$getBii = Run("Select " . dbObject . "Branch.Bid," . dbObject . "Branch.BName from " . dbObject . "Branch where ismain='1'");
									$bid = myfetch($getBii)->Bid;
								} else {
									$Bracnhes = Run("Select " . dbObject . "Branch.Bid," . dbObject . "Branch.BName from " . dbObject . "Branch
Inner JOIN " . dbObject . "EMP  On " . dbObject . "EMP.BID = " . dbObject . "Branch.Bid
where " . dbObject . "EMP.WebCode = '" . $_SESSION['code'] . "' ");
									$getB = myfetch($Bracnhes);
									$bid = $getB->Bid;
								}


								$Bid = $_GET['Bid'];
								if ($Bid != '') {
									$bid = $Bid;
								}



								//s$SrchBy = !empty($_GET['SrchBy']) ? $_GET['SrchBy']: 0;
								$vdate = !empty($_GET['vdate']) ? $_GET['vdate'] : date("Y-m-d");
								$vdate = date("Y-m-d", strtotime($vdate));





								$salesSp = Run("Select sum(nettotal) as TotalSales from DataOut where Bid = '" . $bid . "' and  cast(BillDate as Date) = '" . $vdate . "' and SPType<>0");
								$TotalSales = myfetch($salesSp)->TotalSales;
								$TotalSales  = !empty($TotalSales) ? $TotalSales : '0';

								$salescashQ = Run("Select sum(nettotal) as salescash from DataOut where Bid = '" . $bid . "' and  cast(BillDate as Date) = '" . $vdate . "' and SPType='1';");
								$salescash = myfetch($salescashQ)->salescash;
								$salescash  = !empty($salescash) ? $salescash : '0';

								$salescreditQ = Run("Select sum(nettotal) as salescredit  from DataOut where Bid = '" . $bid . "' and  cast(BillDate as Date) = '" . $vdate . "' and SPType='2'");
								$salescredit  = myfetch($salescreditQ)->salescredit;
								$salescredit  = !empty($salescredit) ? $salescredit : '0';






								$salesRSp = Run("Select sum(nettotal) as TotalSalesReturn  from DataOutReturn where Bid = '" . $bid . "' and  cast(BillDate as Date) = '" . $vdate . "' and SPType<>0");
								$TotalSalesReturn  = myfetch($salesRSp)->TotalSalesReturn;
								$TotalSalesReturn  = !empty($TotalSalesReturn) ? $TotalSalesReturn : '0';

								$salescashQ = Run("Select sum(nettotal) as salesreturncash from DataOutReturn where Bid = '" . $bid . "' and  cast(BillDate as Date) = '" . $vdate . "' and SPType='1';");
								$salesreturncash = myfetch($salescashQ)->salesreturncash;
								$salesreturncash  = !empty($salesreturncash) ? $salesreturncash : '0';
								$salescreditQ = Run("Select sum(nettotal) as salesreturncredit  from DataOutReturn where Bid = '" . $bid . "' and  cast(BillDate as Date) = '" . $vdate . "' and SPType='2'");
								$salesreturncredit  = myfetch($salescreditQ)->salesreturncredit;
								$salesreturncredit  = !empty($salesreturncredit) ? $salesreturncredit : '0';

								$Netsales = $TotalSales - $TotalSalesReturn;
								$Netsales  = !empty($Netsales) ? $Netsales : '0';


								/////////// Cash REceipt Entry////

								$casRecQ = Run("select sum(Receipt.nettotal) as casRec,bank.snameEng,Receipt.bnkid from Receipt
inner join bank on bank.id = Receipt.bnkid where Receipt.Bid = '" . $bid . "' and bank.IsCash=1
and  cast(Receipt.BillDate as Date) = '" . $vdate . "'  group by Receipt.bnkid,Bank.snameEng");
								$casRec  = myfetch($casRecQ)->casRec;
								$casRec  = !empty($casRec) ? $casRec : '0';

								$cashEntry = ($casRec + $TotalSales) - $TotalSalesReturn;
								$cashEntry  = !empty($cashEntry) ? $cashEntry : '0';

								?>
								<div class="content_form">
									<div class="mb-3">
										<a href="javascript:;" style="background-color: #34465d !important;" class="btn btn-light p-3 enBtn">Sales <b>(<?= AmountValue($TotalSales) ?>)</b> </a>
										<a href="javascript:;" style="background-color: #34465d !important;" class="btn btn-light p-3 arBtn"><b>(<?= AmountValue($TotalSales) ?>)</b> <?= getArabicTitle('Sales') ?></a>
									</div>
									<div class="mb-3">
										<a href="javascript:;" style="width: 45%;float: left; background-color: #00aff0;" class="btn btn-light p-3 enBtn">Cash <b>(<?= AmountValue($salescash) ?>)</b></a>
										<a href="javascript:;" style="width: 45%;float: left; background-color: #00aff0;" class="btn btn-light p-3 arBtn"><b>(<?= AmountValue($salescash) ?>)</b> <?= getArabicTitle('Cash') ?></a>


										<a href="javascript:; " style="width: 45%; float: right; background-color: #34465d !important;" class="btn btn-light p-3 enBtn">Credit <b>(<?= AmountValue($salescredit) ?>)</b></a>
										<a href="javascript:;" style="width: 45%;float: right; background-color: #34465d !important;" class="btn btn-light p-3 arBtn"><b>(<?= AmountValue($salescredit) ?>)</b> <?= getArabicTitle('Credit') ?></a>

									</div>



									<div class="mb-3" style="margin-top: 35%;">
										<a href="javascript:;" style="background-color: #34465d !important;" class="btn btn-light p-3 enBtn">Sales Return <b>(<?= AmountValue($TotalSalesReturn) ?>)</b> </a>
										<a href="javascript:;" style="background-color: #34465d !important;" class="btn btn-light p-3 arBtn"><b>(<?= AmountValue($TotalSalesReturn) ?>)</b> <?= getArabicTitle('Sales Return') ?></a>
									</div>
									<div class="mb-3">
										<a href="javascript:;" style="width: 45%;float: left; background-color: #00aff0 !important;" class="btn btn-light p-3 enBtn">Cash <b>(<?= AmountValue($salesreturncash) ?>)</b></a>
										<a href="javascript:;" style="width: 45%;float: left; background-color: #00aff0 !important;" class="btn btn-light p-3 arBtn"><b>(<?= AmountValue($salesreturncash) ?>)</b> <?= getArabicTitle('Cash') ?></a>

										<a href="javascript:; " style="width: 45%; float: right; background-color: #34465d !important;" class="btn btn-light p-3 enBtn">Credit <b>(<?= AmountValue($salesreturncredit) ?>)</b></a>
										<a href="javascript:;" style="width: 45%;float: right; background-color: #34465d !important;" class="btn btn-light p-3 arBtn"><b>(<?= AmountValue($salesreturncredit) ?>)</b> <?= getArabicTitle('Credit') ?></a>

									</div>

									<div class="mb-3" style="margin-top: 35%;">
										<a href="javascript:;" style="background-color: #34465d !important;" class="btn btn-light p-3 enBtn">Net Sales <b>(<?= AmountValue($Netsales) ?>)</b> </a>
										<a href="javascript:;" style="background-color: #34465d !important;" class="btn btn-light p-3 arBtn"><b>(<?= AmountValue($Netsales) ?>)</b> <?= getArabicTitle('Net Sales') ?></a>
									</div>
									<div class="mb-3">
										<a href="javascript:;" style="background-color: #00aff0 !important;" class="btn btn-light p-3 enBtn">Cash <b>(<?= AmountValue($salescash + $casRec) ?>)</b> </a>
										<a href="javascript:;" style="background-color: #00aff0 !important;" class="btn btn-light p-3 arBtn"><b>(<?= AmountValue($salescash + $casRec) ?>)</b> <?= getArabicTitle('Cash') ?></a>
									</div>

									<div class="mb-3">
										<a href="javascript:;" style="background-color: #34465d !important;" class="btn btn-light p-3 enBtn">Cash Receipt <b>(<?= AmountValue($casRec) ?>)</b> </a>
										<a href="javascript:;" style="background-color: #34465d !important;" class="btn btn-light p-3 arBtn"><b>(<?= AmountValue($casRec) ?>)</b> <?= getArabicTitle('Cash Receipt') ?></a>
									</div>

									<?php
									$ReceBnakQ = Run("select sum(Receipt.nettotal) as credit,bank.snameEng,Receipt.bnkid from Receipt
inner join bank on bank.id = Receipt.bnkid where Receipt.Bid = '" . $bid . "' and bank.IsCash=0
and  cast(Receipt.BillDate as Date) = '" . $vdate . "' group by Receipt.bnkid,Bank.snameEng");
									while ($getV = myfetch($ReceBnakQ)) {
									?>

										<div class="mb-3">
											<a href="javascript:;" class="btn btn-light p-3 enBtn"><?= $getV->snameEng ?> <b>(<?= AmountValue($getV)->credit ?>)</b> </a>
											<a href="javascript:;" style="background-color: #00aff0;" class="btn btn-light p-3 arBtn"><b>(<?= AmountValue($getV)->credit ?>)</b> <?= getArabicTitle($getV->snameEng) ?></a>
										</div>
									<?php
									}

									?>


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