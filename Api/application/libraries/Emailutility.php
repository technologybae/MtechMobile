<?php
if (!defined('APPPATH'))  exit('No direct script access allowed');

/*
 * @Author: Ali Cheema
 *
 */

final class Emailutility {

    function Emailutility() {
        $this->CI = & get_Instance();
        $this->CI->load->library('phpmailer');
        $this->CI->load->library('email');
    }

    /**
    * @method: userRegistrationEmail
    * @params: $to, $subject, $message
    */

    function userRegistrationEmail($to, $subject, $message, $sendor_name, $sendor_email){

        Emailutility::sendMail($to, $subject, $message, $sendor_name, $sendor_email);
    }
	
	function userForgotPassword($to, $subject, $message, $sendor_name, $sendor_email){

        Emailutility::sendMail($to, $subject, $message, $sendor_name, $sendor_email);
    }

    /**
    * @method: sendInvoiceEmail
    * @params: $to, $subject, $message
    */

    function sendInvoiceEmail($to, $subject, $message, $sendor_name, $sendor_email){
       
        Emailutility::sendMail($to, $subject, $message, $sendor_name, $sendor_email);
    }
    
    /*
      Send Mail
      Pra @ To Email address
      Pra @ sendor name
      Pra @ sendor email address
      Pra @ subject
      Pra @ html body
      Pra @ html text
     */

    function sendMail($to_email, $subject, $body_html, $sendor_name = NO_REPLY_SENDER_NAME, $sendor_email = NO_REPLY_EMAIL, $attachment=NULL, $cc=NULL, $bcc=NULL) {
  
        $separator = md5(time());
        $eol = PHP_EOL;

        // main header (multipart mandatory)
       $headers = "";
            $headers .= "From: " . $sendor_name . "<" . $sendor_email . ">\r\n";
            if ($cc <> '')
                $headers = "cc:  " . $cc . "\r\n";
            if ($bcc <> '')
                $headers = "bcc:  " . $bcc . "\r\n";
        $headers .= "MIME-Version: 1.0" . $eol;
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;
        $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
        $headers .= "This is a MIME encoded message." . $eol . $eol;

        // message
        $headers .= "--" . $separator . $eol;
        $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
        $headers .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
        $headers .= $body_html . $eol . $eol;

        // attachment
        if ($attachment["file_name"] != "") {
            $headers .= "--" . $separator . $eol;
            $headers .= "Content-Type: application/octet-stream; name=\"" . $attachment["file_name"] . "\"" . $eol;
            $headers .= "Content-Transfer-Encoding: base64" . $eol;
            $headers .= "Content-Disposition: attachment" . $eol . $eol;
            $headers .= chunk_split(base64_encode(file_get_contents($attachment["tmp_name"]))) . $eol . $eol;
            $headers .= "--" . $separator . "--";
        }
          
        $config = array (
                  'mailtype' => 'html',
                  'charset'  => 'utf-8'
                );
        $this->CI->email->initialize($config);
        $this->CI->email->from($sendor_email, $sendor_name);
        $this->CI->email->to($to_email); 
        if ($cc <> '')
            $this->email->cc($cc); 
        if ($bcc <> '')           
            $this->email->bcc($bcc); 

        $this->CI->email->subject($subject);
        $this->CI->email->message($body_html);
        if ($attachment["file_name"] != "") {  
           $this->CI->email->attach($attachment["tmp_name"]);
        }
        $this->CI->email->send();
    }
}

?>