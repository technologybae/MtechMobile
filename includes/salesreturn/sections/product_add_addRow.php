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
?>

<div class="content">
	<h2 class="heading_fixed">Sales Return Voucher</h2>
</div>
<div id="fetchProductDetails"></div>
<div class="content_form">
	<div class="form_list">
		<?php
		$row_count = 1;
		$tt = "EXECUTE " . dbObject . "SPSalDetSelectWeb @Billno=$Billno,@Bid=$Bid,@sBid=$sBid";
		$detailsSp = Run($tt);
		while ($getDetails = myfetch($detailsSp)) {
			$Pcode = $getDetails->PCode;
			$Pid = $getDetails->pid;
			$product = $getDetails->PName;
			$unit = $getDetails->UnitName;
			$qty = $getDetails->Qty;
			$Sprice = round($getDetails->Price, 2);
			$vatAmt = round($getDetails->vatAmt, 2);
			$vatPer = $getDetails->vatPer;
			$vatSprice = round($getDetails->vatPTotal, 2);
			$unit_id = $getDetails->uid;
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
						<input type="hidden" name="qty<?php echo $row_count ?>" id="qty<?php echo $row_count ?>" value="<?php echo $qty ?>" class="form-control tot_qty" onkeyup="qtyPriceTotal('<?php echo $row_count ?>')" max="<?= $qty ?>">
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
				<div class="action">
					<div class="a__a" id="action_button<?php echo $row_count ?>">
						<a href="#" onclick="editRow('<?php echo $row_count ?>','0')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
					</div>
					<div class="a__a">
						<a href="#" onclick="deleteRow('<?php echo $row_count ?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					</div>
				</div>
			</div>
		<?php
			$row_count++;
		}
		?>

		<input type="hidden" name="row_count" id="row_count" value="<?= $row_count - 1 ?>">


		<div class="mb-3 overflow-hidden direction">
			<button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back</button>
			<button type="button" class="btn btn-success btn-actions float-end submit-next" onclick="calculateAllTotals(this)">Next <i class="fa fa-arrow-right icon-font"></i></button>
		</div>
	</div>
</div>