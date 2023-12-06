function next(e) {
  $(e).parent().parent().parent().parent().addClass("done");
  $(e).parent().parent().parent().parent().next().removeClass("slided");
}
function prev(e) {
  $(e).parent().parent().parent().parent().addClass("slided");
  $(e).parent().parent().parent().parent().prev().removeClass("done");
}

function customerValidation() {
  var CName = $("#CName").val();
  var anyaction = false;
  if (CName == "") {
    $("#CName").css("border", "2px solid red");
    anyaction = true;
  } else {
    $("#CName").css("border", "1px solid green");
  }

  if (anyaction) {
    return false;
  } else {
    $("#finishSave").attr("disabled", true);

    var myform = document.getElementById("customer_form");
    var fd = new FormData(myform);
    document.getElementById("customerFormData").innerHTML =
      "<img width='80px' src='loader/wheel.gif'/>";
    $.ajax({
      url: "includes/customers/saveCustomerForm.php",
      data: fd,
      cache: false,
      processData: false,
      contentType: false,
      type: "POST",
      success: function (data) {
        $("#customerFormData").html(data);
      },
    });

    $("#finishSave").attr("disabled", false);
  }
}

function customerUpdateValidation() {
  var CName = $("#CName").val();
  var anyaction = false;
  if (CName == "") {
    $("#CName").css("border", "2px solid red");
    anyaction = true;
  } else {
    $("#CName").css("border", "1px solid green");
  }

  if (anyaction) {
    return false;
  } else {
    var myform = document.getElementById("customer_form");
    var fd = new FormData(myform);
    document.getElementById("customerFormData").innerHTML =
      "<img width='80px' src='loader/wheel.gif'/>";
    $.ajax({
      url: "includes/customers/updateCustomerForm.php",
      data: fd,
      cache: false,
      processData: false,
      contentType: false,
      type: "POST",
      success: function (data) {
        $("#customerFormData").html(data);
      },
    });
  }
}

function deleteCustomer(CCode, bid) {
  $.confirm({
    title: "Confirm!",
    content: "Are You Sure You Want To Delete?",
    buttons: {
      confirm: function () {
        $.ajax({
          url: "includes/customers/deleteCustomer.php",
          data: { CCode: CCode, bid: bid },
          type: "POST",
          success: function (data) {
            $("#customerFormData").html(data);
          },
        });
      },
      cancel: function () {
        $.alert("Canceled!");
      },
      // somethingElse: {
      //     text: 'Something else',
      //     btnClass: 'btn-blue',
      //     keys: ['enter', 'shift'],
      //     action: function(){
      //         $.alert('Something else?');
      //     }
      // }
    },
  });
}

function loadPage(pg) {
  location.href = pg;
}

$(document).ready(function () {
  $("#salesMan").select2({
    width: "100%",
    closeOnSelect: true,
    placeholder: "",
  });
});

function loadPage(pg) {
  location.href = pg;
}

function showModal() {
  $("#exampleModal").css("display", "block");
  $("#exampleModal").removeClass("fade");
}

function changeLanguage(lang) {
  if (lang == 2) {
    $("span.en").css("display", "none");
    $("span.ar").css("display", "block");
    $(".enBtn").css("display", "none");
    $(".arBtn").css("display", "block");
    $(".direction").addClass("direction-rtl");
    $(".direction").removeClass("direction-ltr");
  } else {
    $("span.en").css("display", "block");
    $("span.ar").css("display", "none");
    $(".arBtn").css("display", "none");
    $(".enBtn").css("display", "block");
    $(".direction").addClass("direction-ltr");
    $(".direction").removeClass("direction-rtl");
  }
  $("#exampleModal").addClass("fade");
  $("#exampleModal").css("display", "none");

  $.post('changeLanguage.php', { lang: lang });
}
