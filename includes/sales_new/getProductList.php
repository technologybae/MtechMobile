<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
$code = addslashes(trim($_POST['code']));
$query = Run("Select * from ".dbObject."Product where Pcode = '".$code."'");
$fetch = myfetch($query);
$product_name = $fetch->PName;
?>

<select id="product" name="product" class="js-states form-control"
onChange="setmyValue(this.value,'Pcode');fetchProductDetails(this.value)">
	<option value="<?=$code?>" selected><?php echo $product_name ?></option>
</select>

<script>

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
templateResult: formatResult
});

function formatResult(d) {
if (d.loading) {
return d.text;
}
// Creating an option of each id and text
$d = $('<option/>').attr({
'value': d.value
}).text(d.text);

return $d;
}

});


</script>




