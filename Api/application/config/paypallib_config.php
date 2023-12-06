<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------
// Paypal Configuration Class
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// Paypal IPN Config
// ------------------------------------------------------------------------

// If (and where) to log ipn to file
$config['paypal_lib_ipn_log_file'] = APPPATH.'logs/paypal_ipn.txt';
$config['paypal_lib_ipn_log'] = TRUE;

// ------------------------------------------------------------------------
// Paypal GENERAL Config
// ------------------------------------------------------------------------

//Paypal Mode (sandbox/Live)
$config['paypal_sandbox'] = TRUE; // to make it live set to false

// Where are the buttons located at 
$config['paypal_lib_button_path'] = 'buttons';

// What is the default currency?
$config['paypal_lib_currency_code'] = 'USD';


?>
