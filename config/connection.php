<?php
session_start();
error_reporting(0);
define('dbObject', '['.$_SESSION['dbName'].'].[dbo].');

function Run($var)
{
$server = $_SERVER['SERVER_ADDR'];
$server = '217.76.50.216,8080\VMI826410\SQLEXPRESS';

$user = $_SESSION['dbUser'];
$pass = $_SESSION['dbPass'];
//Define Port
$port='Port='.$_SESSION['dbPort'];
$database = $_SESSION['dbName'];
$dbHost = $_SESSION['dbHost'];
if($dbHost=='154.53.40.18')
{
$server = $dbHost;
}
else
{
$server = $server.",".$_SESSION['dbPort'];
}
$conn = new PDO( "sqlsrv:server=$server; Database = $database", $user, $pass); 

$conn->setAttribute( PDO::SQLSRV_ATTR_ENCODING, PDO::ERRMODE_EXCEPTION );  
$stmt = $conn->query($var) or print_r ($conn->errorInfo());  
; 
return $stmt;
}


function myfetch($var)
{
$row = $var->fetchObject();
return $row;
}

function colfetch($var)
{
$row = $var->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
function colcount($var)
{
$row = $var->columnCount();
return $row;
}

function DateVal($vv)
{
	return date("d M,Y",strtotime($vv));
	
}
function AmtValue($vv)
{
	if(is_numeric($vv))
	{
	$vv =  number_format($vv,3);
	}
	return $vv;
}
include("config/functions.php");

?>