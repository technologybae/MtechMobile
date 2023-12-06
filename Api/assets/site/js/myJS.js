$(document).ready(function (){	
	
		
	
	$(".cust-ddl").hover(
		function(){
			$(this).css("z-index", "2");
			$(".overlay").stop().fadeIn("fast");
			$(this).children(".cust-ddl-detail").stop().fadeIn("slow");
		},
		function(){
			$(this).css("z-index", "0");
			$(".overlay").fadeOut("slow");
			$(this).children(".cust-ddl-detail").fadeOut("fast");
			$(".cust-ddl-detail-nav a").removeClass("active");
			$(".sub-nav").children(".sub-nav-detail").hide();
		}
	);
	
	$(".cust-ddl-detail-nav a").hover(
		function(){
			$(".cust-ddl-detail-nav a").removeClass("active");
			$(".sub-nav").children(".sub-nav-detail").hide();
			
			$(this).addClass("active");
			var activeTab = $(this).attr("data-url");
			if(activeTab !="")
			{
				$("#"+ activeTab).fadeIn("fast");
				if($(window).width()>768)
					$(".sub-nav").animate({width: '470px'},500);
				else
					$(".sub-nav").animate({width: '100%'},500);
			}
			else{
				$(".sub-nav").css("width","1");
			}
		},
		function(){
		}
	);
	
	$(".hot-ms-tab").click(
		function(){
			
			$(".hot-ms-cert-nav-detail").slideUp(400);
			$(this).parent("div").children(".hot-ms-cert-nav-detail").slideDown(1000);
			
			if($(this).children("a").text() == '∨'){
				$(this).children("a").html(">");
			}
			else{
				$(this).children("a").html("∨");
			}
		
	});
	$(".new-release-header a").click(function(){
		$(this).parent("div").children("a").removeClass("active");
		$(this).addClass("active"); 
		var currentActive = $(this).attr("data-url");
		$(".ms-tabs").children("div").transition({ scale: 0, delay: 200 });
		$(".ms-tabs").children("div").hide(100);
		$(".ms-tabs").children("#"+currentActive).show(100);
		$(".ms-tabs").children("#"+currentActive).transition({ scale: 1, delay: 100 });
		
		//data-detail	
	});
	
	$(".selectAll").click(
		function(){
			if($(this).children(".checkbox-cust").attr("checked") != "checked")
				$(".checkbox-cust").attr('checked', 'checked');
			else
				$(".checkbox-cust").removeAttr('checked', 'checked');
		
	});
	
	$(".option-list").click(
		function(){
			if($(this).children(".checkbox-cust").attr("checked") != "checked")
				$(this).children(".checkbox-cust").attr('checked', 'checked');
			else
				$(this).children(".checkbox-cust").removeAttr('checked', 'checked');
			
		
	});
	
	$(".pay-method a").click(
		function(){
			var currentActive = $(this).attr("data-url");
			$("."+currentActive).children("input").attr('checked', 'checked');
			$(".pay-method a, .mobile-pay-pal a").removeClass("active");
				
			
			$("."+currentActive).addClass("active");
			$(".pay-method-container").children(".secure-bill-contents").transition({ scale: 0, delay: 200 });
			$(".pay-method-container").children(".secure-bill-contents").hide(100);
			$(".pay-method-container").children("#"+currentActive).show(100);
			$(".pay-method-container").children("#"+currentActive).transition({ scale: 1, delay: 100 });		
			$('html, body').animate({
				scrollTop: $(".pay-method-container").offset().top
			}, 1000);
	});
	$(".mobile-pay-pal a").click(
		function(){
			var flag=0;
			var currentActive = $(this).attr("data-url");
			$(".pay-method a, .mobile-pay-pal a").removeClass("active");
			
			if($("."+currentActive).children(".chkbx").attr('checked')=='checked')
			{
				flag=1;
				$("."+currentActive).children(".chkbx").removeAttr('checked');
			}
			else
			{
				$("."+currentActive).children("input").attr('checked', 'checked');
				$("."+currentActive).addClass("active");
				
			}
			
			
			$(".pay-method-container").children(".secure-bill-contents").transition({ scale: 0, delay: 200 });
			$(".pay-method-container").children(".secure-bill-contents").hide(100);
			if(flag==0)
			{
				$(".pay-method-container").children("#"+currentActive).show(100);
				$(".pay-method-container").children("#"+currentActive).transition({ scale: 1, delay: 100 });		
			}
			$('html, body').animate({
				scrollTop: $(".pay-method-container").offset().top
			}, 1000);
	});
	
	$(".desk-nav a, .desk-nav-mb a").click(
		function(){
			$(".desk-nav a, .desk-nav-mb a").removeClass("active");
				
			var currentActive = $(this).attr("data-url");
			$("."+currentActive).addClass("active");
			$(".desk-nav-detail").children(".desk-nav-detail-data").transition({ scale: 0, delay: 200 });
			$(".desk-nav-detail").children(".desk-nav-detail-data").hide(100);
			$(".desk-nav-detail").children("#"+currentActive).show(100);
			$(".desk-nav-detail").children("#"+currentActive).transition({ scale: 1, delay: 100 });		
			$('html, body').animate({
				scrollTop: $(".desk-nav-detail").offset().top
			}, 1000);
	});
	
	
	
	
});// JavaScript Document
$(document).ready(function (){	
	
		$(window).resize(function() {
				var widthScr = $(window).width();
			
				if(widthScr > 700) {
					$(".mobile-f-slide").show();
					$(".expand-f").html('+');
				}
				else{
					$(".mobile-f-slide").hide();
					$(".expand-f").html('+');
				}
				
			
				
	});
	$(".exam-box-outer").hover(
		function(){
			$(this).children(".exam-box").stop().transition({
				  perspective: '0px',
				  rotateY: '180deg'
				});
			$(this).children(".exam-box").stop().children(".exam-box-front").hide();
			$(this).children(".exam-box").stop().children(".exam-box-back").show();
			$(this).children(".exam-box").stop().children(".exam-box-back").transition({
				  perspective: '0px',
				  rotateY: '-180deg'
				});
			
		},
		function(){
			$(this).children(".exam-box").stop().transition({
				  perspective: '0px',
				  rotateY: '0deg'
				});
			$(this).children(".exam-box").stop().children(".exam-box-front").show();
			$(this).children(".exam-box").stop().children(".exam-box-back").hide();			
		}
	
	
	);
	$(".tooltip-hover").hover(
		function(){
			var left=($(this).width()/4);
			//$(this).children(".tooltip-cust").show();
			$(this).append("<div class='tooltip-cust'><div class='tooltip-cust-txt'>" + 
						  $(this).attr("tooltip") +	"<b></b></div></div>");
			$(".tooltip-cust").stop(200).css("left", left);
		},
		function(){
			$(this).children(".tooltip-cust").remove();		
		}
	
	
	);
	$(".my-account").hover(
		function(){
				$(this).stop().addClass("active");
				$(".sub-nav").stop().fadeIn();	
		},
		function(){
			$(this).stop().removeClass("active");
			$(".sub-nav").fadeOut();	
		}
	);
	
	$(".updates-header a").click(function(){
		$(this).parent("div").children("a").removeClass("selected");
		$(this).addClass("selected"); 
		var currentActive = $(this).attr("data-detail");
		$(".recent-updates").children("div").transition({ scale: 0, delay: 200 });
		$(".recent-updates").children("div").hide(100);
		$(".recent-updates").children("."+currentActive).show(100);
		$(".recent-updates").children("."+currentActive).transition({ scale: 1, delay: 100 });
		
		
		//data-detail	
	});
	$(".exam-nav a").click(function(){
		$(this).parent("div").children("a").removeClass("selected");
		$(this).addClass("selected"); 
		var currentActive = $(this).attr("data-detail");
		$(".hot-exam-div").children("div").transition({ scale: 0, delay: 200 });
		$(".hot-exam-div").children("div").hide(100);
		$(".hot-exam-div").children("."+currentActive).show(100);
		$(".hot-exam-div").children("."+currentActive).transition({ scale: 1, delay: 100 });
		
		//data-detail	
	});
	$(".exam-cert-header a").click(function(){
		$(this).parent("div").children("a").removeClass("selected");
		$(this).addClass("selected"); 
		var currentActive = $(this).attr("data-detail");
		$(".exam-data").children("div").transition({ scale: 0, delay: 200 });
		$(".exam-data").children("div").hide(100);
		$(".exam-data").children("."+currentActive).show(100);
		$(".exam-data").children("."+currentActive).transition({ scale: 1, delay: 100 });
		
		//data-detail	
	});
	
	var activeDiv="products-div";
	
	$(".member-nav a, .mobile-nav a").click(function(){
		$(".member-nav a, .mobile-nav a").removeClass("selected");
		var activeLink = $(this).attr("actClass");
		$("."+ activeLink).addClass("selected"); 
		var currentActive = $(this).attr("data-detail");
		
		$("." + activeDiv).transition({ scale: 0, delay: 200 });
		$("." + activeDiv).hide(100);
		$("."+currentActive).show(100);
			$("."+currentActive).transition({ scale: 1, delay: 100 });
		//$(".member-area-right-contents").focus();
		$('html, body').animate({
			scrollTop: $(".member-area-right-contents").offset().top
		}, 1000,function(){
			
			
		});
		activeDiv=currentActive;
		
		//data-detail	
	});
	
	
	$(".leder-sec-box").hover(
		function(){
				$(this).stop().transition({ scale: 1.5, delay: 100 });
		},
		function(){
			$(this).stop().transition({ scale: 1, delay: 100 });	
		}
	);
	$(".expand-f").click(function(){
		var txt = $(this).html();
		if(txt == '+')
		{
			$(this).html('-')
		}
		else{
			$(this).html('+')
		}
		$(this).parent("b").parent(".footer-links-box").children(".mobile-f-slide").slideToggle();
	});
	

	
	
	
});// JavaScript Document