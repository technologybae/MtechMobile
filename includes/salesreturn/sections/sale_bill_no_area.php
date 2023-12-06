<?php
session_start();
error_reporting(0);
include("../../../config/connection.php");
include("../../../config/functions.php");
$Bid = addslashes(trim($_POST['Bid']));
$Billno = addslashes(trim($_POST['Billno']));
$Bid = !empty($Bid) ? $Bid : '2';
$Billno = !empty($Billno) ? $Billno : '0';
$Billno = (int)$Billno;
$sBid = !empty($sBid) ? $sBid : '1';
$LanguageId = $_REQUEST['LanguageId'];
$LanguageId = !empty($LanguageId) ? $LanguageId : '1';
$ab = "Exec " . dbObject . "SPSalesSelectWeb @SrchBy=1,@Billno=$Billno,@Bid=$Bid,@sBid=1,@LanguageId=$LanguageId,@FRecNo=0,@ToRecNo=1";
$storeProcedure = Run($ab);
$myFetch = myfetch($storeProcedure);
?>
<script>
    $('#sale_bill_option').addClass('done');
    $('#sale_bill_no_area').removeClass('slided');
</script>
<div class="content">
    <h2 class="heading_fixed enBtn">Sales Return Voucher</h2>
    <h2 class="heading_fixed arBtn"><?= getArabicTitle('Sales Return Voucher') ?></h2>
</div>
<div class="content_form">
    <div class="form_list">

        <div class="mb-3">
            <!-- <label for="" class="form-label">Date :</label> -->
            <label for="" class="form-label"><span class="en">Date :</span><span class="ar"><?= getArabicTitle('Date') ?> :</span></label>
            <input value="<?= $myFetch->BillDate ?>" id="bill_date_time" name="bill_date_time" type="datetime-local" class="form-control direction">
        </div>
        <div class="mb-3">
            <!-- <label for="" class="form-label"> Reference no </label> -->
            <label for="" class="form-label"><span class="en">Reference No :</span><span class="ar"><?= getArabicTitle('Reference No') ?> :</span></label>
            <input type="text" class="form-control direction" name="RefNo1" id="RefNo1" readonly value="<?= $myFetch->sbBillno ?>">
        </div>
        <div class="mb-3">
            <!-- <label for="" class="form-label">Sales Man </label> -->
            <label for="" class="form-label"><span class="en">Sales Man :</span><span class="ar"><?= getArabicTitle('Sales Man') ?> :</span></label>
            <div>

                <?php
                $jk = "select  Cid Id,CCode + ' - ' + Cname CName from Emp Where  isnull(IsDeleted,0)=0 and Cid = '" . $myFetch->EmpID . "' order by Cid";
                $query = Run($jk);
                $loadEMployees = myfetch($query);
                ?>
                <select class="form-select direction" id="salesMan" name="EmpID" aria-label="sales-men">
                    <option value="<?= $loadEMployees->Id ?>"><?= $loadEMployees->CName ?></option>
                </select>
            </div>

        </div>
        <!-- <div class="mb-3 overflow-hidden">
            <button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="location.reload()"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Reload</button>
            <button type="button" class="btn btn-success btn-actions float-end submit-next" onclick="validateRefrenceNo(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
        </div> -->

        <div class="mb-3 overflow-hidden">
        <button type="button" class="btn btn-info btn-actions float-start back text-white enBtn" onclick="location.reload()"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Reload</button>
        <button type="button" class="btn btn-info btn-actions float-start back text-white arBtn" onclick="location.reload()"><?= getArabicTitle('Reload') ?>&nbsp;<i class="fa fa-arrow-right icon-font"></i></button>

        <button type="button" class="btn btn-success btn-actions float-end submit-next enBtn" onclick="validateRefrenceNo(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
        <button type="button" class="btn btn-success btn-actions float-end submit-next arBtn" onclick="validateRefrenceNo(this)"><i class="fa fa-arrow-left icon-font"></i> <?= getArabicTitle('Next') ?></button>
    </div>
    </div>
</div>