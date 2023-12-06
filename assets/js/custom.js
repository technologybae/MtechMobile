$(".submit-next").on("click", function (e) {
  e.preventDefault();
  $(this).parent().parent().parent().parent().addClass("done");
  $(this).parent().parent().parent().parent().next().removeClass("slided");
});
$(".back").on("click", function (e) {
  e.preventDefault();
  $(this).parent().parent().parent().parent().addClass("slided");
  $(this).parent().parent().parent().parent().prev().removeClass("done");
});

// $(".multiple").select2({
//   placeholder: "Select",
//   allowClear: true,
// });

$(document).ready(function () {
  var lang = document.getElementById("selected_lang").value;
  changeLanguage(lang);
});

function changeLanguage(lang){
  if(lang == 2){
    // $("#selected_lang").attr('value', '2');
    $("span.en").css("display", "none");
    $("span.ar").css("display", "block");
    // $(".add_me").addClass("rv");
    // $(".ar").addClass("tb");
  }
  else{
    // $("#selected_lang").attr('value', '1')
    $("span.en").css("display", "block");
    $("span.ar").css("display", "none");
    // $(".add_me").removeClass("rv");
    // $(".ar").removeClass("tb");
  }
  $("#exampleModal").addClass("fade");
  $("#exampleModal").css("display", "none");

  $.post('changeLanguage.php', { lang: lang });
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

function showModal(){
  $("#exampleModal").css("display", "block");
  $("#exampleModal").removeClass("fade");
}