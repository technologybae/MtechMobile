<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
include("../../config/functions.php");
$Pcode = addslashes(trim($_POST['Pcode']));
$Bid = addslashes(trim($_POST['Bid']));
//$product = addslashes($_POST['product']);
$unit = addslashes($_POST['unit']);
$unit_id = addslashes($_POST['unit_id']);
$qty = addslashes($_POST['qty']);
$Sprice = addslashes($_POST['Sprice']);
$vatSprice = addslashes($_POST['vatSprice']);
$vatPer = addslashes($_POST['vatPer']);
$vatAmt = addslashes($_POST['vatAmt']);
$isVat = addslashes($_POST['isVat']);
$row_count = addslashes($_POST['row_count']);

$region = $_SESSION['region'];
if ($region == '1') {
    $sp = "EXECUTE " . dbObject . "GetProductSearchByCode @pCode='$Pcode' ,@bid='$Bid'";
}
if ($region == "2") {
    $sp = "EXECUTE " . dbObject . "Getproductsearchbycodeweb @pCode='$Pcode' ,@bid='$Bid'";
}
$QueryMax = Run($sp);
$getDetails = myfetch($QueryMax);
$product = $getDetails->pname;
$Pid = $getDetails->pid;

//// ALl Hidden Fields Calculations///
$total_with_tax = $qty * $vatSprice;
$total_without_tax = $qty * $Sprice;
$NetTotalWithTax = $total_with_tax;
$NetTotalWithOutTax = $total_without_tax;
?>

<div class="mb-3 card p-4" id="<?php echo $row_count ?>">
    <h5><?php echo $Pcode ?>-<?php echo $product ?></h5>
    <ul>
        <li>
            <!-- <p><span>Unit :</span><span><?php echo $unit ?></span></p> -->
            <p><span class="en">Unit :</span><span class="ar"><?= getArabicTitle('Unit') ?>:</span><span><?php echo $unit ?></span></p>
        </li>
        <li>
            <!-- <p><span>Qty :</span><span class="hide_span_qty<?php echo $row_count ?>"><?php echo $qty ?></span></p> -->
            <p><span class="en">Qty :</span><span class="ar"><?= getArabicTitle('Qty') ?>:</span><span class="hide_span_qty<?php echo $row_count ?>"><?php echo $qty ?></span></p>
            <input type="hidden" name="qty<?php echo $row_count ?>" id="qty<?php echo $row_count ?>" value="<?php echo $qty ?>" class="form-control tot_qty" onkeyup="qtyPriceTotal('<?php echo $row_count ?>')">
        </li>
        <li>
            <!-- <p><span>Price:</span><span class="hide_Sprice<?php echo $row_count ?>"><?php echo $Sprice ?></span></p> -->
            <p><span class="en">Price :</span><span class="ar"><?= getArabicTitle('Price') ?>:</span><span class="hide_Sprice<?php echo $row_count ?>"><?php echo $Sprice ?></span></p>
            <input type="hidden" name="Sprice<?php echo $row_count ?>" id="Sprice<?php echo $row_count ?>" value="<?php echo $Sprice ?>" class="form-control" onKeyUp="PricecalculationsRow(this.value,'vatSprice','<?= $row_count ?>');">
        </li>

        <li>
            <!-- <p><span>NetTotal:</span><span class="hide_Nettotal<?php echo $row_count ?>"><?php echo $Sprice * $qty ?></span></p> -->
            <p><span class="en">NetTotal :</span><span class="ar"><?= getArabicTitle('NetTotal') ?>:</span><span class="hide_Nettotal<?php echo $row_count ?>"><?php echo $Sprice * $qty ?></span></p>
            <input type="hidden" name="netT<?php echo $row_count ?>" id="netT<?php echo $row_count ?>" value="<?php echo $Sprice * $qty; ?>" class="form-control tot_Sprice">
        </li>


        <li>
            <!-- <p><span>Vat Amt:</span><span class="hide_vatAmt<?php echo $row_count ?>"><?php echo $vatAmt ?></span></p> -->
            <p><span class="en">Vat Amt :</span><span class="ar"><?= getArabicTitle('Vat Amt') ?>:</span><span class="hide_vatAmt<?php echo $row_count ?>"><?php echo $vatAmt ?></span></p>
            <input type="hidden" name="vatAmt<?php echo $row_count ?>" id="vatAmt<?php echo $row_count ?>" value="<?php echo $vatAmt ?>" class="form-control tot_vatAmt">
            <input type="hidden" name="rowvatAmt<?php echo $row_count ?>" id="rowvatAmt<?php echo $row_count ?>" value="<?php echo $vatAmt * $qty ?>" class="form-control tot_rowvatAmt">
        </li>


        <li>
            <!-- <p><span>Vat Per:</span><span class="hide_vatper<?php echo $row_count ?>"><?php echo $vatPer ?></span></p> -->
            <p><span class="en">Vat Per :</span><span class="ar"><?= getArabicTitle('Vat Per') ?>:</span><span class="hide_vatper<?php echo $row_count ?>"><?php echo $vatPer ?></span></p>
            <input type="hidden" name="vatPer<?php echo $row_count ?>" id="vatPer<?php echo $row_count ?>" value="<?php echo $vatPer ?>" class="form-control tot_vatPer">

        </li>

        <li>
            <!-- <p><span>Grand Total :</span><span class="hide_vatSprice<?php echo $row_count ?>" id="hide_vatSprice<?php echo $row_count ?>"><?php echo $vatSprice ?></span></p> -->
            <p><span class="en">Grand Total :</span><span class="ar"><?= getArabicTitle('Grand Total') ?>:</span><span class="hide_vatSprice<?php echo $row_count ?>" id="hide_vatSprice<?php echo $row_count ?>"><?php echo $vatSprice ?></span></p>
            <input type="hidden" name="vatSprice<?php echo $row_count ?>" id="vatSprice<?php echo $row_count ?>" value="<?php echo $vatSprice ?>" readonly class="form-control tot_vatSprice" readonly>
        </li>

        <input type="hidden" name="Pid<?php echo $row_count ?>" id="Pid<?php echo $row_count ?>" value="<?= $Pid ?>">
        <input type="hidden" name="PCode<?php echo $row_count ?>" id="PCode<?php echo $row_count ?>" value="<?php echo $Pcode ?>">
        <input type="hidden" name="unit<?php echo $row_count ?>" id="unit<?php echo $row_count ?>" value="<?php echo $unit ?>">
        <input type="hidden" name="Uid<?php echo $row_count ?>" id="Uid<?php echo $row_count ?>" value="<?php echo $unit_id ?>">

        <input type="hidden" name="autono<?php echo $row_count ?>" id="autono<?php echo $row_count ?>" value="<?php echo $row_count ?>" class="form-control">
    </ul>
    <div class="action direction">
        <div class="a__a" id="action_button<?php echo $row_count ?>">
            <a href="#" onclick="editRow('<?php echo $row_count ?>','0')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
        </div>
        <div class="a__a">
            <a href="#" onclick="deleteRow('<?php echo $row_count ?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
<div id=""></div>