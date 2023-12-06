<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
include("../../config/functions.php");
$customer_id = addslashes(trim($_POST['customer_id']));
$Bid = addslashes(trim($_POST['Bid']));
//$query1 = Run("select ( select SUM(Nettotal) as custBalance from dataoutdetail where CSID = '".$customer_id."' and SPTYPE='2' and Bid = '".$Bid."') - (Select SUM(NetTotal) as rectol from Receipt where CustomerID = '".$customer_id."' and Bid = '".$Bid."') as custBalance");
//$aab = "select ( select SUM(vatPTotal) as tlo from dataout where CSID = '".$customer_id."' and SPTYPE='2' and Bid = '".$Bid."') - (Select SUM(Total) as rectol from Receipt where CustomerID = '".$customer_id."' and Bid = '".$Bid."') as custBalance";
//   $aab = "select sum(Credit-Debit) as custBalance from V_CustBalance where cid='".$customer_id."' and bid = '".$Bid."'";
// $query1 = Run($aab);
//  $custBalance = myfetch($query1)->custBalance;
// $customer_Balance = round($custBalance,2);


$aab = "	EXEC " . dbObject . "GetCustomerBalalance @bid='$Bid',@dt='',@dt2='',@Cids='$customer_id',@LanguageId ='2',@IsIncludingZeroBal ='1',@OrderBy ='CCode',@UserId ='0',@CustAreaId ='0',@IsCombined ='1',@DataType=3,@FRecNo=0,@ToRecNo=15  ";
$query1 = Run($aab);
$custBalance = myfetch($query1)->Balance;
$customer_Balance = round($custBalance, 2);
?>
<div class="mb-3">
	<!-- <label for="" class="form-label">Balance :</label>  -->
	<label for="" class="form-label" id="custBalanceError"><span class="en">Balance : <?= $customer_Balance ?></span><span class="ar"><?= $customer_Balance ?><?= getArabicTitle('Balance') ?> :</span></label>
	<input value="<?= $customer_Balance ?>" id="cust_balance" name="cust_balance" type="hidden" class="form-control">
</div>

<div class="mb-3">
	<!-- <label for="" class="form-label">Total :</label> -->
	<label for="" class="form-label"><span class="en">Total :</span><span class="ar"><?= getArabicTitle('Total') ?> :</span></label>
	<input value="0" id="total" name="total" type="text" class="form-control direction" onkeyup="baki.value=this.value;TotVal(this.value);gridCalculation();mainCalculation();">
</div>


<div class="mb-3">
	<!-- <span>Disc% :</span>	 -->
	<label for="" class="form-label"><span class="en">Disc% :</span><span class="ar">: %<?= getArabicTitle('Disc') ?></span></label>

	<input type="text" id="disPer" name="disPer" value="0" class="form-control direction" onKeyUp="calculateWholeDiscountAmount(this.value)">
</div>
<div class="mb-3">
	<!-- <span>Disc Amount :</span> -->
	<label for="" class="form-label"><span class="en">Disc Amount :</span><span class="ar"><?= getArabicTitle('Disc Amount') ?> :</span></label>
	<input type="text" id="disAmt" name="disAmt" value="0" class="form-control direction" onKeyUp="calculateWholeDiscountper(this.value)">
</div>

<div class="mb-3 direction">
	<!-- <span class="en">Net Total: </span> <span class="span_netTotal">0</span> <span class="ar"> :<?= getArabicTitle('Net Total') ?></span> -->
	<label for="" class="direction"><span class="en">Net Total :</span> <span class="span_netTotal">0</span> <span class="ar"><?= getArabicTitle('Net Total') ?> :</span></label>
	<input type="hidden" id="netTotal" name="netTotal" value="0">
</div>


<div class="mb-3 direction">
	<!-- <span class="en">Advance :</span> <span id="span_Advance">0</span> <span class="ar"><?= getArabicTitle('Advance') ?> :</span> -->
	<label for="" class="direction"><span class="en">Advance :</span> <span class="span_Advance">0</span> <span class="ar"><?= getArabicTitle('Advance') ?> :</span></label>
	<input type="hidden" id="Advance" name="Advance" value="0">

	<input type="hidden" id="baki" name="baki" value="0">

</div>
<div class="mb-3">
	<!-- <label for="" class="form-label">Bank </label> -->
	<label for="" class="form-label"><span class="en">Bank</span><span class="ar"><?= getArabicTitle('Bank') ?></span></label>
	<div>
		<select class="form-select direction" name="bnkid" id="bnkid" aria-label="Banks">
			<?php
			$Bracnhes = Run("exec " . dbObject . "GetPaymentType @bid='$Bid'");
			while ($getBanks = myfetch($Bracnhes)) {
				$selected = "";
			?>
				<option value="<?php echo $getBanks->id; ?>" <?php echo $selected; ?>><?php echo $getBanks->snameEng; ?></option>
			<?php
			}

			?>
		</select>
	</div>
	</p>
</div>


<p>
	<a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
		<span class="en">Show All Invoices</span><span class="ar"><?= getArabicTitle('Show All Invoices') ?></span>
	</a>

</p>
<div class="collapse direction" id="collapseExample">
	<div class="card card-body">
		<?php
		$row_count = 1;
		//// QUery TO Get Pending Payments////
		$aaa = "Select Billno,sbBillno,vatPTotal,CSID,Bid,BillDate from dataout where SPType=2 and CSID = '" . $customer_id . "'  and Bid='" . $Bid . "' and sbBillno Not IN (Select sbBillno from RecieptDetails where billAmount>PaidAmount and CustomerID = '" . $customer_id . "' and Bid = '" . $Bid . "' )";
		$query2 = Run($aaa);
		while ($getDet = myfetch($query2)) {

			//////////// Check Paid Amount/////////
			$paidQuery = Run("Select Sum(PaidAmount) as AlreadyPaid from RecieptDetails where salSubInv='" . $getDet->sbBillno . "' and CustomerID = '" . $customer_id . "' and Bid = '" . $Bid . "'");
			$paidAmount = myfetch($paidQuery)->AlreadyPaid;
			$paidAmount = !empty($paidAmount) ? $paidAmount : '0';


			$balance = $getDet->vatPTotal - $paidAmount;

			if ($balance > 0) {

		?>

				<input type="hidden" id="InvoiceNo<?php echo $row_count ?>" name="InvoiceNo<?php echo $row_count ?>" value="<?= $getDet->Billno ?>">
				<input type="hidden" id="InvoiceDate<?php echo $row_count ?>" name="InvoiceDate<?php echo $row_count ?>" value="<?= $getDet->BillDate ?>">
				<input type="hidden" id="billAmount<?php echo $row_count ?>" name="billAmount<?php echo $row_count ?>" value="<?= $getDet->vatPTotal ?>">
				<input type="hidden" id="sbBillno<?php echo $row_count ?>" name="sbBillno<?php echo $row_count ?>" value="<?= $getDet->sbBillno ?>">

				<div class="mb-3 card p-4" id="<?php echo $row_count ?>">
					<h5><?php echo $getDet->sbBillno ?></h5>
					<ul>
						<li>
							<p><span class="en">Date :</span><span class="ar"><?= getArabicTitle('Date') ?>:</span><span><?php echo DateVal($getDet->BillDate) ?></span></p>
						</li>
						<li>
							<p><span class="en">Bill Amount :</span><span class="ar"><?= getArabicTitle('Bill Amount') ?>:</span><span><?php echo AmtValue($getDet->vatPTotal) ?></span></p>
						</li>
						<li>
							<p><span class="en">Paid Amount:</span><span class="ar"><?= getArabicTitle('Paid Amount') ?>:</span><span><?= AmtValue($paidAmount) ?></span></p>
						</li>

						<li>
							<p><span class="en">Paying Amount:</span><span class="ar"><?= getArabicTitle('Paying Amount') ?>:</span></p>
							<input type="text" name="payingAmount<?php echo $row_count ?>" id="payingAmount<?php echo $row_count ?>" value="0" onKeyUp="AmtRowCal('<?= $row_count ?>')" value="0" class="payingAmt form-control direction" max="<?= AmtValue($balance) ?>">
						</li>

						<li>
							<p><span class="en">Balance Amount:</span><span class="ar"><?= getArabicTitle('Balance Amount') ?>:</span><span id="balanceAmt<?= $row_count ?>"><?= $balance ?></span><input type="hidden" id="Remaining<?= $row_count ?>" readonly name="Remaining<?= $row_count ?>" value="<?= $balance ?>"></p>
							<input type="hidden" id="balance<?= $row_count ?>" readonly name="balance<?= $row_count ?>" value="<?= $balance ?>">
						</li>



						<input type="hidden" name="autono<?php echo $row_count ?>" id="autono<?php echo $row_count ?>" value="<?php echo $row_count ?>" class="form-control">

				</div>
		<?php
				$row_count++;
			}
		}
		?>
	</div>
</div>
<input type="hidden" id="nrows" name="nrows" value="<?= $row_count ?>">
<hr />