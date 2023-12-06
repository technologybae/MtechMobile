<?php
//error_reporting(0);

define('dbObjectMain', '[MtechWebSuperAdmin].[dbo].Mtech_');

function RunMain($var)
{
$server = $_SERVER['SERVER_ADDR'];
$server = '217.76.50.216\VMI826410\SQLEXPRESS';

$user = 'Sa';
$pass = 'mTechOff4015113';
//Define Port
$port='8080';
$database = 'MtechWebSuperAdmin';

	
	
	
	
	
	
$conn = new PDO( "sqlsrv:server=$server,$port ; Database = $database", $user, $pass);  
$conn->setAttribute( PDO::SQLSRV_ATTR_ENCODING, PDO::ERRMODE_EXCEPTION );  
$stmt = $conn->query($var) or die (print_r($conn->errorInfo()));
return $stmt;
}


function myfetchMain($var)
{
$row = $var->fetchObject();
return $row;
}

function colfetchMain($var)
{
$row = $var->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
function colcountMain($var)
{
$row = $var->columnCount();
return $row;
}


//include("config/main_functions.php");

?>