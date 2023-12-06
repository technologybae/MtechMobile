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

        .form-label {
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
                            <h2 class="heading_fixed enBtn">Stock Report</h2>
                            <h2 class="heading_fixed arBtn"><?= getArabicTitle('Stock Report') ?></h2>
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
                                    <label for="" class="form-label"><span class="en">From Date</span><span class="ar"> <?= getArabicTitle('From Date') ?></span></label>
                                    <input id="from_date" name="from_date" type="date" class="form-control direction" value="<?php echo $_GET['from_date'] ?>" autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label"><span class="en">To Date</span><span class="ar"> <?= getArabicTitle('To Date') ?></span></label>
                                    <input id="to_date" name="to_date" type="date" class="form-control direction" value="<?php echo $_GET['to_date'] ?>" autocomplete="off">
                                </div>
                                <?php /*?>	
<div class="mb-3">
<label for="" class="form-label add_icon">From Item</label>
<div>
<select id="from_item_name" name="from_item_name" class="js-states form-control">
<?php
if (isset($_GET['from_item_name']) && !empty($_GET['from_item_name'])) {
?>
<option value="<?php echo $_GET['from_item_name']; ?>" selected> <?php echo getProductDetails($_GET['from_item_name'])->CName; ?> -
</option>
<?php
}
?>
</select>
</div>
</div>

<div class="mb-3">
<label for="" class="form-label add_icon">To Item</label>
<div>
<select id="to_item_name" name="to_item_name" class="js-states form-control">
<?php
if (isset($_GET['to_item_name']) && !empty($_GET['to_item_name'])) {
?>
<option value="<?php echo $_GET['to_item_name']; ?>" selected> <?php echo getProductDetails($_GET['to_item_name'])->CName; ?> -
</option>
<?php
}
?>
</select>
</div>
</div>

<?php */ ?>

                                <div class="mb-3">
                                    <label for="" class="form-label"><span class="en">Product Group</span><span class="ar"> <?= getArabicTitle('Product Group') ?></span></label>
                                    <div>
                                        <select id="product_group_name" name="Gids[]" class="js-states form-control direction" multiple>
                                            <?php


                                            if (isset($_GET['Gids']) && !empty($_GET['Gids'])) {


                                                foreach ($_GET['Gids'] as $ss) {


                                            ?>
                                                    <option value="<?php echo $ss; ?>" selected> <?php echo getProductGroupDetails($ss)->CName; ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="" class="form-label"><span class="en">Products</span><span class="ar"> <?= getArabicTitle('Products') ?></span></label>
                                    <div>
                                        <select id="product_name" name="Pids[]" class="js-states form-control direction" multiple>
                                            <?php


                                            if (isset($_GET['Pids']) && !empty($_GET['Pids'])) {
                                                foreach ($_GET['Pids'] as $ss) {
                                            ?>
                                                    <option value="<?php echo $ss; ?>" selected> <?php echo getProductDetails($ss)->CName; ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label"><span class="en">Multi Unit</span><span class="ar"> <?= getArabicTitle('Multi Unit') ?></span></label>
                                    <div>
                                        <select id="Ismultiunit" name="Ismultiunit" class="js-states form-control direction">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 overflow-hidden">
                                    <button type="button" class="btn btn-danger btn-actions float-end submit-next enBtn" onClick="loadPage('stock_report.php')">Clear</button>
                                    <button type="button" class="btn btn-danger btn-actions float-end submit-next arBtn" onClick="loadPage('stock_report.php')"><?= getArabicTitle('Clear') ?></button>

                                    <button type="submit" class="btn btn-success btn-actions float-end submit-next enBtn">Submit <i class="fa fa-arrow-right icon-font"></i></button>
                                    <button type="submit" class="btn btn-success btn-actions float-end submit-next arBtn"><i class="fa fa-arrow-left icon-font"></i> <?= getArabicTitle('Submit') ?></button>
                                </div>


                                <?php
                                if ($_SESSION['isAdmin'] == '1') {
                                    $branchesArray = array();
                                    $Bracnhes = Run("Select * from " . dbObject . "Branch order by BName ASC");
                                    while ($getBranches = myfetch($Bracnhes)) {
                                        array_push($branchesArray, $getBranches->Bid);
                                    }
                                    $branchIds = implode(",", $branchesArray);
                                } else {
                                    $Bracnhes = Run("Select " . dbObject . "Branch.Bid," . dbObject . "Branch.BName from " . dbObject . "Branch
Inner JOIN " . dbObject . "EMP  On " . dbObject . "EMP.BID = " . dbObject . "Branch.Bid
where " . dbObject . "EMP.WebCode = '" . $_SESSION['code'] . "' ");
                                    $getB = myfetch($Bracnhes);
                                    $bbid = $getB->Bid;
                                    $branchIds = $bbid;
                                }

                                $Bid = $_GET['Bid'];
                                if ($Bid != '') {
                                    $branchIds = $Bid;
                                }

                                $bid = $branchIds;

                                $OrderBy = '1';



                                if (isset($_GET['from_date']) && !empty($_GET['from_date'])) {
                                    $from_date = urldecode($_GET['from_date']);
                                    $from_date = date("Y-m-d", strtotime($from_date));
                                    $dt = $from_date;
                                }






                                if (isset($_GET['to_date']) && !empty($_GET['to_date'])) {
                                    $to_date = urldecode($_GET['to_date']);
                                    $to_date = date("Y-m-d", strtotime($to_date));
                                    $dt2 = $to_date;
                                }






                                $LanguageId = !empty($_REQUEST['LanguageId']) ? $_REQUEST['LanguageId'] : '1';
                                $OrderBy = 1;
                                $dt = !empty($dt) ? $dt : NULL;
                                $dt2 = !empty($dt2) ? $dt2 : NULL;
                                $FItemCode = !empty($_REQUEST['from_item_name']) ? $_REQUEST['from_item_name'] : '';
                                $TItemCode = !empty($_REQUEST['to_item_name']) ? $_REQUEST['to_item_name'] : '';
                                $ItemType = !empty($_REQUEST['ItemType']) ? $_REQUEST['ItemType'] : 0;
                                $suppid = !empty($_REQUEST['suppid']) ? $_REQUEST['suppid'] : 0;
                                $supGids = !empty($_REQUEST['supGids']) ? $_REQUEST['supGids'] : 0;
                                $Gids = implode(",", $_GET['Gids']);
                                $Gids = !empty($Gids) ? $Gids : '';
                                $condCriteria = !empty($_REQUEST['condCriteria']) ? $_REQUEST['condCriteria'] : '';
                                $PurInv = !empty($_REQUEST['PurInv']) ? $_REQUEST['PurInv'] : '';
                                $Ismultiunit = !empty($_REQUEST['Ismultiunit']) ? $_REQUEST['Ismultiunit'] : 0;
                                $ProdGrpCombine = !empty($_REQUEST['ProdGrpCombine']) ? $_REQUEST['ProdGrpCombine'] : '';
                                $IsDelvEffectStock = !empty($_REQUEST['IsDelvEffectStock']) ? $_REQUEST['IsDelvEffectStock'] : 0;
                                $IsPurEfctStock = !empty($_REQUEST['IsPurEfctStock']) ? $_REQUEST['IsPurEfctStock'] : '1';
                                $IsMultiProduction = !empty($_REQUEST['IsMultiProduction']) ? $_REQUEST['IsMultiProduction'] : 0;
                                $PromotionBillNo = !empty($_REQUEST['PromotionBillNo']) ? $_REQUEST['PromotionBillNo'] : '';
                                $FPid = !empty($_REQUEST['from_product_id']) ? $_REQUEST['from_product_id'] : 0;

                                $TPid = !empty($_REQUEST['to_product_id']) ? $_REQUEST['to_product_id'] : 0;

                                $pids = implode(",", $_GET['Pids']);
                                $pids = !empty($pids) ? $pids : '';
                                $CBid = !empty($_REQUEST['CBid']) ? $_REQUEST['CBid'] : '1';
                                $CrPrice = !empty($_REQUEST['CrPrice']) ? $_REQUEST['CrPrice'] : '';
                                $OrderyBy = '1';







                                include('pagination/paginator.class.php');

                                $pages = new Paginator;

                                ?>
                                <div class="mb-3">
                                    <?php

                                    $mainStoreProcedure = "EXEC  " . dbObject . "GetProdDetStock @bid='" . $bid . "',
@dt='" . $dt . "',
@dt2='" . $dt2 . "',
@FItemCode='" . $FItemCode . "',
@TItemCode='" . $TItemCode . "', 
@ItemType='" . $ItemType . "', 
@suppid='" . $suppid . "', 
@supGids='" . $supGids . "',
@pids='" . $pids . "',
@Gids='" . $Gids . "',
@CBid='" . $CBid . "',
@condCriteria='" . $condCriteria . "',
@PurInv='" . $PurInv . "', 
@Ismultiunit='" . $Ismultiunit . "', @ProdGrpCombine='" . $ProdGrpCombine . "', @IsDelvEffectStock='" . $IsDelvEffectStock . "', @IsPurEfctStock='" . $IsPurEfctStock . "', 
@FPid='" . $FPid . "', 
@TPid='" . $TPid . "', 
@CrPrice='" . $CrPrice . "', @IsMultiProduction='" . $IsMultiProduction . "', @PromotionBillNo='" . $PromotionBillNo . "', @OrderyBy='" . $OrderyBy . "', 
@LanguageId='" . $LanguageId . "' ";
                                    $initialLimit = ",@FRecNo=0,@ToRecNo=15";
                                    $DataType = ",@DataType=1";



                                    ///// Get Total Count/////
                                    $sql_ = $mainStoreProcedure . $DataType . $initialLimit;

                                    $sql_forms = Run($sql_);
                                    $tolrec = myfetch($sql_forms)->RecNo;








                                    ///// Get SUM/////
                                    $DataType = ",@DataType=2";
                                    $sumQuery = Run($mainStoreProcedure . $DataType . $initialLimit);
                                    $fetchAllTotals = colfetch($sumQuery)[0];









                                    $pages->default_ipp = 15;
                                    $pages->items_total = $tolrec;
                                    $pages->mid_range = 9;
                                    $pages->paginate();

                                    $DataType = ",@DataType=3";
                                    $initialLimit = "," . $pages->limit;

                                    ///// Main Query/////
                                    $mmQ = $mainStoreProcedure . $DataType . $initialLimit;
                                    $result = Run($mmQ);


                                    ?>



                                    <!-- Listing -->
                                    <table class="table table-striped table-bordered dt-responsive table-hover direction ">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%;">#</th>
                                                <th style="width: 15%;"><span class="en">Pcode</span><span class="ar"> <?= getArabicTitle('Pcode') ?></span></th>
                                                <th style="width: 15%;"><span class="en">PName</span><span class="ar"> <?= getArabicTitle('PName') ?></span></th>
                                                <th style="width: 15%;"><span class="en">Unit</span><span class="ar"> <?= getArabicTitle('Unit') ?></span></th>
                                                <th style="width: 15%;"><span class="en">Multi Unit Balance</span><span class="ar"> <?= getArabicTitle('Multi Unit Balance') ?></span></th>
                                                <th style="width: 15%;"><span class="en">Balance</span><span class="ar"> <?= getArabicTitle('Balance') ?></span></th>
                                            </tr>

                                        </thead>
                                        <tbody>


                                            <?php
                                            if ($pages->items_total > 0) {
                                                $cnt = 1;
                                                while ($single  =   myfetch($result)) {
                                            ?>
                                                    <tr>
                                                        <td><?= $cnt ?></td>
                                                        <td><?= $single->ProductCode ?></td>
                                                        <td><?= $single->ProductName ?></td>
                                                        <td><?= $single->UnitName ?></td>
                                                        <td><?= $single->ProductDesc ?></td>
                                                        <td><?= $single->Balance ?></td>
                                                    </tr>


                                                <?php
                                                    $cnt++;
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">
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

                                            <?php }


                                            ?>
                                        </div>

                                        <div class="clearfix"></div>

                                    </div>

                                    <!-- /bottom pagination -->



                                    <div class="clearfix"></div>

                                    <div class="clearfix"></div>

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
<script src="includes/product_stock/js.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

</html>