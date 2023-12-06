<?php

use OptimalPayments\OptimalApiClient;
use OptimalPayments\Environment;
use OptimalPayments\HostedPayment\Order;
use OptimalPayments\CardPayments\Authorization;

class Netbanx_payments
{ 
  protected $optimalApiKeyId;
  protected $optimalApiKeySecret;
  protected $optimalAccountNumber;
  protected $currencyCode;
  protected $currencyBaseUnitsMultiplier;
  public function __construct() {
  		//configure global values
      $this->optimalApiKeyId = '35210-1001041540';
      $this->optimalApiKeySecret = 'B-qa2-0-56797b0d-0-302c021453183efbc14bbf7fd5c2f6e31aa077d3edca9fc9021421c1e383fb90471905da1e7c149e376e00cf8156';
      $this->optimalAccountNumber = '1001041540';      
      $this->currencyCode = 'USD'; 
      $this->currencyBaseUnitsMultiplier = 100; 

      require_once(APPPATH.'libraries/netbanx/optimalpayments.php');
	  
  }
  
  /**
  * @Method: netbanxHostedPayment
  * @params: $post array
  * return: boolean
  */
  public function netbanxHostedPayment($post){
    $ci = & get_instance ();
    
    $client = new OptimalApiClient($this->optimalApiKeyId, $this->optimalApiKeySecret, Environment::TEST, $this->optimalAccountNumber);
  	try {
      //Set callback urls
      $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";         
    
      $successURL = $pageURL.$_SERVER["SERVER_NAME"].'/payments/payment_success/';
      $cancelURL = $pageURL.$_SERVER["SERVER_NAME"].'/payments/payment_cancel/';
      $errorURL = $pageURL.$_SERVER["SERVER_NAME"].'/payments/payment_error/';

      //set order array
      $orderArray = array(
                     'merchantRefNum' => $post['merchant_ref_num'],
                     'currencyCode' => $this->currencyCode,
                     'totalAmount' => $post['amount'] * $this->currencyBaseUnitsMultiplier,
                     'redirect' => array(
                        array(
                          'rel' => 'on_success',
                          'uri' => $successURL,
                          'returnKeys' => array(
                             'id'
                          )
                        ),
                        array(
                          'rel' => 'on_decline',
                          'uri' => $cancelURL,
                          'returnKeys' => array(
                             'id'
                          )
                        ),
                        array(
                          'rel' => 'on_error',
                          'uri' => $errorURL,
                          'returnKeys' => array(
                             'id'
                          )
                        )
                     ),
                     'customerNotificationEmail' => $ci->session->userdata('front_user')->email,
                     /*'profile' => array(
                        'firstName' => $post['first_name'],
                        'lastName' => $post['last_name']
                     ),
                     'billingDetails' => array(
                        'street' => $post['street_address'],
                        'city' => $post['city'],
                        'state' => $post['state'],
                        'country' => $post['country'],
                        'zip' => $post['zip']
                      )*/
                  );      
       
      //Process order
      $order = $client->hostedPaymentService()->processOrder(new Order($orderArray));

      //set order session
      $ci->session->set_userdata('order',$order);
      
      redirect($order->getLink('hosted_payment')->uri);
      die;
    } catch (OptimalPayments\NetbanxException $e) {
        echo '<pre>';
        var_dump($e->getMessage());
        if ($e->fieldErrors) {
          var_dump($e->fieldErrors);
        }
        if ($e->links) {
          var_dump($e->links);
        }
        echo '</pre>';
    } catch (\OptimalPayments\OptimalException $e) {
      //for debug only, these errors should be properly handled before production
      var_dump($e->getMessage());
    }     
  }

  /**
  * @Method: netbanxCreditCardPayment
  * @params: $post array
  * return: boolean
  */
  public function netbanxCreditCardPayment($post){
    $ci = & get_instance ();
    //print_r($post);
    $client = new OptimalApiClient($this->optimalApiKeyId, $this->optimalApiKeySecret, Environment::TEST, $this->optimalAccountNumber);
	//echo '<pre>';
    try {
      $auth = $client->cardPaymentService()->authorize(new Authorization(
	  
	  array(
         'merchantRefNum' => $post['merchant_ref_num'],
         'amount' => $post['amount'] * $this->currencyBaseUnitsMultiplier,
         'settleWithAuth' => true,
         'card' => array(
            'cardNum' => $post['card_number'],
            'cvv' => $post['card_cvv'],
            'cardExpiry' => array(
              'month' => $post['expiry_month'],
              'year' => $post['expiry_year']
            )
         ),
         'billingDetails' => array(
            'street' => $post['street_address'],
            'city' => $post['city'],
            'state' => $post['state'],
            'country' => $post['country'],
            'zip' => $post['zip']
      ))));
      
      return $auth;
      die;
    } catch (OptimalPayments\NetbanxException $e) {
        //echo '<pre>';
        //var_dump($e->getMessage());
		return $e->getMessage();
        if ($e->fieldErrors) {
        return $e->fieldErrors();
        }
        if ($e->links) {
        return $e->links();
        }
        //echo '</pre>';
    } catch (\OptimalPayments\OptimalException $e) {
      //for debug only, these errors should be properly handled before production
      var_dump($e->getMessage());
    }     
  }
  /**
  * Method: getOrderDetial
  * params: $orderId array
  * Returns: order details
  */

  public function getOrderDetial($orderId){
    $client = new OptimalApiClient($this->optimalApiKeyId, $this->optimalApiKeySecret, Environment::TEST, $this->optimalAccountNumber);
    try {      
      $order = $client->hostedPaymentService()->getOrder(new Order(array(
         'id' => $orderId
      )));
      return $order;
    } catch (OptimalPayments\NetbanxException $e) {
      echo '<pre>';
      var_dump($e->getMessage());
      if ($e->fieldErrors) {
        var_dump($e->fieldErrors);
      }
      if ($e->links) {
        var_dump($e->links);
      }
      echo '</pre>';
    } catch (\OptimalPayments\OptimalException $e) {
      //for debug only, these errors should be properly handled before production
      var_dump($e->getMessage());
    }
  }
}
?>