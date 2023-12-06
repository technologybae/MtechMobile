<?php
session_start();
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
	</style>
</head>

<body>
	<?php include("header.php"); ?>
	<section class="">
		<div class="slide-form justify-content-center">
			<div action="#" class="glass">
				<div class="content">

				</div>
				<div class="content_form">
					<div class="mb-3">
						<!-- <a href="sales_voucher_type.php" class="btn btn-light d-block p-3"><?php echo ( $lang == 1) ? 'Sales' : getArabicTitle('Sales');?></a> -->
						<a href="sales_voucher_type.php" class="btn btn-light d-block p-3"><span class="en">Sales</span><span class="ar"> <?= getArabicTitle('Sales') ?></span></a>
						</div>
					<div class="mb-3">
						<a href="salesreturn_voucher_type.php" class="btn btn-light d-block p-3"><span class="en">Sales Return</span><span class="ar"> <?= getArabicTitle('Sales Return') ?></span></a>
					</div>
					<div class="mb-3">
						<a href="customers.php" class="btn btn-light d-block p-3"><span class="en">Customers</span><span class="ar"> <?= getArabicTitle('Customers') ?></span></a>
					</div>
					<div class="mb-3">
						<a href="receipt_voucher_type.php" class="btn btn-light d-block p-3"><span class="en">Receipt</span><span class="ar"> <?= getArabicTitle('Receipt') ?></span></a>
					</div>


					<div class="mb-3">
						<a href="list_closing.php" class="btn btn-light d-block p-3"><span class="en">Daily Report</span><span class="ar"> <?= getArabicTitle('Daily Report') ?></span></a>
					</div>

					<div class="mb-3">
						<a href="stock_report.php" class="btn btn-light d-block p-3"><span class="en">Stock Report</span><span class="ar"> <?= getArabicTitle('Stock Report') ?></span></a>
					</div>
					<?php /*?>   <div class="mb-3">
<a href="" class="btn btn-light d-block p-3">Advance</a>
</div><?php */ ?>
				</div>
			</div>
		</div>
	</section>
	<?php
	include("footer.php");
	?>
</body>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/custom.js"></script>

</html>