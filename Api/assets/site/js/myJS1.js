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
			scrollTop: $(".dashboard .tab-list").offset().top
		}, 1000,function(){
			
			
		});
		activeDiv=currentActive;
		
		//data-detail	
	});
	
	$(".products-div a").click(function(){
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
			scrollTop: $(".dashboard .tab-list").offset().top
		}, 1000,function(){
		});
		activeDiv=currentActive;
		
		//data-detail	
	});
	
	$(".bundles-div a").click(function(){
		$(".member-nav a, .mobile-nav a").removeClass("selected");
		var activeLink = $(this).attr("actClass");
		//$('.bundles-div').hide();
		$("."+ activeLink).addClass("selected"); 
		var currentActive = $(this).attr("data-detail");
		console.log(currentActive);
		var activeDiv = "bundles-div";
		$("." + activeDiv).transition({ scale: 0, delay: 200 });
		$("." + activeDiv).hide(100);
		$("."+currentActive).show(100);
		$("."+currentActive).transition({ scale: 1, delay: 100 });
		//$(".member-area-right-contents").focus();
		$('html, body').animate({
			scrollTop: $(".dashboard .tab-list").offset().top
		}, 1000,function(){
			$('.bundles-div').hide();
			
		});
		activeDiv=currentActive;
		//$('.bundles-div').hide();
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

	function backtoBundles(){
		$(".sclae").hide(100);
		$(".bundles-div").css('transform','inherit');
		$(".bundles-div").show(100);
	}