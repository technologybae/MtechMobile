	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Vendors extends Public_Controller {

	protected $_table  = "vendors";

	public function __construct() {
	parent::__construct();
	$this->load->model('Vendor_model','model');
	}




	public function activeList()
	{
	$data = json_decode(file_get_contents('php://input'), true);
	$secret_key = $data['secret_key'];
      $category_id = $data['category_id'];
	if($secret_key == API_SECRET_KEY)
	{
	$list = $this->model->getactiveList($category_id);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	}
	else
	{
	http_response_code(401);
	$response = array("message" => "Invalid Secret Key!", "status" => "Error");
	}

	echo json_encode($response);
	exit;
	}

	public function searchVendors()
	{
	$data = json_decode(file_get_contents('php://input'), true);
	$secret_key = $data['secret_key'];
      $category_id = $data['category_id'];
        $vendor_id = $data['vendor_id'];
	if($secret_key == API_SECRET_KEY)
	{
	$list = $this->model->getsearchVendorList($category_id,$vendor_id);
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	}
	else
	{
	http_response_code(401);
	$response = array("message" => "Invalid Secret Key!", "status" => "Error");
	}

	echo json_encode($response);
	exit;
	}
	/////search vendors on category/shop page sidebar//////
        public function searchVendorsMainProducts()
        {
            $data = json_decode(file_get_contents('php://input'), true);
            $secret_key = $data['secret_key'];
            $search = $data['search'];
            if($secret_key == API_SECRET_KEY)
            {
                $list = $this->model->getsearchVendorListMainProducts($search);
                http_response_code(200);
                $response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
            }
            else
            {
                http_response_code(401);
                $response = array("message" => "Invalid Secret Key!", "status" => "Error");
            }

            echo json_encode($response);
            exit;
        }
        /////search vendors list by category id on category/shop page sidebar//////
        public function searchCategoryVendorsList()
        {
            $data = json_decode(file_get_contents('php://input'), true);
            $secret_key = $data['secret_key'];
            $cateogry_id = $data['category_id'];
            $vendor_id = $data['vendor_id'];
            $data = array('category_id' =>$cateogry_id,'vendor_id'=>$vendor_id);

            if($secret_key == API_SECRET_KEY)
            {
                $list = $this->model->searchCategoryVendorsList($cateogry_id);
                http_response_code(200);
                $response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
            }
            else
            {
                http_response_code(401);
                $response = array("message" => "Invalid Secret Key!", "status" => "Error");
            }

            echo json_encode($response);
            exit;
        }


	public function list()
	{
	$data = json_decode(file_get_contents('php://input'), true);
	$secret_key = $data['secret_key'];

	if($secret_key == API_SECRET_KEY)
	{
	$list = $this->model->getList();
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
	}
	else
	{
	http_response_code(401);
	$response = array("message" => "Invalid Secret Key!", "status" => "Error");
	}

	echo json_encode($response);
	exit;
	}

		
	public function insert()
	{
	$data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $display_order = $data['display_order'];

	$secret_key = $data['secret_key'];

	if( $name!='' && $display_order!='')
	{
	$data = array('name' => $name, 'display_order' => $display_order);
	if($secret_key == API_SECRET_KEY)
	{
	$insert  = $this->model->insert($data);
	if($insert=='inserted')
	{
	http_response_code(200);
	$response = array("message" => "Record Inserted Successfully!", "status" => "Success");
	}
	if($insert=='error')
	{
	http_response_code(409);
	$response = array("message" => "Name Already Exists!", "status" => "Error");

	}
	}
	else
	{
	http_response_code(401);
	$response = array("message" => "Invalid Secret Key!", "status" => "Error");
	}
	}
	else
	{
	http_response_code(400);
	$response = array("message" => "Unable to insert Record, Missing Parameters!", "status" => "Error");
	}

	echo json_encode($response);
	exit;
	}

		
		
	
	public function update()
	{

	$data = json_decode(file_get_contents('php://input'), true);
	$name = $data['name'];
	$display_order = $data['display_order'];
	$status = $data['status'];

	$id = $data['id'];
	$secret_key = $data['secret_key'];

	if($name!='' && $display_order!=''  && $id!='' && $status!='')
	{
	 $data = array('name' => $name, 'status' => $status, 'display_order' => $display_order, 'id' => $id);
	 if($secret_key == API_SECRET_KEY)
	{
	$update  = $this->model->update($data);
    if($update=='success')
	{
	http_response_code(200);
	$response = array("message" => "Record Updated Successfully!", "status" => "Success");
	}
	if($update=='error')
	{
	http_response_code(409);
	$response = array("message" => "Name Already Exists!", "status" => "Error");

	}
	}


	else
	{
	http_response_code(401);
	$response = array("message" => "Invalid Secret Key!", "status" => "Error");
	}
	}
	else
	{
	http_response_code(400);
	$response = array("message" => "Unable to update Record, Missing Parameters!", "status" => "Error");
	}

	echo json_encode($response);
	exit;
	}

	

	public function delete()
	{

	$data = json_decode(file_get_contents('php://input'), true);
	$id = $data['id'];

	$secret_key = $data['secret_key'];

	if($id)
	{
	if($secret_key == API_SECRET_KEY)
	{
	$delete = $this->model->delete($id);
	if($delete=="success")
	{
	http_response_code(200);
	$response = array("message" => "Vendor Deleted Successfully!", "status" => "Success");
	}
	if($delete=="error")
	{
	http_response_code(401);
	$response = array("message" => "Please Delete Its Product(s) First!", "status" => "Error");
	}
	
	}
	else
	{
	http_response_code(401);
	$response = array("message" => "Invalid Secret Key!", "status" => "Error");
	}
	}
	else
	{
	http_response_code(400);
	$response = array("message" => "Unable to Delete Record, Missing Parameters!", "status" => "Error");
	}

	echo json_encode($response);
	exit;
	}









	public function single()
	{
	$data = json_decode(file_get_contents('php://input'), true);
	$secret_key = $data['secret_key'];
	$id = $data['id'];

	if($secret_key == API_SECRET_KEY)
	{
	$list = $this->model->single_record($id);
	http_response_code(200);
	$response = array("data" => $list,"message" => "Record Found Successfully!", "status" => "Success");
	}
	else
	{
	http_response_code(401);
	$response = array("message" => "Invalid Secret Key!", "status" => "Error");
	}

	echo json_encode($response);
	exit;
	}
		
	}
