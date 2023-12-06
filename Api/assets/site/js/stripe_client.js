$(document).ready(function(){
   //var stripe = Stripe('pk_live_ZVcwTbQn1nHURECcz3RpgVsX'); Key For Affiliates
	var stripe = Stripe('pk_live_UWPrcAbQCmzkrWItmQWtYSFq');
    var elements = stripe.elements();
    var cardElement = elements.create('card', {
      iconStyle: 'solid',
      style: {
        base: {
          iconColor: '#9e9b9b',
          color: '#9e9b9b',
          lineHeight: '36px',
          fontFamily: '"Lato", sans-serif',
          fontSize: '13.5px',
    
          '::placeholder': {
            color: '#9e9b9b',
          },
        },
        invalid: {
          iconColor: '#e85746',
          color: '#e85746',
        }
      },
      classes: {
        focus: 'is-focused',
        empty: 'is-empty',
      },
    });
    cardElement.mount('#card-element');
    // cardElement.mount('#card-element1');
    
    $('#card-button').click(function(){
        
        var cardholderName = $('#cardholderName').val();
        var cardButton = $('#card-button').val();
        var email = $('#email').val();
        var street_address = $('#street_address').val();
        var city = $('#city').val();
        var country = $("#InputCountry option:selected").val();
        var state = $("#state option:selected").val();
            
        if ($('#cardholderName').val().length == 0) {
            $('.first_name-error').text("Card Holder Name is required.");
            // $('#cardholderName').css({"border-color": "red !important"});
            return false;
        }
        else
        {
            $('.first_name-error').text("");
        }
        if ($('#email').val().length == 0) {
            $(".email-error").text("Email is required.");
            return false;
        }
        else
        {
            $(".email-error").text("");
        }
        if ($('#street_address').val().length == 0) {
            $(".street_address-error").text("Street Address is required.");
            return false;
        }
        else
        {
            $(".street_address-error").text("");
        }
        if ($('#city').val().length == 0) {
            $(".city-error").text("City is required.");
            return false;
        }
        else
        {
            $(".city-error").text("");
        }
        
        if ($('#InputCountry').val().length == 0) {
            $(".InputCountry-error").remove();
            $('#InputCountry').after('<span class="help-block InputCountry-error"></span>');
            $(".InputCountry-error").text("Country is required.");
            return false;
        }
        else
        {
            $(".InputCountry-error").text("");
        }
        
        if ($('#state').val().length == 0) {
            $(".state-error").remove();
            $('#state').after('<span class="help-block state-error"></span>');
            $(".state-error").text("State is required.");
            return false;
        }
        else
        {
            $(".state-error").text("");
        }
        
       var fewSeconds = 5;
        var btn = $('#card-button');
        btn.prop('disabled', true);
        setTimeout(function(){
            btn.prop('disabled', false);
        }, fewSeconds*1000);
    
      
      stripe.createPaymentMethod('card', cardElement, {
        billing_details: {name: cardholderName, email: email, address: {"city": city,"country": country, "line1": street_address, "line2": null,"state": state}}
      }).then(function(result) {
        if (result.error) {
            $(".loadingimg").hide();
            console.log(result);
			if(result.error.message == 'Invalid positive integer')
			{
				var sessExpired = '<div class="alert alert-warning"><h3>Your Session is Expired due to Inactivity</h3><p>Please select products again and add to cart.</p><p><a style="margin-top:20px;" onclick="window.history.back();" class="btn btn-default">Go Back</a></p></div>';
				$('.finalcartcss').html(sessExpired);
			}
          $('.stripeResponse').html(result.error.message);
          $('.stripeResponse').show();
          setTimeout(function() {
                $(".stripeResponse").hide('blind', {}, 500)
            }, 10000);
        } else {
            $(".loadingimg h3").text("Please Wait - Your Transaction is in Process.......");
            $(".loadingimg").show();
          
          fetch('/payments/stripe_checkout', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                'Upgrade-Insecure-Requests': 1
            },
            body: JSON.stringify({ payment_method_id: result.paymentMethod.id, name: cardholderName, email:email,street_address:street_address,city:city,country:country,state:state }).toString()
          }).then(function(result) {
            result.json().then(function(json) {
              handleServerResponse(json);
              console.log(json);
              if(json.error)
              {
                $(".loadingimg").hide();
				if(json.error == 'Invalid positive integer')
				{
					var sessExpired = '<div class="alert alert-warning"><h3>Your Session is Expired due to Inactivity</h3><p>Please select products again and add to cart.</p><p><a style="margin-top:20px;" onclick="window.history.back();" class="btn btn-default">Go Back</a></p></div>';
					$('.finalcartcss').html(sessExpired);
				}
                $('.stripeResponse').html(json.error);
                $('.stripeResponse').show();
                setTimeout(function() {
                    $(".stripeResponse").hide('blind', {}, 500)
                    }, 10000);  
                }
            })
        });
        }
      });
        
    })
})



function handleServerResponse(response) {
    
    //var stripe = Stripe('pk_live_ZVcwTbQn1nHURECcz3RpgVsX'); Key For Affiliates
	var stripe = Stripe('pk_live_UWPrcAbQCmzkrWItmQWtYSFq');
    
    var cardholderName = $('#cardholderName').val();
    var cardButton = $('#card-button').val();
    var email = $('#email').val();
    var street_address = $('#street_address').val();
    var city = $('#city').val();
    var country = $("#InputCountry option:selected").val();
    var state = $("#state option:selected").val();
    
    
  if (response.error) {
        console.log(response);
        $(".loadingimg").hide();
		if(response.error == 'Invalid positive integer')
		{
			var sessExpired = '<div class="alert alert-warning"><h3>Your Session is Expired due to Inactivity</h3><p>Please select products again and add to cart.</p><p><a style="margin-top:20px;" onclick="window.history.back();" class="btn btn-default">Go Back</a></p></div>';
			$('.finalcartcss').html(sessExpired);
		}
        $('.stripeResponse').html(response.error);
        $('.stripeResponse').show();
        setTimeout(function() {
            $(".stripeResponse").hide('blind', {}, 500)
        }, 10000);
  } else if (response.requires_action) {
      
    $(".loadingimg").hide(); 
    // Use Stripe.js to handle required card action
    stripe.handleCardAction(
      response.payment_intent_client_secret
    ).then(function(result) {
      if (result.error) {
        $(".loadingimg").hide();
        $('.stripeResponse').html(result.error);
        $('.stripeResponse').show();
        setTimeout(function() {
            $(".stripeResponse").hide('blind', {}, 500)
        }, 10000);
      } else {
        $(".loadingimg").show();
        fetch('/payments/stripe_checkout', {
        method: 'POST',
          credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                'Upgrade-Insecure-Requests': 1
         },
          body: JSON.stringify({ payment_intent_id: result.paymentIntent.id, name: cardholderName, email:email,street_address:street_address,city:city,country:country,state:state  }).toString()
        }).then(function(confirmResult) {
          return confirmResult.json();
        }).then(handleServerResponse);
      }
    });
  } else {
      if(response.status == 'success')
      {
          redirectPage(BASE_URL + 'payments/thankyou/'+response.order_id);
      }
      else
      {
        $(".loadingimg").hide();
		if(response.error == 'Invalid positive integer')
		{
			var sessExpired = '<div class="alert alert-warning"><h3>Your Session is Expired due to Inactivity</h3><p>Please select products again and add to cart.</p><p><a style="margin-top:20px;" onclick="window.history.back();" class="btn btn-default">Go Back</a></p></div>';
			$('.finalcartcss').html(sessExpired);
		}
        $('.stripeResponse').html(response.error);
        $('.stripeResponse').show();
        setTimeout(function() {
                    $(".stripeResponse").hide('blind', {}, 500)
        }, 10000);
      }
      console.log(response);
  }
}