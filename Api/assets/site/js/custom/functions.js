$(document).ready(function() {
    $('#InputCountry').change(function() {
        var country = $(this).val();
        if (country) {
            var options = '<option value="">Please Wait...</option>';
            $('#state').find('option').remove().end().append(options);

            var URL = BASE_URL + 'certifications/ajaxGetStates';
            $.ajax({
                type: 'POST',
                url: URL,
                data: {
                    cid: country
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#state').before(function() {
                        return getLoadingImg();
                    });
                },
                success: function(response) {
                    var options = '<option value="">Select State</option>';
                    for (var i = 0; i < response.length; i++) {
                        options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                    }
                    options += '<option value="other">other</option>';
                    $('#state').find('option').remove().end().append(options);
                    //remove loader
                    $('#imgLoader').remove();
                },
                error: function() {
                    alert('something went wrong please try again');
                    //remove loader
                    $('#imgLoader').remove();
                }
            });
        } else {
            var options = '<option value="">Select State</option>';
            $('#state').find('option').remove().end().append(options);
            //remove loader
            $('#imgLoader').remove();
        }
    })

    $('#country_id').change(function() {
        var country = $(this).val();
        if (country) {
            var options = '<option value="">Please Wait...</option>';
            $('#state').find('option').remove().end().append(options);

            var URL = BASE_URL + 'certifications/ajaxGetStates';
            $.ajax({
                type: 'POST',
                url: URL,
                data: {
                    cid: country
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#state').before(function() {
                        return getLoadingImg();
                    });
                },
                success: function(response) {
                    var options = '<option value="">Select State</option>';
                    for (var i = 0; i < response.length; i++) {
                        options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                    }
                    options += '<option value="other">other</option>';
                    $('#state').find('option').remove().end().append(options);
                    //remove loader
                    $('#imgLoader').remove();
                },
                error: function() {
                    alert('something went wrong please try again');
                    //remove loader
                    $('#imgLoader').remove();
                }
            });
        } else {
            var options = '<option value="">Select State</option>';
            $('#state').find('option').remove().end().append(options);
            //remove loader
            $('#imgLoader').remove();
        }
    })

    $('#InputCountry_pay').change(function() {
        var country = $(this).val();
        if (country) {
            var options = '<option value="">Please Wait...</option>';
            $('#state_pay').find('option').remove().end().append(options);

            var URL = BASE_URL + 'certifications/ajaxGetStates';
            $.ajax({
                type: 'POST',
                url: URL,
                data: {
                    cid: country
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#state_pay').before(function() {
                        return getLoadingImg();
                    });
                },
                success: function(response) {
                    var options = '<option value="">Select State</option>';
                    for (var i = 0; i < response.length; i++) {
                        options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                    }
                    options += '<option value="other">other</option>';
                    $('#state_pay').find('option').remove().end().append(options);
                    //remove loader
                    $('#imgLoader').remove();
                },
                error: function() {
                    alert('something went wrong please try again');
                    //remove loader
                    $('#imgLoader').remove();
                }
            });
        } else {
            var options = '<option value="">Select State</option>';
            $('#state_pay').find('option').remove().end().append(options);
            //remove loader
            $('#imgLoader').remove();
        }
    })
})
$(function() {
    $('.playVidoeTestimonail').on('click', function() {
        var playerId = $(this).attr("id");
        var videoId = $(this).attr("data");
        var videoSrc = 'https://www.youtube.com/embed/' + videoId + '';
        $('#mainVideo').html('<iframe width="590" height="293" src="' + videoSrc + '" frameborder="0" allowfullscreen></iframe>');
        var vidoeDesc = $('#videoDesc_' + playerId).val();
        $('#mainVideoDesc').html(vidoeDesc)
    });
    $(".cartQty").keydown(function(event) {
        if (event.keyCode == 46 || event.keyCode == 8) {} else {
            if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault()
            }
        }
    });
    $('.addonProducts').change(function() {
        if ($(this).is(":checked")) {
            var formID = $(this).attr('id');
            $("#" + formID).submit()
        }
    });
    $(".cartQty").on("keyup", function(event) {
        updateCartQty()
    });
    $("#ApplyCoupon").on("click", function() {
        $Coupon = $("#coupon-code")
        if ($Coupon.val() == "") {
            $Coupon.focus()
        } else {
            validate_coupon_code($Coupon.val())
        }
    });
    $('#btnUserProfileSubmit').on("click", function() {
        validateUserProfile()
    });
    $('#btnChangePasswordSubmit').on("click", function() {
        validatePasswordChange()
    })
});
$('body').on('click', 'input[name="extension_type"]', function() {
    var selectedVal = $(this).val();
    if (selectedVal == 'add_users') {
        $('.hideifDuration').show();
        var price = $('input[name="lisence_key_price_activation"]').val();
        $('#lisence_update_form #lbl_price').html(price)
    } else {
        $('.hideifDuration').hide();
        var price = $('input[name="lisence_key_price"]').val();
        $('#lisence_update_form #lbl_price').html(price)
    }
})
$('body').on('click', 'input[name="noofusers"]', function() {
    var selectedQty = $(this).val();
    if (selectedQty > 1) {
        $('.hideifDuration').show();
        var price = $('input[name="lisence_key_price_activation_base"]').val();
        price = price * selectedQty;
        $('input[name="lisence_key_price_activation"]').val(price);
        $('#lisence_update_form #lbl_price').html(price)
    } else {
        var price = $('input[name="lisence_key_price_activation_base"]').val();
        $('input[name="lisence_key_price_activation"]').val(price);
        $('#lisence_update_form #lbl_price').html(price)
    }
})
$('body').on('keyup', 'input[name="noofusers"]', function() {
    var selectedQty = $(this).val();
    if (selectedQty > 1) {
        $('.hideifDuration').show();
        var price = $('input[name="lisence_key_price_activation_base"]').val();
        price = price * selectedQty;
        $('input[name="lisence_key_price_activation"]').val(price);
        $('#lisence_update_form #lbl_price').html(price)
    } else {
        var price = $('input[name="lisence_key_price_activation_base"]').val();
        $('input[name="lisence_key_price_activation"]').val(price);
        $('#lisence_update_form #lbl_price').html(price)
    }
})
    
$('body').on('submit', '#lisence_update_form', function() {
    event.preventDefault();
    if ($("#lisence_update_form").valid()) {
        validateLisenceForm('lisence_update_form')
    } else {
        return !1
    }
})

function toggleDisable(elementId, val) {
    $('#' + elementId).prop('disabled', val)
}

function validateLisenceForm(popupID) {
    var formId = 'lisence_update_form';
    var data = $('#' + popupID + ' #' + formId).serialize();
    var URL = BASE_URL + 'users/extendLisence';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function() {
            toggleDisable('btn-demo', !0);
            $('#btn-demo').after(function() {
                return getLoadingImg()
            })
        },
        success: function(response) {
            if (response.msgStatus == 'Error') {
                $('#' + popupID + ' #response').html(response.msg)
            } else if (response.msgStatus == 'Success') {
                $('#' + popupID + ' #response').html(response.msg);
                setTimeout(function() {
                    redirectPage(BASE_URL + 'users/')
                }, 2000)
            }
            toggleDisable('btn-demo', !1);
            $('#imgLoader').remove()
        },
        error: function() {
            alert('something went wrong please try again');
            toggleDisable('btn-demo', !1);
            $('#imgLoader').remove()
        }
    })
}

function radioOneClick() {}

function radioTwoClick() {}

function radioThreeClick() {}

function redirectPage(url) {
    setTimeout(function() {
        window.location.href = url
    }, 2000)
}

function getLoadingImg() {
    var imgURL = BASE_URL + 'assets/admin/images/loading.gif';
    var img = '<span id="imgLoader" style="display:block;"><img src="' + imgURL + '" /></span>';
    return img
}

function submitForm(url) {
    document.listing_form.action = url;
    document.listing_form.submit()
}

function updateCartQty() {
    var url = BASE_URL + 'carts/updateCart';
    document.cartForm.action = url;
    document.cartForm.submit()
}

function updateCartLisenceQty() {
    var url = BASE_URL + 'carts/updateLisenceCart';
    document.cartForm.action = url;
    document.cartForm.submit()
}

function ajaxLoadCertifications(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'certifications/ajaxGetcerts';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {
                vid: vid
            },
            dataType: 'json',
            beforeSend: function() {
                $('#certification_id').before(function() {
                    return getLoadingImg()
                })
            },
            success: function(response) {
                var options = '<option value="">Select Certification</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].name + '</option>'
                }
                $('#certification_id').find('option').remove().end().append(options);
                $('#imgLoader').remove()
            },
            error: function() {
                alert('something went wrong please try again');
                $('#imgLoader').remove()
            }
        })
    } else {
        var options = '<option value="">Select Certification</option>';
        $('#certification_id').find('option').remove().end().append(options);
        $('#imgLoader').remove()
    }
}

function ajaxLoadExams(cid) {
    if (cid > 0) {
        var URL = BASE_URL + 'exams/ajaxGetexams';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {
                cid: cid
            },
            dataType: 'json',
            beforeSend: function() {
                $('#exam_id').before(function() {
                    return getLoadingImg()
                })
            },
            success: function(response) {
                var options = '<option value="">Select Exam</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].name + '</option>'
                }
                $('#exam_id').find('option').remove().end().append(options);
                $('#imgLoader').remove()
            },
            error: function() {
                alert('something went wrong please try again');
                $('#imgLoader').remove()
            }
        })
    } else {
        var options = '<option value="">Select Exam</option>';
        $('#exam_id').find('option').remove().end().append(options);
        $('#imgLoader').remove()
    }
}

function UpdateGrandTotal() {
    var discount = 0;
    var grandTotal = 0;
    $(".cartQty").each(function() {
        var Amount = $(this).attr("data");
        var Qty = $(this).val();
        var SbTotal = Amount * Qty;
        SbTotal = parseFloat(SbTotal).toFixed(2);
        $(this).parent().parent().next("td").children("p").children().text("$" + SbTotal);
    });
    var Amount = 0;
    $(".sub-total-amount").each(function() {
        var AM = $(this).html().replace("$", "");
        AM = AM.replace(",", "");
        Am = parseInt(AM);
        Amount = parseInt(Amount + Am)
    });
    discount = parseInt($('#DiscountAmount').html().replace("$", ""));
    grandTotal = parseInt(Amount - discount);
    grandTotal = parseFloat(grandTotal).toFixed(2);
    $('#DiscountNewAmount').html("$" + grandTotal);
    $("#GrandTotalAmount").html("$" + grandTotal)
}

function validate_coupon_code(code) {
    UpdateGrandTotal();
    var URL = BASE_URL + 'carts/validate_coupon';
    $.ajax({
        type: 'POST',
        url: URL,
        data: {
            Coupon: code
        },
        dataType: 'html',
        beforeSend: function() {},
        success: function(resp) {
            var re = /\s\s+/g;
            resp = resp.replace(re, ' ');
            RespObject = JSON.parse(resp);
            if (RespObject.Status) {
                var discountId = RespObject.Coupon.id;
                var grandTotal = 0;
                var totalOrderAmount = 0;
                $(".sub-total-amount").each(function() {
                    var Am = $(this).html();
                    Am = Am.replace(",", "");
                    
                    Am = parseInt(Am.replace("$", ""));
                    grandTotal = totalOrderAmount = parseInt(totalOrderAmount + Am);
               });
               console.log(totalOrderAmount);
                var totalOrderQuantity = 0;
                
                $(".cartQty").each(function() {
                    var Am = parseInt($(this).val().replace("$", ""));
                   totalOrderQuantity = parseInt(totalOrderQuantity + Am);
                });
                
                if (RespObject.Coupon.discount_type == 1) {
                    var discountAmount = RespObject.Coupon.discount_amount;
                    var subTotal = totalOrderAmount - discountAmount;
                    subTotal = (Math.round(subTotal * 100) / 100);
                    var grandTotal = subTotal
                } else if (RespObject.Coupon.discount_type == 2) {
                    var discount_percent = RespObject.Coupon.discount_percent;
                    var discountAmount = (totalOrderAmount * discount_percent) / 100;
                    var subTotal = totalOrderAmount - discountAmount;
                    subTotal = (Math.round(subTotal * 100) / 100);
                    var grandTotal = subTotal;
                    $(".coupon-discount-area").show();
                }
                discountAmount = parseFloat(discountAmount).toFixed(2);
                subTotal = parseFloat(subTotal).toFixed(2);
                grandTotal = parseFloat(grandTotal).toFixed(2);
                $("#DiscountAmount").html("$" + discountAmount);
                $('#DiscountNewAmount').html("$" + subTotal);
                $("#GrandTotalAmount").html("$" + grandTotal);
                update_total(discountAmount, subTotal, grandTotal, discountId)
            } else {
                $("#codemsg").addClass("invalid").html(RespObject.Message)
            }
        },
        error: function() {
            alert('something went wrong please try again')
        }
    })
}

function update_total(couponAmount, discountedAmount, grandTotal, couponId) {
    var URL = BASE_URL + 'carts/update_coupon_total';
    $.ajax({
        type: 'POST',
        url: URL,
        data: {
            cm: couponAmount,
            dm: discountedAmount,
            gt: grandTotal,
            ci: couponId
        },
        dataType: 'html',
        beforeSend: function() {},
        success: function(resp) {
            var re = /\s\s+/g;
            resp = resp.replace(re, ' ');
            RespObject = JSON.parse(resp);
            console.log(RespObject)
        },
        error: function() {}
    })
}

function reapplycoupon() {
    setTimeout(function() {
        $("#ApplyCoupon").trigger("click")
    }, 1000)
}

function loadVideoDetails(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'exam/ajaxGetVideoDetails';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {
                vid: vid
            },
            dataType: 'html',
            beforeSend: function() {
                $('.CourseListData').before(function() {
                    return getLoadingImg()
                })
            },
            success: function(response) {
                $('.CourseListData').html(response);
                $('#imgLoader').remove()
            },
            error: function() {
                alert('something went wrong please try again');
                $('#imgLoader').remove()
            }
        })
    }
}

function convertToMonthsYears(days) {
    if (days == 0) {
        var result = 'Life Time'
    } else if (days > 0 && days < 365) {
        var result = Math.ceil(days / 30) + ' Months'
    } else {
        var result = Math.ceil(days / 365) + ' Years'
    }
    return result
}

function ChangePriceByMonth(value) {
    var subOptions = value.split(':');
    var days = subOptions[0];
    var price = subOptions[1];
    var monthName = convertToMonthsYears(days);
    $("#lbl_price").html(price);
    $("#checkout_price").val(price);
    $("#price").val(price);
    $("#free_update").html(monthName);
    $("#free_update_val").val(days);
    var plan_type = $("#subscription_plan").val();
    if (plan_type == '1') {
        $("#plan_type").html("Single User - 2 PC's");
        $("#usage").val("Single User - 2 PC\'s")
    } else if (plan_type == '2') {
        $("#plan_type").html("10 Users - 25 PC's");
        $("#usage").val("10 Users - 25 PC\'s")
    } else if (plan_type == '3') {
        $("#plan_type").html("Unlimited Users, PC's");
        $("#usage").val("Unlimited Users, PC\'s")
    }
}

function ChangePriceByType(user_plan) {
    var subscription_options = $('#sub_options_container_' + user_plan).html();
    $('#subscription_options').html(subscription_options);
    var month_val = $("#subscription_options").val();
    var subOptions = month_val.split(':');
    var price = subOptions[1];
    var days = subOptions[0];
    var price = subOptions[1];
    var monthName = convertToMonthsYears(days);
    $("#lbl_price").html(price);
    $("#checkout_price").val(price);
    $("#price").val(price);
    $("#free_update").html(monthName);
    $("#free_update_val").val(days);
    $("#lbl_price").html(price);
    $("#checkout_price").val(price);
    $("#price").val(price);
    if (user_plan == '1') {
        $("#plan_type").html("Single User - 2 PC's");
        $("#usage").val("Single User - 2 PC\'s")
    } else if (user_plan == '2') {
        $("#plan_type").html("10 Users - 25 PC's");
        $("#usage").val("10 Users - 25 PC\'s")
    } else if (user_plan == '3') {
        $("#plan_type").html("Unlimited Users, PC's");
        $("#usage").val("Unlimited Users, PC\'s")
    }
}

function submitBundle() {
    $('#bundleInfoForm').submit()
}

function validatePreOrder() {
    var email = $.trim($('#preorder-email').val());
    if (email == '') {
        $('#preorderMsg').show();
        $('#preorderMsg').html('<p class="alert alert-danger">Please enter your email address.</p>');
        return !1
    }
    if (validateEmail(email) == !1) {
        msg = '<p class="alert alert-danger">Please enter valid email address.</p>';
        $('#preorderMsg').show();
        $('#preorderMsg').html(msg);
        return !1
    }
    var URL = BASE_URL + '/exams/preorder';
    var data = $('#preorder-form').serialize();
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function() {
            $('#btnPreOrder').before(function() {
                return getLoadingImg()
            })
        },
        success: function(response) {
            if (response.Error) {
                $('#preorderMsg').show();
                $('#preorderMsg').html('<p class="alert alert-danger">' + response.MSG + '</p>')
            } else {
                $('#preorderMsg').show();
                $('#preorderMsg').html('<p class="alert alert-success">' + response.MSG + '</p>')
            }
            $('#imgLoader').remove();
            var examId = $('#perOrderExamId').val()
        },
        error: function() {
            alert('something went wrong please try again');
            $('#imgLoader').remove()
        }
    })
}

function validateEmail(elementValue) {
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(elementValue)
}

function ajaxLoadVendorExams(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'demos/ajax_get_exams';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {
                vid: vid
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(response) {
                var options = '<option value="">Select Exam</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].exam_code + '">' + response[i].exam_code + '</option>'
                }
                $('#demo_exam_id').find('option').remove().end().append(options);
                $('#imgLoader').remove()
            },
            error: function() {
                alert('something went wrong please try again');
                $('#imgLoader').remove()
            }
        })
    } else {
        var options = '<option value="">Select Exam</option>';
        $('#demo_exam_id').find('option').remove().end().append(options);
        $('#imgLoader').remove()
    }
}

function validateDemoForm() {
    var demo_vendor_id = $('#demo_vendor_id').val();
    var demo_exam_id = $('#demo_exam_id').val();
    var demo_email = $('#demo_email').val();
    if (demo_vendor_id == '') {
        $('#demoMsg').show();
        $('#demoMsg').html('<p class="alert alert-danger">Please select vendor.</p>');
        return !1
    }
    if (demo_exam_id == '') {
        $('#demoMsg').show();
        $('#demoMsg').html('<p class="alert alert-danger">Please select exam.</p>');
        return !1
    }
    if (demo_email == '') {
        $('#demoMsg').show();
        $('#demoMsg').html('<p class="alert alert-danger">Please enter your email address.</p>');
        return !1
    }
    if (validateEmail(demo_email) == !1) {
        msg = '<p class="alert alert-danger">Please enter valid email address.</p>';
        $('#demoMsg').show();
        $('#demoMsg').html(msg);
        return !1
    }
    $('#demos_form').submit()
}

function updateLicense(val, rowId) {
    if (val <= 2) {
        var price = '69';
        var discount = 0
    } else if (val == 3) {
        var price = '84';
        var discount = 21
    } else if (val == 4) {
        var price = '112';
        var discount = 28
    } else if (val == 5) {
        var price = '140';
        var discount = 35
    } else if (val == 6) {
        var price = '168';
        var discount = 42
    }
    $('#sub_total_' + rowId).html("$" + price);
    $('#license_discount_' + rowId).html("$" + discount + " discount");
    if (val > 2) {
        $('#license_discount_' + rowId).show()
    } else {
        $('#license_discount_' + rowId).hide()
    }
}

function validatePasswordChange() {
    var password = $.trim($('#password').val());
    var cpassword = $.trim($('#cpassword').val());
    if (password == '') {
        $('#passwordErrorMsg').show();
        $('#passwordErrorMsg').html('<p class="alert alert-danger">Please enter your password.</p>');
        return !1
    }
    if (password != cpassword) {
        $('#passwordErrorMsg').show();
        $('#passwordErrorMsg').html('<p class="alert alert-danger">Password should match with confirm password.</p>');
        return !1
    }
    var URL = BASE_URL + 'users/changePassword';
    var data = $('#passwordForm').serialize();
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function() {
            $('#passwordErrorMsg').before(function() {
                return getLoadingImg()
            })
        },
        success: function(response) {
            if (response.Error) {
                $('#passwordErrorMsg').show();
                $('#passwordErrorMsg').html('<p class="alert alert-danger">' + response.MSG + '</p>')
            } else {
                $('#passwordErrorMsg').show();
                $('#passwordErrorMsg').html('<p class="alert alert-success">' + response.MSG + '</p>')
            }
            $('#imgLoader').remove()
        },
        error: function() {
            alert('something went wrong please try again');
            $('#imgLoader').remove()
        }
    })
}

function validatePasswordChange2() {
    var password = $.trim($('#password').val());
    var cpassword = $.trim($('#cpassword').val());
    if (password == '') {
        $('#passwordErrorMsg').show();
        $('#passwordErrorMsg').html('<p class="alert alert-danger">Please enter your password.</p>');
        return !1
    }
    if (password != cpassword) {
        $('#passwordErrorMsg').show();
        $('#passwordErrorMsg').html('<p class="alert alert-danger">Password should match with confirm password.</p>');
        return !1
    }
}

function validateUserProfile() {
    var full_name = $.trim($('#full_name').val());
    var email = $.trim($('#email').val());
    var country_id = $.trim($('#country_id').val());
    var gender = $.trim($('#gender').val());
    var phone = $.trim($('#mobile').val());
    var mobile = $.trim($('#mobile').val());
    if (full_name == '') {
        $('#profileErrorMsg').show();
        $('#profileErrorMsg').html('<p class="alert alert-danger">Please enter your name.</p>');
        return !1
    }
    if (email == '') {
        $('#profileErrorMsg').show();
        $('#profileErrorMsg').html('<p class="alert alert-danger">Please enter your email address.</p>');
        return !1
    }
    if (country_id == '') {
        $('#profileErrorMsg').show();
        $('#profileErrorMsg').html('<p class="alert alert-danger">Please select your country.</p>');
        return !1
    }
    if (mobile == '') {
        $('#profileErrorMsg').show();
        $('#profileErrorMsg').html('<p class="alert alert-danger">Please enter your mobile.</p>');
        return !1
    }
    var URL = BASE_URL + 'users/updateprofile';
    var data = $('#userProfileForm').serialize();
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function() {
            $('#btnChangePasswordSubmit').before(function() {
                return getLoadingImg()
            })
        },
        success: function(response) {
            if (response.Error) {
                $('#profileErrorMsg').show();
                $('#profileErrorMsg').html('<p class="alert alert-danger">' + response.MSG + '</p>')
            } else {
                $('#profileErrorMsg').show();
                $('#profileErrorMsg').html('<p class="alert alert-success">' + response.MSG + '</p>')
            }
            $('#imgLoader').remove()
        },
        error: function() {
            alert('something went wrong please try again');
            $('#imgLoader').remove()
        }
    })
}
$(document).ready(function() {
    $('.member-login input[type="radio"]').click(function() {
        var inpVal = this.value;
        if (inpVal == 'member-register') {
            $('#member-login').hide();
            $('#member-register').show()
        } else if (inpVal == 'member-login') {
            $('#member-register').hide();
            $('#member-login').show()
        }
    })
})

function checkEmailExists(email) {
    if (email) {
        var URL = BASE_URL + 'register/checkifEmailExists';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {
                email: email
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(response) {
                if (response.msgStatus == 'Success') {
                    $('p.error').remove();
                    $('#imgLoader').remove()
                } else {
                    $('#imgLoader').remove();
                    $('p.error').remove();
                    $('#email').val('');
                    $('#email').after('<p class="error">' + email + ' already exists please try another email address or kindly <a class="popupBox" href="' + BASE_URL + 'login/login_popup">Login to your account</a></p>');
                    $('#email_pay').val('');
                    $('#email_pay').after('<p class="error">' + email + ' already exists please try another email address or kindly <a class="popupBox" href="' + BASE_URL + 'login/login_popup">Login to your account</a></p>');
                    $('.popupBox').magnificPopup({
                        type: 'ajax',
                        alignTop: !0,
                        closeOnBgClick: !0,
                        showCloseBtn: !0,
                        modal: !0,
                        overflowY: 'scroll',
                        fixedContentPos: !0
                    })
                }
                $('#imgLoader').remove()
            },
            error: function() {
                alert('something went wrong please try again');
                $('#imgLoader').remove()
            }
        })
    }
}

function updateBundlePrice() {
    var subscription = $('#subscription').val();
    var subscription_plan = $('#subscription_plan').val();
    var price = $('#price').val();
    var checkout_price = $('#checkout_price').val();
    var subscription_price_3_inc = $('#subscription_price_3_inc').val();
    var subscription_price_6_inc = $('#subscription_price_6_inc').val();
    var subscription_price_12_inc = $('#subscription_price_12_inc').val();
    var individual_pcs = $('#individual_pcs').val();
    var individual_price_inc = $('#individual_price_inc').val();
    var corporate_pcs = $('#corporate_pcs').val();
    var corporate_price_inc = $('#corporate_price_inc').val();
    var trainer_pcs = $('#trainer_pcs').val();
    var trainer_price_inc = $('#trainer_price_inc').val();
    price = parseInt(price) + parseInt($('#subscription_price_' + subscription + '_inc').val());
    price = parseInt(price) + parseInt($('#' + subscription_plan + '_price_inc').val());
    $('#checkout_price').val(price);
    $('#lbl_price').html(price);
    var default_days = 30;
    var free_days = subscription * default_days;
    $('#free_update').html(free_days + ' days');
    $('#plan_type').html($('#' + subscription_plan + '_pcs').val() + ' PC\'s')
}
$('.popupBox').magnificPopup({
    type: 'ajax',
    alignTop: !0,
    closeOnBgClick: !0,
    showCloseBtn: !0,
    modal: !0,
    overflowY: 'scroll',
    fixedContentPos: !0
});

function closePopup() {
    $.magnificPopup.close()
}

function checkEmailExistsforReseller(email) {
    if (email == '') {
        return false;
    }
    var URL = BASE_URL + 'register/checkifEmailExists';
    $.ajax({
        type: 'POST',
        url: URL,
        data: {
            email: email
        },
        dataType: 'json',
        success: function(response) {
            if (response.msgStatus == 'Success') {
                $('.createCustomer p.error').remove();
                $('.createCustomer #btnCreateResellerUser').removeAttr('disabled');
            } else {
                $('.createCustomer p.error').remove();
                $('.createCustomer #email').val('');
                $('.createCustomer #email').after('<p class="error">' + email + ' already exists please try another email address.</p>');
            }
        },
        error: function() {
            console.log('something went wrong please try again');
        }
    });
}

$(document).ready(function() {

    $('.listCustomers #dataTable').DataTable({
        "aaSorting": [
            [2, "desc"]
        ]
    });
    $('.listCustomers #dataTableProducts').DataTable();

    $('#btnCreateResellerUser').click(function() {
        var full_name = $('.createCustomer #full_name').val();
        var email = $('.createCustomer #email').val();
        var pass = $('.createCustomer #password').val();
        var check_email = $('.createCustomer #check_email').val();

        if (full_name == '') {
            $('.createCustomer #full_name').css('border', '1px solid red');
        } else {
            $('.createCustomer #full_name').css('border', '1px solid #ccc');
        }

        if (email == '') {
            $('.createCustomer #email').css('border', '1px solid red');
        } else {
            $('.createCustomer #email').css('border', '1px solid #ccc');
        }

        if (pass == '') {
            $('.createCustomer #password').css('border', '1px solid red');
        } else {
            $('.createCustomer #password').css('border', '1px solid #ccc');
        }

        if (full_name != '' && email != '' && pass != '') {
            var URL = BASE_URL + 'users/createResellerUser';
            $.ajax({
                type: 'POST',
                url: URL,
                data: {
                    'full_name': full_name,
                    'email': email,
                    'password': pass
                },
                dataType: 'json',
                success: function(response) {
                    if (response.msgStatus == 'Success') {
                        $('#CustomerErrorMsg').show();
                        $('#CustomerErrorMsg').html('<p class="alert alert-success">' + response.msg + '</p>');
                        $('.createCustomer #full_name').val('');
                        $('.createCustomer #email').val('');
                        $('.createCustomer #password').val('');
                        getResellerUsers();
                        setTimeout(function() {
                            $('#CustomerErrorMsg').hide();
                        }, 1000);
                        location.reload();

                    } else {
                        $('#CustomerErrorMsg').show();
                        $('#CustomerErrorMsg').html('<p class="alert alert-danger">' + response.msg + '</p>');
                        setTimeout(function() {
                            $('#CustomerErrorMsg').hide();
                        }, 1000);
                        location.reload();

                    }
                },
                error: function() {
                    console.log('something went wrong please try again');
                }
            });
        }
    })
})

function getResellerUsers() {
    var URL = BASE_URL + 'users/getResellerUsers';
    $.ajax({
        type: 'POST',
        url: URL,
        dataType: 'json',
        success: function(response) {
            if (response.data) {
                console.log(response.data);
                $('.listCustomers #dataTable').DataTable().destroy();
                $('.listCustomers #dataTable tbody').html(response.data);
                $('.listCustomers #dataTable').DataTable({
                    "aaSorting": [
                        [2, "desc"]
                    ]
                });
            }
        },
        error: function() {
            console.log('something went wrong please try again');
        }
    });

}

function deleteUser(user_id) {
    //alert(user_id);
    if (confirm("Are you sure you want to delete this User?")) {
        $('#user_' + user_id).remove();
        var URL = BASE_URL + 'users/deleteUser';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {
                'user_id': user_id
            },
            dataType: 'json',
            success: function(response) {
                if (response.msgStatus == 'Success') {
                    $('#user_' + user_id).remove();
                    getResellerUsers();
                    location.reload();
                }
            },
            error: function() {
                console.log('something went wrong please try again');
            }
        });
    } else {
        return false;
    }

}

function validateShareForm(popupID) {
    //var restoreTxt = getOldHtml('vendorsInfMsg');
    var formId = 'share_product_form';

    var user_id = $('#' + popupID + ' #user_id option:selected').val();
    if (user_id == '') {
        $('#' + popupID + ' #user_id').css('border', '1px solid red');
        return false;
    }

    var data = $('#' + popupID + ' #' + formId).serialize();
    var URL = BASE_URL + 'users/share_product';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function() {
            toggleDisable('btn-demo', true);
            $('#btn-demo').after(function() {
                return getLoadingImg();
            });
        },
        success: function(response) {
            if (response.msgStatus == 'Error') { //if failed
                $('#' + popupID + ' #response').html(response.msg);
            } else if (response.msgStatus == 'Success') { //if failed
                $('#' + popupID + ' #response').html(response.msg);
                getUserSharedProducts(user_id);
                location.reload();

            }
            toggleDisable('btn-demo', false);
            $('#imgLoader').remove();
        },
        error: function() {
            console.log('something went wrong please try again');
            toggleDisable('btn-demo', false);
            $('#imgLoader').remove();
        }
    });
}

function getLisenceKey(exam_code, order_id, validity, allowed_devices, qty) {
    if (exam_code) {
        var exCd = exam_code.replace(/[_\W]+/g, "");
        exCd = exCd + '_practice_' + order_id;
        var URL = BASE_URL + 'users/getLisenceKey';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {
                exam_code: exam_code,
                order_id: order_id,
                validity: validity,
                allowed_devices: allowed_devices,
                qty: qty
            },
            dataType: 'json',
            beforeSend: function() {
                $('#' + exCd + ' #serialKeyBtn').before(function() {
                    return getLoadingImg();
                });
                $('#' + exCd + ' #serialKeyBtn').remove();
            },
            success: function(response) {
                var keyHtml = response.html;
                var popupHtml = response.popup;
                var shareHtml = response.share;
                console.log(response);
                $('.dashboard').append(shareHtml);
                $('.dashboard').append(popupHtml);
                $('body').on('click', 'input[name="extension_type"]', function() {
                    var selectedVal = $(this).val();
                    if (selectedVal == 'add_users') {
                        $('.hideifDuration').show();
                        var price = $('input[name="lisence_key_price_activation"]').val();
                        $('#lisence_update_form #lbl_price').html(price);
                    } else {
                        $('.hideifDuration').hide();
                        var price = $('input[name="lisence_key_price"]').val();
                        $('#lisence_update_form #lbl_price').html(price);
                    }
                })
                
				//Add these Here...
                $('#' + exCd + ' .serialKeyBox').append(keyHtml);
                $('#' + exCd + ' #serialKeyBtn').remove();
                $('#imgLoader').remove();
                
                
                var cardNumber = $('.lisencePopup #cardNumber');
                var cardNumberField = $('.lisencePopup #card-number-field');
                var CVV = $(".lisencePopup #cvv");
                
                cardNumber.payform('formatCardNumber');
                CVV.payform('formatCardCVC');
            
                cardNumber.keyup(function() {
                    cardNumber.removeClass('visa');
                    cardNumber.removeClass('amex');
                    cardNumber.removeClass('mastercard');
            
                    console.log($.payform.parseCardType(cardNumber.val()));
                    if ($.payform.validateCardNumber(cardNumber.val()) == false) {
                        cardNumberField.addClass('has-error');
                    } else {
                        cardNumberField.removeClass('has-error');
                        cardNumberField.addClass('has-success');
                    }
                    if ($.payform.parseCardType(cardNumber.val()) == 'visa') {
                        cardNumber.addClass('visa');
                    } else if ($.payform.parseCardType(cardNumber.val()) == 'amex') {
                        cardNumber.addClass('amex');
                    } else if ($.payform.parseCardType(cardNumber.val()) == 'mastercard') {
                        cardNumber.addClass('mastercard');
                    }
                });
                
                
                
            },
            error: function() {
                alert('something went wrong please try again');
                $('#' + exCd + ' #imgLoader').remove();
            }
        });
    } else {
        $('#' + exCd + ' .serialKeyBox').html('');
        $('#' + exCd + ' #imgLoader').remove();
    }
}

function deleteUserProduct(id, user_id, exam, serial_key, order_id) {
    //alert(user_id);
    if (confirm("Are you sure you want to remove this product from user?")) {
        $('#userProd_' + id).remove();
        var URL = BASE_URL + 'users/deleteUserProduct';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {
                'user_id': user_id,
                'exam': exam,
                'serial_key': serial_key,
                'order_id': order_id
            },
            dataType: 'json',
            success: function(response) {
                if (response.msgStatus == 'Success') {
                    $('#userProd_' + id).remove();
                    getUserSharedProducts(user_id);
                    location.reload();
                }
            },
            error: function() {
                console.log('something went wrong please try again');
            }
        });
    } else {
        return false;
    }

}

function getUserSharedProducts(user_id) {
    var URL = BASE_URL + 'users/getUserSharedProducts';
    $.ajax({
        type: 'POST',
        url: URL,
        data: {
            'reseller_id': user_id
        },
        dataType: 'json',
        success: function(response) {
            if (response.data) {
                //console.log(response.data);
                $('.listCustomers #dataTableProducts').DataTable().destroy();
                $('.listCustomers #dataTableProducts tbody').html(response.data);
                $('.listCustomers #dataTableProducts').DataTable();
            }
        },
        error: function() {
            console.log('something went wrong please try again');
        }
    });

}



function calculatePrice()
	{
		var exam_code = $("#demo_exam_id option:selected").val();
		if(exam_code != '' && exam_code != 'Select Exam' )
		{
		var total_price = 0;
		var URL = BASE_URL+'exams/getProductPrice';
		$.ajax({
			type: 'POST',
			url: URL,
			data: {'exam_code':exam_code},
			dataType: 'json',
			success:function (response){
				if (response){
					console.log(response);
					var pdf_price = response.pdf_price;
					var base_price = response.base_price;
					var practice_price = response.practice_price;
					var key_price = response.key_price;
					var exam_id = response.exam_id;
					console.log(key_price);
					if($('#pdf_check').is(":checked"))
					{
						var pdf_copy = 0;
						var num_copy = $('#num_copy').val();
						$('#num_pdf').val(num_copy);
						if(num_copy)
						{
							num_copy = num_copy - 1;
							pdf_copy = key_price * num_copy;
						}
						else
						{
							$('#num_pdf').val(1);
						}
						$('#bundle_type_id').val(exam_id);
						var pdf_total_price = parseInt(pdf_price) + parseInt(pdf_copy);
						total_price = parseInt(total_price) + parseInt(pdf_total_price);
					}
					if ($('input[name="practice_check"]:checked').length > 0)
					{
						if($('input[name="practice_check"]:checked').val() == 'additional')
						{
							//alert($('input[name="practice_check"]:checked').val());
							var practice_license = 0;
							var num_license = $('#num_license').val();
							$('#num_license_hidden').val(num_license);
							$('#qty').val(1);
							if(num_license && num_license < 3)
							{
								num_license = num_license - 1;
								practice_license = base_price * num_license;
								
								var practice_total_price = parseInt(base_price) + parseInt(practice_license);
							}
							if(num_license > 2)
							{
								num_license = num_license - 2;
								practice_license = key_price * num_license;
								
								var practice_total_price = parseInt(base_price) + parseInt(base_price) + parseInt(practice_license);
							}
							else
							{
								$('#num_license_hidden').val(1);
								
								var practice_total_price = parseInt(base_price) + parseInt(practice_license);
								
							}
							
							total_price = parseInt(total_price) + parseInt(practice_total_price);
							
						}
						else
						{
							//alert($('input[name="practice_check"]:checked').val());
							var num_license_act = 0;
							var num_license_activations = $('#num_license_act').val();
							$('#qty').val(num_license_activations);
							$('#num_license_hidden').val(1);
							if(num_license_activations)
							{
								num_license_activations = num_license_activations - 1;
								num_license_act = key_price * num_license_activations;
							}
							else
							{
								$('#qty').val(1);
							}
							
							var practice_total_price = parseInt(key_price) + parseInt(num_license_act);
							total_price = parseInt(total_price) + parseInt(practice_total_price);
						}
						
					}
					$('#bundle_name').val(exam_code+' Reseller Bundle Pack');
					$('#price').val(total_price);
					$('#checkout_price').val(total_price);
					$('#bundle_type_id').val(exam_id);
					$('#actualPrice').html(base_price);
					$('.additionalKey span').html(key_price);
					
					var num_license = $('#num_license').val();
					if(num_license > 2)
					{
						$('.resel_price span.detail_price').show();
						$('.additionalKey').show();
						var base_price_full = base_price * 2;
						
						num_license = num_license - 2;
						practice_license = key_price * num_license;
						
						$('.resel_price span.detail_price').html(base_price_full+' + '+practice_license+' ('+key_price+'*'+num_license+') = '+total_price);
					}
					else
					{
						$('.resel_price span.detail_price').hide();
						$('.additionalKey').hide();
					}
					
					
					
					if(total_price > 0)
					{
						$('#lbl_price').html(total_price);
						$('.resel_price').show();
						$('#rtl_price').html(practice_price);
						$('.retail_Price').show();
						$('.yourPrice').show();
						$('#submitResellBtn').removeAttr('disabled');
					}
					else
					{
						$('.retail_Price').hide();
						$('.yourPrice').hide();
						$('.resel_price').hide();
						$('#submitResellBtn').attr('disabled','disabled');
					}
					
					
					console.log(total_price);
				}
			},
			error:function(){
				alert('something went wrong please try again');
			}
		});	
		}
		else
		{
			$('.retail_Price').hide();
			$('.yourPrice').hide();
			$('.resel_price').hide();
			$('#submitResellBtn').attr('disabled','disabled');
		}
	}
	
	
function replaceThisKey(serial_key,customer_email,exam_code,order_id)
{
	var data = {'serial_key': serial_key, 'customer_email': customer_email, 'exam_code' :exam_code, 'order_id':order_id};
    var URL = BASE_URL + 'users/replaceKeyFunc';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function() {
            $('#replaceKey').after(function() {return getLoadingImg();});
        },
        success: function(response) {
			location.reload();
            $('#imgLoader').remove();
        },
        error: function() {
			location.reload();
            console.log(response);
            $('#imgLoader').remove();
        }
    });
}