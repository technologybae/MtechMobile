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
            <?php if ($lang == 1) {
                echo "display: none;";
            } ?>
        }

        .arBtn {
            <?php if ($lang == 1) {
                echo "display: none;";
            } ?>
        }

        .direction {
            <?php if ($lang == 1) {
                echo " direction: ltr;";
            } else {
                echo "direction: rtl;";
            } ?>
        }

        .direction-ltr {
            direction: ltr !important;
        }

        .direction-rtl {
            direction: rtl !important;
        }

        .en {
            text-align: left;
            <?php if ($lang == 2) {
                echo "display: none;";
            } ?>
        }

        .enBtn {
            <?php if ($lang == 2) {
                echo "display: none;";
            } ?>
        }

        .form-label {
            display: grid;
        }

        .contents{
            display: contents !important;
        }
    </style>
</head>

<body>
    <?php
    include("header.php");
    ?>
    <form id="customer_form">
        <section>
            <?php
            $CCode = $_GET['CCode'];
            $bid = $_GET['bid'];
            $que = "select * from CustFile where CCode='" . $CCode . "' and bid='" . $bid . "' ";
            $execute = Run($que);
            $getData = myfetch($execute);
            ?>

            <div class="slide-form justify-content-center">
                <div id="saveSalesForm"></div>
                <div class="slide-box glass">
                    <div class="content">
						<h2 class="heading_fixed"><span class="en">Update Customer</span><span class="ar"> <?= getArabicTitle('Update Customer') ?></span></h2>
                    </div>
                    <div class="content_form">
                        <div class="form_list">
                            <div id="customerForm"></div>
                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Branch</span><span class="ar"> <?= getArabicTitle('Branch') ?></span></label>
                                <div>
                                    <select class="form-select direction" name="Bid" id="Bid" aria-label="sales-men">
                                        <?php
                                        $Bracnhes = Run("Select * from " . dbObject . "Branch order by BName ASC");
                                        while ($getBranches = myfetch($Bracnhes)) {
                                            $selected = "";
                                            if ($_GET['branc'] != '') {
                                                if ($getBranches->ismain == '1') {
                                                    $selected = "Selected";
                                                }
                                            }
                                        ?>
                                            <option value="<?php echo $getBranches->Bid; ?>" <?php if ($getData->bid == $getBranches->Bid) { ?> selected <?php } ?>><?php echo $getBranches->BName; ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Code</span><span class="ar"> <?= getArabicTitle('Code') ?></span></label>
                                <input type="text" class="form-control direction" name="CCode" id="CCode" readonly value="<?= $getData->CCode ?>">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Name</span><span class="ar"> <?= getArabicTitle('Name') ?></span></label>
                                <input type="text" class="form-control direction" name="CName" id="CName" value="<?= $getData->CName ?>">
                            </div>


                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Description</span><span class="ar"> <?= getArabicTitle('Description') ?></span></label>
                                <textarea class="form-control direction" name="Description" id="Description"><?= $getData->Description ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Address</span><span class="ar"> <?= getArabicTitle('Address') ?></span></label>
                                <textarea class="form-control direction" name="Address" id="Address"><?= $getData->Address ?></textarea>
                            </div>


                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Phone</span><span class="ar"> <?= getArabicTitle('Phone') ?></span></label>
                                <input type="number" class="form-control direction" name="Contact1" id="Contact1" value="<?= $getData->Contact1 ?>">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Email</span><span class="ar"> <?= getArabicTitle('Email') ?></span></label>
                                <input type="email" class="form-control direction" name="Email" id="Email" value="<?= $getData->Email ?>">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Opening Balance</span><span class="ar"> <?= getArabicTitle('Opening Balance') ?></span></label>
                                <input type="number" min="0" class="form-control direction" name="OpenBalance" id="OpenBalance" value="<?= $getData->OpenBalance ?>">
                            </div>

                            <div class="mb-3">
                                <label for="VatNo" class="form-label"><span class="en">Vat No</span><span class="ar"> <?= getArabicTitle('Vat No') ?></span></label>
                                <input type="text" class="form-control direction" name="VatNo" id="VatNo" value="<?= $getData->VatNo ?>">
                            </div>

                            <div class="mb-3">
                                <label for="NTNNo" class="form-label"><span class="en">Opening Balance Debit</span><span class="ar"> <?= getArabicTitle('Opening Balance Debit') ?></span></label>
                                <input type="number" min="0" class="form-control direction" name="openDebit" id="openDebit" value="<?= $getData->openDebit ?>">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label"><span class="en">Sales Man</span><span class="ar"> <?= getArabicTitle('Sales Man') ?></span></label>
                                <div>
                                    <select class="form-select direction" id="salesMan" name="Salesman" aria-label="sales-men">
                                        <?php
                                        if ($getData->Salesman) {
                                            $getUserDetails = getUserDetails($getData->Salesman);
                                        ?>
                                            <option value="<?php echo $getData->Salesman ?>" Selected><?php echo $getUserDetails->CCode . " - " . $getUserDetails->CName ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>








                            <div class="mb-3 overflow-hidden">
                                <button type="button" class="btn btn-success btn-actions float-end submit-next enBtn" onclick="customerUpdateValidation();">Update <i class="fa fa-arrow-right icon-font"></i></button>
                                <button type="button" class="btn btn-success btn-actions float-end submit-next arBtn" onclick="customerUpdateValidation();"><i class="fa fa-arrow-left icon-font"></i> <?= getArabicTitle('Update') ?></button>
                            </div>

                        </div>
                    </div>
                    <div class="m-5" id="customerFormData"></div>
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
<script src="includes/customers/js.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

</html>
<script>
    $("#Bid").select2({});
</script>