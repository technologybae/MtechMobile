<?php

    session_start();
    error_reporting(0);
    include("./config/main_connection.php");
    include("./config/connection.php");
    // include("./config/functions.php");
    include("./config/main_functions.php");
    include("./Lib/qrCode/qrlib.php");


    $getLoginUserCompanyData = getLoginUserCompanyData($_SESSION['id']);

    $saleSp = "select * from dataOutReturn";
    $execute = Run($saleSp);
    // $getData = myfetch($execute);

    while($getData = myfetch($execute)){

        echo 'return <br>';
        // print_r($getData);
        echo $SBBillno = $getData->BillNo;
        echo $Bid = $getData->Bid;
        // die();

        //// Generate QR Code////
        $PNG_WEB_DIR = 'includes/salesreturn/QrCodes/';
        $PNG_TEMP_DIR = 'includes/salesreturn/QrCodes/';
        
        //html PNG location prefix
        $vatno= $getLoginUserCompanyData->vat;
        $CustomerName= $getLoginUserCompanyData->name;

        $ddd = "Invoice Number: ".$SBBillno."
        Sellers Name:".$CustomerName."
        Vat No: ".$vatno."
        Invoice Date & Time: ".date("Y-m-d H:i a",strtotime($getData->BillDate))." 
        Invoice Vat Total: ".$getData->totalVat."
        Invoice Total (with Vat): ".AmountValue($getData->vatPTotal)."
        ";
        // die();

        if (!file_exists($PNG_TEMP_DIR))
            mkdir($PNG_TEMP_DIR);

        $errorCorrectionLevel = 'H';
        if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

        $matrixPointSize = 4;
        if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

        $filename = $PNG_TEMP_DIR.'SaleReturn-'.$SBBillno.'-'.$Bid.'-'.$_SESSION['companyId'].'.png';
        QRcode::png(($ddd), $filename, $errorCorrectionLevel, $matrixPointSize, 2); 

    }


    $saleSp = "select * from dataOut";
    $execute = Run($saleSp);
    // $getData = myfetch($execute);

    while($getData = myfetch($execute)){


        // print_r($getData);
        echo 'sales <br>';

        // for metchmoile
        echo $SBBillno = $getData->Billno;
        $Bid = $getData->Bid;

        // for mtech
        // echo $SBBillno = $getData->Billno;
        // die();

        //// Generate QR Code////
        // sales return mtech
        $PNG_WEB_DIR = 'includes/sales/QrCodes/';
        $PNG_TEMP_DIR = 'includes/sales/QrCodes/';
        
        //html PNG location prefix
        $vatno= $getLoginUserCompanyData->vat;
        $CustomerName= $getLoginUserCompanyData->name;

        $ddd = "Invoice Number: ".$SBBillno."
        Sellers Name:".$CustomerName."
        Vat No: ".$vatno."
        Invoice Date & Time: ".date("Y-m-d H:i a",strtotime($getData->BillDate))." 
        Invoice Vat Total: ".$getData->totalVat."
        Invoice Total (with Vat): ".AmountValue($getData->vatPTotal)."
        ";
        // die();

        if (!file_exists($PNG_TEMP_DIR))
            mkdir($PNG_TEMP_DIR);

        $errorCorrectionLevel = 'H';
        if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

        $matrixPointSize = 4;
        if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

        $filename = $PNG_TEMP_DIR.'Sale-'.$SBBillno.'-'.$Bid.'-'.$_SESSION['companyId'].'.png';
        QRcode::png(($ddd), $filename, $errorCorrectionLevel, $matrixPointSize, 2); 

    }

?>