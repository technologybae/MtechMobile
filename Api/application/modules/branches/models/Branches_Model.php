<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Branches_Model extends CI_Model {


public function __construct() {
parent::__construct();
}

public function getList(){
$sql_ = 'EXEC  GetBranchList';
$result = $this->db->query($sql_)->result_array();
return $result;
}


}