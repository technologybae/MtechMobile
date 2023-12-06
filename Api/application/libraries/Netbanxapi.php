<?php
/**
* @mainpage NETBANX Hosted Payment API
* The Hosted Payment API is a RESTful interface for making secure payments by way of your ecommerce site. The REST API works with JSON messages and responses.
* - With the API, your customer can pay securely using a PCI-compliant hosted payment page.
* - By using a payment page hosted by NETBANX, sensitive payment information such as credit card numbers is handled by NETBANX.
* - The NETBANX payment page helps reduce the overhead of PCI audit requirements and its associated costs.
* - The API does not allow merchants to pass card data. If you wish your e-commerce site to collect and pass card data, then you need to use the NETBANX Web Services API and comply with PCI guidelines regarding the handling of card data.
*
* This library provides common methods for calling NETBANX Hosted API
*
* Change log
* ----------
* 1.2.3 2014-02-07
*   - refund method deprecated in favour of refund_order
*   - settle_payment method deprecated in favour of settle_order
*   - example refund_a_payment.php updated to use new method names and renamed to refund_an_order.php
*   - example settle_a_payment.php updated to use new method names and renamed to settle_an_order.php
*
* 1.2.2 2014-01-16
*   - fixed bug causing invalid certificate errors when running on WAMP
*   - added "pretty" print for example output using dBug
*   - non essential functions moved from examples to common.php
*   - removed api type from examples
*
* 1.2.1 2013-02-20
*   - Added examples for storing and reusing profiles for pay by last card
*
* 1.2 2013-02-15
*   - Added curl_opts methods for setting custom curl options( for connecting trough proxy). 
*   - Certificate errors not being ignored by default
*
* 1.1 2012-12-13
*   - Fixed bug incorrectly reporting $ext for missing extensions. Test cases added.
*
* 1.0 2012-12-07
*/

/**
* @brief Library provides generic methods for creating and manipulating orders using NETBANX Payment API
* NetbanxAPI library should be used with NETBANX Hosted Paymet API Reference Guide. To get one, please contact support@netbanx.com.
*
* Library covers methods for:
*   - Create an Order (create_order)
*   - Cancel an Order (cancel_order)
*   - Get an Order (get_order)
*   - Refund an Order (refund_order)
*   - Settle an Order (settle_order)
*   - Get an Order Report (order_report)
*   - Get a Payment Report (payment_report)
*   - Resend Callback (resend_callback)
*
* Generic workflow:
*   -# Create an Order with create_order method
*   -# Redirect customer to the payment page.\n
*      Use results from create_order or use get_order to get redirection uri
*   -# Update order.\n
*      Use either callback mechanism or use get_order to retrieve order status.
*
* Check NETBANX Hosted Payment API documentation for more details.
**/

class NetbanxAPI
{
    private $api        = 'hosted';                     // api type ( hosted )
    private $curl_opts  = array();                      // additional curl connection parameters, e.g. proxy
    private $key        = 'someuser:somepassword';      // api key in a form of 'username:password'
    private $uri        = 'https://pay.netbanx.com';    // netbanx uri
    private $version    = 'v1';                         // netbanx api version

    private function auth_header(){
        return ( 'BASIC ' . base64_encode($this->key()) );
    }

    private function full_uri( $token, $action, $endpoint ){
        $uri =  sprintf( '%s%s%s%s%s%s%s', $this->uri(), '/', $this->api() , '/', $this->version() , '/', $endpoint );
        if ( ! is_null( $token ) ){
            $uri = sprintf( '%s%s%s', $uri, '/', $token );
            if( ! is_null( $action ) ){
                $uri = sprintf( '%s%s%s', $uri, '/', $action );
            }
        }
        return $uri;
    }

    private function netbanx_curl( $args = array() ){

        // HTTP Method
        if ( array_key_exists( 'method', $args ) ){
            $method = $args[ 'method' ];
        } else {
            $method = 'GET';
        }

        // NETBANX Token
        if ( array_key_exists( 'token', $args ) ) {
            $token = $args[ 'token' ];
        } else {
            $token = null;
        }

        // params to go into the body of the post/put request
        if ( array_key_exists( 'parameters', $args ) ){
            $parameters = $args[ 'parameters' ];
        } else {
            $parameters = array();
        }

        // Action: refund/resend_callback/settlement etc
        if ( array_key_exists( 'action', $args ) ){
            $action = $args[ 'action' ];
        } else {
            $action = null;
        }

        // Endpoint: orders, payments, profiles etc.
        if ( array_key_exists( 'endpoint', $args ) ){
            $endpoint = $args[ 'endpoint' ];
        } else {
            $endpoint = 'orders';
        }

        $headers = array( sprintf( 'Authorization: %s', $this->auth_header() ) );

        $ch = curl_init();

        if ( in_array( $method, array( 'POST', 'PUT' ) ) ){
            curl_setopt( $ch, CURLOPT_POST, TRUE );
        }

        // apply additional curl options
        foreach( $this->curl_opts as $opt => $val ){
            curl_setopt( $ch, $opt, $val );
        }


        //return response instead of printing it to SDTOUT
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        // follow redirects
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        // prevent infinitive loop while following redirects
        curl_setopt($ch, CURLOPT_MAXREDIRS,10);

        if ( in_array( $method, array( 'POST', 'PUT' ) ) ){
            array_push( $headers,'Content-Type: application/json;' );
            if ( count( $parameters ) > 0 ){
                curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $parameters ) );
            }
        }

        $uri = $this->full_uri( $token, $action, $endpoint );

        if ( $method == 'GET' && count( $parameters ) > 0 ){
            $out = array();
            foreach( $parameters as $key => $value )
                $out[] = "$key=$value";

            $uri .= '?' . join('&', $out );
        }

        //set endpoint uri
        curl_setopt( $ch, CURLOPT_URL, $uri );

        // set headers
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

        // set http method
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $method );

        $response = curl_exec( $ch );

        if ( is_bool( $response ) && $response == false ){
            throw new NetbanxException( 'Unable connect to ' . $uri . ', curl error: ' . curl_error( $ch ) );
        }

        curl_close( $ch );

        $json = json_decode( $response );

        // catch netbanx errors
        if (  is_object( $json ) && array_key_exists( 'error', $json ) ){
            throw new NetbanxError( $json->error->message, $json->error->code );
        }else if( is_int( $json ) ){
            throw new NetbanxError( 'Requested resource error', $json );
        }

        // TODO enable option to return decoded json as array
        return json_decode( $response, FALSE );
    }

    /**
    * Create new API class.
    * Can set uri, key and api type if an array with parameters is passed in.
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $nbx = new NetbanxAPI(
    *   array(
    *       "api" => "hosted",
    *       "key" => "some key",
    *       "uri" => "https://pay.test.netbanx.com",
    *       )
    *   );
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * same as above:
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $nbx = new NetbanxAPI();
    * $nbx->api( "hosted" );
    * $nbx->key( "some key" );
    * $nbx->uri( "https://pay.test.netbanx.com" );
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    *
    * @param $args - associative array with settings for uri, key and/or api type.
    * @sa api() key() uri()
    */
    public function __construct( $args = array() ){
        //check if all extensions available
        $extensions = array( 'curl','json' );

        foreach( $extensions as $ext ){
            if( !extension_loaded( $ext ) ){
                throw new NetbanxException("$ext extension not loaded");
            }
        }

        if( array_key_exists( 'uri', $args ) ){
            $this->uri( $args[ 'uri' ] );
        }

        if( array_key_exists( 'key', $args ) ){
            $this->key( $args[ 'key' ] );
        }

        if ( array_key_exists( 'api', $args ) ){
            $this->api( $args[ 'api' ] );
        }

        if ( array_key_exists( 'curl_opts', $args ) ) {
            $this->curl_opts( $args[ 'curl_opts' ] );
        }
    }

    /**
    * Set/Get API type ( "hosted" )
    * When called with $api_type, sets NETBANX API type, otherwise returns current value
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $nbx->api( "hosted" );
    * print $nbx->api(); //will print "hosted"
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * @param $api_type - set api type. api_type can be "hosted"
    * @return current api type
    * @sa __construct() key() uri()
    */

    public function api( $api_type = 0 ){
        $valid = array( 'hosted' );
        if ( $api_type && in_array( $api_type, $valid ) ){
            $this->api = $api_type;
        }else if ( $api_type ){
            throw new NetbanxException( sprintf('invalid api value, should be %s', join(' or ', $valid ) ) );
        }else{
            return $this->api;
        }
    }

    /**
    * Calls NETBANX API to cancel an order
    * @param $token - unique netbanx order id ( token )
    * @return standard object created by deserializing json ( using json_decode()  )
    *
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $result = $nbx->cancel_order( "P_25TWPYN9B04XLJI1LV" );
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    *
    * @sa create_order() get_order() refund_order() settle_order() order_report() payment_report()
    */
    public function cancel_order( $token = 0 ){
        if ( $token ){
            return $this->netbanx_curl(
                array(
                    'method'    => 'DELETE',
                    'token'     => $token
                )
            );
        }else {
            throw new NetbanxException('missing token');
        }
    }

    /**
    * Calls NETBANX API to create an order
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $nbx->create_order( array (
    *   "total_amount"      => 1337,
    *   "currency_code"     => "GBP",
    *   "merchant_ref_num"  => "Order 1",
    *   "callback"' =>
    *           array (
    *               array(
    *                   "format" => "json",
    *                   "rel" => "on_success",
    *                   "uri" => "https://shop.example.com/pass.php"
    *               ),
    *               array(
    *                   "format" => "json",
    *                   "rel" => "on_decline",
    *                   "uri" => "https://shop.example.com/decline.php"
    *               )
    *           ),
    *   "merchant_notification_email" => "accounting@example.com",
    * ) );
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * @param $args - an array containing parameters to create new order( and prepare payment page)
    * @return standard object created by deserializing json ( using json_decode() )
    * @sa cancel_order() get_order() refund_order() settle_order() order_report() payment_report()
    */
    public function create_order( $args = array() ){
        return $this->netbanx_curl(
            array(
                'method'        => 'POST',
                'parameters'    =>  $args
            )
        );
    }

    /**
    * Set/Get additional curl connecion options ( e.g. proxy )
    * When called with $curl_opts, sets curl connections options, otherwise returns current value
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $nbx->curl_opts(
    *     array(
    *         "CURLOPT_PROXY" => "proxy.example.com",
    *         "CURLOPT_SSL_VERYFYHOST" => FALSE,  // ignore certificate errors, don't use this on prod
    *         "CURLOPT_SSL_VERYFYPEER" => FALSE   // ignore certificate errrors, don't use this on prod
    *     )
    * );
    * print_r $nbx->curl_opts(); //will print current curl settings
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * @param $curl_opts - set curl connection options.
    * @return current curl options
    */
    public function curl_opts( $curl_opts = array() ){

        if ( $curl_opts ){
            $this->curl_opts = $curl_opts;
        }else{
            return $this->curl_opts;
        }
    }

    /**
    * Calls NETBANX API to get order details
    * @param $token - unique netbanx order id ( token )
    * @return standard object created by deserializing json ( using json_decode()  )
    *
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $order = $nbx->get_order( "P_25TWPYN9B04XLJI1LV" );
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    *
    * @sa create_order() refund_order() settle_order() order_report() payment_report()
    */
    public function get_order( $token = 0 ){
        if ( $token ){
            return $this->netbanx_curl(
                array(
                    'method'    => 'GET',
                    'token'     => $token
                )
            );
        }else{
            throw new NetbanxException('missing token');
        }
    }

    /**
    * Set/Get API key
    * When called with $key sets an API key to provided value, when called without, returns current value of the API key.
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $nbx->key( "jTxL2wsNysJ8Jzmpdwim:NAA043a7c53c66ac3826c5e" );
    * print( $nbx->key); //will print "jTxL2wsNysJ8Jzmpdwim:NAA043a7c53c66ac3826c5e"
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * @param $key - NETBANX API key
    * @return current API key
    * @sa __construct() api() uri()
    */
    public function key( $key = 0 ){
        if( $key && preg_match('/^[0-9a-zA-Z]+:[0-9a-zA-Z]+$/',$key)){
            $this->key = $key;
        }else if( $key ) {
            throw new NetbanxException('invalid api key');
        }else{
            return $this->key;
        }
    }
    /**
    * Calls NETBANX API to get order report
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $report = $nbx->order_report(
    *   array (
    *       "start" => 1, // This is the record number at which to start.
    *                     // For example, setting the value to 20 would start the report at the 20th order.
    *       "num" => 1    // This is the number of records to return;
    *   )
    * );
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * @param $args - an array of order parameters
    * @return standard object created by deserializing json ( using json_decode()  )
    * @sa create_order() get_order() settle_order() order_report() payment_report()
    */
    public function order_report( $args = array() ){
        return $this->netbanx_curl(
            array(
                'method'        => 'GET',
                'parameters'    => $args
            )
        );
    }

    /**
    * Calls NETBANX API to get payment report
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $report = $nbx->payment_report(
    *   array (
    *       "start" => 1, // This is the record number at which to start.
    *                     // For example, setting the value to 20 would start the report at the 20th order.
    *       "num" => 1    // This is the number of records to return;
    *   )
    * );
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * @param $args - an array of order parameters
    * @return standard object created by deserializing json ( using json_decode()  )
    * @sa create_order() get_order() settle_order() order_report() order_report()
    */
    public function payment_report( $args = array() ){
        return $this->netbanx_curl(
            array(
                'method'        => 'GET',
                'endpoint'      => 'payments',
                'parameters'    => $args
            )
        );
    }

    /**
    * Calls NETBANX API to refund a payment
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $refund_order = $nbx->refund(
    *   "P_25TWPYN9B04XLJI1LV",
    *   array(
    *       "amount" => 120,
    *       "merchantRefNum" => "refund of the order 1"
    *   )
    * );
    * // or to refund full amount
    * $refund_order = $nbx->refund( "P_25TWPYN9B04XLJI1LV" );
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * @param $token - unique netbanx order id ( token )
    * @param $args - an array of refund parameters
    * @return standard object created by deserializing json ( using json_decode()  )
    * @sa create_order() get_order() settle_order() order_report() payment_report()
    */
    public function refund_order( $token = 0, $args = array() ){
        if ( $token ){
            return $this->netbanx_curl(
                array(
                    'method'        => 'POST',
                    'token'         => $token,
                    'action'        => 'refund',
                    'parameters'    => $args
                )
            );

        }else{
            throw new NetbanxException('missing token');
        }
    }

    /**
    * Deprecated. same as refund_order()
    * @sa refund_order()
    */
    public function refund( $token = 0, $args = array() ){
        return $this->refund_order( $token, $args );
    }

    /**
    * Calls NETBANX API to request callback resend
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $nbx->resend_callback( "P_25TWPYN9B04XLJI1LV" );
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * @param $token - netbanx order id ( token ) of the order callback should be resent for
    * @return standard object created by deserializing json ( using json_decode()  )
    * @sa create_order() get_order() settle_order() order_report() order_report()
    */
    public function resend_callback( $token = 0 ){
        if ( $token ){
            return $this->netbanx_curl(
                array(
                    'method'        => 'GET',
                    'token'         => $token,
                    'action'        => 'resend_callback',
                )
            );

        }else{
            throw new NetbanxException('missing token');
        }

    }

    /**
    * Calls NETBANX API to settle a payment
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $settle_order = $nbx->settle_order(
    *   "P_25TWPYN9B04XLJI1LV",
    *   array(
    *       "amount" => 120,
    *       "merchantRefNum" => "settle of the order 1"
    *   )
    * );
    * // or to settle full amount
    * $settle_order = $nbx->settle_order( "P_25TWPYN9B04XLJI1LV" );
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * @param $token - unique netbanx order id ( token )
    * @param $args - an array of settling parameters
    * @return standard object created by deserializing json ( using json_decode()  )
    * @sa create_order() get_order() settle_order() order_report() payment_report()
    */
    public function settle_order( $token = 0, $args = array() ){
        if ( $token ){
            return $this->netbanx_curl(
                array(
                    'method'        => 'POST',
                    'token'         => $token,
                    'action'        => 'settlement',
                    'parameters'    => $args
                )
            );

        }else{
            throw new NetbanxException('missing token');
        }
    }

    /**
    * Deprecated.
    * same as settle_order()
    * @sa settle_order()
    */
    public function settle_payment( $token = 0, $args = array() ){
        return $this->settle_order( $token, $args );
    }

    /**
    * Set/Get NETBANX API endpoint URI
    * When called with $uri sets an API endpoint URI, when called without, returns curent URI value.
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $nbx->uri( "https://pay.test.netbanx.com" );
    * print $nbx->uri(); //will print "https://pay.test.netbanx.com"
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * @param $uri - NETBANX API endpoint uri ( eg. https://pay.test.netbanx.com )
    * @return current API endpoint URI
    * @sa __construct() api() key()
    */
    public function uri( $uri = 0 ){
        if( $uri && preg_match('/^(http[s]{0,1}:\/\/.*)$/i',$uri,$reg)){
            $this->uri = rtrim($reg[1],'/');

            // change to dev uri if runing in dev environment
            if (getenv('NBX_URI')){
                $this->uri = getenv('NBX_URI');
            }

        }else if( $uri ){
            throw new NetbanxException('invalid uri');
        }else{
            return $this->uri;
        }
    }

    /**
    * Set/Get NETBANX API version
    * When called with $version sets an API version, when called without, returns curent version value.
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~.php
    * $nbx->version( "v1" );
    * print $nbx->version(); //will print "v1";
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * @param $version - NETBANX API version (eg. v1)
    * @return current API version
    * @sa __construct() api() key() uri()
    */
    public function version( $version = 0 ){
        if( $version && preg_match('/^v\d+$/',$version)){
            $this->version = $version;
        }else{
            return $this->version;
        }
    }
}

/**
* @brief Overloaded Exception class to distinquish between NETBANX client and server errors.\n
*
* NetbanxException will be thrown on server errors as well as on networking issues.
*/
class NetbanxException extends Exception { }
/**
* @brief Overloaded Exception class to distinquish between NETBANX client and server errors.
*
* NetbanxError will be thrown for any client error ( like missing parameters, invalid order id etc )
*/
class NetbanxError extends Exception { }

/**
* @example create_an_order.php
* creates an order and prints order details. use url from the results to get to the payment page
* @example create_an_order_with_new_profile.php
* creates an order and stores customer profile, so cards can be reused in the future payments ( run this and complete payment before running create_an_order_with_existing_profile.php )
* @example create_an_order_with_existing_profile.php
* creates an order with an existing profile and card information ( run create_an_order_with_new_profile.php first )
* @example refund_an_order.php
* partial refund example
* @example cancel_an_order.php
* cancels create, but not completed order ( before customer finishes transaction )
* @example get_an_order.php
* example of retrieving order details
* @example get_an_order_report.php
* example of getting order report
* @example get_a_payment_report.php
* example of payment report
* @example resend_callback.php
* example of callback resend api call
* @example settle_an_order.php

*/

?>
