$(document).ready(function () {

  $("#customer_id").select2({
    width: "100%",
    closeOnSelect: true,
    placeholder: "",
    placeholder: "",
    //minimumInputLength: 2,
    ajax: {
      url: "Api/listings/getCustomers",
      dataType: "JSON",
      type: "POST",
      delay: 50,

      data: function (query) {
        // add any default query here
        query.bid = $('#Bid').val();
		  term: query.terms;
		  
		  
        return query;
      },
      processResults: function (data, params) {
        console.log(data);

        var results = [];
        results.push({
          id: 0,
          text: "Please Select Customer",
        });
        // Tranforms the top-level key of the response object from 'items' to 'results'
        data.data.forEach((e) => {
          // cName = e.CName.toLowerCase();
          // terms = params.term.toLowerCase();
          results.push({
            id: e.Id,
            text: e.CName,
          });
        });
        return {
          results: results,
        };
      },
    },
    //templateResult: formatResult
  });
});

$(document).ready(function () {
  $("#salesMan").select2({
    width: "100%",
    closeOnSelect: true,
    placeholder: "",
  });
});

$("#Bid").select2({});

function next(e) {
  $(e).parent().parent().parent().parent().addClass("done");
  $(e).parent().parent().parent().parent().next().removeClass("slided");
}
function prev(e) {
  $(e).parent().parent().parent().parent().addClass("slided");
  $(e).parent().parent().parent().parent().prev().removeClass("done");
}

function checkValidation(e) {
  var branch = document.getElementById("branch").value;
  if (branch == "") {
    alert("please select branch");
    $("#branch").css("border", "1px solid red");
    return false;
  }
  next(e);
}

function setmyValue(vvl, idx) {
  document.getElementById(idx).value = vvl;
}

function customerCheck(e) {
  var Bid = $("#Bid").val();
  var anyaction = false;
  var customer_id = document.getElementById("customer_id").value;
  if (customer_id == "") {
    $("#customer_id")
      .siblings(".select2-container")
      .css("border", "2px solid red");
    anyaction = true;
  } else {
    $("#customer_id")
      .siblings(".select2-container")
      .css("border", "1px solid green");
  }
  if (anyaction) {
    return false;
  } else {
    document.getElementById("customerCheck").innerHTML =
      "<img width='80px' src='loader/wheel.gif'/>";
    $.post(
      "includes/receipt/customerCheck.php",
      {
        customer_id: customer_id,
        Bid: Bid,
      },
      function (data) {
        $("#customerCheck").html(data);
        next(e);
      }
    );
  }
}

////////// Validations//////////
function validateRefrenceNo(e) {
  var salesMan = $("#salesMan").val();
  anyaction = false;
  //if(salesMan == null || salesMan=='' || salesMan=='0')
  //{
  //$('#salesMan').siblings(".select2-container").css('border', '2px solid red');
  //anyaction = true;
  //}
  //else{
  //$('#salesMan').siblings(".select2-container").css('border', '1px solid green');
  //}
  if (anyaction) {
    return false;
  } else {
    next(e);
  }
}

function loadPage(pg) {
  location.href = pg;
}

function openPopup(id, bid, email) {
  $("#emailpopup").modal("show");
  $("#bill_id").val(id);
  $("#b_id").val(bid);
  $("#email").val(email);
}

function sendemailform() {
  var email = $("#email").val();
  var bill_id = $("#bill_id").val();
  var b_id = $("#b_id").val();
  $.post(
    "includes/receipt/send_email.php",
    {
      b_id: b_id,
      bill_id: bill_id,
      LanguageId: 1,
      email: email,
    },
    function (data) {
      console.log(data);
      //$('#sendemailform').html(data);
      if (data == "Email Sent") {
        $("#emailpopup").modal("hide");
        $("#ignismyModal").modal("show");
      }
      // $("#printInvoice").html(data);
    }
  );
}

function AmtRowCal(row_count) {
  var payingAmount = $("#payingAmount" + row_count).val();
  var Remaining = $("#Remaining" + row_count).val();
  var balance = $("#balance" + row_count).val();
  if (parseFloat(payingAmount) > parseFloat(balance)) {
    $("#payingAmount" + row_count).val(0);
    $("#Remaining" + row_count).val(balance);

    $("#balanceAmt" + row_count).text(balance);
  } else {
    var Rem = parseFloat(balance) - parseFloat(payingAmount);
    $("#Remaining" + row_count).val(Rem);
    $("#balanceAmt" + row_count).text(Rem);
  }
  getAllTotals();
}

function getAllTotals() {
  var sum = 0;
  $(".payingAmt").each(function () {
    sum += +$(this).val();
  });
  $("#total").val(sum);
  $("#netTotal").val(sum);
  $(".span_netTotal").text(sum);
  $("#disPer").val(0);
  $("#disAmt").val(0);
}

function gridCalculation() {
  var cnt = 1;
  var row_count = $("#nrows").val();
  while (cnt < row_count) {
    var balance = $("#balance" + cnt).val();
    $("#payingAmount" + cnt).val(0);
    $("#Remaining" + cnt).val(balance);
    cnt++;
  }
}

function mainCalculation() {
  var row_count = $("#nrows").val();
  var total = $("#total").val();
  var cnt = 1;
  var customer_balance = $("#customer_balance").val();
  if (parseFloat(total) >= parseFloat(customer_balance)) {
    var advance = parseFloat(total) - parseFloat(customer_balance);
    $("#advance").val(advance);
    $(".span_Advance").val(advance);

    while (cnt < row_count) {
      var balance = $("#balance" + cnt).val();
      $("#payingAmount" + cnt).val(balance);
      $("#Remaining" + cnt).val(0);
      cnt++;
    }
  } else {
    $("#advance").val(0);
    $(".span_Advance").val(0);
    while (cnt < row_count) {
      var balance = $("#balance" + cnt).val();
      var baki = $("#baki").val();
      if (parseFloat(baki) == parseFloat(balance)) {
        $("#payingAmount" + cnt).val(baki);
        $("#Remaining" + cnt).val(0);
        $("#baki").val(0);
        return false;
      }

      if (parseFloat(baki) > parseFloat(balance)) {
        var balance = $("#balance" + cnt).val();
        var Remaining = parseFloat($("#Remaining" + cnt).val());
        var CurrentBaki = parseFloat(baki) - parseFloat(balance);
        $("#baki").val(CurrentBaki);
        $("#payingAmount" + cnt).val(balance);
        $("#Remaining" + cnt).val(0);
      }

      if (parseFloat(baki) < parseFloat(balance)) {
        var balance = $("#balance" + cnt).val();
        var Remaining = parseFloat($("#Remaining" + cnt).val());
        var CurrentBaki = parseFloat(baki) - parseFloat(balance);
        var Rem = parseFloat(balance) - parseFloat(baki);
        $("#baki").val(0);
        $("#payingAmount" + cnt).val(baki);
        $("#Remaining" + cnt).val(Rem);
        return false;
      }
      cnt++;
    }
  }
}

function TotVal(vvl) {
  $("#disPer").val(0);
  $("#disAmt").val(0);
  $("#netTotal").val(vvl);
  $(".span_netTotal").text(vvl);
  calculateAdvance();
}

function calculateWholeDiscountAmount(vvl) {
  var total = $("#total").val();
  var discam = parseFloat(total) * parseFloat(vvl);
  var discamount = discam / 100;
  var dc = discamount.toFixed(2);
  $("#disAmt").val(dc);
  var nT = parseFloat(total) - parseFloat(dc);
  nT = nT.toFixed(2);
  $("#netTotal").val(nT);
  $(".span_netTotal").html(nT);
  calculateAdvance();
}

function calculateWholeDiscountper(vvl) {
  var total = $("#total").val();
  var discam = parseFloat(vvl) / parseFloat(total);
  discam = discam * 100;
  var dc = discam.toFixed(2);
  $("#disPer").val(dc);
  var nT = parseFloat(total) - parseFloat(vvl);
  nT = nT.toFixed(2);
  $("#netTotal").val(nT);
  $(".span_netTotal").html(nT);
  calculateAdvance();
}

function calculateAdvance() {
  var cust_balance = $("#cust_balance").val();
  var netTotal = $("#netTotal").val();
  var Advance = parseFloat(netTotal) - parseFloat(cust_balance);
  Advance = Advance.toFixed(2);
  if (parseFloat(Advance) > 0) {
    $(".span_Advance").text(Advance);
    $("#Advance").val(Advance);
  }
}

function saveVoucher(e) {
  var netTotal = $("#total").val();
  var custBalance = $("#cust_balance").val();
  var bnkid = $("#bnkid").val();
  if (parseFloat(netTotal) < 1) {
    $("#total").css("border", "1px solid red");
    anyaction = true;
  } else {
    $("#total").css("border", "1px solid green");
    anyaction = false;
  }

  if (bnkid == "") {
    anyaction = true;
    $("#bnkid").css("border", "1px solid red");
  }

  if (parseFloat(custBalance) < 1) {
    $("#custBalanceError").css("border", "2px solid red");
    anyaction = true;
  }
  if (anyaction) {
    return false;
  }

  $("#finishSave").attr("disabled", true);
  var myform = document.getElementById("Form_voucher");
  var fd = new FormData(myform);
  document.getElementById("saveVoucher").innerHTML =
    "<img width='80px' src='loader/wheel.gif'/>";
  $.ajax({
    url: "includes/receipt/saveVoucher.php",
    data: fd,
    cache: false,
    processData: false,
    contentType: false,
    type: "POST",
    success: function (dataofconfirm) {
      $("#saveVoucher").html(dataofconfirm);

      $("#finishSave").attr("disabled", false);

      next(e);
    },
  });
}
function saveFinalStep(SBBillno, Bid) {
  $.post(
    "includes/receipt/saveFinalStep.php",
    {
      SBBillno: SBBillno,
      Bid: Bid,
    },
    function (data) {
      $("#saveVoucher").html(data);
    }
  );
}

function printInvoice() {
  var anyaction = false;
  var Bid = $("#Bid").val();
  var Billno = $("#Billno").val();
  if (Billno == "") {
    anyaction = true;
    $("#Billno").css("border", "1px solid red");
  }
  var LanguageId = $("#LanguageId").val();
  if (anyaction) {
    return false;
  }

  document.getElementById("printInvoice").innerHTML =
    "<img width='80px' src='loader/wheel.gif'/>";
  $.post(
    "includes/receipt/printInvoice.php",
    {
      Bid: Bid,
      Billno: Billno,
      LanguageId: LanguageId,
    },
    function (data) {
      $("#printInvoice").html(data);
    }
  );
}

function print(Billno, Bid, LanguageId) {
  document.getElementById("printInvoice").innerHTML =
    "<img width='80px' src='loader/wheel.gif'/>";
  $.post(
    "includes/receipt/print.php",
    {
      Bid: Bid,
      Billno: Billno,
      LanguageId: LanguageId,
    },
    function (data) {
      $("#printInvoice").html(data);
    }
  );
}

function changeLanguage(lang) {
  if (lang == 2) {
    $("span.en").css("display", "none");
    $("span.ar").css("display", "inline-block");
    $(".enBtn").css("display", "none");
    $(".arBtn").css("display", "block");
    $(".direction").addClass("direction-rtl");
    $(".direction").removeClass("direction-ltr");
  } else {
    $("span.en").css("display", "inline-block");
    $("span.ar").css("display", "none");
    $(".arBtn").css("display", "none");
    $(".enBtn").css("display", "block");
    $(".direction").addClass("direction-ltr");
    $(".direction").removeClass("direction-rtl");
  }
  $("#exampleModal").addClass("fade");
  $("#exampleModal").css("display", "none");

  $.post("changeLanguage.php", { lang: lang });
}

function showModal() {
  $("#exampleModal").css("display", "block");
  $("#exampleModal").removeClass("fade");
}

function loadBanks(vvl) {
  if (vvl != "") {
    document.getElementById("cashCreditOption").innerHTML =
      "<img width='80px' src='loader/wheel.gif'/>";
    $.post(
      "includes/receipt/loadBanks.php",
      {
        code: vvl,
      },
      function (data) {
        $("#cashCreditOption").html(data);
      }
    );
  }
}
