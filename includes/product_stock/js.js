
$("#Bid").select2({});

$(document).ready(function () {
$("#from_item_name").select2({
width: '100%',
closeOnSelect: true,
placeholder: '',
//minimumInputLength: 2,
ajax: {
url: "Api/listings/getProducts",
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


$(document).ready(function () {
$("#product_name").select2({
width: '100%',
closeOnSelect: true,
placeholder: '',
//minimumInputLength: 2,
ajax: {
url: "Api/listings/getProducts",
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


$(document).ready(function () {
$("#to_item_name").select2({
width: '100%',
closeOnSelect: true,
placeholder: '',
//minimumInputLength: 2,
ajax: {
url: "Api/listings/getProducts",
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
// cName = e.CName.toLowerCase();
// terms = params.term.toLowerCase();


// if (cName.includes(terms)) {
results.push({
id: e.Id,
text: e.CName
});

// }
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




$(document).ready(function () {
$("#product_group_name").select2({
width: '100%',
closeOnSelect: true,
placeholder: '',
//minimumInputLength: 2,
ajax: {
url: "Api/listings/getProductGroup",
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
text: "Please Select Group"
});
data.data.forEach(e => {
// cName = e.CName.toLowerCase();
// terms = params.term.toLowerCase();


//if (cName.includes(terms)) {
results.push({
id: e.Id,
text: e.CName
});

//}
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




$(document).ready(function () {
$("#ItemType_name").select2({
width: '100%',
closeOnSelect: true,
placeholder: '',
//minimumInputLength: 2,
ajax: {
url: "Api/listings/GetProductType",
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
text: "Please Select Group"
});
data.data.forEach(e => {
// cName = e.CName.toLowerCase();
// terms = params.term.toLowerCase();


//if (cName.includes(terms)) {
results.push({
id: e.Id,
text: e.CName
});

//}
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

function changeLanguage(lang) {
	if (lang == 2) {
	  $("span.en").css("display", "none");
	  $("span.ar").css("display", "inline-block");
	  $(".enBtn").css("display", "none");
	  $(".arBtn").css("display", "inline-block");
	  $(".direction").addClass("direction-rtl");
	  $(".direction").removeClass("direction-ltr");
	} else {
	  $("span.en").css("display", "inline-block");
	  $("span.ar").css("display", "none");
	  $(".arBtn").css("display", "none");
	  $(".enBtn").css("display", "inline-block");
	  $(".direction").addClass("direction-ltr");
	  $(".direction").removeClass("direction-rtl");
	}
	$("#exampleModal").addClass("fade");
	$("#exampleModal").css("display", "none");
  
	$.post('changeLanguage.php', { lang: lang });
  }
  
  function showModal() {
	$("#exampleModal").css("display", "block");
	$("#exampleModal").removeClass("fade");
  }

  function loadPage(pg) {
	location.href = pg;
  }

