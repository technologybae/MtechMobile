	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Reports extends Public_Controller {


	public function __construct() {
	parent::__construct();
	$this->load->model('Reports_Model','model');


	}







public function getSalesReportGroup()
{
$data = json_decode(file_get_contents('php://input'), true);
$bid = $data['bid'];
if($bid=='All')
{
$branchesArray = array();
$bids = getBranches('');
foreach($bids as $single)
{
$ss = $single['Id'];
array_push($branchesArray,$ss);
}

$data['bid'] = implode(",",$branchesArray);
}
$list = $this->model->getSalesReportGroup($data);
http_response_code(200);
$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
echo json_encode($response);
exit;
}





public function GetSalesGen()
{
$data = json_decode(file_get_contents('php://input'), true);
 $bid = $data['bid'];

if($bid=='All')
{
$branchesArray = array();
$bids = getBranches('');
foreach($bids as $single)
{
$ss = $single['Id'];
array_push($branchesArray,$ss);
}

$data['bid'] = implode(",",$branchesArray);
}


$list = $this->model->GetSalesGen($data);
http_response_code(200);
$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
echo json_encode($response);
exit;
}



public function GetSalesDet()
{
$data = json_decode(file_get_contents('php://input'), true);
$bid = $data['bid'];
if($bid=='All')
{
$branchesArray = array();
$bids = getBranches('');
foreach($bids as $single)
{
$ss = $single['Id'];
array_push($branchesArray,$ss);
}

$data['bid'] = implode(",",$branchesArray);
}
$list = $this->model->GetSalesDet($data);
http_response_code(200);
$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
echo json_encode($response);
exit;
}






	}
