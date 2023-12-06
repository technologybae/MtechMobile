<?php
$servername = $_SERVER['SERVER_NAME'];

if($servername=='localhost')
{
define('API_URL', 'http://localhost/Mtech/Api/');
}
else
{
	define('API_URL', 'http://154.53.40.18:8080/Mtech/Api/');

}




function AmountValue($vv)
{
	if(is_numeric($vv))
	{
	$vv =  number_format($vv,3);
	}
	return $vv;
}

function DateValue($vv)
{
	return date("d M,Y",strtotime($vv));
	
}
function getLanguage($user)
{
	return "1";
}

function submit_request($action,$data)
{
$data['PosId'] = "2";
// API URL
$url = API_URL.$action;
// Create a new cURL resource
$ch = curl_init($url);
$payload = json_encode($data);

//echo $url ;
//echo "<br/>";
//echo $payload;
//echo "<br/>";
//	die();

// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Execute the POST request
$result = curl_exec($ch);
//var_dump($result);
// Close cURL resource
curl_close($ch);
$response = json_decode($result);


//print_r($result);


//print_r($response);


return $response;
}


function GetSalesGroup($branchIdsh, $transaction_type, $from_bill_no, $to_bill_no, $from_date, $to_date, $customer_id, $user_id, $UsrId,$from_product_id , $to_product_id, $product_group_id, $amount, $selected_lang,$amount_type)
{
$data = array();
$data['bid']=$branchIdsh;
$data['SpType']=$transaction_type;
$data['FBillno']=$from_bill_no;
$data['TBillno']=$to_bill_no;
$data['dt']=$from_date;
$data['dt2']=$to_date;
$data['CustSupId']=$customer_id;
$data['EmpId']=$user_id;
$data['UsrId']=$UsrId;
$data['FPid']=$from_product_id;
$data['TPrid']=$to_product_id;
$data['PGroupId']=$product_group_id;
$data['CrAmount']=$amount;
$data['LanguageId']=$selected_lang;
$data['amount_type']=$amount_type;
$response = submit_request('reports/getSalesReportGroup',$data);	
return $response->data;	
}




function GetSalesGen($branchIdsh, $transaction_type, $from_bill_no, $to_bill_no, $from_date, $to_date, $customer_id, $user_id, $UsrId,$from_product_id , $to_product_id, $product_group_id, $amount, $selected_lang,$amount_type,$GroupByType,$OrderBy)
{
$data = array();
$data['bid']=$branchIdsh;
$data['SpType']=$transaction_type;
$data['FBillno']=$from_bill_no;
$data['TBillno']=$to_bill_no;
$data['dt']=$from_date;
$data['dt2']=$to_date;
$data['CustSupId']=$customer_id;
$data['EmpId']=$user_id;
$data['UsrId']=$UsrId;
$data['FPid']=$from_product_id;
$data['TPrid']=$to_product_id;
$data['PGroupId']=$product_group_id;
$data['CrAmount']=$amount;
$data['LanguageId']=$selected_lang;
$data['amount_type']=$amount_type;
$data['GroupByType']=$GroupByType;
$data['OrderBy']=$OrderBy;
$response = submit_request('reports/GetSalesGen',$data);	
return $response->data;	
}







function GetSalesDet($branchIdsh, $transaction_type, $from_bill_no, $to_bill_no, $from_date, $to_date, $customer_id, $user_id, $UsrId,$from_product_id , $to_product_id, $product_group_id, $amount, $selected_lang,$amount_type,$OrderBy)
{
$data = array();
$data['bid']=$branchIdsh;
$data['SpType']=$transaction_type;
$data['FBillno']=$from_bill_no;
$data['TBillno']=$to_bill_no;
$data['dt']=$from_date;
$data['dt2']=$to_date;
$data['CustSupId']=$customer_id;
$data['EmpId']=$user_id;
$data['UsrId']=$UsrId;
$data['FPid']=$from_product_id;
$data['TPrid']=$to_product_id;
$data['PGroupId']=$product_group_id;
$data['CrAmount']=$amount;
$data['LanguageId']=$selected_lang;
$data['amount_type']=$amount_type;
$data['OrderBy']=$OrderBy;
$response = submit_request('reports/GetSalesDet',$data);	
return $response->data;	
}







function getBranches()
{
$data = array();
$response = submit_request('reports/getBranches',$data);	
return $response->data;	
}


function getCustomerDetails($id)
{
$query = Run("Select * from ".dbObject."CustFile where Cid = '".$id."'");
$fetch = myfetch($query);
return $fetch;	
}

function getUserDetails($id)
{
$query = Run("Select * from ".dbObject."Emp where Cid = '".$id."'");
$fetch = myfetch($query);
return $fetch;	
}

function getSupplierDetails($id)
{
$query = Run("Select * from ".dbObject."SupplierFile where Cid = '".$id."'");
$fetch = myfetch($query);
return $fetch;	
}


function getExpenseIdDetails($id)
{
$query = Run("Select * from ".dbObject."Expense where GId = '".$id."'");
$fetch = myfetch($query);
return $fetch;	
}



function getProductDetails($id)
{
$query = Run("Select Pid Id,Pcode + ' - ' + Pname CName from ".dbObject."Product where Pid = '".$id."'");
$fetch = myfetch($query);
return $fetch;	
}






function getProductGroupDetails($id)
{
$query = Run("Select Gid  Id,Code + ' - ' + NameArb CName from ".dbObject."productgroup where Gid = '".$id."'");
$fetch = myfetch($query);
return $fetch;	
}


function getSupplierGroupDetails($id)
{
$query = Run("select TOP 5 Cid Id,CCode + ' - ' + Cname CName  from  ".dbObject."ProductType where Cid = '".$id."'");
$fetch = myfetch($query);
return $fetch;	
}

function GetProductType($id)
{
$query = Run("Select Gid  Id,Code + ' - ' + NameArb CName from ".dbObject."SupplierGroup where Gid = '".$id."'");
$fetch = myfetch($query);
return $fetch;	
}

function ProductStockConditionCriteria()
{
$array = array();
	
array_push($array, ['id' => 1,'name'=>'Balance']);	
array_push($array, ['id' => 2,'name'=>'OpenQty']);		
array_push($array, ['id' => 3,'name'=>'CarryForwordBalance']);
	
array_push($array, ['id' => 4,'name'=>'Purchase']);
	
array_push($array, ['id' => 5,'name'=>'Purchase Return']);	
	
array_push($array, ['id' => 6,'name'=>'Stock Out']);	

array_push($array, ['id' => 7,'name'=>'Sales']);	
array_push($array, ['id' => 8,'name'=>'Sales Return']);	
	
array_push($array, ['id' => 9,'name'=>'BranchTransfer']);	
	
	
array_push($array, ['id' => 10,'name'=>'BranchTransferReceived']);	
		
	
array_push($array, ['id' => 11,'name'=>'Production']);		
	
	
array_push($array, ['id' => 12,'name'=>'Production Rawmeterial']);		

array_push($array, ['id' => 13,'name'=>'Production De-Composit']);	
	
	
array_push($array, ['id' => 14,'name'=>'Production De-Composit Rawmeterial']);	

	
array_push($array, ['id' => 15,'name'=>'StockReceivingQty']);	
	
	
array_push($array, ['id' => 16,'name'=>'DeliveryQTy']);	
		
	
array_push($array, ['id' => 17,'name'=>'SalQtyIn']);	
		
array_push($array, ['id' => 18,'name'=>'SalQtyOut']);	
return $array;	
}
function EmailSend($to,$subject,$message,$from)
{
$from = "Mtechsols.pak@gmail.com";	
$header = "From:".$from." \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";
$retval = mail ($to,$subject,$message,$header);
$variable = "Email Sending Error";
if($retval == true) {
$variable = "Email Sent";
}
return $variable;
}

function AmountInWords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}

function getArabicTitle($str)
{
$server = $_SERVER['SERVER_ADDR'];
$server = '217.76.50.216\VMI826410\SQLEXPRESS';

$user = 'Sa';
$pass = 'mTechOff4015113';
//Define Port
$port='8080';
$database = 'MtechWebSuperAdmin';

$var = "Select * from Mtech_translations where english = '".$str."'";
$conn = new PDO( "sqlsrv:server=$server,$port ; Database = $database", $user, $pass);  
$conn->setAttribute( PDO::SQLSRV_ATTR_ENCODING, PDO::ERRMODE_EXCEPTION );  
$stmt = $conn->query($var) or die (print_r($conn->errorInfo()));

$row = $stmt->fetchObject();
$arabic = $row->arabic;
if(empty($arabic))
{
$arabic =  $str;
}

return $arabic;
}

?>