// $('.submit-next').on('click',function(e){
//   e.preventDefault();
//   $(this).parent().parent().parent().parent().addClass('done')








$(document).ready(function () {
$("#product").select2({
width: '100%',
	language: 'ar',
closeOnSelect: true,
delay: 50,

placeholder: '',
//minimumInputLength: 2,
ajax: {
url: "Api/listings/getProductsWithOutCode",
dataType: 'json',
type: 'POST',
data: function (query) {
// add any default query here
term:query.terms;
return query;
},
processResults: function (data, params) {

// Tranforms the top-level key of the response object from 'items' to 'results'
var results = [];

results.push({
id: 0,
text: "Please Select Product"
});
data.data.forEach(e => {
//cName = e.CName.toLowerCase();
//terms = params.term.toLowerCase();



results.push({
id: e.Id,
text: e.CName
});


});
return {
results: results
};
},
},
//templateResult: formatResult
});



});





function next(e)
{
$(e).parent().parent().parent().parent().addClass('done')
$(e).parent().parent().parent().parent().next().removeClass('slided');
}
function prev(e)
{
$(e).parent().parent().parent().parent().addClass('slided')
$(e).parent().parent().parent().parent().prev().removeClass('done');
}

function checkValidation(e)
{
var branch = document.getElementById('branch').value;
if(branch=='')
{
alert("please select branch");
$("#branch").css('border','1px solid red')
return false;
}
next(e);
}

function setmyValue(vvl, idx) {
document.getElementById(idx).value = vvl;
}


function checkBankValue()
{
var SPType = $(".SPType:checked").val();
if(SPType=='1')
{
$('#cashCreditOption').css('display', 'block');
}
if(SPType=='2')
{
$('#cashCreditOption').css('display', 'none');
}
}



function customerValidation(e)
{
var SPType = $(".SPType:checked").val();
var anyaction = false;
if(SPType=='2')
{
var customer_id = document.getElementById('customer_id').value;
console.log(customer_id);
if(customer_id=='')
{
$('#customer_id').siblings(".select2-container").css('border', '2px solid red');
anyaction = true;
}
else
{
$('#customer_id').siblings(".select2-container").css('border', '1px solid green');
}
}
if(SPType=='1')
{
	
var sal_amount1 = 	parseFloat($('#sal_amount1').val());
if(sal_amount1<0)
{
$('#sal_amount1').css('border', '1px solid red');
anyaction = true;
}
else
{
$('#sal_amount1').css('border', '1px solid green');
}



}
if(anyaction)
{
return false;
}









else{


var myform = document.getElementById("sales_voucher");
var fd = new FormData(myform);
document.getElementById('saveSalesForm').innerHTML = "<img width='80px' src='loader/wheel.gif'/>";
$.ajax({
url:"includes/sales/saveSalesForm.php",
data: fd,
cache: false,
processData: false,
contentType: false,
type: 'POST',
success: function (dataofconfirm) {
$("#saveSalesForm").html(dataofconfirm);

next(e);	

}
});



}
}

function generateRow(e)
{
var anyaction  = false;
var Pcode = $("#Pcode").val();
var product = $("#product").text();
var Sprice = $("#Sprice").text();
var row_count = $("#row_count").val();

if(row_count<=1) {

if (Pcode == '') {
$('#Pcode').css('border', '1px solid red');
anyaction = true;
} else {
$('#Pcode').css('border', '1px solid green');

}


if (product == '') {
$('#product').css('border', '1px solid red');
anyaction = true;
} else {
$('#product').css('border', '1px solid green');

}


if (Sprice == '0') {
$('#Sprice').css('border', '1px solid red');
anyaction = true;
} else {
$('#Sprice').css('border', '1px solid green');

}

if (anyaction) {

return false;

}
}

var unit = $("#unit").val();
var unit_id = $("#unit_id").val();
var qty = $("#qty").val();
var Bid = $("#Bid").val();
var Sprice = $("#Sprice").val();
var vatSprice = $("#vatSprice").val();
var vatPer = $("#vatPer").val();
var vatAmt = $("#vatAmt").val();
var isVat = $("#isVat").val();

var in_html = $("#add_row").html();
// $('#row_append').innerHTML ="<img src='loader/wheel.gif' style='width:10%' />";
if (Pcode != '') {
$.post("includes/sales/addRow.php", {
Pcode: Pcode,
product: product,
unit_id: unit_id,
unit: unit,
qty: qty,
Sprice: Sprice,
row_count: row_count,
vatSprice: vatSprice,
Bid: Bid,
vatPer: vatPer,
vatAmt: vatAmt,
isVat: isVat


}, function (data) {
// console.log(data);
$("#add_row").html(data);
$("#add_row").append(in_html);
$("#row_count").val(parseInt(row_count) + 1);


$("#Pcode").val('');
$("#product").each(function () { //added a each loop here
$(this).select2('val', '')
});
$("#unit").val('');
$("#unit_id").val('');
$("#qty").val(1);
$("#Sprice").val(0);
$("#vatSprice").val(0);
$("#vatPer").val(0);
$("#vatAmt").val(0);
$("#isVat").val('');

});
}
next(e);

}

function editRow(row_count,type)
{
if(type==0)
{
$(".hide_span_qty"+row_count).css('display','none');
$(".hide_Sprice"+row_count).css('display','none');
$("#Sprice"+row_count).attr('type', 'text');
$("#qty"+row_count).attr('type', 'text');
$("#action_button"+row_count).html('<a href="#" onClick="editRow('+row_count+',1)"><i class="fa fa-check" aria-hidden="true"></i></a>');
}
else{
$(".hide_span_qty"+row_count).css('display','block');
$(".hide_Sprice"+row_count).css('display','block');

$("#qty"+row_count).attr('type', 'hidden');
$("#Sprice"+row_count).attr('type', 'hidden');

$(".hide_Sprice"+row_count).text($("#Sprice"+row_count).val());
$(".hide_span_qty"+row_count).text($("#qty"+row_count).val());

$("#action_button"+row_count).html('<a href="#" onClick="editRow('+row_count+',0)"><i class="fa fa-pencil" aria-hidden="true"></i></a>');
}
}

function rowGst(row_count,type)
{
var price = $("#price"+row_count).val();
var qty = $("#qty"+row_count).val();
var total = parseFloat(price)*parseFloat(qty);
var gst_per = $("#gst_per"+row_count).val();

if(type==0)
{
var gst_amount = $("#gst_amount"+row_count).val((parseFloat(total)*parseFloat(gst_per))/100);
}
else {
var gst_amount = $("#gst_amount"+row_count).val();
var gst_per = $("#gst_per"+row_count).val((parseFloat(gst_amount)*100)/parseFloat(total));
}

$("#row_total"+row_count).val(parseFloat(total)+parseFloat(gst_amount));

}



function fetchProductDetails(vvl)
{
if(vvl!='')
{
var Bid = $("#Bid").val();
document.getElementById('fetchProductDetails').innerHTML ="<img width='80px' src='loader/wheel.gif'/>";

$.post("includes/sales/fetchProductDetails.php",{
code:vvl,
Bid:Bid
},function(data){
$("#fetchProductDetails").html(data);});
}
}
function fetchProductDetailsFromCode(vvl)
{
if(vvl!='')
{
var Bid = $("#Bid").val();
//document.getElementById('fetchProductDetails').innerHTML ="<img width='80px' src='loader/wheel.gif'/>";

$.post("includes/sales/fetchProductDetailsFromCode.php",{
code:vvl,
Bid:Bid
},function(data){
$("#fetchProductDetails").html(data);});
}
}
function getProductList(vvl)
{
if(vvl!='')
{
document.getElementById('getProductList').innerHTML ="<img width='80px' src='loader/wheel.gif'/>";

$.post("includes/sales/getProductList.php",{
code:vvl,
},function(data){
$("#getProductList").html(data);});
}
}
function loadBanks(vvl)
{
if(vvl!='')
{
document.getElementById('cashCreditOption').innerHTML ="<img width='80px' src='loader/wheel.gif'/>";
$.post("includes/sales/loadBanks.php",{
code:vvl,
},function(data){
$("#cashCreditOption").html(data);});
}
}




function Discount(row_count)
{
var Discount = $("#Discount"+row_count).val()
$("#hide_span_dis"+row_count).html(Discount);




var total_without_tax = $("#total_without_tax"+row_count).val();
console.log(total_without_tax);
var n_net_total_without_tax = parseFloat(total_without_tax)-parseFloat(Discount);
console.log(n_net_total_without_tax);

if(n_net_total_without_tax<0)
{
n_net_total_without_tax = 0;
}

$("#net_total_without_tax"+row_count).val(n_net_total_without_tax);
$("#hide_span_nettotal_without_tax"+row_count).html(n_net_total_without_tax);








var total_without_tax = $("#total_with_tax"+row_count).val();
var n_net_total_with_tax = parseFloat(total_without_tax)-parseFloat(Discount);
if(n_net_total_with_tax<0)
{
n_net_total_with_tax = 0;
}
$("#net_total_with_tax"+row_count).val(n_net_total_with_tax);
$("#hide_span_nettotal_with_tax"+row_count).html(n_net_total_with_tax);







}



function deleteRow(row_count)
{
$.confirm({
title: 'Confirm!',
content: 'Are You Sure You Want To Delete?',
buttons: {
confirm: function () {
$("#"+row_count).remove()
$.alert('Confirmed!');
},
cancel: function () {
$.alert('Canceled!');
}
// somethingElse: {
//     text: 'Something else',
//     btnClass: 'btn-blue',
//     keys: ['enter', 'shift'],
//     action: function(){
//         $.alert('Something else?');
//     }
// }
}
});
}

function addMoreRows(e)
{

$('#product').select2('destroy');
$('#product').val('');
$("#product").css('border','1px solid #ced4da')



$(document).ready(function () {
$("#product").select2({
width: '100%',
closeOnSelect: true,
placeholder: '',
//minimumInputLength: 2,
ajax: {
url: "Api/listings/getProductsWithOutCode",
dataType: 'json',
type: 'POST',
data: function (query) {
// add any default query here
term:query.terms;
return query;
},
processResults: function (data, params) {

// Tranforms the top-level key of the response object from 'items' to 'results'
var results = [];

results.push({
id: 0,
text: "Please Select Product"
});
data.data.forEach(e => {
//cName = e.CName.toLowerCase();
//terms = params.term.toLowerCase();



results.push({
id: e.Id,
text: e.CName
});


});
return {
results: results
};
},
},
//templateResult: formatResult
});


});







prev(e);
}



function Pricecalculations(vvl,tp)
{
document.getElementById('fetchProductDetails').innerHTML ="<img width='80px' src='loader/wheel.gif'/>";

var vatAmt = $("#vatAmt").val();
var vatPer = $("#vatPer").val();
var qty = $("#qty").val();
if(vatPer!='0')
{
$.post("includes/sales/Pricecalculations.php",{
vvl:vvl,
tp:tp,
vatPer:vatPer,
vatAmt:vatAmt,
qty:qty,

},function(data){
$("#fetchProductDetails").html(data);});
}
if(vatPer=='0')
{
$("#fetchProductDetails").html('');
$("#vatSprice").val(vvl*qty);
}


}

function PricecalculationsRow(vvl,tp,row_count)
{
document.getElementById('fetchProductDetails').innerHTML ="<img width='80px' src='loader/wheel.gif'/>";

var vatAmt = $("#vatAmt"+row_count).val();
var vatPer = $("#vatPer"+row_count).val();
var qty = $("#qty"+row_count).val();
if(vatPer!='0')
{
$.post("includes/sales/PricecalculationsRow.php",{
vvl:vvl,
tp:tp,
vatPer:vatPer,
vatAmt:vatAmt,
qty:qty,
row_count:row_count,

},function(data){
$("#fetchProductDetails").html(data);});
}
if(vatPer=='0')
{
	$("#fetchProductDetails").html('');

$("#vatSprice"+row_count).val(vvl*qty);
}


}









function calculateAllTotals(e)
{
var tot_Sprice = 0;
$(".tot_Sprice").each(function(){
tot_Sprice += +$(this).val();
});
tot_Sprice = tot_Sprice.toFixed(2);	


$("#total").val(tot_Sprice);	
$("#span_total").html(tot_Sprice);	


$("#netTotal").val(tot_Sprice);	
$("#span_netTotal").html(tot_Sprice);	


var tot_rowvatAmt = 0;
$(".tot_vatAmt").each(function(){
tot_rowvatAmt += +$(this).val();
});
tot_rowvatAmt = tot_rowvatAmt.toFixed(2);	

$("#totVat").val(tot_rowvatAmt);	
$("#span_totVat").html(tot_rowvatAmt);	

var grandTotal = parseFloat(tot_Sprice)+parseFloat(tot_rowvatAmt);

grandTotal = grandTotal.toFixed(2);	

$("#grandTotal").val(grandTotal);	
$("#disPer").val(0);	
$("#disAmt").val(0);	
$("#span_grandTotal").html(grandTotal);	

next(e);
}

function calculateAllTotalsSimple(tp)
{
var tot_Sprice = 0;
$(".tot_Sprice").each(function(){
tot_Sprice += +$(this).val();
});
tot_Sprice = tot_Sprice.toFixed(2);	


$("#total").val(tot_Sprice);	
$("#span_total").html(tot_Sprice);	


$("#netTotal").val(tot_Sprice);	
$("#span_netTotal").html(tot_Sprice);	


var tot_rowvatAmt = 0;
$(".tot_vatAmt").each(function(){
tot_rowvatAmt += +$(this).val();
});
tot_rowvatAmt = tot_rowvatAmt.toFixed(2);	

$("#totVat").val(tot_rowvatAmt);	
$("#span_totVat").html(tot_rowvatAmt);	

var grandTotal = parseFloat(tot_Sprice)+parseFloat(tot_rowvatAmt);

grandTotal = grandTotal.toFixed(2);	

$("#grandTotal").val(grandTotal);	
$("#"+tp).val(0);	
$("#span_grandTotal").html(grandTotal);	
}

function calculateWholeDiscountAmount(vvl)
{

calculateAllTotalsSimple('disAmt');


var total = $("#total").val();	


var discam = parseFloat(total)*parseFloat(vvl);
var discamount = 	discam/100;
var dc =	discamount.toFixed(2);
$("#disAmt").val(dc);



var nT = parseFloat(total)-parseFloat(dc);
nT = nT.toFixed(2);
$("#netTotal").val(nT);
$("#span_netTotal").html(nT);

var totVat = $("#totVat").val();

var grandTotal = parseFloat(totVat)+parseFloat(nT);
grandTotal = grandTotal.toFixed(2);
$("#grandTotal").val(grandTotal);
$("#span_grandTotal").text(grandTotal);


var InitialtotVat = $("#totVat").val();	
	
	console.log(InitialtotVat);
	
var totVat = $("#totVat").val();	
	console.log(totVat);

totVat = parseFloat(totVat)*parseFloat(vvl);
var totVatAmtt = 	totVat/100;
var totVatAmtt =	totVatAmtt.toFixed(2);

var bbT = parseFloat(InitialtotVat)-parseFloat(totVatAmtt)
bbT = bbT.toFixed(2);

$("#totVat").val(bbT);
$("#span_totVat").text(bbT);


var grandTotal = parseFloat(nT)+parseFloat(bbT);

$("#grandTotal").val(grandTotal);
$("#span_grandTotal").text(grandTotal);



/// get furhter totals here///
}










function calculateWholeDiscountper(vvl)
{

calculateAllTotalsSimple('disPer');
var total = $("#total").val();	


var discam = parseFloat(vvl)/parseFloat(total);
discam = discam*100;
var dc =	discam.toFixed(2);
$("#disPer").val(dc);



var nT = parseFloat(total)-parseFloat(vvl);
nT = nT.toFixed(2);
$("#netTotal").val(nT);
$("#span_netTotal").html(nT);

var totVat = $("#totVat").val();

var grandTotal = parseFloat(totVat)+parseFloat(nT);
grandTotal = grandTotal.toFixed(2);
$("#grandTotal").val(grandTotal);
$("#span_grandTotal").text(grandTotal);


var InitialtotVat = $("#totVat").val();	
var totVat = $("#totVat").val();	

totVat = parseFloat(totVat)*parseFloat(dc);
var totVatAmtt = 	totVat/100;
var totVatAmtt =	totVatAmtt.toFixed(totVatAmtt);

var bbT = parseFloat(InitialtotVat)-parseFloat(totVatAmtt)
bbT = bbT.toFixed(2);
$("#totVat").val(bbT);
$("#span_totVat").text(bbT);


var grandTotal = parseFloat(nT)+parseFloat(bbT);

$("#grandTotal").val(grandTotal);
$("#span_grandTotal").text(grandTotal);



/// get furhter totals here///
}














function calculateSingleVatTotal(vvl)
{
var Sprice = $("#Sprice").val();	
var vatAmt = $("#vatAmt").val();	
var qty = $("#qty").val();	


Pricecalculations(Sprice,'vatSprice');


}





function qtyPriceTotal(row_count)
{
var vvl = $("#qty"+row_count).val();
var Sprice = $("#Sprice"+row_count).val();	
if(Sprice==0)
{
$("#vatSprice"+row_count).val('0');	
$(".hide_vatSprice"+row_count).text(0);

}
else{
PricecalculationsRow(Sprice,'vatSprice',row_count);
}	


$("#hide_span_qty"+row_count).html(vvl);

}


function paymentScreen(e)
{
var disPer = parseFloat($('#disPer').val());
var disAmt = parseFloat($('#disAmt').val());
var total = parseFloat($('#total').val());
var anyaction = false;	
if(disPer<0 || disPer=='NaN')
{
$("#disPer").css('border','1px solid red');
anyaction = true

}
else
{
$("#disPer").css('border','1px solid green');
}
if(disAmt<0 || disAmt=='NaN')
{
$("#disAmt").css('border','1px solid red');
anyaction = true

}
else
{
$("#disAmt").css('border','1px solid green');
}




if(total=='' || total<=0)
{
$("#disPer").css('border','1px solid red');
$("#disAmt").css('border','1px solid red');
anyaction = true
}
else
{
$("#disPer").css('border','1px solid green');
$("#disAmt").css('border','1px solid green');
}
var netTotal = parseFloat($('#netTotal').val());
if(netTotal=='' || netTotal<=0)
{
$("#disPer").css('border','1px solid red');
$("#disAmt").css('border','1px solid red');
anyaction = true
}
else
{
$("#disPer").css('border','1px solid green');
$("#disAmt").css('border','1px solid green');
}


var totVat = parseFloat($('#totVat').val());
if(totVat<0)
{
$("#disPer").css('border','1px solid red');
$("#disAmt").css('border','1px solid red');
anyaction = true
}
else
{
$("#disPer").css('border','1px solid green');
$("#disAmt").css('border','1px solid green');}


var grandTotal = parseFloat($('#grandTotal').val());
if(grandTotal<=0)
{

anyaction = true
}
else
{
$("#disPer").css('border','1px solid green');
$("#disAmt").css('border','1px solid green');}
if(anyaction)
{
$("#disPer").css('border','1px solid red');
$("#disAmt").css('border','1px solid red');

return false;
}
else{

$("#disPer").css('border','1px solid green');
$("#disAmt").css('border','1px solid green');
$('#payment_screen_total').text(grandTotal);
$('#payment_screen_remaining').text(0);
$('#sal_amount1').val(grandTotal);
next(e);
}


}

function CalculateRemainings()
{
var salAmnt = 0;
$(".salAmnt").each(function(){
salAmnt += +$(this).val();
});

var gTotal = $('#payment_screen_total').text();

var Remaining = parseFloat(gTotal)-parseFloat(salAmnt);
Remaining = Remaining.toFixed(2);
$('#payment_screen_remaining').text(Remaining);
$('#sal_amount1').val(Remaining);
	
	var sal_amount1 = $('#sal_amount1').val();
	var tttl = parseFloat(salAmnt)+parseFloat(sal_amount1);
	
	var aa = parseFloat(gTotal)-parseFloat(tttl);
	aa.toFixed(2);
$('#payment_screen_remaining').text(aa);

}



function AddBank()
{
var Bid = $('#Bid').val();
var bankrows = $('#bankrows').val();
var Bank = $('#Bank'+bankrows).val();
if(Bank=='')
{
$('#Bank'+bankrows).css('border', '2px solid red');
return false;
}

$('#Bank'+bankrows).css('border', '1px solid green');

var sal_amount = $('#sal_amount'+bankrows).val();
if(sal_amount=='0' || sal_amount=='')
{
$('#sal_amount'+bankrows).css('border', '2px solid red');
return false;
}

$('#sal_amount'+bankrows).css('border', '1px solid green');

bankrows = parseFloat(bankrows)+1
var old_data = $('#loadBanks').html();
$.post("includes/sales/loadBanks.php",{
code:Bid,
nrow:bankrows
},function(data){
$("#loadBanks").append(data);
$('#bankrows').val(bankrows);	

});
}








////////// Validations//////////
function validateRefrenceNo(e)
{
var salesMan = $('#salesMan').val();
anyaction =false;
if(salesMan == null || salesMan=='' || salesMan=='0')
{
$('#salesMan').siblings(".select2-container").css('border', '2px solid red');
anyaction = true;
}
else{
$('#salesMan').siblings(".select2-container").css('border', '1px solid green');
}	
if(anyaction)
{
return false;
}
else{
next(e);
}
}









function saveFinalStep(SBBillno,Bid)
{
	
$.post("includes/sales/saveFinalStep.php",{
SBBillno:SBBillno,
Bid:Bid,
},function(data){
$("#saveFinalStep").html(data);
});	
}


function printInvoice()
{
var anyaction = false;
var Bid = $('#Bid').val();
var Billno = $('#Billno').val();
if(Billno=='')
{
anyaction = true;
$('#Billno').css('border', '1px solid red');


}
var LanguageId = $('#LanguageId').val();
if(anyaction)
{
return false;
}
	
document.getElementById('printInvoice').innerHTML = "<img width='80px' src='loader/wheel.gif'/>";	
$.post("includes/sales/printInvoice.php",{
Bid:Bid,
Billno:Billno,
LanguageId:LanguageId,
},function(data){
$("#printInvoice").html(data);
});		
}


function print(Billno,Bid,LanguageId)
{
document.getElementById('printInvoice').innerHTML = "<img width='80px' src='loader/wheel.gif'/>";	
$.post("includes/sales/print.php",{
Bid:Bid,
Billno:Billno,
LanguageId:LanguageId,
},function(data){
$("#printInvoice").html(data);
});		
}

function loadPage(pg)
{
	location.href=pg;
}


function openPopup(id,bid,email)
{
	$("#emailpopup").modal('show');
	$("#bill_id").val(id);
	$("#b_id").val(bid);
	$("#email").val(email);
}

function openPrintPopup(id,bid)
{
	$("#printpopup").modal('show');
	$("#bill_id_print").val(id);
	$("#b_id_print").val(bid);
}








function Print_details()
{
var bill_id = $("#bill_id_print").val();
var b_id = $("#b_id_print").val();
var print_language = $("#print_language").val();

window.open(
'includes/sales/print.php?Billno='+bill_id+'&Bid='+b_id+'&LanguageId='+print_language+'',
'_blank' // <- This is what makes it open in a new window.
);


}














function sendemailform()
{
var email = $("#email").val();
var bill_id = $("#bill_id").val();
var b_id = $("#b_id").val();
var LanguageId = $("#email_lang").val();
$.post("includes/sales/send_email.php",{
b_id:b_id,
bill_id:bill_id,
LanguageId:LanguageId,
email:email,
},function(data){
console.log(data);
//$('#sendemailform').html(data);
if(data=='Email Sent')
{
$("#emailpopup").modal('hide');
$("#ignismyModal").modal('show');
}
// $("#printInvoice").html(data);
});
}