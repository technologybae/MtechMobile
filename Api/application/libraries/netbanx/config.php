<?php

$optimalApiKeyId = '18844-1000032164';
$optimalApiKeySecret = 'B-qa2-0-55660e79-0-302d02147d160c2dc825583ed7e7c193814e5a7d131639ef0215008e421738035ed29285ff33dec78607a229215121';
$optimalAccountNumber = '1000032164';
// The currencyCode should match the currency of your Optimal account. 
// The currencyBaseUnitsMultipler should in turn match the currencyCode.
// Since the API accepts only integer values, the currencyBaseUnitMultiplier is used convert the decimal amount into the accepted base units integer value.
$currencyCode = 'USD'; // for example: CAD
$currencyBaseUnitsMultiplier = ''; // for example: 100 

require_once('optimalpayments.php');