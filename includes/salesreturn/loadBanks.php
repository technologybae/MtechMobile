<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
$code = addslashes(trim($_POST['code']));
$nrow = 1;
?>
<!-- <label for="" class="form-label add_icon">Banks</label> -->
<label for="" class="form-label"><span class="en">Banks : </span><span id="payment_screen_total"></span><span class="ar"><?= getArabicTitle('Banks') ?> :</span></label>


<table class="tabel table-bordered table-striped" style="width: 100%; margin-top: 10px;">
	<thead>
		<tr>
			<th align="center">#</th>
			<th align="center">Bank</th>
			<th align="center"><span class="en">Bank</span><span class="ar"> <?= getArabicTitle('Bank') ?></span></th>
			<th align="center"><span class="en">Amount</span><span class="ar"> <?= getArabicTitle('Amount') ?></span></th>

		</tr>
	</thead>
	<tbody>

		<?php
		$nrow = 1;
		$Bracnhes = Run("exec " . dbObject . "GetPaymentType @bid='$code'");
		while ($getBranches = myfetch($Bracnhes)) {
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
																													} ?>  " value="0" onKeyUp="CalculateRemainings()" <?php if ($nrow == 1) {
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