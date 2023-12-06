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
$SPType = $myFetch->SPType;
?>

<div class="content">
	<h2 class="heading_fixed enBtn">Sales Return Voucher</h2>
	<h2 class="heading_fixed arBtn"><?= getArabicTitle('Sales Return Voucher') ?></h2>
</div>
<div class="content_form">
	<div class="form_list">
		<div class="mb-3">
			<!-- <span>Grand Total :</span> <span id="payment_screen_total"> -->
			<label for="" class="form-label"><span class="en">Grand Total : </span><span class="ar"><?= getArabicTitle('Grand Total') ?> :</span><span id="payment_screen_total"></span></label>
		</div>
		<div class="mb-3" style="display: none;">
			<!-- <span>Remaining :</span> <span id="payment_screen_remaining"> -->
			<label for="" class="form-label"><span class="en">Remaining : </span><span id="payment_screen_remaining"></span><span class="ar"><?= getArabicTitle('Remaining') ?> :</span></label>
		</div>
		<div class="row mb-3">

			<?php
			if ($SPType == '1') {
			?>

				<div class="mb-3 col-6">
					<div class="form-check">
						<input class="form-check-input SPType direction" onClick="checkBankValue()" <?php if ($SPType == '1') {
																													echo "Checked";
																												} ?> type="radio" name="SPType" id="cash" value="1">
						<label class="form-check-label" for="cash">
							<span class="en">Cash</span>
							<span class="ar"><?= getArabicTitle('Cash') ?></span>
						</label>
					</div>
				</div>
			<?php
			}
			if ($SPType == '2') {

			?>
				<div class="mb-3 col-6">
					<div class="form-check">
						<input class="form-check-input SPType direction" type="radio" name="SPType" id="credit" <?php if ($SPType == '2') {
																													echo "Checked";
																												} ?> onClick="checkBankValue()" value="2">
						<label class="form-check-label" for="credit">
							<span class="en">Credit</span>
							<span class="ar"><?= getArabicTitle('Credit') ?></span>
						</label>
					</div>
				</div>

			<?php
			}
			?>
			<?php /*?>
<input type="button" onClick="bank_section('<?=$Bid?>','<?=$Billno?>','<?=$sBid?>',<?=$LanguageId?>);	" value="reload"><?php */ ?>
			<div class="mb-3">
				<!-- <label for="" class="form-label add_icon">Customer</label> -->
				<label for="" class="form-label add_icon"><span class="en">Customer</span><span class="ar"> <?= getArabicTitle('Customer') ?></span></label>
				<div>
					<select id="customer_id" name="customer_id" class="form-control direction">
						<?php
						if ($SPType != '1') {
							$CSID = $myFetch->CSID;
							$custQ = Run("select  Cid Id,CCode + ' - ' + Cname CName from " . dbObject . "CustFile Where  isnull(IsDeleted,0)=0 and Cid='" . $CSID . "' order by Cid");
							$getCust = myfetch($custQ);

						?>
							<option value="<?= $getCust->Id ?>"><?= $getCust->CName ?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="mb-3">
				<!-- <label for="" class="form-label add_icon">Shop Name</label> -->
				<label for="" class="form-label"><span class="en">Shop Name</span><span class="ar"> <?= getArabicTitle('Shop Name') ?></span></label>
				<input type="text" name="CustomerName" id="CustomerName" class="form-control direction" value="<?= $myFetch->CustomerName ?>">

			</div>

			<div class="mb-3">

				<div id="cashCreditOption" <?php if ($SPType != '1') {
												echo 'style="display:none"';
											} ?>>
					<!-- <label for="" class="form-label add_icon">Banks</label> -->
					<label for="" class="form-label add_icon"><span class="en">Banks</span><span class="ar"> <?= getArabicTitle('Banks') ?></span></label>
					<table class="tabel table-bordered table-striped" style="width: 100%; margin-top: 10px;">
						<thead>
							<tr>
								<th align="center">#</th>
								<th align="center"><span class="en">Bank</span><span class="ar"> <?= getArabicTitle('Bank') ?></span></th>
								<th align="center"><span class="en">Amount</span><span class="ar"> <?= getArabicTitle('Amount') ?></span></th>

							</tr>
						</thead>
						<tbody>
							<?php
							$nrow = 1;
							$Bracnhes = Run("exec " . dbObject . "GetPaymentType @bid='$Bid'");
							while ($getBranches = myfetch($Bracnhes)) {



								$query2 = Run("select d.paytype,b.snameArb,b.snameEng,d.remAmount ,d.amount from DataOutPayment d,Bank b Where b.id=d.paytype  and billno='" . $Billno . "' and d.bid='" . $Bid . "' and d.sbid='" . $sBid . "' and b.mbid='" . $Bid . "' and b.id='" . $getBranches->id . "'   order by d.id");
								$getD = myfetch($query2);
							?>
								<tr>
									<td align="center"><input type="hidden" id="Bank<?= $nrow ?>" name="Bank<?= $nrow ?>" class="form-control" value="<?php echo $getBranches->id; ?>" readonly> <input type="hidden" id="BankName<?= $nrow ?>" name="BankName<?= $nrow ?>" class="form-control" value="<?php echo $getBranches->snameEng; ?>" readonly>
										<?= $nrow ?></td>
									<td align="center">

										<?php echo $getBranches->snameEng; ?>

									</td>
									<td>
										<input type="text" id="sal_amount<?= $nrow ?>" name="sal_amount<?= $nrow ?>" class="form-control <?php if ($nrow != 1) {
																																				echo 'salAmnt';
																																			} ?>  " value="<?= $getD->amount ?>" onKeyUp="CalculateRemainings()" <?php if ($nrow == 1) {
																																																					echo 'readonly';
																																																				} ?>>
									</td>
								</tr>

							<?php
								$nrow++;
							}

							?>
						</tbody>
					</table>
					<input type="hidden" id="bankrows" name="bankrows" value="<?= $nrow ?>">
				</div>
			</div>

			<script>
				$(document).ready(function() {
					CalculateRemainings();
					$('#sal_amount2').focus();
				});
			</script>





		</div>


		<div class="mb-3 overflow-hidden direction">
			<button type="button" class="btn btn-info btn-actions float-start back text-white" onclick="prev(this);"><i class="fa fa-arrow-left icon-font"></i>&nbsp;Back</button>
			<button type="button" class="btn btn-success btn-actions float-end submit-next" onclick="customerValidation(this);">Finish & Save <i class="fa fa-arrow-right icon-font"></i></button>
		</div>
	</div>
</div>