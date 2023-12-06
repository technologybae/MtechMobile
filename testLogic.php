Balance
<input type="text" id="customer_balance" name="customer_balance" readonly value="1000">
Advance
<input type="text" id="advance" name="advance" value="0" readonly>
Total:
<input type="text" id="total" name="total" onkeyup="baki.value=this.value;TotVal(this.value);gridCalculation();mainCalculation();" value="0">
Disc%
<input type="text" id="disPer" name="disPer" value="0" class="form-control" onKeyUp="calculateWholeDiscountAmount(this.value)"> 

Disc Amt
<input type="text" id="disAmt" name="disAmt" value="0" class="form-control"   onKeyUp="calculateWholeDiscountper(this.value)"> 
<hr/>
Net Total  <span id="span_netTotal">0</span>
<input type="text" id="netTotal" name="netTotal" value="0"> 


Baki:
<input type="text" id="baki" name="baki"   value="0">
<hr/>



<table border="2">
<tr>
<td>Bill Amount</td>
<td>Paid Amount</td>
<td>Paying Amount</td>
<td>Remaining Amount</td>
<td style="display: none;" >Balance Amount</td>
</tr>

<?php
$count = 1;
$rand = 10;
while($count<=$rand)
{
$randc = rand(1,100);
?>
<tr>
<td><input type="text" id="BillAmount<?= $count ?>" readonly name="BillAmount<?= $count ?>" value="<?=$randc?>"></td>
<td><input type="text" id="paidamount<?= $count ?>" readonly  name="paidamount<?= $count ?>" value="0"></td>
<td><input type="text" id="payingAmount<?= $count ?>" name="payingAmount<?= $count ?>" onKeyUp="AmtRowCal('<?=$count?>')" value="0" class="payingAmt form-control"></td>
<td><input type="text" id="Remaining<?= $count ?>" readonly name="Remaining<?= $count ?>" value="<?= $randc ?>"></td>
<td style="display: none;"><input type="hidden" id="balance<?= $count ?>" readonly name="balance<?= $count ?>" value="<?= $randc ?>"></td>
</tr>

<?php
$count++;
}
?>
</table>

<input type="hidden" id="nrows" name="nrows" value="<?=$count?>">
<script>

function AmtRowCal(row_count)
{
var payingAmount = $('#payingAmount'+row_count).val();	
var Remaining = $('#Remaining'+row_count).val();	
var balance = $('#balance'+row_count).val();	
if(parseFloat(payingAmount)>parseFloat(balance))
{
$('#payingAmount'+row_count).val(0);
$('#Remaining'+row_count).val(balance);
}
else{
var Rem = parseFloat(balance)-parseFloat(payingAmount);
$('#Remaining'+row_count).val(Rem);
}
getAllTotals();
}

function getAllTotals()
{
var sum = 0;
$(".payingAmt").each(function(){
sum += +$(this).val();
});
$("#total").val(sum);
$("#netTotal").val(sum);
$("#span_netTotal").text(sum);
$("#disPer").val(0);
$("#disAmt").val(0);
}









function gridCalculation()
{
var cnt = 1;
var row_count = $('#nrows').val();
while(cnt<row_count)	
{
var balance = $('#balance'+cnt).val();		
$('#payingAmount'+cnt).val(0);
$('#Remaining'+cnt).val(balance);
cnt++;	
}

}




function mainCalculation()
{
var row_count = $('#nrows').val();
var total = $('#total').val();
var cnt=1;
var customer_balance = $('#customer_balance').val();
if(parseFloat(total)>=parseFloat(customer_balance))
{
var advance = parseFloat(total)-parseFloat(customer_balance);
$('#advance').val(advance);

while(cnt<row_count)	
{
var balance = $('#balance'+cnt).val();		
$('#payingAmount'+cnt).val(balance);
$('#Remaining'+cnt).val(0);
cnt++;	
}

}
else
{
$('#advance').val(0);

while(cnt<row_count)	
{
var balance = $('#balance'+cnt).val();		
var baki = $('#baki').val();		
if(parseFloat(baki)==parseFloat(balance))
{

$('#payingAmount'+cnt).val(baki);
$('#Remaining'+cnt).val(0);
$('#baki').val(0);
return false;
}

if(parseFloat(baki)>parseFloat(balance))
{
var balance = $('#balance'+cnt).val();
var Remaining = parseFloat($('#Remaining'+cnt).val());


var CurrentBaki = parseFloat(baki)-parseFloat(balance);





$('#baki').val(CurrentBaki);
$('#payingAmount'+cnt).val(balance);
$('#Remaining'+cnt).val(0);

}


if(parseFloat(baki)<parseFloat(balance))
{
var balance = $('#balance'+cnt).val();
var Remaining = parseFloat($('#Remaining'+cnt).val());
var CurrentBaki = parseFloat(baki)-parseFloat(balance);

var Rem = parseFloat(balance)-parseFloat(baki);



$('#baki').val(0);
$('#payingAmount'+cnt).val(baki);
$('#Remaining'+cnt).val(Rem);
return false;

}







cnt++;	
}	
















}



}

function TotVal(vvl)
{
$('#disPer').val(0);
$('#disAmt').val(0);
$('#netTotal').val(vvl);
$('#span_netTotal').text(vvl);
calculateAdvance();

}




function calculateWholeDiscountAmount(vvl)
{
var total = $("#total").val();	
var discam = parseFloat(total)*parseFloat(vvl);
var discamount = 	discam/100;
var dc =	discamount.toFixed(2);
$("#disAmt").val(dc);
var nT = parseFloat(total)-parseFloat(dc);
nT = nT.toFixed(2);
$("#netTotal").val(nT);
$("#span_netTotal").html(nT);
calculateAdvance();
}




function calculateWholeDiscountper(vvl)
{
var total = $("#total").val();	
var discam = parseFloat(vvl)/parseFloat(total);
discam = discam*100;
var dc =	discam.toFixed(2);
$("#disPer").val(dc);


var nT = parseFloat(total)-parseFloat(vvl);
nT = nT.toFixed(2);
$("#netTotal").val(nT);
$("#span_netTotal").html(nT);
calculateAdvance();
}

function calculateAdvance()
{
var cust_balance = $('#cust_balance').val();
var netTotal = $('#netTotal').val();

var Advance= parseFloat(netTotal)-parseFloat(cust_balance);
Advance = Advance.toFixed(2);
if(parseFloat(Advance)>0)
{

$('#span_Advance').text(Advance);
$('#Advance').val(Advance);
}
}

</script>








<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.js" integrity="sha512-nO7wgHUoWPYGCNriyGzcFwPSF+bPDOR+NvtOYy2wMcWkrnCNPKBcFEkU80XIN14UVja0Gdnff9EmydyLlOL7mQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>