$(function () {
	//$('#certTree').jstree();
	$("#certTree").treeview({
	 collapsed: false,
	 unique: true,
	 persist: "location"
	});
	
	$("#checkAll").click(function(){
		$('tr td input:checkbox').not(this).prop('checked', this.checked);
	});
	
	$('tr td input:checkbox').click(function(){
		if($('tr td input:checkbox').not(':checked').length){
		  $("#checkAll").prop('checked', false);
		}
	});
	
	$("#selectAllRecords").click(function(){
		$('tr td input:checkbox').not(this).prop('checked', this.checked);
	});
	
	$('tr td input:checkbox').click(function(){
		if($('tr td input:checkbox').not(':checked').length){
		  $("#selectAllRecords").prop('checked', false);
		}
	});
	
	$('#applyBulk').change(function(){
		var selected_val = $('#applyBulk').val();
		var controller_name = $('#controller_name').val();
		var replacement_array = $('#replacement_array').val();
		var notactive_array = $('#notactive_array').val();
		var restoreTxt = '';
		if(selected_val != '')
		{
			var comma_sep_ids = '';
			if ($("tr td input:checkbox:checked").length > 0)
			{
				$('tr td input:checkbox:checked').each(function() {
			   		comma_sep_ids += $(this).val()+',';
			 	});
				comma_sep_ids = comma_sep_ids.slice(0,-1);
				if(selected_val == 'delete')
				{
					replacement_array = replacement_array.split(',');
					comma_sep_ids = comma_sep_ids.split(',');
					comma_sep_ids = comma_sep_ids.filter( function( el ) {
					  return replacement_array.indexOf( el ) < 0;
					});
					comma_sep_ids = comma_sep_ids.join(",");
					if(comma_sep_ids){
						if(confirm("Are you sure to delete selected record(s)?"))
						{
							var URL = BASE_URL + 'admin/'+controller_name+'/bulk_delete/';
							var data = {'selected_ids':comma_sep_ids};
							$.ajax({
								type: 'POST',
								url: URL,
								data: data,
								dataType: 'json',
								success: function (response) {
									if (response.msgStatus == 'Error') { //if failed
										displayMessage('infoMessage', 'danger', response.msgText, restoreTxt);
									} else if (response.msgStatus == 'Success') { //if failed
										displayMessage('infoMessage', 'success', response.msgText, restoreTxt);
										var array_ids = comma_sep_ids.split(',');
										$.each(array_ids, function( index, value ) {
										  removeRow(controller_name+'_'+value); 
										});
										$("#applyBulk").selectBoxIt('selectOption', 0);
									}
								},
								error: function () {
									alert('something went wrong please try again');
								}
							});
						}
						else
						{
							$("#applyBulk").selectBoxIt('selectOption', 0);
						}
					}
				}
				notactive_array = notactive_array.split(',');
				comma_sep_ids = comma_sep_ids.split(',');
				comma_sep_ids = comma_sep_ids.filter( function( el ) {
					return notactive_array.indexOf( el ) < 0;
				});
				comma_sep_ids = comma_sep_ids.join(",");
				if(selected_val == 'inactive')
				{
					var URL = BASE_URL + 'admin/'+controller_name+'/bulk_inactive';
					var data = {'selected_ids':comma_sep_ids};
					$.ajax({
							type: 'POST',
							url: URL,
							data: data,
							dataType: 'json',
							success: function (response) {
								if (response.msgStatus == 'Error') { //if failed
									displayMessage('infoMessage', 'danger', response.msgText, restoreTxt);
								} else if (response.msgStatus == 'Success') { //if failed
									displayMessage('infoMessage', 'success', response.msgText, restoreTxt);
									var array_ids = comma_sep_ids.split(',');
									$.each(array_ids, function( index, value ) {
										var curCls = 'danger';
										var curState = 'Inactive';
										$('#isStatus_'+value).removeClass("label label-success label-danger").addClass('label label-' + curCls);
										$('#isStatus_'+value).html('').html(curState);
									});
									window.location = window.location.pathname;
									//redirectPage(BASE_URL + 'admin/'+controller_name);
								}
							},
							error: function () {
								alert('something went wrong please try again');
							}
					});
				}
				if(selected_val == 'active')
				{
					var URL = BASE_URL + 'admin/'+controller_name+'/bulk_active';
					var data = {'selected_ids':comma_sep_ids};
					$.ajax({
							type: 'POST',
							url: URL,
							data: data,
							dataType: 'json',
							success: function (response) {
								if (response.msgStatus == 'Error') { //if failed
									displayMessage('infoMessage', 'danger', response.msgText, restoreTxt);
								} else if (response.msgStatus == 'Success') { //if failed
									displayMessage('infoMessage', 'success', response.msgText, restoreTxt);
									var array_ids = comma_sep_ids.split(',');
									$.each(array_ids, function( index, value ) {
										var curCls = 'success';
										var curState = 'Active';
										$('#isStatus_'+value).removeClass("label label-success label-danger").addClass('label label-' + curCls);
										$('#isStatus_'+value).html('').html(curState);
									});
									window.location = window.location.pathname;
									//redirectPage(BASE_URL + 'admin/'+controller_name);
								}
							},
							error: function () {
								alert('something went wrong please try again');
							}
					});
				}
				
			}
			else
			{
			   alert('Please Select Records First!');
			   $("#applyBulk").selectBoxIt('selectOption', 0);
			}
		}
	})
	
	$('#applyBulkAttrib').change(function(){
		var selected_val = $('#applyBulkAttrib').val();
		var controller_name = $('#controller_name').val();
		var attribute_type = $('#attribute_type').val();
		var restoreTxt = '';
		if(selected_val != '')
		{
			var comma_sep_ids = '';
			if ($("tr td input:checkbox:checked").length > 0)
			{
				$('tr td input:checkbox:checked').each(function() {
			   		comma_sep_ids += $(this).val()+',';
			 	});
				comma_sep_ids = comma_sep_ids.slice(0,-1);
				if(selected_val == 'delete')
				{
					if(confirm("Are you sure to delete selected record(s)?"))
					{
						var URL = BASE_URL + 'admin/'+controller_name+'/bulk_delete_'+attribute_type+'/';
						var data = {'selected_ids':comma_sep_ids};
						$.ajax({
							type: 'POST',
							url: URL,
							data: data,
							dataType: 'json',
							success: function (response) {
								if (response.msgStatus == 'Error') { //if failed
									displayMessage('infoMessage', 'danger', response.msgText, restoreTxt);
								} else if (response.msgStatus == 'Success') { //if failed
									displayMessage('infoMessage', 'success', response.msgText, restoreTxt);
									var array_ids = comma_sep_ids.split(',');
									$.each(array_ids, function( index, value ) {
									  removeRow(attribute_type+'_'+value);
									});
									$("#applyBulkAttrib").selectBoxIt('selectOption', 0);
								}
							},
							error: function () {
								alert('something went wrong please try again');
							}
						});
					}
					else
					{
						$("#applyBulkAttrib").selectBoxIt('selectOption', 0);
					}
				}
				if(selected_val == 'inactive')
				{
					var URL = BASE_URL + 'admin/'+controller_name+'/bulk_inactive_'+attribute_type+'';
					var data = {'selected_ids':comma_sep_ids};
					$.ajax({
							type: 'POST',
							url: URL,
							data: data,
							dataType: 'json',
							success: function (response) {
								if (response.msgStatus == 'Error') { //if failed
									displayMessage('infoMessage', 'danger', response.msgText, restoreTxt);
								} else if (response.msgStatus == 'Success') { //if failed
									displayMessage('infoMessage', 'success', response.msgText, restoreTxt);
									var array_ids = comma_sep_ids.split(',');
									$.each(array_ids, function( index, value ) {
										var curCls = 'danger';
										var curState = 'Inactive';
										$('#isStatus_'+value).removeClass("label label-success label-danger").addClass('label label-' + curCls);
										$('#isStatus_'+value).html('').html(curState);
									});
									window.location = window.location.pathname;
									//redirectPage(BASE_URL + 'admin/'+controller_name);
								}
							},
							error: function () {
								alert('something went wrong please try again');
							}
					});
				}
				if(selected_val == 'active')
				{
					var URL = BASE_URL + 'admin/'+controller_name+'/bulk_active_'+attribute_type+'';
					var data = {'selected_ids':comma_sep_ids};
					$.ajax({
							type: 'POST',
							url: URL,
							data: data,
							dataType: 'json',
							success: function (response) {
								if (response.msgStatus == 'Error') { //if failed
									displayMessage('infoMessage', 'danger', response.msgText, restoreTxt);
								} else if (response.msgStatus == 'Success') { //if failed
									displayMessage('infoMessage', 'success', response.msgText, restoreTxt);
									var array_ids = comma_sep_ids.split(',');
									$.each(array_ids, function( index, value ) {
										var curCls = 'success';
										var curState = 'Active';
										$('#isStatus_'+value).removeClass("label label-success label-danger").addClass('label label-' + curCls);
										$('#isStatus_'+value).html('').html(curState);
									});
									window.location = window.location.pathname;
									//redirectPage(BASE_URL + 'admin/'+controller_name);
								}
							},
							error: function () {
								alert('something went wrong please try again');
							}
					});
				}
				
			}
			else
			{
			   alert('Please Select Records First!');
			   $("#applyBulkAttrib").selectBoxIt('selectOption', 0);
			}
		}
	})
	
	$('.addAttrib').magnificPopup({
		type: 'ajax',
		alignTop: true,
		overflowY: 'scroll',
		fixedContentPos: true
	});
	
	$('.viewCertDetail').magnificPopup({
		type: 'ajax',
		alignTop: true,
		overflowY: 'scroll',
		fixedContentPos: true
	});
	
    $('.option_day').on('click',function(){
       alert($(this).val());
       $(this).closest("div").find('.showmonths').remove();
    });
    /**validate login**/
    $('#Login_form').submit(function (event) {

        event.preventDefault();
        validateLogin();
    });
    /**ENd validate login**/

    /**update adminAccountInfo*/
    $('#adminAccountInfo_form').submit(function (event) {
        event.preventDefault();
        updateAdminAccountInfo();
    });

    /**Change admin password*/
    $('#adminPassword_form').submit(function (event) {
        event.preventDefault();
        changeAdminPassword();
    });
	
	/**Change Users password*/
    $('#usersPassword_form').submit(function (event) {
        event.preventDefault();
        changeUsersPassword();
    });
	
	

    /**submit vendor form**/
    $("#vendorData_form").submit(function (event) {
        event.preventDefault();
        if ($("#vendorData_form").valid()) {
            validateVendor('vendorData_form');
        } else {
            return false;
        }
    });

    /**submit certification form**/
    $("#certificationData_form").submit(function (event) {
        event.preventDefault();
        if ($("#certificationData_form").valid()) {
            validateCertification('certificationData_form');
        } else {
            return false;
        }
    });

    /**submit exam form**/
    $("#examData_form").submit(function (event) {
        event.preventDefault();
        if ($("#examData_form").valid()) {
            validateExam('examData_form');
        } else {
            return false;
        }
    });

    /**Submit pages form*/

    $("#pageData_form").submit(function (event) {
        event.preventDefault();
        if ($("#pageData_form").valid()) {
            validatePage('pageData_form');
        } else {
            return false;
        }
    });

    /**Submit coupons form*/

    $("#couponData_form").submit(function (event) {
        event.preventDefault();
        if ($("#couponData_form").valid()) {
            validateCoupon('couponData_form');
        } else {
            return false;
        }
    });
    
    /**Submit currencies form*/

    $("#currencyData_form").submit(function (event) {
        event.preventDefault();
        if ($("#currencyData_form").valid()) {
            validateCurrency('currencyData_form');
        } else {
            return false;
        }
    });
    /**Submit customers form*/
    $("#customerData_form").submit(function (event) {
        event.preventDefault();
        if ($("#customerData_form").valid()) {
            validateCustomer('customerData_form');
        } else {
            return false;
        }
    });

    /**Submit users form*/
    $("#userData_form").submit(function (event) {
        event.preventDefault();
        if ($("#userData_form").valid()) {
            validateUser('userData_form');
        } else {
            return false;
        }
    });

    /**Submit Site settings form*/
    $("#site_settingData_form").submit(function (event) {
        event.preventDefault();
        if ($("#site_settingData_form").valid()) {
            validateSite_setting('site_settingData_form');
        } else {
            return false;
        }
    });
    
    /**Submit no follow settings form*/
    $("#noFollowData_form").submit(function (event) {
        event.preventDefault();
        if ($("#noFollowData_form").valid()) {
            validateNoFollow('noFollowData_form');
        } else {
            return false;
        }
    });
    
    /**Submit gvcode form*/
    $("#gv_codeData_form").submit(function (event) {
        event.preventDefault();
        if ($("#gv_codeData_form").valid()) {
            validategv_code('gv_codeData_form');
        } else {
            return false;
        }
    });
    
    /**Submit gAnalytics form*/
    $("#gAnalyticsData_form").submit(function (event) {
        event.preventDefault();
        if ($("#gAnalyticsData_form").valid()) {
            validategAnalytics('gAnalyticsData_form');
        } else {
            return false;
        }
    });
    
    /**Submit gAnalytics form*/
    $("#approveOrderData_form").submit(function (event) {
        event.preventDefault();
        if ($("#approveOrderData_form").valid()) {
            validategapproveOrder('approveOrderData_form');
        } else {
            return false;
        }
    });


    /**Submit Banners form*/
    $("#bannerData_form").submit(function (event) {
        event.preventDefault();
        if ($("#bannerData_form").valid()) {
            validateBanner('bannerData_form');
        } else {
            return false;
        }
    });

    /**Submit Banners form*/
    $("#widgetData_form").submit(function (event) {
        event.preventDefault();
        if ($("#widgetData_form").valid()) {
            validateWidget('widgetData_form');
        } else {
            return false;
        }
    });
	
	/**Submit Faqs form*/
    $("#faqData_form").submit(function (event) {
        event.preventDefault();
        if ($("#faqData_form").valid()) {
            validateFaq('faqData_form');
        } else {
            return false;
        }
    });

    /**submit content form**/
    $("#contentData_form").submit(function (event) {
        event.preventDefault();
        if ($("#contentData_form").valid()) {
            validateContent('contentData_form');
        } else {
            return false;
        }
    });
	
	/**submit content form**/
    $("#contentData_form2").submit(function (event) {
        event.preventDefault();
        if ($("#contentData_form2").valid()) {
            validateContent2('contentData_form2');
        } else {
            return false;
        }
    });

    $("#product_typeData_form").submit(function (event) {
        event.preventDefault();
        if ($("#product_typeData_form").valid()) {
            validateProduct_type('product_typeData_form');
        } else {
            return false;
        }
    });
	

    $("#productData_form").submit(function (event) {
        event.preventDefault();
        if ($("#productData_form").valid()) {
            validateProductPrice('productData_form');
        } else {
            return false;
        }
    });

    /**Submit Product videos form*/
    $("#Product_videosData_form").submit(function (event) {
        event.preventDefault();
        if ($("#Product_videosData_form").valid()) {
            validateProduct_videos('Product_videosData_form');
        } else {
            return false;
        }
    });

    /**Submit Testimonials form*/
    $("#testimonialData_form").submit(function (event) {
        event.preventDefault();
        if ($("#testimonialData_form").valid()) {
            validateTestimonial('testimonialData_form');
        } else {
            return false;
        }
    });

    /**submit bundle form**/
    $("#bundleData_form").submit(function (event) {
        event.preventDefault();
        if ($("#bundleData_form").valid()) {
            validateBundle('bundleData_form');
        } else {
            return false;
        }
    });

    /**submit bundle_default form**/
    $("#bundle_defaultData_form").submit(function (event) {
        event.preventDefault();
        if ($("#bundle_defaultData_form").valid()) {
            validateBundleDefault('bundle_defaultData_form');
        } else {
            return false;
        }
    });
    
    /**submit subscription form**/
    $("#subscriptionData_form").submit(function (event) {
        event.preventDefault();
        if ($("#subscriptionData_form").valid()) {
            validateSubscription('subscriptionData_form');
        } else {
            return false;
        }
    });
    
    
    /**Submit netbanxhoster_payment_method form*/
    $("#netbanxhoster_payment_methodData_form").submit(function (event) {
        event.preventDefault();
        if ($("#netbanxhoster_payment_methodData_form").valid()) {
            validatenetbanxhoster_payment_method('netbanxhoster_payment_methodData_form');
        } else {
            return false;
        }
    });
    
    /**Submit netbanxenterprise_payment_method form*/
    $("#netbanxenterprise_payment_methodData_form").submit(function (event) {
        event.preventDefault();
        if ($("#netbanxenterprise_payment_methodData_form").valid()) {
            validatenetbanxenterprise_payment_method('netbanxenterprise_payment_methodData_form');
        } else {
            return false;
        }
    });
    
    /**Submit paypal_payment_method form*/
    $("#paypal_payment_methodData_form").submit(function (event) {
        event.preventDefault();
        if ($("#paypal_payment_methodData_form").valid()) {
            validatepaypal_payment_method('paypal_payment_methodData_form');
        } else {
            return false;
        }
    });
    
    /**Submit sagepay_payment_method form*/
    $("#sagepay_payment_methodData_form").submit(function (event) {
        event.preventDefault();
        if ($("#sagepay_payment_methodData_form").valid()) {
            validatesagepay_payment_method('sagepay_payment_methodData_form');
        } else {
            return false;
        }
    });
    
    /**Submit manualorder_payment_method form*/
    $("#manualorder_payment_methodData_form").submit(function (event) {
        event.preventDefault();
        if ($("#manualorder_payment_methodData_form").valid()) {
            validatemanualorder_payment_method('manualorder_payment_methodData_form');
        } else {
            return false;
        }
    });
    
    /**Submit bundle-discountData_form */
    $("#bundle-discountData_form").submit(function (event) {
        event.preventDefault();
        if ($("#bundle-discountData_form").valid()) {
            validateBundleDiscount('bundle-discountData_form');
        } else {
            return false;
        }
    });
    
    /**Submit reorder-discountData_form*/
    $("#reorder-discountData_form").submit(function (event) {
        event.preventDefault();
        if ($("#reorder-discountData_form").valid()) {
            validateReorderDiscount('reorder-discountData_form');
        } else {
            return false;
        }
    });
    
    /**Submit royalpack-discountData_form*/
    $("#royalpack-discountData_form").submit(function (event) {
        event.preventDefault();
        if ($("#royalpack-discountData_form").valid()) {
            validateRoyalpackDiscount('royalpack-discountData_form');
        } else {
            return false;
        }
    });
    
    /**Submit quanity-discountData_form*/
    $("#quantity-discountData_form").submit(function (event) {
        event.preventDefault();
        if ($("#quantity-discountData_form").valid()) {
            validateQuantityDiscount('quantity-discountData_form');
        } else {
            return false;
        }
    });   

    /**Submit Redirects**/
     $("#redirectData_form").submit(function (event) {
        event.preventDefault();
        if ($("#redirectData_form").valid()) {
            validateRedirect('redirectData_form');
        } else {
            return false;
        }
    });
	
	/**submit Level form**/
    $("#levelData_form").submit(function (event) {
        event.preventDefault();
        if ($("#levelData_form").valid()) {
            validateLevel('levelData_form');
        } else {
            return false;
        }
    });
	
	$("#scriptsData_form").submit(function (event) {
		event.preventDefault();
        if ($("#scriptsData_form").valid()) {
            validateTags('scriptsData_form');
        } else {
            return false;
        }
    });
	
	/**submit Audience form**/
    $("#audienceData_form").submit(function (event) {
        event.preventDefault();
        if ($("#audienceData_form").valid()) {
            validateAudience('audienceData_form');
        } else {
            return false;
        }
    });
	
	/**submit Technology form**/
    $("#techData_form").submit(function (event) {
        event.preventDefault();
        if ($("#techData_form").valid()) {
            validateTech('techData_form');
        } else {
            return false;
        }
    });
	
	/**submit Format form**/
    $("#formatData_form").submit(function (event) {
        event.preventDefault();
        if ($("#formatData_form").valid()) {
            validateFormat('formatData_form');
        } else {
            return false;
        }
    });
	
	/**submit Format form**/
    $("#emailData_form").submit(function (event) {
        event.preventDefault();
        if ($("#emailData_form").valid()) {
            validateEmails('emailData_form');
        } else {
            return false;
        }
    });
	
	/**submit Format form**/
    $("#emailSettings_form").submit(function (event) {
        event.preventDefault();
        if ($("#emailSettings_form").valid()) {
            validateEmailSettings('emailSettings_form');
        } else {
            return false;
        }
    });
	
	/**submit Format form**/
    $("#emailTypeData_form").submit(function (event) {
        event.preventDefault();
        if ($("#emailTypeData_form").valid()) {
            validateEmailType('emailTypeData_form');
        } else {
            return false;
        }
    });
	
	/**submit Format form**/
    $("#adminData_form").submit(function (event) {
        event.preventDefault();
        if ($("#adminData_form").valid()) {
            validateAdminUser('adminData_form');
        } else {
            return false;
        }
    });
	
	 $("#keysOrderData_form").submit(function (event) {
        event.preventDefault();
        if ($("#keysOrderData_form").valid()) {
            validateKeysOrder('keysOrderData_form');
        } else {
            return false;
        }
    });
	
	
	
	
	
	
	
	

});
	function clearSelection(id)
	{
		$("#"+id+" option:selected").prop("selected", false);
	}
	
	function checkCheckboxes(cls)
	{
		var checkBoxes = $("."+cls+" input[name=exam_ids\\[\\]]");
		checkBoxes.prop("checked", "checked");
	}
	
	function uncheckCheckboxes(cls)
	{
		var checkBoxes = $("."+cls+" input[name=exam_ids\\[\\]]");
		checkBoxes.removeAttr("checked");
	}
	
	
	$('body').on('change','#require_certs', function() {
		var cids = $(this).val();
		var vid = $('#vendor_id option:selected').val();
		if(cids)
		{
			cids = cids.toString();
			ajaxLoadExamsOnCertBasis(vid,cids);
		}
		else
		{
			$('#require_exams').html('');
		}
		
	})
	
	$('body').on('change','#keyPracticeExam #examExt', function() {
		var exam = $(this).val();
		getPracticeExamKeys(exam);
	})
	
	$('body').on('change','#lisence_keysExt', function() {
		//alert("YES");
		var count = $("#lisence_keysExt :selected").length;
		$('#noofkeysExt').val(count);
		updateOrderPriceExt();
	})
	
	
	
	
	$('body').on('change','#certification_id', function() {
		var cid = $(this).val();
		var vid = $('#vendor_id option:selected').val();
		if(cid)
		{
			ajaxLoadExamsOnCertBasisDropdown(vid,cid);
		}
		else
		{
			$('#exam_id').html('');
		}
		
	})
	
function selectSlugListingTypeFunc(val)
{
	if(val)
	{
		window.location.href = BASE_URL + 'admin/slug/'+val;
	}
	 
}	
	
$(document).ready(function(){
	
	$('#pageData_form select').change(function(){
		checkIfPageAlreadyExists('pageData_form','pages');
	})
	
	
	$( "#accordion" ).accordion({
      collapsible: true,
	  heightStyle: "content",
	  active: false
    });
	
	$( "#accordion2" ).accordion({
      collapsible: true,
	  heightStyle: "content",
	  active: false
    });
	
	
    $('#missingTable').DataTable();
	$('#missingTable1').DataTable();
	$('#missingTable2').DataTable();
	$('#missingTable3').DataTable();
	$('#missingTable4').DataTable();
	$('#missingTable5').DataTable();
	$('#missingTable6').DataTable();
});
$('body').on('click','#btnExamSubmitOptions', function() {
		var restoreTxt = getOldHtml('examsInfMsg');
		var data = $('.mfp-content #examData_form').serialize();
		var URL = BASE_URL + 'admin/exams/ajaxSave';
		$.ajax({
			type: 'POST',
			url: URL,
			data: data,
			dataType: 'json',
			beforeSend: function () {
				toggleDisable('btnExamSubmitOptions', true);
				$('#btnExamSubmitOptions').before(function () {
					return getLoadingImg();
				});
			},
			success: function (response) {
				if (response.msgStatus == 'Error') { //if failed
					displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
				} else if (response.msgStatus == 'Success') { //if failed
					displayMessage('examsInfMsg', 'success', response.msgText, restoreTxt);
					window.location = window.location.pathname;
				}
				toggleDisable('btnExamSubmitOptions', false);
			},
			error: function () {
				alert('something went wrong please try again');
				toggleDisable('btnExamSubmitOptions', false);
			}
		});
})

$('body').on('change','select#preorder', function() {
		//alert($('select#preorder').val());
		if($('select#preorder').val() == 0)
		{
			$('.checkPreorder').hide();
			$('.hideifNotPreorder').show();
		}
		else
		{
			$('.hideifNotPreorder').hide();
			$('.checkPreorder').show();
		}
})

$('body').on('change','select#status', function() {
		//alert($('select#preorder').val());
		if($('select#status').val() != '0')
		{
			$('.redirectOptions').hide();
		}
		else
		{
			$('.redirectOptions').show();
		}
})

$('body').on('change','select#actionPeriod', function() {
		var period = $(this).val();
		getTotalVisitors(period);
		getTotalRegistration(period);
		getTotalDemos(period);
		getTotalOrders(period);
		getTotalRefundedOrders(period);
		getTotalSalesType(period);
})

function getTotalVisitors(period) {
    var URL = BASE_URL + 'admin/home/totalVisitors';
    $.ajax({
        type: 'POST',
        url: URL,
        data: { 'order_period' : period},
        dataType: 'json',
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                
            } else if (response.msgStatus == 'Success') { //if failed
                $('#noOfUsers').html(response.data);
            }
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}

function getTotalRegistration(period) {
    var URL = BASE_URL + 'admin/home/totalRegisters';
    $.ajax({
        type: 'POST',
        url: URL,
        data: { 'order_period' : period},
        dataType: 'json',
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                
            } else if (response.msgStatus == 'Success') { //if failed
                $('#noOfUsersReg').html(response.data);
            }
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}

function getTotalDemos(period) {
    var URL = BASE_URL + 'admin/home/totalDemos';
    $.ajax({
        type: 'POST',
        url: URL,
        data: { 'order_period' : period},
        dataType: 'json',
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                
            } else if (response.msgStatus == 'Success') { //if failed
                $('#noOfDemos').html(response.data);
            }
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}

function getTotalOrders(period) {
    var URL = BASE_URL + 'admin/home/totalOrders';
    $.ajax({
        type: 'POST',
        url: URL,
        data: { 'order_period' : period},
        dataType: 'json',
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                
            } else if (response.msgStatus == 'Success') { //if failed
                $('#noOfOrders').html('Orders = '+response.data.noOfOrders);
				$('#noOfOrdersSales').html('Sales = $'+response.data.totalSales);
            }
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}

function getTotalRefundedOrders(period) {
    var URL = BASE_URL + 'admin/home/totalRefundedOrders';
    $.ajax({
        type: 'POST',
        url: URL,
        data: { 'order_period' : period},
        dataType: 'json',
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                
            } else if (response.msgStatus == 'Success') { //if failed
                $('#noOfRefOrders').html('Orders = '+response.data.noOfOrders);
				$('#noOfRefOrdersAmount').html('Refund Amount = $'+response.data.totalSales);
            }
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}

function getTotalSalesType(period) {
    var URL = BASE_URL + 'admin/home/salesTypes';
    $.ajax({
        type: 'POST',
        url: URL,
        data: { 'order_period' : period},
        dataType: 'json',
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                
            } else if (response.msgStatus == 'Success') { //if failed
                $('#salesTypeDemo').html('Sales after Demo = '+response.data.salesTypeDemo);
				$('#salesTypeDirect').html('Direct Sales = '+response.data.salesTypeDirect);
            }
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}




function changeBundlePricing(val)
{
	if(val == 'price')
	{
		$('.BDPercentage').hide();
		$('.BDPrice').show();
	}
	else if(val == 'percentage')
	{
		$('.BDPrice').hide();
		$('.BDPercentage').show();
	}
}


$(document).ready(function(){
	
	$('#include_format').click(function(){
		if($('#include_format').is(":checked"))
		{
			$('.hideCondition').show();
		}
		else
		{
			$('.hideCondition').hide();
		}
	});
	
	
	$('#btnEditBulkSlug').click(function(){
		if ($("tr td input:checkbox:checked").length > 0)
		{
				
		}
		else
		{
			$('.validate-has-error').remove();
			$('.recordsDiv').css('border','1px solid #cc3f44');
			errorHtml = '<span id="name-error" class="validate-has-error">Please Select at least one record to implement Slug change!</span>';
			$('.recordsDiv').before(errorHtml);
			return false;
		}
	})
	
	$("#vendorIncludeSlug").change(function() {
		var vendor_txt = $("#vendor_id option:selected").text();
		var vendor_val = $("#vendor_id option:selected").val();
		var nameOptionsSlug = $('input[name=examNameIncludeSlug]:checked').val();
		var name_slug = $("#name").val();
		var full_slug = '';
		console.log(nameOptionsSlug);
		console.log(vendor_val);
		var shortname_slug = $("#exam_code").val();
		shortname_slug = shortname_slug.replace('/', "-");
		name_slug = name_slug.replace('/', "-");
		vendor_txt = vendor_txt.replace('/', "-");
		if($(this).is(":checked")) {
				if(vendor_val && nameOptionsSlug)
				{
					var vendor_slug = vendor_txt.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					vendor_slug = vendor_slug+'-';
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = vendor_slug+name_slug;
						}
						else
						{
							alert('Please enter Exam Name to include in Slug!');
							full_slug = vendor_slug;
						}
						
					}
					if(nameOptionsSlug == 'examcode')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = vendor_slug+shortname_slug;
						}
						else
						{
							alert('Please enter Exam Code to include in Slug!');
							full_slug = vendor_slug;
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val == '' && !(nameOptionsSlug) && shortname_slug != '')
				{
					alert('Please select Vendor First!');
					$("#vendorIncludeSlug").removeAttr('checked');
					shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = shortname_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val == '' && !(nameOptionsSlug) && name_slug != '')
				{
					alert('Please select Vendor First!');
					$("#vendorIncludeSlug").removeAttr('checked');
					name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = name_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val != '' && !(nameOptionsSlug))
				{
					var vendor_slug = vendor_txt.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					vendor_slug = vendor_slug+'-';
					if(name_slug)
					{
						name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
						full_slug = vendor_slug+name_slug;
					}
					else
					{
						full_slug = vendor_slug;
					}
					$("#cert_slug").val(full_slug);
				}
				else if(!(vendor_val) && nameOptionsSlug)
				{
					alert('Please select Vendor First!');
					$("#vendorIncludeSlug").removeAttr('checked');
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = name_slug;
						}
						else
						{
							alert('Please enter Exam Name to include in Slug!');
							full_slug = '';
						}
						
					}
					if(nameOptionsSlug == 'examcode')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = shortname_slug;
						}
						else
						{
							alert('Please enter Exam Code to include in Slug!');
							full_slug = '';
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else
				{
					alert('Please select Vendor First!');
					if(shortname_slug)
					{
						shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
						full_slug = shortname_slug;
					}
					$("#cert_slug").val(full_slug);
					$("#vendorIncludeSlug").removeAttr('checked');
				}
				
			}
			else
			{
				if(nameOptionsSlug)
				{
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = name_slug;
						}
						else
						{
							alert('Please enter Exam Name to include in Slug!');
							full_slug = '';
						}
						
					}
					if(nameOptionsSlug == 'examcode')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = shortname_slug;
						}
						else
						{
							alert('Please enter Exam Code to include in Slug!');
							full_slug = '';
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else if(!(nameOptionsSlug) && name_slug == '' && shortname_slug != '')
				{
					shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = shortname_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(!(nameOptionsSlug) && name_slug != '')
				{
					name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = name_slug;
					$("#cert_slug").val(full_slug);
				}
				else
				{
					$("#cert_slug").val('');
				}
			}
	});
	
	$("#vendorIncludeCertSlug").change(function() {
		var vendor_txt = $("#vendor_id option:selected").text();
		var vendor_val = $("#vendor_id option:selected").val();
		var nameOptionsSlug = $('input[name=nameIncludeSlug]:checked').val();
		var name_slug = $("#name").val();
		var full_slug = '';
		console.log(nameOptionsSlug);
		console.log(vendor_val);
		var shortname_slug = $("#cert_shortname").val();
		shortname_slug = shortname_slug.replace('/', "-");
		name_slug = name_slug.replace('/', "-");
		vendor_txt = vendor_txt.replace('/', "-");
		if($(this).is(":checked")) {
				if(vendor_val && nameOptionsSlug)
				{
					var vendor_slug = vendor_txt.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					vendor_slug = vendor_slug+'-';
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = vendor_slug+name_slug;
						}
						else
						{
							alert('Please enter Certification Title to include in Slug!');
							full_slug = vendor_slug;
						}
						
					}
					if(nameOptionsSlug == 'shortname')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = vendor_slug+shortname_slug;
						}
						else
						{
							alert('Please enter Certification Short Name to include in Slug!');
							full_slug = vendor_slug;
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val == '' && !(nameOptionsSlug) && name_slug != '')
				{
					alert('Please select Vendor First!');
					$("#vendorIncludeCertSlug").removeAttr('checked');
					name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = name_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val == '' && !(nameOptionsSlug) && name_slug == '' && shortname_slug != '')
				{
					alert('Please select Vendor First!');
					$("#vendorIncludeCertSlug").removeAttr('checked');
					shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = shortname_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val != '' && !(nameOptionsSlug))
				{
					var vendor_slug = vendor_txt.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					vendor_slug = vendor_slug+'-';
					if(name_slug)
					{
						name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
						full_slug = vendor_slug+name_slug;
					}
					else
					{
						full_slug = vendor_slug;
					}
					$("#cert_slug").val(full_slug);
				}
				else if(!(vendor_val) && nameOptionsSlug)
				{
					alert('Please select Vendor First!');
					$("#vendorIncludeCertSlug").removeAttr('checked');
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = name_slug;
						}
						else
						{
							alert('Please enter Certification Title to include in Slug!');
							full_slug = '';
						}
						
					}
					if(nameOptionsSlug == 'shortname')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = shortname_slug;
						}
						else
						{
							alert('Please enter Certification Short Name to include in Slug!');
							full_slug = '';
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else
				{
					alert('Please select Vendor First!');
					if(shortname_slug)
					{
						shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
						full_slug = shortname_slug;
					}
					$("#cert_slug").val(full_slug);
					$("#vendorIncludeCertSlug").removeAttr('checked');
				}
				
			}
			else
			{
				if(nameOptionsSlug)
				{
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = name_slug;
						}
						else
						{
							alert('Please enter Certification Title to include in Slug!');
							full_slug = '';
						}
						
					}
					if(nameOptionsSlug == 'shortname')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = shortname_slug;
						}
						else
						{
							alert('Please enter Certification Short Name to include in Slug!');
							full_slug = '';
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else if(!(nameOptionsSlug) && name_slug != '')
				{
					name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = name_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(!(nameOptionsSlug) && name_slug == '' && shortname_slug != '')
				{
					shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = shortname_slug;
					$("#cert_slug").val(full_slug);
				}
				else
				{
					$("#cert_slug").val('');
				}
			}
	});
	
	$("input[name=examNameIncludeSlug]").change(function() {
		var vendor_txt = $("#vendor_id option:selected").text();
		var vendor_val = $("#vendor_id option:selected").val();
		var nameOptionsSlug = $('input[name=examNameIncludeSlug]:checked').val();
		var name_slug = $("#name").val();
		var full_slug = '';
		console.log(nameOptionsSlug);
		console.log(vendor_val);
		var shortname_slug = $("#exam_code").val();
		shortname_slug = shortname_slug.replace('/', "-");
		name_slug = name_slug.replace('/', "-");
		vendor_txt = vendor_txt.replace('/', "-");
		if($("#vendorIncludeSlug").is(":checked")) {
				if(vendor_val && nameOptionsSlug)
				{
					var vendor_slug = vendor_txt.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					vendor_slug = vendor_slug+'-';
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = vendor_slug+name_slug;
						}
						else
						{
							alert('Please enter Exam Name to include in Slug!');
							full_slug = vendor_slug;
						}
						
					}
					if(nameOptionsSlug == 'examcode')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = vendor_slug+shortname_slug;
						}
						else
						{
							alert('Please enter Exam Code to include in Slug!');
							full_slug = vendor_slug;
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val == '' && !(nameOptionsSlug) && name_slug != '')
				{
					name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = name_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val == '' && !(nameOptionsSlug) && name_slug == '' && shortname_slug != '')
				{
					shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = shortname_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val != '' && !(nameOptionsSlug))
				{
					var vendor_slug = vendor_txt.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					vendor_slug = vendor_slug+'-';
					if(name_slug)
					{
						name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
						full_slug = vendor_slug+name_slug;
					}
					else
					{
						full_slug = vendor_slug;
					}
					$("#cert_slug").val(full_slug);
				}
				else if(!(vendor_val) && nameOptionsSlug)
				{
					alert('Please select Vendor First!');
					$("#vendorIncludeSlug").removeAttr('checked');
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = name_slug;
						}
						else
						{
							alert('Please enter Exam Name to include in Slug!');
							full_slug = '';
						}
						
					}
					if(nameOptionsSlug == 'examcode')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = shortname_slug;
						}
						else
						{
							alert('Please enter Exam Code to include in Slug!');
							full_slug = '';
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else
				{
					alert('Please select Vendor First!');
					if(shortname_slug)
					{
						shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
						full_slug = shortname_slug;
					}
					$("#cert_slug").val(full_slug);
					$("#vendorIncludeSlug").removeAttr('checked');
				}
				
			}
			else
			{
				if(nameOptionsSlug)
				{
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = name_slug;
						}
						else
						{
							alert('Please enter Exam Name to include in Slug!');
							full_slug = '';
						}
						
					}
					if(nameOptionsSlug == 'examcode')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = shortname_slug;
						}
						else
						{
							alert('Please enter Exam Code to include in Slug!');
							full_slug = '';
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else if(!(nameOptionsSlug) && name_slug != '')
				{
					name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = name_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(!(nameOptionsSlug) && name_slug == '' && shortname_slug != '')
				{
					shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = shortname_slug;
					$("#cert_slug").val(full_slug);
				}
				else
				{
					$("#cert_slug").val('');
				}
			}
	});
	
	$("input[name=nameIncludeSlug]").change(function() {
		var vendor_txt = $("#vendor_id option:selected").text();
		var vendor_val = $("#vendor_id option:selected").val();
		var nameOptionsSlug = $('input[name=nameIncludeSlug]:checked').val();
		var name_slug = $("#name").val();
		var full_slug = '';
		var shortname_slug = $("#cert_shortname").val();
		shortname_slug = shortname_slug.replace('/', "-");
		name_slug = name_slug.replace('/', "-");
		vendor_txt = vendor_txt.replace('/', "-");
		if($("#vendorIncludeCertSlug").is(":checked")) {
				if(vendor_val && nameOptionsSlug)
				{
					var vendor_slug = vendor_txt.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					vendor_slug = vendor_slug+'-';
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = vendor_slug+name_slug;
						}
						else
						{
							alert('Please enter Certification Title to include in Slug!');
							full_slug = vendor_slug;
						}
						
					}
					if(nameOptionsSlug == 'shortname')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = vendor_slug+shortname_slug;
						}
						else
						{
							alert('Please enter Certification Shortname to include in Slug!');
							full_slug = vendor_slug;
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val == '' && !(nameOptionsSlug) && name_slug != '')
				{
					name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = name_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val == '' && !(nameOptionsSlug) && name_slug == '' && shortname_slug != '')
				{
					shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = shortname_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val != '' && !(nameOptionsSlug))
				{
					var vendor_slug = vendor_txt.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					vendor_slug = vendor_slug+'-';
					if(name_slug)
					{
						name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
						full_slug = vendor_slug+name_slug;
					}
					else
					{
						full_slug = vendor_slug;
					}
					$("#cert_slug").val(full_slug);
				}
				else if(vendor_val == '' && nameOptionsSlug)
				{
					alert('Please select Vendor First!');
					$("#vendorIncludeCertSlug").removeAttr('checked');
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = name_slug;
						}
						else
						{
							alert('Please enter Certification Title to include in Slug!');
							full_slug = '';
						}
						
					}
					if(nameOptionsSlug == 'shortname')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = shortname_slug;
						}
						else
						{
							alert('Please enter Certification Shortname to include in Slug!');
							full_slug = '';
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else
				{
					alert('Please select Vendor First!');
					$("#vendorIncludeCertSlug").removeAttr('checked');
				}
				
			}
			else
			{
				if(nameOptionsSlug)
				{
					if(nameOptionsSlug == 'name')
					{
						if(name_slug)
						{
							name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = name_slug;
						}
						else
						{
							alert('Please enter Certification Title to include in Slug!');
							full_slug = '';
						}
						
					}
					if(nameOptionsSlug == 'shortname')
					{
						if(shortname_slug)
						{
							shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
							full_slug = shortname_slug;
						}
						else
						{
							alert('Please enter Certification Shortname to include in Slug!');
							full_slug = '';
						}
					}
					$("#cert_slug").val(full_slug);
				}
				else if(!(nameOptionsSlug) && name_slug != '')
				{
					name_slug = name_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = name_slug;
					$("#cert_slug").val(full_slug);
				}
				else if(!(nameOptionsSlug) && name_slug == '' && shortname_slug != '')
				{
					shortname_slug = shortname_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
					full_slug = shortname_slug;
					$("#cert_slug").val(full_slug);
				}
				else
				{
					$("#cert_slug").val('');
				}
			}
	});
	
	$("#is_replacement").change(function() {
		var replacement_relation = $('#replacement_relation').val();
		if($(this).is(":checked") && replacement_relation == '') {
			$('.hideForReplacement').attr('disabled','disabled');
		}
		else
		{
			$('.hideForReplacement').removeAttr('disabled','disabled');
		}
	});	
})

function generateVendorSlug(value) {
    var full_slug = value.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
	full_slug = full_slug.replace('/', "-");
	$("#slug").val(full_slug);
}

function generateExamSlug(value) {
    var full_slug = value.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
	if($("#vendorIncludeSlug").is(":checked")) {
			var vendor_txt = $("#vendor_id option:selected").text();
			var vendor_slug = vendor_txt.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
			full_slug = vendor_slug+'-'+full_slug;
			full_slug = full_slug.replace('/', "-");
			$("#cert_slug").val(full_slug);
		}
		else
		{
			full_slug = full_slug.replace('/', "-");
			$("#cert_slug").val(full_slug);
		}
}

function generateWidgetSlug(value) {
    var full_slug = value.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
	$("#widget_id").val(full_slug);
}



function generateCertificationSlug(value) {
    var full_slug = value.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
	if($("#vendorIncludeCertSlug").is(":checked")) {
		var vendor_txt = $("#vendor_id option:selected").text();
		var vendor_slug = vendor_txt.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
		full_slug = vendor_slug+'-'+full_slug;
		full_slug = full_slug.replace('/', "-");
		$("#cert_slug").val(full_slug);
	}
	else
	{
		full_slug = full_slug.replace('/', "-");
		$("#cert_slug").val(full_slug);
	}
}




	function btnExamSubmitOptions()
	{
		var restoreTxt = getOldHtml('examsInfMsg');
		var data = $('.mfp-content #examData_form').serialize();
		var URL = BASE_URL + 'admin/exams/ajaxSave';
		$.ajax({
			type: 'POST',
			url: URL,
			data: data,
			dataType: 'json',
			beforeSend: function () {
				toggleDisable('btnExamSubmitOptions', true);
				$('#btnExamSubmitOptions').before(function () {
					return getLoadingImg();
				});
			},
			success: function (response) {
				if (response.msgStatus == 'Error') { //if failed
					displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
				} else if (response.msgStatus == 'Success') { //if failed
					displayMessage('examsInfMsg', 'success', response.msgText, restoreTxt);
					redirectPage(BASE_URL + 'admin/exams');
				}
				toggleDisable('btnExamSubmitOptions', false);
			},
			error: function () {
				alert('something went wrong please try again');
				toggleDisable('btnExamSubmitOptions', false);
			}
		});
	}
	
	function ajaxLoadCertificationDetail(cid)
	{
		if(cid)
		{
			var URL = BASE_URL + 'admin/certifications/certDetail';
			var data = {'cid':cid};
			$.ajax({
				type: 'POST',
				url: URL,
				data: data,
				dataType: 'json',
				beforeSend: function () {
					$('#old_replacement_cert').after(function () {
						return getLoadingImg();
					});
					
				},
				success: function (response) {
					console.log(response);
					var OldReplacement = $("#old_replacement_cert option:selected").text();
					var html = '';
					html += '<p>By adding this Certification as a replacement of <strong>'+OldReplacement+'</strong> all following things will be automaticaly apply to this certification.</p>';
					html += '<table>';
					if(response.parent_cert){ var parent_cert = response.parent_cert;} else { var parent_cert = 'None'; }
					var child_cert_html = '';
						if(response.child_cert){ 
							var child_cert = response.child_cert;
							$.each(child_cert, function( index, value ) {
								child_cert_html += value+'<br/>';
							});
						} else { 
								child_cert_html = 'None'; 
						}
						html += '<tr><td><strong>Parent Certification</strong></td><td>'+parent_cert+'</td></tr>';
						html += '<tr><td><strong>Child Certification(s)</strong></td><td>'+child_cert_html+'</td></tr>';
						var prerequisit_cert_html = '';
						if(response.prerequisit_cert){ 
							var prerequisit_cert = response.prerequisit_cert;
							var require_certifications = prerequisit_cert.require_certifications;
							var require_exams = prerequisit_cert.require_exams;
							if(require_certifications)
							{
								prerequisit_cert_html += '<strong>Require Certifications</strong><br/>';
								$.each(require_certifications, function( index, value ) {
									prerequisit_cert_html += value+'<br/>';
								});
							}
							if(require_exams)
							{
								prerequisit_cert_html += '<strong>Require Exams</strong><br/>';
								$.each(require_exams, function( index, value ) {
									prerequisit_cert_html += value+'<br/>';
								});
							}
							html += '<tr><td colspan="2"><p>Following will be Prerequists for this Certification:</p></td></tr>';
							html += '<tr><td><strong>Prerequisits</strong></td><td>'+prerequisit_cert_html+'</td></tr>';
						}
						var prerequisit_of_cert_html = '';
						if(response.prerequisit_of_cert){ 
							var prerequisit_of_cert = response.prerequisit_of_cert;
							var certifications = prerequisit_of_cert.certifications;
							var exams = prerequisit_of_cert.exams;
							if(certifications)
							{
								prerequisit_of_cert_html += '<strong>Certifications</strong><br/>';
								$.each(certifications, function( index, value ) {
									prerequisit_of_cert_html += value+'<br/>';
								});
							}
							if(exams)
							{
								prerequisit_of_cert_html += '<strong>Exams</strong><br/>';
								$.each(exams, function( index, value ) {
									prerequisit_of_cert_html += value+'<br/>';
								});
							}
							html += '<tr><td colspan="2"><p>This Certification will be Prerequisit for following:</p></td></tr>';
							html += '<tr><td><strong>Prerequisit For</strong></td><td>'+prerequisit_of_cert_html+'</td></tr>';
						}
						
						
						
					html += '</table>';
					
					$('#replacementInfo').html(html);
					$('#imgLoader').remove();
				},
				error: function () {
					alert('something went wrong please try again');
					$('#imgLoader').remove();
				}
			});
		}
		else
		{
			$('#replacementInfo').html('');
		}
	}
	
	
		function ajaxLoadExamDetail(eid)
	{
		if(eid)
		{
			var URL = BASE_URL + 'admin/exams/examDetail';
			var data = {'eid':eid};
			$.ajax({
				type: 'POST',
				url: URL,
				data: data,
				dataType: 'json',
				beforeSend: function () {
					$('#old_replacement_cert').after(function () {
						return getLoadingImg();
					});
					
				},
				success: function (response) {
					console.log(response);
					var OldReplacement = $("#old_replacement_cert option:selected").text();
					var html = '';
					html += '<p>By adding this Exam as a replacement of <strong>'+OldReplacement+'</strong> all following things will be automaticaly apply to this Exam.</p>';
					html += '<table>';
					if(response.certs){ var certs = response.certs;} else { var certs = 'None'; }
						html += '<tr><td><strong>Exam Certification(s)</strong></td><td>'+certs+'</td></tr>';
						var prerequisit_cert_html = '';
						if(response.prerequisit_exam){ 
							var prerequisit_exam = response.prerequisit_exam;
							var require_certifications = prerequisit_exam.require_certifications;
							var require_exams = prerequisit_exam.require_exams;
							if(require_certifications)
							{
								prerequisit_cert_html += '<strong>Require Certifications</strong><br/>';
								$.each(require_certifications, function( index, value ) {
									prerequisit_cert_html += value+'<br/>';
								});
							}
							if(require_exams)
							{
								prerequisit_cert_html += '<strong>Require Exams</strong><br/>';
								$.each(require_exams, function( index, value ) {
									prerequisit_cert_html += value+'<br/>';
								});
							}
							html += '<tr><td colspan="2"><p>Following will be Prerequists for this Exam:</p></td></tr>';
							html += '<tr><td><strong>Prerequisits</strong></td><td>'+prerequisit_cert_html+'</td></tr>';
						}
						var prerequisit_of_cert_html = '';
						if(response.prerequisit_of_exam){ 
							var prerequisit_of_exam = response.prerequisit_of_exam;
							var certifications = prerequisit_of_exam.certifications;
							var exams = prerequisit_of_exam.exams;
							if(certifications)
							{
								prerequisit_of_cert_html += '<strong>Certifications</strong><br/>';
								$.each(certifications, function( index, value ) {
									prerequisit_of_cert_html += value+'<br/>';
								});
							}
							if(exams)
							{
								prerequisit_of_cert_html += '<strong>Exams</strong><br/>';
								$.each(exams, function( index, value ) {
									prerequisit_of_cert_html += value+'<br/>';
								});
							}
							html += '<tr><td colspan="2"><p>This Exam will be Prerequisit for following:</p></td></tr>';
							html += '<tr><td><strong>Prerequisit For</strong></td><td>'+prerequisit_of_cert_html+'</td></tr>';
						}
						
						
						
					html += '</table>';
					
					$('#replacementInfo').html(html);
					$('#imgLoader').remove();
				},
				error: function () {
					alert('something went wrong please try again');
					$('#imgLoader').remove();
				}
			});
		}
		else
		{
			$('#replacementInfo').html('');
		}
	}
	
	
/**General functions**/
function displayMessage(containerId, msgClass, msgText, restoreTxt) {
    var msg = '<div class="alert alert-' + msgClass + '">' + msgText + '</div>';
    $('#' + containerId).html('').html(msg).show('slow');
    setTimeout(function () {
        $('#' + containerId).html('').html(restoreTxt).show('slow'); //restore default message
    }, 2000);
}

function getOldHtml(containerId) {
    var html = $('#' + containerId).html();
    return html;
}

function restoreMsg(containerId, msg) {
    $('#' + containerId).html('').html(msg);
}
/***/
function toggleDisable(elementId, val) {
    $('#' + elementId).prop('disabled', val);
}

function redirectPage(url) {
    setTimeout(function () {
        window.location.href = url;
    }, 2000);
}
/**
 * Method: goToURL
 * Params: url
 * Retrun: 
 */
function goToURL(url) {
    window.location.href = url;
}

/**
 @Method: removeRow
 @Param: rowId
 */

function removeRow(rowId) {
    $('#' + rowId).remove();
}

/**
 @Method: deleteListItem
 @Param: controller, itemId
 @Return: boolean (True,false)
 */
 
 function deleteListItemwithAction(controller, itemId, type, action) {
    var restoreTxt = '';
    var ans = confirm('Are you sure! You want to delete.');
    if (ans) {
        if (itemId > 0) {
            var URL = BASE_URL + 'admin/' + controller + '/'+action+'/' + itemId;
            //Start AJax Call
            $.ajax({
                type: "POST",
                url: URL,
                dataType: "json",
                success: function (response) {
					if(type == 'group_coupons')
					{
						var rowId = controller + '_' + itemId;
					}
					else
					{
						var rowId = type + '_' + itemId;
					}
                    
                    
					if (response.msgStatus == 'Error') { //if failed				
                        displayMessage('listingPageMsg', 'danger', response.msgText, restoreTxt);
                    } else if (response.msgStatus == 'Success') { //if failed
                        displayMessage('listingPageMsg', 'success', response.msgText, restoreTxt);
                        removeRow(rowId);
						if(type == 'tech')
						{
							type = 'technologies';
						}
						if(type == 'format')
						{
							type = 'product_formats';
						}
                        redirectPage(BASE_URL + 'admin/' +controller+'/'+type);
                    }
                },
                error: function () {
                    alert('something went wrong please try again');
                }
            });
        }
    }
}



function deleteListItem(controller, itemId) {
    var restoreTxt = '';
    var ans = confirm('Are you sure! You want to delete.');
    if (ans) {
        if (itemId > 0) {
            var URL = BASE_URL + 'admin/' + controller + '/delete/' + itemId;
            //Start AJax Call
            $.ajax({
                type: "POST",
                url: URL,
                dataType: "json",
                success: function (response) {
                    var rowId = controller + '_' + itemId;
                    if (response.msgStatus == 'Error') { //if failed				
                        displayMessage('listingPageMsg', 'danger', response.msgText, restoreTxt);
                    } else if (response.msgStatus == 'Success') { //if failed
                        displayMessage('listingPageMsg', 'success', response.msgText, restoreTxt);
                        removeRow(rowId);
                        redirectPage(BASE_URL + 'admin/' + controller);
                    }
                },
                error: function () {
                    alert('something went wrong please try again');
                }
            });
        }
    }
}

function deleteListItemRep(controller, itemId, rep_from, rep_to) {
    var restoreTxt = '';
    var ans = confirm('Are you sure! You want to delete this replacement.');
    if (ans) {
        if (itemId > 0) {
			var data = {'rep_from':rep_from,'rep_to':rep_to}
            var URL = BASE_URL + 'admin/' + controller + '/delete_replacement/';
            //Start AJax Call
            $.ajax({
                type: "POST",
                url: URL,
				data:data,
                dataType: "json",
				beforeSend: function () {
					$('#replacement_' + itemId+' td a.btn-danger').after(function () {
						return getLoadingImg();
					});
					
				},
                success: function (response) {
                    var rowId = 'replacement_' + itemId;
                    if (response.msgStatus == 'Error') { //if failed				
                        displayMessage('listingPageMsg', 'danger', response.msgText, restoreTxt);
                    } else if (response.msgStatus == 'Success') { //if failed
                       //displayMessage('listingPageMsg', 'success', response.msgText, restoreTxt);
                        removeRow(rowId);
                        redirectPage(BASE_URL + 'admin/' + controller+'/replacements');
                    }
                },
                error: function () {
                    alert('something went wrong please try again');
                }
            });
        }
    }
}

function getLoadingImg() {
    var imgURL = BASE_URL + 'assets/admin/images/loading.gif';
    var img = '<span id="imgLoader" style="display:block; float:left;"><img src="' + imgURL + '" /></span>';
    return img;
}

function validateEmail(elementValue) {
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(elementValue);
}//End validateEmail

function updateFieldAttrib(rowId, tbl, field, whereCol, whereVal) {
    var oldState = $.trim($('#' + rowId).html());

    if (oldState == 'No') {
        var curState = 'Yes';
        var curCls = 'success';

    } else if (oldState == 'Yes') {
        var curState = 'No';
        var curCls = 'danger';
    } else if (oldState == 'Inactive') {
        var curState = 'Active';
        var curCls = 'success';

    } else if (oldState == 'Active') {
        var curState = 'Inactive';
        var curCls = 'danger';
    }

    var URL = BASE_URL + 'admin/attributes/updateBoolean';
    $.ajax({
        type: 'POST',
        url: URL,
        data: {tab: tbl, fld: field, wc: whereCol, wv: whereVal},
        dataType: 'json',
        beforeSend: function () {},
        success: function (response) {
            if (response.msgStatus == 'Success') { //if failed
                $('#' + rowId).removeClass("label label-success label-danger").addClass('label label-' + curCls);
                $('#' + rowId).html('').html(curState);
            }
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}


function updateField(rowId, tbl, field, whereCol, whereVal) {
    var oldState = $.trim($('#' + rowId).html());
	
	if(field == 'status')
	{
		var attr = $('#' + rowId).attr('replacement'); 
		if (typeof attr !== 'undefined' && attr !== false && attr != '') { 
			alert('This item is inactive because of Replacement please remove replacement relationship in order to activate this!');
			return false;
		}
	}

    if (oldState == 'No') {
        var curState = 'Yes';
        var curCls = 'success';

    } else if (oldState == 'Yes') {
        var curState = 'No';
        var curCls = 'danger';
    } else if (oldState == 'Inactive') {
        var curState = 'Active';
        var curCls = 'success';

    } else if (oldState == 'Active') {
        var curState = 'Inactive';
        var curCls = 'danger';
    }
	
	if(field == 'expired')
	{
		if (oldState == 'No') {
			var curState = 'Yes';
			var curCls = 'danger';

		} else if (oldState == 'Yes') {
			var curState = 'No';
			var curCls = 'success';
		}	
	}

    var URL = BASE_URL + 'admin/vendors/updateBoolean';
    $.ajax({
        type: 'POST',
        url: URL,
        data: {tab: tbl, fld: field, wc: whereCol, wv: whereVal},
        dataType: 'json',
        beforeSend: function () {},
        success: function (response) {
            if (response.msgStatus == 'Success') { //if failed
                $('#' + rowId).removeClass("label label-success label-danger").addClass('label label-' + curCls);
                $('#' + rowId).html('').html(curState);
            }
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}

function updateBundleCouponsExpiry(rowId, tbl, field, whereCol, whereVal) {
    var oldState = $.trim($('#' + rowId).html());
	
	if(field == 'status')
	{
		var attr = $('#' + rowId).attr('replacement'); 
		if (typeof attr !== 'undefined' && attr !== false && attr != '') { 
			alert('This item is inactive because of Replacement please remove replacement relationship in order to activate this!');
			return false;
		}
	}
	
	if(field == 'expired')
	{
		if (oldState == 'No') {
			var curState = 'Yes';
			var curCls = 'danger';

		} else if (oldState == 'Yes') {
			var curState = 'No';
			var curCls = 'success';
		}	
	}

    var URL = BASE_URL + 'admin/coupons/updateBundleExpiryOptions';
    $.ajax({
        type: 'POST',
        url: URL,
        data: {tab: tbl, fld: field, wc: whereCol, wv: whereVal},
        dataType: 'json',
        beforeSend: function () {},
        success: function (response) {
            if (response.msgStatus == 'Success') { //if failed
                $('#' + rowId).removeClass("label label-success label-danger").addClass('label label-' + curCls);
                $('#' + rowId).html('').html(curState);
            }
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}

function submitForm(url) {
    document.listing_form.action = url;
    document.listing_form.submit();
}

function submitOrderForm(id)
{
	$('#'+id).submit();
}
/**End General functions**/


function validateLogin() {
    var restoreTxt = getOldHtml('loginMsg');
    var emailaddress = $.trim($('#txt_email').val());
    var password = $.trim($('#txt_password').val());
    var msg = '';
    if (emailaddress == '') {
        msg = 'Please enter email.';
        displayMessage('loginMsg', 'danger', msg, restoreTxt);
        return false;
    }

    if (validateEmail(emailaddress) == false) {
        msg = 'Please enter valid email address.';
        displayMessage('loginMsg', 'danger', msg, restoreTxt);
        return false;
    }

    if (password == '') {
        msg = 'Please enter password.';
        displayMessage('loginMsg', 'danger', msg, restoreTxt);
        return false;
    }
    var URL = BASE_URL + 'index.php/admin/login/ajaxLogin';
    $.ajax({
        type: 'POST',
        url: URL,
        data: {name: emailaddress, pwd: password},
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btn_login', true);
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed				
                displayMessage('loginMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('loginMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin');
            }
            toggleDisable('btn_login', false);
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}

/*validate admin account*/
function updateAdminAccountInfo() {
    var restoreTxt = getOldHtml('accountInfMsg');
    var fullname = $.trim($("#full_name").val());

    if (fullname == '') {
        msg = 'Fullname is required.';
        displayMessage('accountInfMsg', 'danger', msg, restoreTxt);
        return false;
    }
    var URL = BASE_URL + 'admin/account/update_info';
    $.ajax({
        type: 'POST',
        url: URL,
        data: {name: fullname},
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnAccountInfo', true);
            $('#btnAccountInfo').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('accountInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('accountInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/account');
            }

            toggleDisable('btnAccountInfo', false);
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}

function validateTags(formId) {
    var restoreTxt = getOldHtml('certificationsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/tags_scripts/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnAttributeSubmit', true);
            $('#btnAttributeSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('certificationsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('certificationsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/tags_scripts');
            }
            toggleDisable('btnAttributeSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnAttributeSubmit', false);
        }
    });
}

function changeAdminPassword() {
    var restoreTxt = getOldHtml('pwdInfMsg');
    //var oldpassword = $.trim($("#oldpassword").val());
    var newpassword = $.trim($("#newpassword").val());
    var confirmpassword = $.trim($("#confirmpassword").val());

    /*if (oldpassword==''){
     msg = 'Old password is required.';
     displayMessage('pwdInfMsg','danger',msg,restoreTxt);
     return false;
     }*/

    if (newpassword == '') {
        msg = 'New password is required.';
        displayMessage('pwdInfMsg', 'danger', msg, restoreTxt);
        return false;
    }

    if (confirmpassword == '') {
        msg = 'Confirm password is required.';
        displayMessage('pwdInfMsg', 'danger', msg, restoreTxt);
        return false;
    }

    if (newpassword != confirmpassword) {
        msg = 'Confirm password is not matched.';
        displayMessage('pwdInfMsg', 'danger', msg, restoreTxt);
        return false;
    }

    var URL = BASE_URL + 'index.php/admin/account/change_password';
    $.ajax({
        type: 'POST',
        url: URL,
        data: {newpwd: newpassword},
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnAccountInfo', true);
            $('#btnAccountInfo').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('pwdInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('pwdInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/account');
            }

            toggleDisable('btnAccountInfo', false);
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}

function changeUsersPassword() {
    var restoreTxt = getOldHtml('pwdInfMsg');
    //var oldpassword = $.trim($("#oldpassword").val());
    var newpassword = $.trim($("#newpassword").val());
    var confirmpassword = $.trim($("#confirmpassword").val());
	var user_id = $("#user_id").val();
    /*if (oldpassword==''){
     msg = 'Old password is required.';
     displayMessage('pwdInfMsg','danger',msg,restoreTxt);
     return false;
     }*/

    if (newpassword == '') {
        msg = 'New password is required.';
        displayMessage('pwdInfMsg', 'danger', msg, restoreTxt);
        return false;
    }

    if (confirmpassword == '') {
        msg = 'Confirm password is required.';
        displayMessage('pwdInfMsg', 'danger', msg, restoreTxt);
        return false;
    }

    if (newpassword != confirmpassword) {
        msg = 'Confirm password is not matched.';
        displayMessage('pwdInfMsg', 'danger', msg, restoreTxt);
        return false;
    }

    var URL = BASE_URL + 'index.php/admin/users/change_password';
    $.ajax({
        type: 'POST',
        url: URL,
        data: {newpwd: newpassword,'user_id': user_id},
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnChangePwd', true);
            $('#btnChangePwd').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('pwdInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('pwdInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/users');
            }

            toggleDisable('btnChangePwd', false);
        },
        error: function () {
            alert('something went wrong please try again');
        }
    });
}

/**validate vendor**/
function validateVendor(formId) {

    var restoreTxt = getOldHtml('vendorsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/vendors/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnVendorSubmit', true);
            $('#btnVendorSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('vendorsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('vendorsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/vendors');
            }
            toggleDisable('btnVendorSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnVendorSubmit', false);
        }
    });
}


/**validate Certification**/
function validateCertification(formId) {
	
	var slug = $('#cert_slug').val();
	var old_slug = $('#old_slug').val();
	if(slug != old_slug)
	{
		$.confirm({
			title: 'Slug Update!',
			content: 'Slug has been updated due to your changes at this page. either you want to update slug or not?',
			closeIcon: true,
			buttons: {
				updateslug: {
					text: 'Update Slug',
					btnClass: 'btn-red',
					action: function(){
						$('#old_slug').val(slug);
						validateCertification('certificationData_form');
					}
				},
				keep: {
					text: 'Keep Old Slug',
					btnClass: 'btn-blue',
					action: function(){
						$('#cert_slug').val(old_slug);
						validateCertification('certificationData_form');
					}
				},
			}
		});
		return false;
	}
	
	
	var check_shortname = $('#check_shortname').val();
	var check_name = $('#check_name').val();
	if(check_shortname == '1' || check_name == '1')
	{
		return false;
	}
	
	if($("#is_replacement").is(":checked")) {
		var sel_val = $('#old_replacement_cert').val();
		if(sel_val == '')
		{
			alert('If this Certification is Replacement of any old then please Select that one');
			$('#old_replacement_cert').css('border','1px solid #cc3f44');
			return false;
		}
		else
		{
			$('#old_replacement_cert').css('border','1px solid #e4e4e4');
		}
	}
	else
	{
		$('#old_replacement_cert').css('border','1px solid #e4e4e4');
	}
    var restoreTxt = getOldHtml('certificationsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/certifications/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnCertificationSubmit', true);
            $('#btnCertificationSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('certificationsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('certificationsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/certifications');
            }
            toggleDisable('btnCertificationSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnCertificationSubmit', false);
        }
    });
}

/**validate Level**/
function validateLevel(formId) {
	var check_name = $('#check_name').val();
	if(check_name == '1')
	{
		return false;
	}
    var restoreTxt = getOldHtml('examsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/attributes/ajaxSaveLevel';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnAttributeSubmit', true);
            $('#btnAttributeSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
			console.log(response);
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('examsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/attributes/level');
            }
            toggleDisable('btnAttributeSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnAttributeSubmit', false);
        }
    });
}

/**validate Audience**/
function validateAudience(formId) {
	var check_name = $('#check_name').val();
	if(check_name == '1')
	{
		return false;
	}
    var restoreTxt = getOldHtml('examsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/attributes/ajaxSaveAudience';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnAttributeSubmit', true);
            $('#btnAttributeSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
			console.log(response);
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('examsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/attributes/audience');
            }
            toggleDisable('btnAttributeSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnAttributeSubmit', false);
        }
    });
}

/**validate Tech**/
function validateTech(formId) {
	var check_name = $('#check_name').val();
	if(check_name == '1')
	{
		return false;
	}
    var restoreTxt = getOldHtml('examsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/attributes/ajaxSaveTech';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnAttributeSubmit', true);
            $('#btnAttributeSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
			console.log(response);
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('examsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/attributes/technologies');
            }
            toggleDisable('btnAttributeSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnAttributeSubmit', false);
        }
    });
}

/**validate Tech**/
function validateFormat(formId) {
	var check_productformat = $('#check_productformat').val();
	if(check_productformat == '1')
	{
		return false;
	}
	
    var restoreTxt = getOldHtml('examsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/attributes/ajaxSaveFormat';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnAttributeSubmit', true);
            $('#btnAttributeSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
			console.log(response);
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('examsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/attributes/product_formats');
            }
            toggleDisable('btnAttributeSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnAttributeSubmit', false);
        }
    });
}


/**validate Tech**/
function validateEmails(formId) {
	
    var restoreTxt = getOldHtml('examsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/emails/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnCouponSubmit', true);
            $('#btnCouponSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
			console.log(response);
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('examsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/emails/');
            }
            toggleDisable('btnCouponSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnCouponSubmit', false);
        }
    });
}


/**validate Email Settings**/
function validateEmailSettings(formId) {
	
    var restoreTxt = getOldHtml('examsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/emails/ajaxSaveSettings';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnCouponSubmit', true);
            $('#btnCouponSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
			console.log(response);
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('examsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/emails/settings');
            }
            toggleDisable('btnCouponSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnCouponSubmit', false);
        }
    });
}

/**validate Email Settings**/
function validateEmailType(formId) {
	//return false;
    var restoreTxt = getOldHtml('examsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/emails/ajaxSaveEmailType';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnAttributeSubmit', true);
            $('#btnAttributeSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
			console.log(response);
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('examsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/emails/email_types');
            }
            toggleDisable('btnAttributeSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnAttributeSubmit', false);
        }
    });
}




/**validate Exam**/
function validateExam(formId) {
	
	var slug = $('#cert_slug').val();
	var old_slug = $('#old_slug').val();
	if(slug != old_slug)
	{
		$.confirm({
			title: 'Slug Update!',
			content: 'Slug has been updated due to your changes at this page. either you want to update slug or not?',
			closeIcon: true,
			buttons: {
				updateslug: {
					text: 'Update Slug',
					btnClass: 'btn-red',
					action: function(){
						$('#old_slug').val(slug);
						validateExam('examData_form');
					}
				},
				keep: {
					text: 'Keep Old Slug',
					btnClass: 'btn-blue',
					action: function(){
						$('#cert_slug').val(old_slug);
						validateExam('examData_form');
					}
				},
			}
		});
		return false;
	}
	
	
	
	
	var check_examcode = $('#check_examcode').val();
	var check_name = $('#check_name').val();
	if(check_examcode == '1' || check_name == '1')
	{
		return false;
	}
	
	if($("#is_replacement").is(":checked")) {
		var sel_val = $('#old_replacement_cert').val();
		if(sel_val == '')
		{
			alert('If this Exam is Replacement of any old then please Select that one');
			$('#old_replacement_cert').css('border','1px solid #cc3f44');
			$("html, body").animate({ scrollTop: 0 }, "slow");
			return false;
		}
		else
		{
			$('#old_replacement_cert').css('border','1px solid #e4e4e4');
		}
	}
	else
	{
		$('#old_replacement_cert').css('border','1px solid #e4e4e4');
		if ($("#examData_form #examsCertsContainer input:checkbox:checked").length > 0)
		{
			$('#certification_id-error').remove();
			$('#examsCertsContainer').removeClass('error');
			$('#examsCertsContainer').css('border','none');
		}
		else
		{
		  if(!($('#examsCertsContainer').hasClass('error')))
		  {
			var errorHtml = '<span id="certification_id-error" class="validate-has-error1">Please choose at least one Exam Certification.</span>';
			$('#examsCertsContainer').after(errorHtml);
			$('#examsCertsContainer').addClass('error');
		  }
		  $("html, body").animate({ scrollTop: 0 }, "slow");
		  $('#examsCertsContainer').css('border','1px solid #cc3f44');
		  return false;
		}
	}
	
	
    var restoreTxt = getOldHtml('examsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/exams/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnExamSubmit', true);
            $('#btnExamSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('examsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/exams');
            }
            toggleDisable('btnExamSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnExamSubmit', false);
        }
    });
}

/**validate Page**/
function validatePage(formId) {
	
	var same_page = $('#same_page').val();
	if(same_page == 1)
	{
		$('#pageAlreadyExistMsg').show();
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	}
	
    var restoreTxt = getOldHtml('pagesInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/pages/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnPageSubmit', true);
            $('#btnPageSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('pagesInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('pagesInfMsg', 'success', response.msgText, restoreTxt);
				//redirectPage(BASE_URL + 'admin/pages');
				location.reload();
            }
            toggleDisable('btnPageSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnPageSubmit', false);
        }
    });
}

function validateAdminUser(formId) {
	
	var check_email = $('#check_email').val();
	if(check_email == '1')
	{
		return false;
	}
	
    var restoreTxt = getOldHtml('pagesInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/users/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnAdminSubmit', true);
            $('#btnAdminSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('pagesInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('pagesInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/users');
            }
            toggleDisable('btnAdminSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnAdminSubmit', false);
        }
    });
}

/**validate Coupon**/
function validateCoupon(formId) {
    var restoreTxt = getOldHtml('couponsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/coupons/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnCouponSubmit', true);
            $('#btnCouponSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('couponsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('couponsInfMsg', 'success', response.msgText, restoreTxt);
				if(response.coupon_type == 'bundle')
				{
					redirectPage(BASE_URL + 'admin/coupons/group_coupons');
				}
				else
				{
					redirectPage(BASE_URL + 'admin/coupons');
				}
                
            }
            toggleDisable('btnCouponSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnCouponSubmit', false);
        }
    });
}

 /**validate Currency**/
function validateCurrency(formId) {
    var restoreTxt = getOldHtml('currenciesInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/currencies/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnCurrencySubmit', true);
            $('#btnCurrencySubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('currenciesInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('currenciesInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/currencies');
            }
            toggleDisable('btnCurrencySubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnCurrencySubmit', false);
        }
    });
}

/**validate Customer**/
function validateCustomer(formId) {
    var restoreTxt = getOldHtml('customersInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/customers/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnCustomerSubmit', true);
            $('#btnCustomerSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('customersInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('customersInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/customers');
            }
            toggleDisable('btnCustomerSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnCustomerSubmit', false);
        }
    });
}

/**validate User**/
function validateUser(formId) {
    var restoreTxt = getOldHtml('usersInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/users/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnUserSubmit', true);
            $('#btnUserSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('usersInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('usersInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/users');
            }
            toggleDisable('btnUserSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnUserSubmit', false);
        }
    });
}

function validateKeysOrder(formId) {
    var restoreTxt = getOldHtml('usersInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/orders/saveKeysOrder';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnManualOrderSubmit', true);
            $('#btnManualOrderSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('usersInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('usersInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/orders');
            }
            toggleDisable('btnManualOrderSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnManualOrderSubmit', false);
        }
    });
}


/**validate Prodcut_type**/
function validateProduct_type(formId) {
    var restoreTxt = getOldHtml('product_typesInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/product_types/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnProduct_typeSubmit', true);
            $('#btnProduct_typeSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('product_typesInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('product_typesInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/product_types');
            }
            toggleDisable('btnProduct_typeSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnProduct_typeSubmit', false);
        }
    });
}


/**validate Product**/
function validateProductPrice(formId) {
    var restoreTxt = getOldHtml('productsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/prices/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnProductSubmit', true);
            $('#btnProductSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('productsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('productsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/prices');
            }
            toggleDisable('btnProductSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnProductSubmit', false);
        }
    });
}
/**validate Site_setting**/
function validateSite_setting(formId) {
    var restoreTxt = getOldHtml('site_settingsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/site_settings/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnSite_settingSubmit', true);
            $('#btnSite_settingSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('site_settingsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('site_settingsInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/site_settings');
            }
            toggleDisable('btnSite_settingSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnSite_settingSubmit', false);
        }
    });
}

/**validate validateNoFollow**/
function validateNoFollow(formId) {
    var restoreTxt = getOldHtml('noFollowInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/site_settings/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnNoFollowSubmit', true);
            $('#btnNoFollowSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('noFollowInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('noFollowInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/site_settings');
            }
            toggleDisable('btnNoFollowSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnSite_settingSubmit', false);
        }
    });
}

/**validate gv_code**/
function validategv_code(formId) {
    var restoreTxt = getOldHtml('gv_codeInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/site_settings/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btngv_codeSubmit', true);
            $('#btngv_codeSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('gv_codeInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('gv_codeInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/site_settings');
            }
            toggleDisable('btngv_codeSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btngv_codeSubmit', false);
        }
    });
}

/**approveOrder**/
function validategapproveOrder(formId) {
    var restoreTxt = getOldHtml('approveOrderInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/site_settings/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnapproveOrderSubmit', true);
            $('#btnapproveOrderSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('approveOrderInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('approveOrderInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/site_settings');
            }
            toggleDisable('btnapproveOrderSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btngv_codeSubmit', false);
        }
    });
}

/**validategAnalytics**/
function validategAnalytics(formId) {
    var restoreTxt = getOldHtml('gAnalyticsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/site_settings/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btngAnalyticsSubmit', true);
            $('#btngAnalyticsSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('gAnalyticsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('gAnalyticsInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/site_settings');
            }
            toggleDisable('btngAnalyticsSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btngv_codeSubmit', false);
        }
    });
}

/**validate Banner**/
function validateBanner(formId) {
    var restoreTxt = getOldHtml('bannersInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/banners/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnBannerSubmit', true);
            $('#btnBannerSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('bannersInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('bannersInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/banners');
            }
            toggleDisable('btnBannerSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnBannerSubmit', false);
        }
    });
}

 /**validate Redirect**/
function validateRedirect(formId) {
    var restoreTxt = getOldHtml('redirectsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/redirects/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnRedirectSubmit', true);
            $('#btnRedirectSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('redirectsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('redirectsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/redirects');
            }
            toggleDisable('btnRedirectSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnRedirectSubmit', false);
        }
    });
}
/**validate Testimonial**/
function validateTestimonial(formId) {
    var restoreTxt = getOldHtml('testimonialsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/testimonials/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnTestimonialSubmit', true);
            $('#btnTestimonialSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('testimonialsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('testimonialsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/testimonials');
            }
            toggleDisable('btnTestimonialSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnTestimonialSubmit', false);
        }
    });
}

/**validate FAQ**/
function validateFaq(formId) {
    var restoreTxt = getOldHtml('widgetsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/faqs/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnWidgetSubmit', true);
            $('#btnWidgetSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('widgetsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('widgetsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/faqs');
            }
            toggleDisable('btnWidgetSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnWidgetSubmit', false);
        }
    });
}


/**validate Widget**/
function validateWidget(formId) {
    var restoreTxt = getOldHtml('widgetsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/widgets/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnWidgetSubmit', true);
            $('#btnWidgetSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('widgetsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('widgetsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/widgets');
            }
            toggleDisable('btnWidgetSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnWidgetSubmit', false);
        }
    });
}

/**validate content**/
function validateContent(formId) {
    var restoreTxt = getOldHtml('contentsInfMsg');
    var data = $('#' + formId).serialize();
    var type = $('#type').val();
    var URL = BASE_URL + 'admin/contents/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnContentSubmit', true);
            $('#btnContentSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('contentsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('contentsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/contents/tags/' + type);
            }
            toggleDisable('btnContentSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnContentSubmit', false);
        }
    });
}

function validateContent2(formId) {
    var restoreTxt = getOldHtml('contentsInfMsg');
    var data = $('#' + formId).serialize();
    var type = $('#type').val();
    var URL = BASE_URL + 'admin/contents/ajaxSave2';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnContentSubmit2', true);
            $('#btnContentSubmit2').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('contentsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('contentsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/contents/tags/' + type);
            }
            toggleDisable('btnContentSubmit2', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnContentSubmit2', false);
        }
    });
}

/**validate Product_videos**/
function validateProduct_videos(formId) {
    var restoreTxt = getOldHtml('product_videosInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/product_videos/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnProduct_videosSubmit', true);
            $('#btnProduct_videosSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                //displayMessage('product_videosInfMsg','danger',response.msgText,restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                //displayMessage('product_videosInfMsg','success',response.msgText,restoreTxt);
                redirectPage(BASE_URL + 'admin/product_videos');
            }
            toggleDisable('btnProduct_videosSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnProduct_videosSubmit', false);
        }
    });
}

/**Load Exams Certifications Tree**/
function  ajaxLoadCertificationsTree(vid) {
	if($("#is_replacement").is(":checked")) {
		var checked = 1;
	}
	else
	{
		var checked = 0;
	}
    if (vid > 0) {
        var URL = BASE_URL + 'admin/exams/getcerttree';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            beforeSend: function () {
                $('#examsCertsContainer').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
                var html = '';
                //response.cleanWhitespace();
				console.log(response);
                $('#examsCertsContainer').html(response.responseText);
				$("#certTree").treeview({
				 collapsed: false,
				 unique: true,
				 persist: "location"
				});
                //remove loader
                $('#imgLoader').remove();
            },
            error: function (response) {
				console.log(response);
				$('#examsCertsContainer').html(response.responseText);
				$("#certTree").treeview({
				 collapsed: false,
				 unique: true,
				 persist: "location"
				});
				if(checked == 1)
				{
					$('.hideForReplacement').attr('disabled','disabled');
				}
				else
				{
					$('.hideForReplacement').removeAttr('disabled');
				}
                //alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
		ajaxLoadAttributes(vid);
		ajaxLoadCertAudience(vid);
		ajaxLoadCertTechnologies(vid);
		//ajaxLoadExams(vid);
		ajaxLoadExamCertifications(vid);
		ajaxLoadExams2(vid);
		ajaxLoadVendorFormats(vid);
		ajaxLoadVendorNotes(vid);
    } else {
        //remove loader
        $('#imgLoader').remove();
    }
}

/**Load Exam Certifications of vendor**/
function  ajaxLoadExamCertifications(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/certifications/ajaxGetcerts';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            beforeSend: function () {},
            success: function (response) {
				var options = '';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                }
				$('#require_certs').find('option').remove().end().append(options);
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
		var options = '';
		$('#require_certs').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }
}

/**Load Certifications of vendor**/
function  ajaxLoadCertifications(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/certifications/ajaxGetcerts';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            beforeSend: function () {
                $('#certification_id').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
                var options = '<option value="">Select Certification</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                }
				var options2 = '';
                for (var i = 0; i < response.length; i++) {
                    options2 += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                }
                $('#certification_id').find('option').remove().end().append(options);
				$('#require_certs').find('option').remove().end().append(options2);
                //remove loader
                $('#imgLoader').remove();
				$("#productData_form #certification_id").select2({
					placeholder: 'Select Certification',
					allowClear: true
				}).on('select2-open', function()
				{
					// Adding Custom Scrollbar
					$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
				});
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
		ajaxLoadCertificationsforReplacement(vid);
		ajaxLoadAttributes(vid);
		ajaxLoadCertAudience(vid);
		ajaxLoadCertTechnologies(vid);
		ajaxLoadExamCode(vid);
		ajaxLoadVendorFormatsDropdown(vid);
		ajaxLoadVendorNotes(vid);
		//ajaxLoadExams(vid);
    } else {
        var options = '<option value="">Select Certification</option>';
		var options2 = '';
        $('#certification_id').find('option').remove().end().append(options);
		$('#require_certs').find('option').remove().end().append(options2);
        //remove loader
        $('#imgLoader').remove();
    }
}

function  ajaxLoadCertificationsforReplacement(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/certifications/ajaxGetcertsAll';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            beforeSend: function () {
                $('#old_replacement_cert').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
                var options = '<option value="">Select Certification for Replacement</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                }
                $('#old_replacement_cert').find('option').remove().end().append(options);
                //remove loader
                $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
        var options = '<option value="">Select Certification for Replacement</option>';
        $('#old_replacement_cert').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }
}

/**Load Exams of vendor**/
function  ajaxLoadExams(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/certifications/ajaxGetExams';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (response) {
				var options = '';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].exam_code + '</option>';
                }
                $('#require_exams').find('option').remove().end().append(options);
            },
            error: function () {
                alert('something went wrong please try again');
            }
        });
    } else {
		var options = '';
        $('#require_exams').find('option').remove().end().append(options);
    }
}

function  ajaxLoadVendorFormats(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/exams/ajaxGetVendorFormats';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (response) {
				var options = '';
				//console.log(JSON.parse(response));
                for (var i = 0; i < response.length; i++) {
                    options +='<label for="check_format'+response[i].id+'"><input id="check_format'+response[i].id+'" name="exam_format[]" value="'+response[i].id+'" type="checkbox"> '+response[i].name+' </label>';	
                }
                $('.formatChecks').html(options);
            },
            error: function () {
                alert('something went wrong please try again');
            }
        });
    } else {
		var options = '';
        //$('#require_exams').find('option').remove().end().append(options);
    }
}


function  ajaxLoadVendorNotes(vid) {
	var html = '';
    if (vid > 0) {
        var URL = BASE_URL + 'admin/vendors/getVendorNotes';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vendor_id: vid},
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (response) {
				if (response.msgStatus == 'Success') { //if failed
					var notes = response.data.notes;
					if(notes)
					{
						html += '<div class="vendorNotesHtml"><h4>Vendor Notes</h4>'+notes+'</div>';
					}
				}
                $('.vendorNotes').html(html);
            },
            error: function () {
                //alert('something went wrong please try again');
            }
        });
    } else {
		var options = '';
        //$('#require_exams').find('option').remove().end().append(options);
    }
}

function  ajaxLoadVendorFormatsDropdown(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/exams/ajaxGetVendorFormats';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (response) {
				var options = '<option value="">Select Product Type</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                }
                $('#ptype_id').find('option').remove().end().append(options);
				$("#ptype_id").select2({
					placeholder: 'Select Product Type',
					allowClear: true
				}).on('select2-open', function()
				{
					// Adding Custom Scrollbar
					$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
				});
            },
            error: function () {
                alert('something went wrong please try again');
            }
        });
    } else {
		var options = '';
        //$('#ptype_id').find('option').remove().end().append(options);
    }
}

function  ajaxLoadExams2(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/certifications/ajaxGetExams';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            success: function (response) {
				 var options = '<option value="">Select Exam for Replacement</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].exam_code + '</option>';
                }
                $('#old_replacement_cert').find('option').remove().end().append(options);
            },
            error: function () {
                alert('something went wrong please try again');
            }
        });
    } else {
        var options = '<option value="">Select Certification for Replacement</option>';
        $('#old_replacement_cert').find('option').remove().end().append(options);
        //remove loader
    }
}

function  ajaxLoadExamsOnCertBasis(vid,cid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/certifications/ajaxGetExamsOnCertBasis';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {'vid': vid, 'cid':cid},
            dataType: 'json',
            success: function (response) {
				 var options = '';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].exam_code + '</option>';
                }
                $('#require_exams').find('option').remove().end().append(options);
            },
            error: function () {
                alert('something went wrong please try again');
            }
        });
    } else {
        var options = '';
        $('#require_exams').find('option').remove().end().append(options);
        //remove loader
    }
}

function  ajaxLoadExamsOnCertBasisDropdown(vid,cid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/certifications/ajaxGetExamsOnCertBasis';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {'vid': vid, 'cid':cid},
            dataType: 'json',
            success: function (response) {
				 var options = '<option value="">Select Exam Code</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].exam_code + '</option>';
                }
                $('#exam_id').find('option').remove().end().append(options);
				$("#exam_id").select2({
					placeholder: 'Select Exam Code',
					allowClear: true
				}).on('select2-open', function()
				{
					// Adding Custom Scrollbar
					$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
				});
            },
            error: function () {
                alert('something went wrong please try again');
            }
        });
    } else {
        var options = '';
        //$('#exam_id').find('option').remove().end().append(options);
        //remove loader
    }
}

/**Load Attributes of vendor**/
function  ajaxLoadAttributes(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/certifications/ajaxGetAttributes';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            beforeSend: function () {
                $('#cert_attributes').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
                var options = '';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                }
                $('#cert_attributes').find('option').remove().end().append(options);

                //remove loader
                $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
        var options = '';
        $('#cert_attributes').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }
}

/**Load Certification Audience on the basis of vendor**/
function  ajaxLoadCertAudience(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/certifications/ajaxGetAudiences';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            beforeSend: function () {
                $('#cert_audience').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
                var options = '';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                }
                $('#cert_audience').find('option').remove().end().append(options);

                //remove loader
                $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
        var options = '';
        $('#cert_audience').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }
}

/**Load Certification Technologies on the basis of vendor**/
function  ajaxLoadCertTechnologies(vid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/certifications/ajaxGetTechnologies';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            beforeSend: function () {
                $('#cert_technologies').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
                var options = '';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                }
                $('#cert_technologies').find('option').remove().end().append(options);

                //remove loader
                $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
        var options = '';
        $('#cert_technologies').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }
}



function changeBannerType(typeId) {
    if (typeId == 1) {
        $('#codeBannerArea').slideUp('slow');
        $('#imageBannerArea').slideDown('slow');
    } else if (typeId == 2) {
        $('#imageBannerArea').slideUp('slow');
        $('#codeBannerArea').slideDown('slow');
    }
}

function generateSlug(value) {
    var value = value.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
    $('#slug').val(value);
}



function checkAll(ele) {
    var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = true;
            }
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            console.log(i)
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = false;
            }
        }
    }
}

function checkAllClass(ele) {
    var checkboxes = document.getElementsByClassName('pageSelected');
    if (ele.checked) {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = true;
            }
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            console.log(i)
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = false;
            }
        }
    }
}

function getTagData(tagType) {
    if (tagType > 0) {
        var URL = BASE_URL + 'admin/contents/tags/' + tagType;
        window.location.href = URL;
        /*var URL = BASE_URL+'admin/contents/ajaxTagData';
         $.ajax({
         type: 'POST',
         url: URL,
         data: {type:tagType},
         dataType: 'json',
         beforeSend: function(){
         $('#type').before(function() {
         return getLoadingImg();
         });
         
         $('#title').val('');
         $('#description').val('');
         },
         success:function (response){
         var title = response[0].title;
         var desc = response[0].description;
         alert(title+'--'+desc);
         $('#title').val(title);
         $('#description').val(desc);
         //remove loader
         $('#imgLoader').remove();
         },
         error:function(){
         alert('something went wrong please try again');
         //remove loader
         $('#imgLoader').remove();
         }
         });	*/
    }
}

/**Load exam codes of vendor**/
function  ajaxLoadExamCode(vid, eid) {
    if (vid > 0) {
        var URL = BASE_URL + 'admin/exams/ajaxGetExamCodes';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {vid: vid},
            dataType: 'json',
            beforeSend: function () {
                $('#exam_id').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
                var options = '<option value="">Select Exam Code</option>';
                for (var i = 0; i < response.length; i++) {
                    if (eid == response[i].id) {
                        var sel = 'selected="selected"';
                    } else {
                        var sel = '';
                    }
                    options += '<option value="' + response[i].id + '" ' + sel + '>' + response[i].exam_code + '</option>';
                }
                $('#exam_id').find('option').remove().end().append(options);
				$("#productData_form #exam_id").select2({
					placeholder: 'Select Exam Code',
					allowClear: true
				}).on('select2-open', function()
				{
					// Adding Custom Scrollbar
					$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
				});
                //remove loader
                $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
        var options = '<option value="">Select Exam Code</option>';
        $('#exam_id').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }
}

/**
 * Method: addVideoDetailsRow
 * 
 * @param: type
 */
function addVideoDetailsRow(tableId) {
    var currentTable = 'tableSectionContainer_' + tableId;
    var output = '';
    // Get size / no of existing rows 
    var count = $('#' + currentTable + ' tr').length - 3 + 1;
    // alert(count+' '+currentTable);
    output = '<tr id="videoRowContainer_' + tableId + '_' + count + '">'
            + '<td>'
            + '<input type="text" class="form-control" id="video_title_' + tableId + '_' + count + '" name="video_title_' + tableId + '_' + count + '[]" value="">'
            + '</td>' +
            '<td>'
            + '<input type="text" class="form-control" id="video_length_' + tableId + '_' + count + '" name="video_length_' + tableId + '_' + count + '[]" value="">'
            + '</td>'
            + '<td>'
            + '<input type="text" class="form-control" id="video_link_' + tableId + '_' + count + '" name="video_link_' + tableId + '_' + count + '[]" value="">'
            + '</td>'
            + '<td>'
            + '<textarea class="form-control" id="video_detail_' + tableId + '_' + count + '" name="video_detail_' + tableId + '_' + count + '[]"></textarea>'
            + '</td>'
            + '<td class="text-center">'
            + '<div class="checkbox">'
            + '<label>'
            + '<input type="checkbox" name="video_preview_' + tableId + '_' + count + '[]" id="video_preview_' + tableId + '_' + count + '" value="1">'
            + '</label>'
            + '</div>'
            + '</td>'

            + '<td>'
            + '<a href="javascript:" title="Remove Row" class="btn btn-icon btn-success" onclick="removeVideoDetailsRow(' + tableId + ',' + count + ');">'
            + '<i class="fa-minus"></i>'
            + '</a>'
            + '</td>'
            + '</tr>';
    $('#' + currentTable + ' tr:last').after(output);
    $('#no_of_vrows_' + tableId).val(count);
}

function removeVideoDetailsRow(tableId, rowId) {
    //alert(tableId+'--'+rowId);
    var currentTable = 'tableSectionContainer_' + tableId;
    var ans = confirm('Are you sure! you want to remove row');
    if (ans) {
        $("#" + currentTable + " tr#videoRowContainer_" + tableId + "_" + rowId).remove(); // Remove current row
    }
    return false;
}

function addNewSection() {
    var tableId = $('#sectionsContainer table').length + 1;
    var count = 1;
    //alert(tableId+'--'+count);
    var output = '<table cellspacing="0" class="table table-small-font table-bordered table-striped" id="tableSectionContainer_' + tableId + '">'
            + '<thead>'
            + '<tr>'
            + '<td colspan="6" class="alert alert-black"><strong>Section ' + tableId + '</strong></td>'
            + '</tr>'
            + '</thead>'
            + '<tr>'
            + '<td colspan="6">'
            + '<div class="form-group">'
            + '<div class="col-sm-2"></div>'
            + '<label class="col-sm-2 control-label text-right" style="padding-top:5px;">Section Name: <span class="redStar">*</span></label>'
            + '<div class="col-sm-4">'
            + '<input type="text" class="form-control" id="section_name_' + tableId + '" name="section_name[]" data-validate="required" value="" />'
            + '</div>'
            + '</div>'
            + '</td>'
            + '</tr>'
            + '<tr>'
            + '<th class="text-center" >Video Title</th>	'
            + '<th class="text-center" style="width:10%;">Length</th>'
            + '<th class="text-center" >Video Link</th>'
            + '<th class="text-center" style="width:30%;">Video Detail</th>'
            + '<th class="text-center" style="width:8%;">Preview</th>'
            + '<th>'
            + '<a href="javascript:" title="Add New Row" class="btn btn-icon btn-success" onclick="addVideoDetailsRow(' + tableId + ');">'
            + '<i class="fa-plus"></i>'
            + '</a>'
            + '</th>'
            + '</tr>'

            + '<tr id="videoRowContainer_' + tableId + '_' + count + '"><input type="hidden" name="no_of_vrows_' + tableId + '" id="no_of_vrows_' + tableId + '" value="' + count + '" />'
            + '<td>'
            + '<input type="text" class="form-control" id="video_title_' + tableId + '_' + count + '" name="video_title_' + tableId + '_' + count + '[]" value="">'
            + '</td>' +
            '<td>'
            + '<input type="text" class="form-control" id="video_length_' + tableId + '_' + count + '" name="video_length_' + tableId + '_' + count + '[]" value="">'
            + '</td>'
            + '<td>'
            + '<input type="text" class="form-control" id="video_link_' + tableId + '_' + count + '" name="video_link_' + tableId + '_' + count + '[]" value="">'
            + '</td>'
            + '<td>'
            + '<textarea class="form-control" id="video_detail_' + tableId + '_' + count + '" name="video_detail_' + tableId + '_' + count + '[]"></textarea>'
            + '</td>'
            + '<td class="text-center">'
            + '<div class="checkbox">'
            + '<label>'
            + '<input type="checkbox" name="video_preview_' + tableId + '_' + count + '[]" id="video_preview_' + tableId + '_' + count + '" value="1">'
            + '</label>'
            + '</div>'
            + '</td>'

            + '<td>'
            + '<a href="javascript:" title="Remove Row" class="btn btn-icon btn-success" onclick="removeVideoDetailsRow(' + tableId + ',' + count + ');">'
            + '<i class="fa-minus"></i>'
            + '</a>'
            + '</td>'
            + '</tr>'
            + '</table>';
    $('#sectionsContainer table:last').after(output);
}

function loadTypes(bundle_type, type_id) {
    if (bundle_type != '' && bundle_type > 0) {
        var URL = BASE_URL + 'admin/bundles/ajax_get_type';
        var bundle_type_text = $("#bundle_type option[value='" + bundle_type + "']").text();
        $('#b_type_title').html(bundle_type_text);
		//alert(bundle_type_text);
        $.ajax({
            type: 'POST',
            url: URL,
            data: {btype: bundle_type},
            dataType: 'json',
            beforeSend: function () {
                $('#type_id').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
                var options = '<option value="">Select ' + bundle_type_text + '</option>';
                for (var i = 0; i < response.length; i++) {
                    if (response[i].id == type_id) {
                        var sel = 'selected=true';
                    } else {
                        var sel = '';
                    }
                    options += '<option value="' + response[i].id + '" ' + sel + '>' + response[i].name + '</option>';
                }
                $('#type_id').find('option').remove().end().append(options);
				
                //remove loader
                $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
        $('#b_type_title').html('Vendor');
        var options = '<option value="">Select Vendor</option>';
        $('#type_id').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }

    if (bundle_type == 3 || bundle_type == 4) {//hide exams section in case of exam
        $('#examsContainer').hide();
    } else {
        $('#examsContainer').show();
    }
	
	if (bundle_type == 4) {//hide exams section in case of exam
        $('#typeBox').hide();
		$('.hideifNotAllExams').show();
    } else {
        $('#typeBox').show();
		$('.hideifNotAllExams').hide();
    }

}

function loadBundleExams(type_id, examids) {
    if (type_id != '' && type_id > 0) {
        var URL = BASE_URL + 'admin/bundles/ajax_get_exams';
        var bundle_type = $("#bundle_type").val();
        if (bundle_type != 3) {//dont call in case of exam
            $.ajax({
                type: 'POST',
                url: URL,
                data: {btype: bundle_type, etype: type_id},
                dataType: 'json',
                beforeSend: function () {
                    $('.examCodesCls ul').before(function () {
                        return getLoadingImg();
                    });
                },
                success: function (response) {
					
                    var options = '';
                    if (response && response[type_id].length > 0) {
                        var examidsArr = [];
                        if (examids != '' && examids != 0) {
                            var examidsArr = JSON.parse(examids);
                        }
                        for (var i = 0; i < response[type_id].length; i++) {
                            var selMe = '';
                            //alert(response[type_id][i].examId+'---'+$.inArray( response[type_id][i].examId, examidsArr));   
                            if ($.inArray(response[type_id][i].examId, examidsArr) > -1) {
                                var selMe = 'checked="true"';
                            }
                            options += '<li><input type="checkbox" name="exam_ids[]" value="' + response[type_id][i].examId + '" ' + selMe + ' /><span>' + response[type_id][i].examCode + '</span></li>';
                        }
                    }

                    $('#imgLoader').remove();//remove loader

                    $('.examCodesCls ul').html(options); //apend values		       
                },
                error: function () {
                    alert('something went wrong please try again');
                    //remove loader
                    $('#imgLoader').remove();
                }
            });
        }
    } else {
        $('.examCodesCls ul').html('');
        //remove loader
        $('#imgLoader').remove();
    }
}

/**validate bundle**/
function validateBundle(formId) {
    var restoreTxt = getOldHtml('bundlesInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/bundles/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnBundleSubmit', true);
            $('#btnBundleSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('bundlesInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('bundlesInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/bundles');
            }
            toggleDisable('btnBundleSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnBundleSubmit', false);
        }
    });
}

/**validate bundle_default**/
function validateBundleDefault(formId) {
    var restoreTxt = getOldHtml('bundle_defaultsInfMsg');
    var btype = $('#bundle_type').val();
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/bundles/ajaxSaveDefault';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnBundleDefaultSubmit', true);
            $('#btnBundleDefaultSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('bundle_defaultsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('bundle_defaultsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/bundle_defaults');
                redirectPage(BASE_URL + 'admin/bundles/default_bundle/' + btype);
            }
            toggleDisable('btnBundleDefaultSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnBundleDefaultSubmit', false);
        }
    });
}
function getBundleTypeData(btype) {
    if (btype > 0) {
        var URL = BASE_URL + 'admin/bundles/default_bundle/' + btype;
        window.location.href = URL;
    }
}

function addNewSubscriptionOption(){
    var template = $('#optionsRow-template').html();
    $('#tableOptionsContainer tbody').append(template);
}

 /**validate subscription**/
function validateSubscription(formId) {
    var restoreTxt = getOldHtml('subscriptionsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/subscriptions/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnSubscriptionSubmit', true);
            $('#btnSubscriptionSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('subscriptionsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('subscriptionsInfMsg', 'success', response.msgText, restoreTxt);
                redirectPage(BASE_URL + 'admin/subscriptions');
            }
            toggleDisable('btnSubscriptionSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnSubscriptionSubmit', false);
        }
    });
}

function loadBundles(bundle_type,bundle_id) {
    if (bundle_type != '' && bundle_type > 0) {        
        var URL = BASE_URL + 'admin/bundles/ajax_get_bundles';        
        $.ajax({
            type: 'POST',
            url: URL,
            data: {btype: bundle_type},
            dataType: 'json',
            beforeSend: function () {
                $('#bundle_id').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
                var options = '<option value="">Select Bundle</option><option value="0">Default Bundle</option>';
                for (var i = 0; i < response.length; i++) {
                    if (response[i].id == bundle_id) {
                        var sel = 'selected=true';
                    } else {
                        var sel = '';
                    }
                    options += '<option value="' + response[i].id + '" ' + sel + '>' + response[i].name + '</option>';
                }
                $('#bundle_id').find('option').remove().end().append(options);

                //remove loader
                $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {        
        var options = '<option value="">Select Bundle</option><option value="0">Default Bundle</option>';
        $('#bundle_id').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }
}


 /**validate netbanxhoster_payment_method**/
function validatenetbanxhoster_payment_method(formId) {
    var restoreTxt = getOldHtml('netbanxhoster_payment_methodsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/payment_methods/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnnetbanxhoster_payment_methodSubmit', true);
            $('#btnnetbanxhoster_payment_methodSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('netbanxhoster_payment_methodInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('netbanxhoster_payment_methodInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/netbanxhoster_payment_methods');
            }
            toggleDisable('btnnetbanxhoster_payment_methodSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnnetbanxhoster_payment_methodSubmit', false);
        }
    });
}

 /**validate netbanxenterprise_payment_method**/
function validatenetbanxenterprise_payment_method(formId) {
    var restoreTxt = getOldHtml('netbanxenterprise_payment_methodsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/payment_methods/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnnetbanxenterprise_payment_methodSubmit', true);
            $('#btnnetbanxenterprise_payment_methodSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('netbanxenterprise_payment_methodInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('netbanxenterprise_payment_methodInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/netbanxenterprise_payment_methods');
            }
            toggleDisable('btnnetbanxenterprise_payment_methodSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnnetbanxenterprise_payment_methodSubmit', false);
        }
    });
}

 /**validate paypal_payment_method**/
function validatepaypal_payment_method(formId) {
    var restoreTxt = getOldHtml('paypal_payment_methodsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/payment_methods/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnpaypal_payment_methodSubmit', true);
            $('#btnpaypal_payment_methodSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('paypal_payment_methodInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('paypal_payment_methodInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/paypal_payment_methods');
            }
            toggleDisable('btnpaypal_payment_methodSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnpaypal_payment_methodSubmit', false);
        }
    });
}

  /**validate sagepay_payment_method**/
function validatesagepay_payment_method(formId) {
    var restoreTxt = getOldHtml('sagepay_payment_methodsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/payment_methods/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnsagepay_payment_methodSubmit', true);
            $('#btnsagepay_payment_methodSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('sagepay_payment_methodInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('sagepay_payment_methodInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/sagepay_payment_methods');
            }
            toggleDisable('btnsagepay_payment_methodSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnsagepay_payment_methodSubmit', false);
        }
    });
}

/**validate manualorder_payment_method**/
function validatemanualorder_payment_method(formId) {
    var restoreTxt = getOldHtml('manualorder_payment_methodsInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/payment_methods/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnmanualorder_payment_methodSubmit', true);
            $('#btnmanualorder_payment_methodSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('manualorder_payment_methodInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('manualorder_payment_methodInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/manualorder_payment_methods');
            }
            toggleDisable('btnmanualorder_payment_methodSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnmanualorder_payment_methodSubmit', false);
        }
    });
}

/**validate validateBundleDiscount**/
function validateBundleDiscount(formId) {
    var restoreTxt = getOldHtml('bundle-discountInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/discounts/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('bundle-discountSubmit', true);
            $('#bundle-discountSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('bundle-discountInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('bundle-discountInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/manualorder_payment_methods');
            }
            toggleDisable('bundle-discountSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnmanualorder_payment_methodSubmit', false);
        }
    });
}

/**validate validateReorderDiscount**/
function validateReorderDiscount(formId) {
    var restoreTxt = getOldHtml('reorder-discountInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/discounts/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('reorder-discountSubmit', true);
            $('#reorder-discountSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('reorder-discountInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('reorder-discountInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/manualorder_payment_methods');
            }
            toggleDisable('reorder-discountSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnmanualorder_payment_methodSubmit', false);
        }
    });
}

/**validate validateRoyalpackDiscount**/
function validateRoyalpackDiscount(formId) {
    var restoreTxt = getOldHtml('royalpack-discountInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/discounts/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('royalpack-discountSubmit', true);
            $('#royalpack-discountSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('royalpack-discountInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('royalpack-discountInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/manualorder_payment_methods');
            }
            toggleDisable('royalpack-discountSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnmanualorder_payment_methodSubmit', false);
        }
    });
}

/**validate validateQuantityDiscount**/
function validateQuantityDiscount(formId) {
    var restoreTxt = getOldHtml('quantity-discountInfMsg');
    var data = $('#' + formId).serialize();
    var URL = BASE_URL + 'admin/discounts/ajaxSave';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('quantity-discountSubmit', true);
            $('#quantity-discountSubmit').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('quantity-discountInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                displayMessage('quantity-discountInfMsg', 'success', response.msgText, restoreTxt);
                $('#imgLoader').remove();
                //redirectPage(BASE_URL + 'admin/manualorder_payment_methods');
            }
            toggleDisable('quantity-discountSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnmanualorder_payment_methodSubmit', false);
        }
    });
}

function loadExamProducts(eid){
    
    if (eid > 0) {
        var examCode = $("#exam_id option:selected").text();
        var URL = BASE_URL + 'admin/exams/getExamProducts';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {eid: eid},
            dataType: 'json',
            beforeSend: function () {
                $('#tblExamProducts tbody').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
                var html = '';
                var k=1;
                var orderSubTotal = 0;
                var itemSubPlan = 1;
                var itemSubPeriod = 3;
                for (var i = 0; i < response.length; i++) {
                   var price = response[i].ptPrice;
                   if (response[i].price > 0){
                       price = response[i].price;
                   }
                   
                   var qty = 1;
                   var discount = 0;
                  
                   //build hidden fields
                   var fields = '<input type="hidden" id="ptypeId_'+k+'" name="ptypeId_'+k+'" value="'+response[i].ptype_id+'" />';
                       fields +='<input type="hidden" id="productName_'+k+'" name="productName_'+k+'" value="'+response[i].vendorName+' '+examCode+' '+response[i].ptName+'" />';
                       fields +='<input type="hidden" id="productQty_'+k+'" name="productQty_'+k+'" value="'+qty+'" />';
                       fields +='<input type="hidden" id="productPrice_'+k+'" name="productPrice_'+k+'" value="'+price+'" />';
                       fields +='<input type="hidden" id="productDiscount_'+k+'" name="productDiscount_'+k+'" value="'+discount+'" />';
                       fields +='<input type="hidden" id="itemSubPlan_'+k+'" name="itemSubPlan_'+k+'" value="'+itemSubPlan+'" />';
                       fields +='<input type="hidden" id="itemSubPeriod_'+k+'" name="itemSubPeriod_'+k+'" value="'+itemSubPeriod+'" />';
                       fields +='<input type="hidden" id="productId_'+k+'" name="productId_'+k+'" value="'+response[i].id+'" />';
                       
                   
                    html += '<tr id="pTypeRow_'+response[i].id+'">'
                            +'<td class="text-center">'
                                +'<input type="checkbox" id="add_order_'+k+'" name="add_order_'+k+'" value="'+k+'" onchange="saveManualOrder(this.value)" />'
                            +'</td>'
                            +'<td>'+response[i].ptName+'</td>'
                            +'<td> 90 Days </td>'
                            +'<td class="text-right">$'+price+'</td>'+fields+'</tr>';
                k++;
               }
               //console.log(html);
               $('#productsListTabl').show();
               $('#tblExamProducts tbody').html(html);
               //remove loader
               $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {        
        $('#tblExamProducts tbody').html('');
        $('#productsListTabl').hide();
        //remove loader
        $('#imgLoader').remove();
    }
}

function saveManualOrder(chkId){
    var restoreTxt = getOldHtml('ordersInfMsg');
   //check user and exam is selected
   var user_id = $('#user_id').val();
   var exam_id = $('#exam_id').val();
   
   if (user_id=='' || user_id < 1){
       var msgText = 'Please select customer';
       displayMessage('ordersInfMsg', 'danger', msgText, restoreTxt);
   }
   
   if (exam_id=='' || exam_id < 1){
       var msgText = 'Please select exam';
       displayMessage('ordersInfMsg', 'danger', msgText, restoreTxt);
   }
   var order_type = $('#order_type').val();
   var dis = $('#discount').val();
   //var dis = $('#discount_per').val();
   if (order_type == 'bundle') {
       var productId = 100+$('#productId_'+chkId+'').val();
       var itemOrderType = 'bundle';
       var itemBundleType = $('#bundle_type').val();
   } else {
       var productId = $('#productId_'+chkId+'').val();
       var itemOrderType = 'single';
       var itemBundleType = 0;
   }
   
   if ($('#add_order_'+chkId).is(":checked")){       
       //build order list    
        var pTypeId = $('#ptypeId_'+chkId+'').val();
        var productName = $('#productName_'+chkId+'').val();
        var productQty = $('#productQty_'+chkId+'').val();
        var productPrice = $('#productPrice_'+chkId+'').val();
        var productDiscount = dis;
        var itemSubPlan = $('#itemSubPlan_'+chkId+'').val();
        var itemSubPeriod = $('#itemSubPeriod_'+chkId+'').val();
        var itemSubTotal = parseInt(productPrice)*parseInt(productQty);
       
        var URL = BASE_URL + 'admin/orders/listManualOrder';
        $.ajax({
            type: 'POST',
            url: URL,
            dataType:'json',
            data: {pTypeId:pTypeId},
            beforeSend: function () {
                $('#orderListContainer').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
			   //var origProductId = productId;
			   var productIdFull = productId;
               var productIdArr = productIdFull.split(',');
			   var exam_code = productIdArr[0];
			   var product_type = productIdArr[1];
			   productId = productId.replace(",", "");
			   var pQty = '<input type="text" name="pQty[]" id="pQty_'+productId+'" value="'+productQty+'" class="form-control" maxlength="3" onkeyup="updateItemPrice(\''+productId+'\');" />';
               var icon = response.iconImg;
               var orderRowId = $('#tblOrderProducts tbody tr').size()+1;               
               var linkToRemove = '<a href="javascript:removeOrderListItem(\''+productId+'\');" id="rmvLink_'+productId+'" class="clsRemoveOrderItem" ><i class="fa fa-remove"></i></a>';
              
               calculateOrderAmount(productPrice,productDiscount,itemSubTotal);
               
               //build hidden fields
                var fields = '<input type="hidden" id="productId_'+productId+'" name="productId[]" value="'+exam_code+'" />';
					fields +='<input type="hidden" id="productTypeId_'+productId+'" name="productTypeId[]" value="'+product_type+'" />';
                    fields +='<input type="hidden" id="productName_'+productId+'" name="productName[]" value="'+productName+'" />';
                    //fields +='<input type="hidden" id="productQty_'+productId+'" name="productQty[]" value="'+productQty+'" />';
                    fields +='<input type="hidden" id="productPrice_'+productId+'" name="productPrice[]" value="'+productPrice+'" />';
                    //fields +='<input type="hidden" id="productDiscount_'+productId+'" name="productDiscount[]" value="'+productDiscount+'" />';
                    fields +='<input type="hidden" id="itemSubPlan_'+productId+'" name="itemSubPlan[]" value="'+itemSubPlan+'" />';
                    fields +='<input type="hidden" id="itemSubPeriod_'+productId+'" name="itemSubPeriod[]" value="'+itemSubPeriod+'" />';
                    fields +='<input type="hidden" id="itemSubTotal_'+productId+'" name="itemSubTotal[]" value="'+itemSubTotal+'" />';
                    fields +='<input type="hidden" id="itemOrderType_'+productId+'" name="itemOrderType[]" value="'+itemOrderType+'" />';
                    fields +='<input type="hidden" id="itemBundleType_'+productId+'" name="itemBundleType[]" value="0" />';
					fields +='<input type="hidden" id="itemBundleTypeID_'+productId+'" name="itemBundleTypeID[]" value="0" />';
					fields +='<input type="hidden" id="itemBundleID_'+productId+'" name="itemBundleID[]" value="0" />';
					fields +='<input type="hidden" id="itemBundleFormat_'+productId+'" name="itemBundleFormat[]" value="0" />';
                    
               var html = '<tr id="orderListRow_'+productId+'">'
                            +'<td>'+icon+'</td>'
                          
                            +'<td>'+productName+'</td>'
                         
                            +'<td class="text-center">'+pQty+'</td>'
                          
                            +'<td class="text-center">$'+productPrice+'</td>'
                          
                            //+'<td class="text-center">$'+productDiscount+'</td>'
                          
                            +'<td class="text-center">$<span id="itemSubTotalLbl_'+productId+'">'+itemSubTotal+'</span></td>'
                         
                            +'<td class="text-center">'+linkToRemove+'</td>'+fields+'</tr>';
               $('#orderListContainer').show();
              
               $('#tblOrderProducts tbody').append(html);
               
               //enable save button
               $('#btnManualOrderSubmit').attr('disabled',false);

               //increment orderItem
               var totalOrderItems = parseInt($('#totalOrderItems').val()) + 1;
               $('#totalOrderItems').val(totalOrderItems);
               //remove loader
               $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
		productId = productId.replace(",", "");
		removeOrderListItem(productId);	
     
    }
	
		if($('#orderData_form #discount_per').val() > 0)
		{
			setTimeout(function(){
			 var discountVal = $('#orderData_form #discount_per').val();
			 if ($.isNumeric(discountVal)) {
			   //alert(discountVal);
			   var totalOrder = $('#orderSubTotal').val();
			   var discount_amount = totalOrder * discountVal / 100;
					$('#orderData_form #discount').val(discount_amount);
					$('#orderDiscountContainer').html(discount_amount);
					$('#orderDiscount').val(discount_amount);
					totalOrder = totalOrder - discount_amount;
					$('#orderTotal').val(totalOrder);
					$('#orderTotalContainer').html(totalOrder);
				}
			}, 3000);	
		}
		else if($('#orderData_form #discount').val() > 0)
		{
			setTimeout(function(){
			 var discountVal = $('#orderData_form #discount').val();
			 if ($.isNumeric(discountVal)) {
			   //alert(discountVal);
					$('#orderDiscountContainer').html(discountVal);
					$('#orderDiscount').val(discountVal);
					var totalOrder = $('#orderSubTotal').val();
					totalOrder = totalOrder - discountVal;
					$('#orderTotal').val(totalOrder);
					$('#orderTotalContainer').html(totalOrder);
					$('#btnManualOrderSubmit').removeAttr('disabled');
				}
			}, 3000);
		}
}


function saveBundleManualOrder(chkId){
    var restoreTxt = getOldHtml('ordersInfMsg');
   //check user and exam is selected
   var user_id = $('#user_id').val();
   var exam_id = $('#exam_id').val();
   
   if (user_id=='' || user_id < 1){
       var msgText = 'Please select customer';
       displayMessage('ordersInfMsg', 'danger', msgText, restoreTxt);
   }
   
   /* if (exam_id=='' || exam_id < 1){
       var msgText = 'Please select exam';
       displayMessage('ordersInfMsg', 'danger', msgText, restoreTxt);
   } */
   var order_type = $('#order_type').val();
   var dis = $('#discount').val();
   if (order_type == 'bundle') {
       var productId = $('#productId_'+chkId+'').val();
       var itemOrderType = 'bundle';
       var itemBundleType = $('#itemBundleType_'+chkId).val();
	   var itemBundleTypeID = $('#bundleTypeId_'+chkId).val();
	   var itemBundleID = $('#bundleId'+chkId).val();
	   var itemBundleFormat = $('#bundle_type').val();
   } else {
       var productId = $('#productId_'+chkId+'').val();
       var itemOrderType = 'single';
       var itemBundleType = 0;
	   var itemBundleTypeID = 0;
	   var itemBundleID = 0;
	    var itemBundleFormat = 0;
   }
   
   if ($('#add_order_'+chkId).is(":checked")){       
       //build order list    
        var pTypeId = $('#ptypeId_'+chkId+'').val();
        var productName = $('#productName_'+chkId+'').val();
        var productQty = $('#productQty_'+chkId+'').val();
        var productPrice = $('#productPrice_'+chkId+'').val();
        var productDiscount = dis;
        var itemSubPlan = $('#itemSubPlan_'+chkId+'').val();
        var itemSubPeriod = $('#itemSubPeriod_'+chkId+'').val();
        var itemSubTotal = parseInt(productPrice)*parseInt(productQty);
       
        var URL = BASE_URL + 'admin/orders/listManualOrder';
        $.ajax({
            type: 'POST',
            url: URL,
            dataType:'json',
            data: {pTypeId:pTypeId},
            beforeSend: function () {
                $('#orderListContainer').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
			   var origProductId = productId;
			   productId=   productId.replace(",", "");
			   product_type = '0';
               var pQty = '<input type="text" name="pQty[]" id="pQty_'+productId+'" value="'+productQty+'" class="form-control" maxlength="3" onkeyup="updateItemPrice(\''+productId+'\');" />';
               var icon = response.iconImg;
               var orderRowId = $('#tblOrderProducts tbody tr').size()+1;               
               var linkToRemove = '<a href="javascript:removeOrderListItem(\''+productId+'\');" id="rmvLink_'+productId+'" class="clsRemoveOrderItem" ><i class="fa fa-remove"></i></a>';
              
               calculateOrderAmount(productPrice,productDiscount,itemSubTotal);
               
               //build hidden fields
                var fields = '<input type="hidden" id="productId_'+productId+'" name="productId[]" value="'+origProductId+'" />';
                    fields +='<input type="hidden" id="productName_'+productId+'" name="productName[]" value="'+productName+'" />';
					fields +='<input type="hidden" id="productTypeId_'+productId+'" name="productTypeId[]" value="'+product_type+'" />';
                    //fields +='<input type="hidden" id="productQty_'+productId+'" name="productQty[]" value="'+productQty+'" />';
                    fields +='<input type="hidden" id="productPrice_'+productId+'" name="productPrice[]" value="'+productPrice+'" />';
                    //fields +='<input type="hidden" id="productDiscount_'+productId+'" name="productDiscount[]" value="'+productDiscount+'" />';
                    fields +='<input type="hidden" id="itemSubPlan_'+productId+'" name="itemSubPlan[]" value="'+itemSubPlan+'" />';
                    fields +='<input type="hidden" id="itemSubPeriod_'+productId+'" name="itemSubPeriod[]" value="'+itemSubPeriod+'" />';
                    fields +='<input type="hidden" id="itemSubTotal_'+productId+'" name="itemSubTotal[]" value="'+itemSubTotal+'" />';
                    fields +='<input type="hidden" id="itemOrderType_'+productId+'" name="itemOrderType[]" value="'+itemOrderType+'" />';
                    fields +='<input type="hidden" id="itemBundleType_'+productId+'" name="itemBundleType[]" value="'+itemBundleType+'" />';
					fields +='<input type="hidden" id="itemBundleTypeID_'+productId+'" name="itemBundleTypeID[]" value="'+itemBundleTypeID+'" />';
					fields +='<input type="hidden" id="itemBundleID_'+productId+'" name="itemBundleID[]" value="'+itemBundleID+'" />';
					fields +='<input type="hidden" id="itemBundleFormat_'+productId+'" name="itemBundleFormat[]" value="'+itemBundleFormat+'" />';
					
                    
               var html = '<tr id="orderListRow_'+productId+'">'
                            +'<td>'+icon+'</td>'
                          
                            +'<td>'+productName+'</td>'
                         
                            +'<td class="text-center">'+pQty+'</td>'
                          
                            +'<td class="text-center">$'+productPrice+'</td>'
                          
                            //+'<td class="text-center">$'+productDiscount+'</td>'
                          
                            +'<td class="text-center">$<span id="itemSubTotalLbl_'+productId+'">'+itemSubTotal+'</span></td>'
                         
                            +'<td class="text-center">'+linkToRemove+'</td>'+fields+'</tr>';
               $('#orderListContainer').show();
              
               $('#tblOrderProducts tbody').append(html);
               
               //enable save button
               $('#btnManualOrderSubmit').attr('disabled',false);

               //increment orderItem
               var totalOrderItems = parseInt($('#totalOrderItems').val()) + 1;
               $('#totalOrderItems').val(totalOrderItems);
               //remove loader
               $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {     
        var isProductExists = $('#productId_'+productId+'').val();
        if (isProductExists){
           //unset values of that row
            var price = parseInt($('#productPrice_'+productId).val());
            var qty = parseInt($('#pQty_'+productId).val());
            var itemSubTotal = parseInt($('#itemSubTotal_'+productId).val());
            $('#itemSubTotalLbl_'+productId).html(0);
            $('#itemSubTotal_'+productId).val(0);
            
            $('#productPrice_'+productId).val(0);
            $('#pQty_'+productId).val(0);
            
            //update order subtotal and grand total
            var orderSubTotal = parseInt($('#orderSubTotal').val());
            var orderTotal = parseInt($('#orderTotal').val());

            orderSubTotal = orderSubTotal-itemSubTotal;
            $('#orderSubTotal').val(orderSubTotal);
            $('#orderSubTotalContainer').html(orderSubTotal);

            orderTotal = orderTotal-itemSubTotal;
            $('#orderTotal').val(orderTotal);
            $('#orderTotalContainer').html(orderTotal);
            
            //remove row if exists
            $('#orderListRow_'+productId).remove();

            var totalOrderRow = $('#tblOrderProducts tbody tr').size();  
            if (totalOrderRow > 0){
                //enable save button
                $('#btnManualOrderSubmit').attr('disabled',false);
            } else {
                //enable save button
                $('#btnManualOrderSubmit').attr('disabled',true);
            } 

            //decrement orderItem
               var totalOrderItems = parseInt($('#totalOrderItems').val()) - 1;
               $('#totalOrderItems').val(totalOrderItems);
        }
        
    }
		if($('#orderData_form #discount_per').val() > 0)
		{
			setTimeout(function(){
			 var discountVal = $('#orderData_form #discount_per').val();
			 if ($.isNumeric(discountVal)) {
			   //alert(discountVal);
			   var totalOrder = $('#orderSubTotal').val();
			   var discount_amount = totalOrder * discountVal / 100;
					$('#orderData_form #discount').val(discount_amount);
					$('#orderDiscountContainer').html(discount_amount);
					$('#orderDiscount').val(discount_amount);
					totalOrder = totalOrder - discount_amount;
					$('#orderTotal').val(totalOrder);
					$('#orderTotalContainer').html(totalOrder);
				}
			}, 3000);	
		}
		else if($('#orderData_form #discount').val() > 0)
		{
			setTimeout(function(){
			 var discountVal = $('#orderData_form #discount').val();
			 if ($.isNumeric(discountVal)) {
			   //alert(discountVal);
					$('#orderDiscountContainer').html(discountVal);
					$('#orderDiscount').val(discountVal);
					var totalOrder = $('#orderSubTotal').val();
					totalOrder = totalOrder - discountVal;
					$('#orderTotal').val(totalOrder);
					$('#orderTotalContainer').html(totalOrder);
					$('#btnManualOrderSubmit').removeAttr('disabled');
				}
			}, 3000);
		}
	
}



function updateItemPrice(productId){
    //alert(productId+'--'+$('#productPrice_'+productId).val());
    var price = parseInt($('#productPrice_'+productId).val());
    var qty = parseInt($('#pQty_'+productId).val());
    var itemSubTotal = parseInt($('#itemSubTotal_'+productId).val());
    var subtotal = price*qty;
    $('#itemSubTotalLbl_'+productId).html(subtotal);
    $('#itemSubTotal_'+productId).val(subtotal);
    //alert(price);
    //update order subtotal and grand total
    var orderSubTotal = parseInt($('#orderSubTotal').val());
    var orderTotal = parseInt($('#orderTotal').val());
    
    orderSubTotal = subtotal+orderSubTotal-itemSubTotal;
    $('#orderSubTotal').val(orderSubTotal);
    $('#orderSubTotalContainer').html(orderSubTotal);
    
    
    orderTotal = subtotal+orderTotal-itemSubTotal;
    $('#orderTotal').val(orderTotal);
    $('#orderTotalContainer').html(orderTotal);
}

function calculateOrderAmount(itemSubTotal, itemDiscount, itemTotal){
    var orderSubTotal = parseInt($('#orderSubTotal').val());
    //alert(orderSubTotal);
    var orderDiscount = parseInt($('#orderDiscount').val());
    var orderTotal = parseInt($('#orderTotal').val());
    
    orderSubTotal = parseInt(itemTotal)+orderSubTotal;
    //alert(orderSubTotal);
    $('#orderSubTotal').val(orderSubTotal);
    $('#orderSubTotalContainer').html(orderSubTotal);
    
	console.log(parseInt(itemDiscount));
    if(parseInt(itemDiscount))
	{
		orderDiscount = parseInt(itemDiscount);
	}
	else
	{
		orderDiscount = 0;
	}
	
	$('#orderDiscount').val(orderDiscount);
	$('#orderDiscountContainer').html(orderDiscount);
    
    
    orderTotal = orderSubTotal-orderDiscount;
    $('#orderTotal').val(orderTotal);
    $('#orderTotalContainer').html(orderTotal);
}

function removeOrderListItem(productId){
    var ans = confirm('Are you sure! You want to delete');
    if (ans){
		console.log(productId);
		//console.log($('#productPrice_'+productId).val());
		//return;
        //unset values of that row
        var price = parseInt($('#productPrice_'+productId).val());
        var qty = parseInt($('#pQty_'+productId).val());
        var itemSubTotal = parseInt($('#itemSubTotal_'+productId).val());
        $('#itemSubTotalLbl_'+productId).html(0);
        $('#itemSubTotal_'+productId).val(0);
        
        $('#productPrice_'+productId).val(0);
        $('#pQty_'+productId).val(0);
        
        //update order subtotal and grand total
        var orderSubTotal = parseInt($('#orderSubTotal').val());
        var orderTotal = parseInt($('#orderTotal').val());

        orderSubTotal = orderSubTotal-itemSubTotal;
        $('#orderSubTotal').val(orderSubTotal);
        $('#orderSubTotalContainer').html(orderSubTotal);

        orderTotal = orderTotal-itemSubTotal;
        $('#orderTotal').val(orderTotal);
        $('#orderTotalContainer').html(orderTotal);
        
        //remove row if exists
        $('#orderListRow_'+productId).remove();
		
		if($('#orderData_form #discount_per').val())
		{
			setTimeout(function(){
			 var discountVal = $('#orderData_form #discount_per').val();
			 if ($.isNumeric(discountVal)) {
			   //alert(discountVal);
			   var totalOrder = $('#orderSubTotal').val();
			   var discount_amount = totalOrder * discountVal / 100;
					$('#orderData_form #discount').val(discount_amount);
					$('#orderDiscountContainer').html(discount_amount);
					$('#orderDiscount').val(discount_amount);
					totalOrder = totalOrder - discount_amount;
					$('#orderTotal').val(totalOrder);
					$('#orderTotalContainer').html(totalOrder);
				}
			}, 200);	
		}
		else if($('#orderData_form #discount').val())
		{
			setTimeout(function(){
			 var discountVal = $('#orderData_form #discount').val();
			 if ($.isNumeric(discountVal)) {
			   //alert(discountVal);
					$('#orderDiscountContainer').html(discountVal);
					$('#orderDiscount').val(discountVal);
					var totalOrder = $('#orderSubTotal').val();
					totalOrder = totalOrder - discountVal;
					$('#orderTotal').val(totalOrder);
					$('#orderTotalContainer').html(totalOrder);
					$('#btnManualOrderSubmit').removeAttr('disabled');
				}
			}, 200);
		}
		

        var totalOrderRow = $('#tblOrderProducts tbody tr').size();  
        if (totalOrderRow > 0){
            //enable save button
            $('#btnManualOrderSubmit').attr('disabled',false);
        } else {
            //enable save button
            $('#btnManualOrderSubmit').attr('disabled',true);
        }

        //un check automatically checkbox of that product

        $('tr#pTypeRow_'+productId+' td').find('input[type="checkbox"]').attr('checked',false);
        //decrement orderItem
        var totalOrderItems = parseInt($('#totalOrderItems').val()) - 1;
        $('#totalOrderItems').val(totalOrderItems);
    }
}

function changeOrderBundleType(orderType){
    if (orderType=='single'){
        $('#bundleOrderItems').hide();
        $('#singleOrderItems').show();        
    } else if (orderType == 'bundle'){
        $('#singleOrderItems').hide();
        $('#bundleOrderItems').show();
    }
}
function loadMyBundles(type_id,bundle_id) {
    var bundle_type = $("#bundle_type option:selected").val();
	var type_text = $("#type_id option:selected").text();

    if (bundle_type != '' && bundle_type > 0 && type_id > 0) {        
        var URL = BASE_URL + 'admin/bundles/ajax_get_my_bundles';        
        $.ajax({
            type: 'POST',
            url: URL,
            data: {btype: bundle_type,typeId:type_id},
            dataType: 'json',
            beforeSend: function () {
                $('#type_id').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
				console.log(response);
	
				$('#subscription_price_3_inc').val(response.subscription_price_3_inc);
				$('#subscription_price_6_inc').val(response.subscription_price_6_inc);
				$('#subscription_price_12_inc').val(response.subscription_price_12_inc);
				
				$('#corporate_price_inc').val(response.corporate_price_inc);
				$('#trainer_price_inc').val(response.trainer_price_inc);
				$('#individual_price_inc').val(response.individual_price_inc);
				
                var html = '';
                var extraOptions = '';
				var x = 200; // can be any number
				var rand = Math.floor(Math.random()*x) + 1;	
                var k = rand;
                var orderSubTotal = 0;
				
				if(response.subscription)
				{
					$('#subscription').val(response.subscription);
					var itemSubPeriod = $('#subscription').val();
				}
				else
				{
					var itemSubPeriod = $('#subscription').val();
				}
				
				if(response.subscription_plan)
				{
					$('#subscription_plan').val(response.subscription_plan);
					var itemSubPlan = $('#subscription_plan').val();
				}
				else
				{
					var itemSubPlan = $('#subscription_plan').val();
				}
                
                
				
				var subscription_planTxt = $("#subscription_plan option:selected").text();
				var subscriptionTxt = $("#subscription option:selected").text();
				
                //for (var i = 0; i < response.products.length; i++) {
                   var price = 0;   
                   var qty = 1;
                   var discount = 0;

                   //prepare bundle subscription options
                    var subTypes = '';
                    var subOptions = '';
					if(response.bundle_type == 'default')
					{
						if(bundle_type == 4)
						{
							var bundle_name =  type_text;
						}
						else
						{
							var bundle_name =  type_text+' '+response.bunlde_name;
						}
						
					}
					else
					{
						if(bundle_type == 4)
						{
							var bundle_name =  type_text;
						}
						else
						{
							var bundle_name =  response.bunlde_name;
						}
					}
                   var fields = '<input type="hidden" id="ptypeId_'+k+'" name="ptypeId_'+k+'" value="'+response.products+'" />';
					   fields += '<input type="hidden" id="rand_key_id" name="rand_key_id" value="'+k+'" />';
					   fields +='<input type="hidden" id="productName_'+k+'" name="productName_'+k+'" value="'+bundle_name+'" />';
                       fields += '<input type="hidden" id="productId_'+k+'" name="productId_'+k+'" value="bundle_product'+k+'" />';
                       fields +='<input type="hidden" id="productQty_'+k+'" name="productQty_'+k+'" value="'+qty+'" />';
                       fields +='<input type="hidden" id="productPrice_'+k+'" name="productPrice_'+k+'" value="'+response.bundle_price+'" />';
                       //fields +='<input type="hidden" id="productDiscount_'+k+'" name="productDiscount_'+k+'" value="0" />';
                       fields +='<input type="hidden" id="itemSubPlan_'+k+'" name="itemSubPlan_'+k+'" value="'+itemSubPlan+'" />';
                       fields +='<input type="hidden" id="itemSubPeriod_'+k+'" name="itemSubPeriod_'+k+'" value="'+itemSubPeriod+'" />';
                       fields +='<input type="hidden" id="bundleTypeId_'+k+'" name="bundleTypeId_'+k+'" value="'+response.bundle_type_id+'" />';
					   fields +='<input type="hidden" id="bundleId'+k+'" name="bundleId'+k+'" value="'+response.bundle_id+'" />';
					   fields +='<input type="hidden" id="itemOrderType_'+k+'" name="itemOrderType_'+k+'" value="bundle" />';
					fields +='<input type="hidden" id="itemBundleType_'+k+'" name="itemBundleType_'+k+'" value="'+response.bundle_type+'" />';					
                    html += '<tr id="pTypeRow_'+response.bundle_id+response.bundle_type+'">'
                            +'<td class="text-center"><input type="checkbox" id="add_order_'+k+'" name="add_order_'+k+'" value="'+k+'" onchange="saveBundleManualOrder(this.value)" />'
                            +'</td>'
							+'<td>'+bundle_name+'</td>'
                            +'<td class="text-left subsOptions">'+subscriptionTxt+' ('+subscription_planTxt+')</td>'
							
                            +'<td class="text-right"><input type="hidden" id="base_price" value="'+response.bundle_price+'" />$ <span id="bundlePriceLbl">'+response.bundle_price+'</span></td>'+fields+'</tr>';
                k++;
              // }
               //console.log(html);
               $('#productsListTabl').show();
               $('#tblExamProducts tbody').html(html);
               //remove loader
               $('#imgLoader').remove();
				
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {        
        var options = '<option value="">Select Bundle</option>';
        $('#bundle_id').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }
}

function loadBundleProducts(bundleId){  
   var bundle_type = $("#bundle_type option:selected").val();  
    if (bundleId > 0) {
        
        var URL = BASE_URL + 'admin/bundles/getBundleProducts';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {bid: bundleId,btype:bundle_type},
            dataType: 'json',
            beforeSend: function () {
                $('#tblExamProducts tbody').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
               // alert(response.bundle_subscription_options[0].subscription_options);

                var html = '';
                var extraOptions = '';
                var k=1;
                var orderSubTotal = 0;
                var itemSubPlan = 1;
                var itemSubPeriod = 3;
                for (var i = 0; i < response.products.length; i++) {
                   var price = 0;   
                   var qty = 1;
                   var discount = 0;

                   //prepare bundle subscription options
                    var subTypes = '';
                    var subOptions = '';
                    if(response.bundle_subscription_options.length > 0) {
                        subTypes = '<div class="col-md-6 pdLeft0"><select id="subscription_plan" name="subscription_plan" class="form-control" onchange="ChangePriceByType(this.value,'+k+');">';
                                    for (var st = 0; st < response.bundle_subscription_options.length; st++) {
                                        subTypes +='<option value="'+response.bundle_subscription_options[st].subscription_type+'">'+response.bundle_subscription_options[st].name+'</option>';
                                    }                                                                      
                                subTypes +='</select></div>';

                        if (response.bundle_subscription_options[0].subscription_options.length > 0){
                            var subscription_options = JSON.parse(response.bundle_subscription_options[0].subscription_options);
                               price = subscription_options[0].price;
                                //alert(subscription_options.length);
                            subOptions = '<div class="col-md-6 pdLeft0"><select id="subscription_options" name="subscription_options" class="form-control" onchange="ChangePriceByMonth(this.value,'+k+');">';
                                        for(n=0; n < subscription_options.length ; n++){
                                                subOptions+='<option value="'+subscription_options[n].days+':'+subscription_options[n].price+'">'+subscription_options[n].days+'</option>';
                                            }
                                        subOptions+='</select></div>';
                        }    
                        //generate other options dropdown

                                                               
                        
                        for (var a = 0; a < response.bundle_subscription_options.length; a++) {
                            extraOptions += '<div style="display:none;" id="sub_options_container_'+response.bundle_subscription_options[a].subscription_type+'">';
                            var subscription_options = JSON.parse(response.bundle_subscription_options[a].subscription_options);
                            for(m=0; m < subscription_options.length ; m++){
                                extraOptions+='<option value="'+subscription_options[m].days+':'+subscription_options[m].price+'">'+subscription_options[m].days+'</option>';
                            }
                            extraOptions+='</div>';
                        }
                    }

                    //alert(extraOptions);
                   //build hidden fields
                   var fields = '<input type="hidden" id="ptypeId_'+k+'" name="ptypeId_'+k+'" value="'+response.products[i].type_id+'" />';
                       fields +='<input type="hidden" id="productName_'+k+'" name="productName_'+k+'" value="'+response.products[i].ptName+'" />';
                       fields +='<input type="hidden" id="productQty_'+k+'" name="productQty_'+k+'" value="'+qty+'" />';
                       fields +='<input type="hidden" id="productPrice_'+k+'" name="productPrice_'+k+'" value="'+price+'" />';
                       fields +='<input type="hidden" id="productDiscount_'+k+'" name="productDiscount_'+k+'" value="'+discount+'" />';
                       fields +='<input type="hidden" id="itemSubPlan_'+k+'" name="itemSubPlan_'+k+'" value="'+itemSubPlan+'" />';
                       fields +='<input type="hidden" id="itemSubPeriod_'+k+'" name="itemSubPeriod_'+k+'" value="'+itemSubPeriod+'" />';
                       fields +='<input type="hidden" id="productId_'+k+'" name="productId_'+k+'" value="'+response.products[i].id+'" />';
                       
                    html += '<tr id="pTypeRow_'+response.products[i].id+'">'
                            +'<td class="text-center">'
                                +extraOptions+'<input type="checkbox" id="add_order_'+k+'" name="add_order_'+k+'" value="'+k+'" onchange="saveManualOrder(this.value)" />'
                            +'</td>'
                            +'<td>'+response.products[i].ptName+'</td>'
                            +'<td class="text-center">'+subTypes+subOptions+'</td>'
                            +'<td class="text-right">$ <span id="bundlePriceLbl">'+price+'</span></td>'+fields+'</tr>';
                k++;
               }
               //console.log(html);
               $('#productsListTabl').show();
               $('#tblExamProducts tbody').html(html);
               //remove loader
               $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {        
        $('#tblExamProducts tbody').html('');
        $('#productsListTabl').hide();
        //remove loader
        $('#imgLoader').remove();
    }
}

function ChangePriceByMonth(value,rowNumber){
    var subOptions = value.split(':');
    var days = subOptions[0];
    var price = subOptions[1];
    
    var plan_type = $("#subscription_plan").val();
    
    //update price
    $("#bundlePriceLbl").html(price);
    $("#productPrice_"+rowNumber+"").val(price);
    $("#itemSubPlan_"+rowNumber+"").val(plan_type);
    $("#itemSubPeriod_"+rowNumber+"").val(days);
}


function ChangePriceByType(user_plan,rowNumber){

    var subscription_options = $('#sub_options_container_'+user_plan).html();

    //update options
    $('#subscription_options').html(subscription_options);

    var month_val = $("#subscription_options").val();

    var subOptions = month_val.split(':');
    var price = subOptions[1];
    var days = subOptions[0];

    //update price
    $("#bundlePriceLbl").html(price);
    $("#productPrice_"+rowNumber+"").val(price);
    $("#itemSubPlan_"+rowNumber+"").val(user_plan);
    $("#itemSubPeriod_"+rowNumber+"").val(days);
}

$.fn.cleanWhitespace = function() {
    textNodes = this.contents().filter(
        function() { return (this.nodeType == 3 && !/\S/.test(this.nodeValue)); })
        .remove();
    return this;
}


function checkIfAvailable(controller,field,value,field_id,itemid)
{
	if(value)
	{
		var data = {'field':field,'value':value,'itemid':itemid};
		var URL = BASE_URL + 'admin/'+controller+'/checkIfAvailable';
		$.ajax({
			type: 'POST',
			url: URL,
			data: data,
			dataType: 'json',
			success: function (response) {
				if (response.msgStatus == 'Error') {
					if(field_id == 'name' && controller == 'certifications')
					{
						$('#'+field_id).css('border', '1px solid #cc3f44');
						$('.validate-has-error2').remove();
						var errorHtml = '<span id="exists-error" class="validate-has-error2">Certification Title already exists! Pleae enter differnt one.</span>';
						$('#check_name').val('1');
						$('#'+field_id).after(errorHtml);						
					}
					if(field_id == 'email' && controller == 'users')
					{
						$('#'+field_id).css('border', '1px solid #cc3f44');
						$('.validate-has-error2').remove();
						var errorHtml = '<span id="exists-error" class="validate-has-error2">User Email already exists! Pleae enter differnt one.</span>';
						$('#check_email').val('1');
						$('#'+field_id).after(errorHtml);						
					}
					if(field_id == 'name' && controller == 'attributes')
					{
						$('#'+field_id).css('border', '1px solid #cc3f44');
						$('.validate-has-error2').remove();
						var errorHtml = '<span id="exists-error" class="validate-has-error2">This Product Format already added!</span>';
						$('#check_productformat').val('1');
						$('#'+field_id).after(errorHtml);						
					}
					if(field_id == 'name' && controller == 'exams')
					{
						$('#'+field_id).css('border', '1px solid #cc3f44');
						$('.validate-has-error4').remove();
						var errorHtml = '<span id="exists-error" class="validate-has-error4">Exam Name already exists! Pleae enter differnt one.</span>';
						$('#check_name').val('1');
						$('#'+field_id).after(errorHtml);						
					}
					if(field_id == 'cert_shortname')
					{
						$('#'+field_id).css('border', '1px solid #cc3f44');
						$('.validate-has-error3').remove();
						var errorHtml = '<span id="exists-error" class="validate-has-error3">Certification Short Name already exists! Pleae enter differnt one.</span>';
						$('#check_shortname').val('1');
						$('#'+field_id).after(errorHtml);						
					}
					if(field_id == 'exam_code')
					{
						$('#'+field_id).css('border', '1px solid #cc3f44');
						$('.validate-has-error5').remove();
						var errorHtml = '<span id="exists-error" class="validate-has-error5">Exam Code already exists! Pleae enter differnt one.</span>';
						$('#check_examcode').val('1');
						$('#'+field_id).after(errorHtml);						
					}
				
				} else if (response.msgStatus == 'Success') {
					if(field_id == 'name' && controller == 'certifications')
					{
						$('.validate-has-error2').remove();
						$('#'+field_id).css('border','1px solid #e4e4e4');
						$('#check_name').val('0');
					}
					if(field_id == 'email' && controller == 'users')
					{
						$('.validate-has-error2').remove();
						$('#'+field_id).css('border','1px solid #e4e4e4');
						$('#check_email').val('0');					
					}
					if(field_id == 'name' && controller == 'attributes')
					{
						$('.validate-has-error2').remove();
						$('#'+field_id).css('border','1px solid #e4e4e4');
						$('#check_productformat').val('0');					
					}
					if(field_id == 'name' && controller == 'exams')
					{
						$('.validate-has-error4').remove();
						$('#'+field_id).css('border','1px solid #e4e4e4');
						$('#check_name').val('0');
					}
					if(field_id == 'cert_shortname')
					{
						$('.validate-has-error3').remove();
						$('#'+field_id).css('border','1px solid #e4e4e4');
						$('#check_shortname').val('0');
					}
					if(field_id == 'exam_code')
					{
						$('.validate-has-error5').remove();
						$('#'+field_id).css('border','1px solid #e4e4e4');
						$('#check_examcode').val('0');
					}
					
				}
			},
			error: function () {
				console.log('something went wrong please try again');
			}
		});
	}
}

function checkIfAttrAvailable(controller,field,value,field_id,type,itemid)
{
	if(value)
	{
		var data = {'field':field,'value':value,'itemid':itemid,'type':type};
		var URL = BASE_URL + 'admin/'+controller+'/checkIfAttrAvailable';
		$.ajax({
			type: 'POST',
			url: URL,
			data: data,
			dataType: 'json',
			success: function (response) {
				if (response.msgStatus == 'Error') {
					if(field_id == 'name' && type == 'level')
					{
						$('#'+field_id).css('border', '1px solid #cc3f44');
						$('.validate-has-error2').remove();
						var errorHtml = '<span id="exists-error" class="validate-has-error2">Level Name already exists! Pleae enter differnt one.</span>';
						$('#check_name').val('1');
						$('#'+field_id).after(errorHtml);						
					}
					if(field_id == 'name' && type == 'audience')
					{
						$('#'+field_id).css('border', '1px solid #cc3f44');
						$('.validate-has-error2').remove();
						var errorHtml = '<span id="exists-error" class="validate-has-error2">Audience already exists! Pleae enter differnt one.</span>';
						$('#check_name').val('1');
						$('#'+field_id).after(errorHtml);						
					}
					if(field_id == 'name' && type == 'tech')
					{
						$('#'+field_id).css('border', '1px solid #cc3f44');
						$('.validate-has-error2').remove();
						var errorHtml = '<span id="exists-error" class="validate-has-error2">Technology already exists! Pleae enter differnt one.</span>';
						$('#check_name').val('1');
						$('#'+field_id).after(errorHtml);						
					}
				} else if (response.msgStatus == 'Success') {
					if(field_id == 'name')
					{
						$('.validate-has-error2').remove();
						$('#'+field_id).css('border','1px solid #e4e4e4');
						$('#check_name').val('0');
					}	
				}
			},
			error: function () {
				console.log('something went wrong please try again');
			}
		});
	}
}

function getVendorCerts(value)
{
	var restoreTxt = getOldHtml('examsInfMsg');
    var data = {'vendor_id':value};
    var URL = BASE_URL + 'admin/slug/getVendorCerts';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            $('.recordsDiv').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
			$('#imgLoader').remove();
			console.log(response);
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                $('.recordsDiv').html(response.data);
				
				$("#selectAllRecords").click(function(){
					$('tr td input:checkbox').not(this).prop('checked', this.checked);
				});
	
				$('tr td input:checkbox').click(function(){
					if($('tr td input:checkbox').not(':checked').length){
					  $("#selectAllRecords").prop('checked', false);
					}
				});
            }
        },
        error: function () {
			$('#imgLoader').remove();
            alert('something went wrong please try again');
        }
    });
}

function getVendorExams(value)
{
    var data = {'vendor_id':value};
    var URL = BASE_URL + 'admin/slug/getVendorExams';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            $('.recordsDiv').before(function () {
                return getLoadingImg();
            });
        },
        success: function (response) {
			$('#imgLoader').remove();
			console.log(response);
            if (response.msgStatus == 'Error') { //if failed
                displayMessage('examsInfMsg', 'danger', response.msgText, restoreTxt);
            } else if (response.msgStatus == 'Success') { //if failed
                $('.recordsDiv').html(response.data);
				
				$("#selectAllRecords").click(function(){
					$('tr td input:checkbox').not(this).prop('checked', this.checked);
				});
	
				$('tr td input:checkbox').click(function(){
					if($('tr td input:checkbox').not(':checked').length){
					  $("#selectAllRecords").prop('checked', false);
					}
				});
            }
        },
        error: function () {
			$('#imgLoader').remove();
            alert('something went wrong please try again');
        }
    });
}

function showFields(val)
{
		if(val == 1)
		{
			$('.couponPercentBox').hide();
			$('.couponAmountBox').show();
		}
		else if(val == 2)
		{
			$('.couponAmountBox').hide();
			$('.couponPercentBox').show();
		}
		else if(val == '')
		{
			$('.couponAmountBox').hide();
			$('.couponPercentBox').hide();
		}
		
	}

function array_diff(array1, array2){
    var difference = $.grep(array1, function(el) { return $.inArray(el,array2) < 0});
    return difference.concat($.grep(array2, function(el) { return $.inArray(el,array1) < 0}));;
}

function showCouponType(selectedVal)
{
	if(selectedVal == 1)
	{
			$('.multiCoupon ').hide();
			$('.singleCoupon').show();
			$('#btnCouponSubmit').removeAttr('disabled');
			
			$('.multiCoupon input').attr('disabled','disabled');
			$('.multiCoupon select').attr('disabled','disabled');
			
			$('.singleCoupon input').removeAttr('disabled');
			$('.singleCoupon select').removeAttr('disabled');
			
	}
	
	if(selectedVal == 2)
	{
			$('.singleCoupon').hide();
			$('.multiCoupon ').show();
			$('#btnCouponSubmit').removeAttr('disabled');
			
			$('.singleCoupon input').attr('disabled','disabled');
			$('.singleCoupon select').attr('disabled','disabled');
			
			$('.multiCoupon input').removeAttr('disabled');
			$('.multiCoupon select').removeAttr('disabled');
	}
	
	if(selectedVal == '')
	{
			$('.multiCoupon ').hide();
			$('.singleCoupon').hide();
			$('#btnCouponSubmit').attr('disabled','disabled');
	}
}

function getPageTypeItems(selected_item)
{
	$('.preorderTxt').hide();
	if(selected_item == 'vendors' || selected_item == 'certifications' || selected_item == 'exams')
	{
		$('.hideIfnotStatic').hide();
		if(selected_item == 'vendors')
		{
			$('.vendorsSlugExample').show();
		}
		else{
			$('.vendorsSlugExample').hide();
		}
		if(selected_item == 'certifications')
		{
			$('.certSlugExample').show();
		}
		else{
			$('.certSlugExample').hide();
		}
		if(selected_item == 'exams')
		{
			$('.examsSlugExample').show();
			$('.preorderTxt').show();
		}
		else{
			$('.examsSlugExample').hide();
			$('.preorderTxt').hide();
		}
		$('.showIfnotStatic').show();
	}
	else
	{
		$('.showIfnotStatic').hide();
		$('.hideIfnotStatic').show();
		
	}
	
	if(selected_item == 'certifications' || selected_item == 'exams')
	{
		$('.vendorContainer').show();
	}
	else
	{
		$('.vendorContainer').hide();
	}
	
	if(selected_item == 'exams')
	{
		$('#formatContainer').show();
		$('#certsContainer').show();
	}
	else
	{
		$('#formatContainer').hide();
		$('#certsContainer').hide();
	}
	
	
	
	var slugManagementLink = '';
	var selected_text = $('#page_type option:selected').text();
	if(selected_item == 'certifications')
	{
		var slugManagementLink = BASE_URL + 'admin/slug/certs';
	}
	if(selected_item == 'exams')
	{
		var slugManagementLink = BASE_URL + 'admin/slug/exams';
	}
	if(selected_item == 'vendors')
	{
		var slugManagementLink = BASE_URL + 'admin/slug/vendors';
	}
	
	if(selected_item == '')
	{
		var slugManagementLink = BASE_URL + 'admin/slug/';
		$('#slugManagementLink').attr('href',slugManagementLink);
		$('#slugManagementLink').html('Slug Management');
		$('.selectedPageType').html('');
	}
	else
	{
		$('#slugManagementLink').attr('href',slugManagementLink);
		$('#slugManagementLink').html(selected_text+' Slug Management');
		$('.selectedPageType').html(selected_text);
	}

		
	
	
	
	
	if(selected_item == 'pages' || selected_item == 'post')
	{
		$('.hideifPage').hide();
	}
	else
	{
		$('.hideifPage').show();
	}
	if (selected_item) {
		$('#pageTypeItemLbl').html('Select '+selected_text);
        var URL = BASE_URL + 'admin/pages/getPageTypeItems';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {selected_item: selected_item},
            dataType: 'json',
            beforeSend: function () {
                $('#page_type_item_id').before(function () {
                    return getLoadingImg();
                });
            },
            success: function (response) {
                var options = '<option value="">Select '+selected_text+'</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                }
                $('#page_type_item_id').find('option').remove().end().append(options);
				$("#page_type_item_id").select2({
					allowClear: true
				}).on('select2-open', function()
				{
					// Adding Custom Scrollbar
					$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
				});
                //remove loader
                $('#imgLoader').remove();
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
		$("#page_type_item_id").select2({
			allowClear: true
		}).on('select2-open', function()
			{
			// Adding Custom Scrollbar
			$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
		});
        var options = '';
        $('#page_type_item_id').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }
}

function checkIfPageAlreadyExists(formId,controller)
{
	var restoreTxt = getOldHtml('examsInfMsg');
	 var data = $('#' + formId).serialize();
	 var URL = BASE_URL + 'admin/'+controller+'/checkIfPageAlreadyExists';
    $.ajax({
        type: 'POST',
        url: URL,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            toggleDisable('btnPageSubmit', true);
        },
        success: function (response) {
            if (response.msgStatus == 'Error') { //if failed
				$('#same_page').val(1);
				$('#pageAlreadyExistMsg').html(response.msgText);
				$('#pageAlreadyExistMsg').show();
            } else if (response.msgStatus == 'Success') { //if Success
				$('#pageAlreadyExistMsg').hide();
				$('#same_page').val(0);
            }
            toggleDisable('btnPageSubmit', false);
        },
        error: function () {
            alert('something went wrong please try again');
            toggleDisable('btnPageSubmit', false);
        }
    });
}

function checkSelUserType(val)
{
	if(val == 1)
	{
		$('.userPermissions input').attr('disabled','disabled');
	}
	else
	{
		$('.userPermissions input').removeAttr('disabled');
	}
	
}

function changeWidgetOptions(widgetType)
{
	if(widgetType != 'html')
	{
		$('.hideifNotStatic').hide();
		$('.hideifStatic').show();
		
		if(widgetType != 'exam' && widgetType == 'cert')
		{
			$('.includeVendors').show();
			$('.includeCerts').hide();
		}
		else if(widgetType != 'exam' && widgetType != 'cert')
		{
			$('.includeVendors').hide();
			$('.includeCerts').hide();
		}
		else if(widgetType == 'exam' && widgetType != 'cert')
		{
			$('.includeVendors').show();
			$('.includeCerts').show();
		}
	}
	else
	{
		$('.hideifStatic').hide();
		$('.hideifNotStatic').show();
		$('.includeVendors').hide();
		$('.includeCerts').hide();
		$('.widgetDateType').hide();
	}
}

function getUserPracticeExams(user_id)
{
	$('#examExt').attr('onchange','return selectOrderID(this.value);');
	$('#exam').attr('onchange','return selectOrderID(this.value);');
	
	getUserPracticeExamsOrders(user_id);
	
	var email = $('#user_idExt option:selected').text();
	var user = $('#user_idExt option:selected').val();
	
	var email2 = $('#user_id option:selected').text();
	var user2 = $('#user_id option:selected').val();
	if(user == user_id)
	{
		$('#user').val(email);
	}
	if(user2 == user_id)
	{
		$('#user').val(email2);
	}

	
	if (user_id > 0) {
        var URL = BASE_URL + 'admin/orders/getUserPracticeExams';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {user_id: user_id},
            dataType: 'json',
            beforeSend: function () {
				$('#exam').before(function () {
                    return getLoadingImg();
                });
			},
            success: function (response) {
				console.log(response);
				if(response.msgStatus == 'Success')
				{
					var options = '<option value="">Select Practice Exam</option>';
					var resData = response.data;
					for (var i = 0; i < resData.length; i++) {
						options += '<option value="' + resData[i].id + '">' + resData[i].name + '</option>';
					}
					$('#exam').find('option').remove().end().append(options);
					$('#examExt').find('option').remove().end().append(options);
					$('#imgLoader').remove();
					
					$("#examExt").select2({
                                    placeholder: 'Select Practice Exam',
                                    allowClear: true
                                }).on('select2-open', function ()
                                {
                                    // Adding Custom Scrollbar
                                    $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                                });
								
					$("#exam").select2({
                                    placeholder: 'Select Practice Exam',
                                    allowClear: true
                                }).on('select2-open', function ()
                                {
                                    // Adding Custom Scrollbar
                                    $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                                });
					
					$("#order_id").select2({
                                    placeholder: 'Select Customer Order',
                                    allowClear: true
                                }).on('select2-open', function ()
                                {
                                    // Adding Custom Scrollbar
                                    $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                                });
					
					$("#order_idExt").select2({
                                    placeholder: 'Select Customer Order',
                                    allowClear: true
                                }).on('select2-open', function ()
                                {
                                    // Adding Custom Scrollbar
                                    $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                                });
					
					
				}
				else
				{
					var options = '<option value="">There is no Practice Exam order found for selected User please add first.</option>';
					
					$('#exam').find('option').remove().end().append(options);
					$('#examExt').find('option').remove().end().append(options);
					$('#imgLoader').remove();
				}
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
		var options = '';
		$('#exam').find('option').remove().end().append(options);
		$('#examExt').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }	
}

function getUserOrderPracticeExams(order_id)
{
	$('#examExt').removeAttr('onchange');
	$('#exam').removeAttr('onchange');
	
	var email = $('#user_idExt option:selected').text();
	var user = $('#user_idExt option:selected').val();
	
	var email2 = $('#user_id option:selected').text();
	var user2 = $('#user_id option:selected').val();
	if(user == user_id)
	{
		$('#user').val(email);
	}
	if(user2 == user_id)
	{
		$('#user').val(email2);
	}

	
	if (order_id) {
        var URL = BASE_URL + 'admin/orders/getUserOrderPracticeExams';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {order_id: order_id},
            dataType: 'json',
            beforeSend: function () {
				$('#exam').before(function () {
                    return getLoadingImg();
                });
			},
            success: function (response) {
				console.log(response);
				if(response.msgStatus == 'Success')
				{
					var options = '<option value="">Select Practice Exam</option>';
					var resData = response.data;
					for (var i = 0; i < resData.length; i++) {
						options += '<option value="' + resData[i].id + '">' + resData[i].name + '</option>';
					}
					$('#exam').find('option').remove().end().append(options);
					$('#examExt').find('option').remove().end().append(options);
					$('#imgLoader').remove();
					
					$("#examExt").select2({
                                    placeholder: 'Select Practice Exam',
                                    allowClear: true
                                }).on('select2-open', function ()
                                {
                                    // Adding Custom Scrollbar
                                    $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                                });
								
					$("#exam").select2({
                                    placeholder: 'Select Practice Exam',
                                    allowClear: true
                                }).on('select2-open', function ()
                                {
                                    // Adding Custom Scrollbar
                                    $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                                });
				}
				else
				{
					var options = '<option value="">There is no Practice Exam order found for selected User please add first.</option>';
					
					$('#exam').find('option').remove().end().append(options);
					$('#examExt').find('option').remove().end().append(options);
					$('#imgLoader').remove();
				}
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
		var options = '';
		$('#exam').find('option').remove().end().append(options);
		$('#examExt').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }		
}

function selectOrderID(exam_code)
{
	var email = $('#user_idExt option:selected').text();
	var user_id = $('#user_idExt option:selected').val();
	
	var email2 = $('#user_id option:selected').text();
	var user_id2 = $('#user_id option:selected').val();
	
	var user = $('#user').val();
	
	if(user == email)
	{
		user_id = user_id;
	}
	if(user == email2)
	{
		user_id = user_id2;
	}
	
	if (exam_code) {
        var URL = BASE_URL + 'admin/orders/getPracticeExamOrderID';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {exam_code: exam_code,user_id:user_id},
            dataType: 'json',
            success: function (response) {
				console.log(response);
				if(response.msgStatus == 'Success')
				{
					var resData = response.data;
					var order_id = resData.order_id;

						$('#order_idExt').val(order_id);
						$("#order_idExt").select2({
                                    placeholder: 'Select Customer Order',
                                    allowClear: true
                                }).on('select2-open', function ()
                                {
                                    // Adding Custom Scrollbar
                                    $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                         });
		
					$('#order_id').val(order_id);			
					$("#order_id").select2({
                                    placeholder: 'Select Customer Order',
                                    allowClear: true
                                }).on('select2-open', function ()
                                {
                                    // Adding Custom Scrollbar
                                    $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                                });
				}
				
				
            },
            error: function () {
                //alert('something went wrong please try again');
                //remove loader
                //$('#imgLoader').remove();
            }
        });
    }
}

function getUserPracticeExamsOrders(user_id)
{
	var email = $('#user_idExt option:selected').text();
	var user = $('#user_idExt option:selected').val();
	
	var email2 = $('#user_id option:selected').text();
	var user2 = $('#user_id option:selected').val();
	if(user == user_id)
	{
		$('#user').val(email);
	}
	if(user2 == user_id)
	{
		$('#user').val(email2);
	}

	
	if (user_id > 0) {
        var URL = BASE_URL + 'admin/orders/getUserPracticeExamsOrders';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {user_id: user_id},
            dataType: 'json',
            beforeSend: function () {
				$('#order_idExt').before(function () {
                    return getLoadingImg();
                });
			},
            success: function (response) {
				console.log(response);
				if(response.msgStatus == 'Success')
				{
					var options = '<option value="">Select Order ID</option>';
					var resData = response.data;
					for (var i = 0; i < resData.length; i++) {
						options += '<option value="' + resData[i].order_id + '">' + resData[i].order_id + '</option>';
					}
					$('#order_id').find('option').remove().end().append(options);
					$('#order_idExt').find('option').remove().end().append(options);
					$('#imgLoader').remove();
				}
				else
				{
					var options = '<option value=""></option>';
					
					$('#order_id').find('option').remove().end().append(options);
					$('#order_idExt').find('option').remove().end().append(options);
					$('#imgLoader').remove();
				}
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
		var options = '';
		$('#order_id').find('option').remove().end().append(options);
		$('#order_idExt').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }	
}

function getPracticeExamKeys(practice_exam)
{
	if (practice_exam) {
		//alert(practice_exam);
        var URL = BASE_URL + 'admin/orders/getPracticeExamKeys';
        $.ajax({
            type: 'POST',
            url: URL,
            data: {practice_exam: practice_exam},
            dataType: 'json',
            beforeSend: function () {
				$('#lisence_keysExt').before(function () {
                    return getLoadingImg();
                });
			},
            success: function (response) {
				console.log(response);
				if(response.msgStatus == 'Success')
				{
					var options = '<option value="">Select Lisence Keys to Extend</option>';
					var resData = response.data;
					for (var i = 0; i < resData.length; i++) {
						options += '<option value="' + resData[i].id + '">' + resData[i].name + '</option>';
					}
					$('#lisence_keysExt').find('option').remove().end().append(options);
					$('#imgLoader').remove();
					 $("#lisence_keysExt").select2({
                                    placeholder: 'Select Lisence Keys to Extend',
                                    allowClear: true
                                }).on('select2-open', function ()
                                {
                                    // Adding Custom Scrollbar
                                    $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                                });
				}
				else
				{
					var options = '<option value="">There is no Lisence Key found for selected Practice Exam please add first.</option>';
					
					$('#lisence_keysExt').find('option').remove().end().append(options);
					$('#imgLoader').remove();
					 $("#lisence_keysExt").select2({
                                    placeholder: 'Select Lisence Keys to Extend',
                                    allowClear: true
                                }).on('select2-open', function ()
                                {
                                    // Adding Custom Scrollbar
                                    $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                                });
				}
				
            },
            error: function () {
                alert('something went wrong please try again');
                //remove loader
                $('#imgLoader').remove();
            }
        });
    } else {
		var options = '';
		$('#lisence_keysExt').find('option').remove().end().append(options);
        //remove loader
        $('#imgLoader').remove();
    }	
}


$(document).ready(function(){
	
	/* $('#preorder').change(function(){
		if($('#preorder').val() == 0)
		{
			$('.hideifNotPreorder').show();
		}
		else
		{
			$('.hideifNotPreorder').hide();
		}
	}) */
	
	$('#check_criteria2').click(function() {
		if($("#check_criteria2").is(':checked'))
		{
			$(".widgetDateType").show();  // checked
		}
		else
		{
			$(".widgetDateType").hide();
		}
			
	});
	
	$('#orderData_form #discount').keypress(function(){
		setTimeout(function(){
		 var discountVal = $('#orderData_form #discount').val();
		 if ($.isNumeric(discountVal)) {
		   //alert(discountVal);
				$('#orderDiscountContainer').html(discountVal);
				$('#orderDiscount').val(discountVal);
				var totalOrder = $('#orderSubTotal').val();
				totalOrder = totalOrder - discountVal;
				$('#orderTotal').val(totalOrder);
				$('#orderTotalContainer').html(totalOrder);
				$('#btnManualOrderSubmit').removeAttr('disabled');
			}
		}, 200);
	})
	
	$('#orderData_form #discount_per').keypress(function(){
		setTimeout(function(){
		 var discountVal = $('#orderData_form #discount_per').val();
		 if ($.isNumeric(discountVal)) {
		   //alert(discountVal);
		   var totalOrder = $('#orderSubTotal').val();
		   var discount_amount = totalOrder * discountVal / 100;
				$('#orderData_form #discount').val(discount_amount);
				$('#orderDiscountContainer').html(discount_amount);
				$('#orderDiscount').val(discount_amount);
				totalOrder = totalOrder - discount_amount;
				$('#orderTotal').val(totalOrder);
				$('#orderTotalContainer').html(totalOrder);
				$('#btnManualOrderSubmit').removeAttr('disabled');
			}
		}, 200);
	})
	
	$('#orderData_form #discount_per').click(function(){
		setTimeout(function(){
		 var discountVal = $('#orderData_form #discount_per').val();
		 if ($.isNumeric(discountVal)) {
		   //alert(discountVal);
		   var totalOrder = $('#orderSubTotal').val();
		   var discount_amount = totalOrder * discountVal / 100;
				$('#orderData_form #discount').val(discount_amount);
				$('#orderDiscountContainer').html(discount_amount);
				$('#orderDiscount').val(discount_amount);
				totalOrder = totalOrder - discount_amount;
				$('#orderTotal').val(totalOrder);
				$('#orderTotalContainer').html(totalOrder);
				$('#btnManualOrderSubmit').removeAttr('disabled');
			}
		}, 200);
	})
	
})

function chooseSerialKeyOrderType(val)
{
	if(val)
	{
		if(val == 'adding_lisence')
		{
			$('#extLisenceKeys').hide();
			$('#addingLisenceKeys').show();
			$('.hideDefault').show();
		}
		if(val == 'extension')
		{
			$('#addingLisenceKeys').hide();
			$('#extLisenceKeys').show();
			$('.hideDefault').show();
		}
		$('#btnManualOrderSubmit').removeAttr('disabled');
	}
	else
	{
		$('.hideDefault').hide();
		$('#addingLisenceKeys').hide();
		$('#extLisenceKeys').hide();
	}
}

function validateInteger(event) {
    var key = window.event ? event.keyCode : event.which;

if (event.keyCode == 8 || event.keyCode == 46
 || event.keyCode == 37 || event.keyCode == 39) {
    return true;
}
else if ( key < 48 || key > 57 ) {
    return false;
}
else return true;
};

$('#perKeyPriceExt').click(function(){
	updateOrderPriceExt();
})

$('#noofkeysExt').change(function(){
	updateOrderPriceExt();
})

$('.hideDefault #discountExt').click(function(){
	updateOrderPriceExt();
})

$('#perKeyPrice').click(function(){
	updateOrderPrice();
})

$('#noofkeys').change(function(){
	updateOrderPrice();
})

$('.hideDefault #discount').click(function(){
	updateOrderPrice();
})




function updateOrderPriceExt()
{
	var price = $('#perKeyPriceExt').val();
	var qty = $('#noofkeysExt').val();
	var discount = $('#discountExt').val();
	if(discount == '')
	{
		discount = 0.00;
	}
	if(qty == '')
	{
		qty = 1;
	}
	
	var orderSubTotal = price * qty;
	var orderTotal = orderSubTotal - discount;
	
	$('#orderSubTotal').html(orderSubTotal);
	$('#order_sub_total').val(orderSubTotal);
	$('#orderDiscount').html(discount);
	$('#orderTotal').html(orderTotal);
	$('#total_amount').val(orderTotal);
	
}

function updateOrderPrice()
{
	var price = $('#perKeyPrice').val();
	var qty = $('#noofkeys').val();
	var discount = $('#discount').val();
	if(discount == '')
	{
		discount = 0.00;
	}
	if(qty == '')
	{
		qty = 1;
	}
	
	var orderSubTotal = price * qty;
	var orderTotal = orderSubTotal - discount;
	
	$('#orderSubTotal').html(orderSubTotal);
	$('#order_sub_total').val(orderSubTotal);
	$('#orderDiscount').html(discount);
	$('#orderTotal').html(orderTotal);
	$('#total_amount').val(orderTotal);
	
}

$(".radioOptions input[name='slug_type']").click(function() {
   if($('#slug_type3').is(':checked')) { $('.hideifnotBoth').show(); } else { $('.hideifnotBoth').hide(); }
});


function updateAdminBundlePrice(){
	
	var key = $('#rand_key_id').val();
	var subscription = $('#subscription').val();
	var subscription_plan = $('#subscription_plan').val();
	
	var subscription_planTxt = $("#subscription_plan option:selected").text();
	var subscriptionTxt = $("#subscription option:selected").text();
	
	var price = $('#base_price').val();

	var subscription_price_3_inc = $('#subscription_price_3_inc').val();
	var subscription_price_6_inc = $('#subscription_price_6_inc').val();
	var subscription_price_12_inc = $('#subscription_price_12_inc').val();

	var individual_price_inc = $('#individual_price_inc').val();
	var corporate_price_inc = $('#corporate_price_inc').val();
	var trainer_price_inc = $('#trainer_price_inc').val();
	
	price = parseInt(price) + parseInt($('#subscription_price_'+subscription+'_inc').val());
	price = parseInt(price) + parseInt($('#'+subscription_plan+'_price_inc').val());
	
	$('#bundlePriceLbl').html(price);
	$('#productPrice_'+key).val(price);
	
	$('#itemSubPlan_'+key).val(subscription_plan);
	$('#itemSubPeriod_'+key).val(subscription);
	
	
	$('.subsOptions').html(subscriptionTxt+' ('+subscription_planTxt+')');
	
}




$(document).ready(function(){
	$('#check_criteria1').click(function() {
			if($("#check_criteria1").is(':checked'))
			{
				$(".widgetSortType").show();  // checked
			}
			else
			{
				$(".widgetSortType").hide();
			}
				
	});
})

