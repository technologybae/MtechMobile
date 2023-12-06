	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Listings extends Public_Controller {


	public function __construct() {
	parent::__construct();
	$this->load->model('Listings_Model','model');
	}



	public function getBranches()
	{
	$data = json_decode(file_get_contents('php://input'), true);
	//$term = $data['term'];
    $list = $this->model->getBranches();
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}

	public function getCustomers()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';
    $Bid = !empty($_REQUEST['bid']) ? $_REQUEST['bid']: '';
	
		
		
    $list = $this->model->getCustomers($term,$Bid);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}



	public function getUsers()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';
    $list = $this->model->getUsers($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}




	public function GetSupplierList()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';
    $list = $this->model->GetSupplierList($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}
		
public function GetExpenseList()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';
    $list = $this->model->GetExpenseList($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}




	public function getProducts()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';

    $list = $this->model->getProducts($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}

    public function getProductsWithCode()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';

    $list = $this->model->getProductsWithCode($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}

    public function getProductsWithOutCode()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';

    $list = $this->model->getProductsWithOutCode($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}

	public function getProductGroup()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';
    $list = $this->model->getProductGroup($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}	
	public function GetPurTypeList()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';
    $list = $this->model->GetPurTypeList($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}
		
		public function GetCustAreaList()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';
    $list = $this->model->GetCustAreaList($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}
		
		
		
	public function GetPurPurchaserList()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';
    $list = $this->model->GetPurPurchaserList($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}
	public function GetProductType()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';
    $list = $this->model->GetProductType($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}
public function GetSupplierGroup()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $term = !empty($_REQUEST['term']) ? $_REQUEST['term']: '';
    $list = $this->model->GetSupplierGroup($term);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	echo json_encode($response);
	exit;
	}


	}
