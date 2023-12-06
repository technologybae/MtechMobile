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
        
        .slide-box a{
            background-color: #34465d !important;
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
                        <div class="form_list" id="printInvoice">
                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Branch</span><span class="ar"> <?= getArabicTitle('Branch') ?></span></label>
                                <div>
                                    <select class="form-select direction" name="Bid" id="Bid" aria-label="sales-men">
                                        <?php


                                        if ($_SESSION['isAdmin'] == '1') {
                                            $Bracnhes = Run("Select * from " . dbObject . "Branch order by BName ASC");
                                        } else {
                                            $Bracnhes = Run("Select " . dbObject . "Branch.Bid," . dbObject . "Branch.BName from " . dbObject . "Branch Inner JOIN " . dbObject . "EMP  On " . dbObject . "EMP.BID = " . dbObject . "Branch.Bid where " . dbObject . "EMP.WebCode = '" . $_SESSION['code'] . "' ");
                                        }




                                        while ($getBranches = myfetch($Bracnhes)) {
                                            $selected = "";
                                            if ($_GET['branc'] != '') {
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
                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Bill no</span><span class="ar"> <?= getArabicTitle('Bill no') ?></span></label>
                                <input type="number" class="form-control direction" name="Billno" id="Billno">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Language</span><span class="ar"> <?= getArabicTitle('Language') ?></span></label>
                                <div>
                                    <select class="form-select direction" name="LanguageId" id="LanguageId" aria-label="sales-men">
                                        <option value="1">English</option>
                                        <option value="2">Arabic</option>
                                    </select>
                                </div>

                            </div>

                            <div class="mb-3 overflow-hidden">
                                <button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="loadPage('sales_voucher_type.php');"><i class="fa fa-arrow-left icon-font"></i> Back</button>
                                <button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="loadPage('sales_voucher_type.php');"><?= getArabicTitle('Back') ?> <i class="fa fa-arrow-right icon-font"></i></button>

                                <button type="submit" class="btn btn-success btn-actions float-end submit-next enBtn" onclick="printInvoice()">Submit <i class="fa fa-arrow-right icon-font"></i></button>
                                <button type="submit" class="btn btn-success btn-actions float-end submit-next arBtn" onclick="printInvoice()"><i class="fa fa-arrow-left icon-font"></i> <?= getArabicTitle('Submit') ?></button>
                            </div>

                        </div>
                    </div>
                    <div class="m-5"></div>
                </div>
            </div>
        </section>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="emailpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
    <div class="modal fade" id="printpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
    <div class="modal fade" id="ignismyModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" role="dialog">
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