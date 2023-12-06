<?php
session_start();
error_reporting(0);
include("../../config/connection.php");
include("../../config/functions.php");
include("../../config/main_connection.php");
include("../../config/main_functions.php");
include("../../config/templates.php");
$Bid = $_REQUEST['b_id'];
$Bid = !empty($Bid) ? $Bid: '2';
 $Billno = $_REQUEST['bill_id'];
$LanguageId = $_REQUEST['LanguageId'];
$to = $_REQUEST['email'];
$subject = "Sale Return Invoice - ".$Billno;
$from = '';

 $message = getSaleReturnPrintTemplateNew($Billno,$Bid,$LanguageId);
echo $mailSEnd = EmailSend($to,$subject,$message,$from);


?>