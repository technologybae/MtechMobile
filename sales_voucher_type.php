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
                <div class="slide-box glass">
                    <div class="content">
                        <h2 class="heading_fixed enBtn">Sales Voucher</h2>
						<h2 class="heading_fixed arBtn"><?= getArabicTitle('Sales Voucher') ?></h2>
                    </div>
                    <div class="content_form">
                        <div class="mb-3">
                            <!-- <a href="sales_voucher.php" class="btn btn-light d-block p-3">New Invoice</a> -->
                            <a href="sales_voucher.php" class="btn btn-light d-block p-3"><span class="en">New Invoice</span><span class="ar"> <?= getArabicTitle('New Invoice') ?></span></a>

                        </div>

                        <div class="mb-3">
                            <!-- <a href="print_sales.php" class="btn btn-light d-block p-3">Print Invoice</a> -->
                            <a href="print_sales.php" class="btn btn-light d-block p-3"><span class="en">Print Invoice</span><span class="ar"> <?= getArabicTitle('Print Invoice') ?></span></a>
                        </div>


                        <div class="mb-3">
                            <!-- <a href="list_sales_voucher.php" class="btn btn-light d-block p-3">List Invoices</a> -->
                            <a href="list_sales_voucher.php" class="btn btn-light d-block p-3"><span class="en">List Invoices</span><span class="ar"> <?= getArabicTitle('List Invoices') ?></span></a>
                        </div>

                    </div>
                    <div class="m-5"></div>
                </div>











            </div>
        </section>
    </form>
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