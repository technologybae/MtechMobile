	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Customers extends Public_Controller {


	public function __construct() {
	parent::__construct();
	$this->load->model('Customers_Model','model');
	}



	public function list()
	{
	$data = json_decode(file_get_contents('php://input'), true);
	$list = $this->model->getList();
	http_response_code(200);
	$response = array("data" => $list,"message" => "List Successfully!", "status" => "Success");
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
	$this->model->delete($id);
	http_response_code(200);
	$response = array("message" => "Record Deleted Successfully!", "status" => "Success");
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
        public function getStates()
        {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'];
            $secret_key = $data['secret_key'];


            if($secret_key == API_SECRET_KEY)
            {
                $list = $this->model->getStateList($id);
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
	}
