	<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Vendor_model extends CI_Model {

	protected $_table  = "vendors";
	protected $_view  = "view_product_details";
	protected $_table_products  = "products";
    protected $_filter_view = "view_filter_products";
    protected $_main_products_view = "main_products_view";

	public function __construct() {
	parent::__construct();
	}

	public function single_record($id){
	$sql_ = 'SELECT * FROM '.$this->db->dbprefix($this->_table).' WHERE id = '.$id.' LIMIT 1';
	$data = $this->db->query($sql_)->row();
	return $data;
	}


	public function getList(){
	$sql_ = 'SELECT * FROM '.$this->db->dbprefix($this->_table).'  order by display_order asc';
	$result = $this->db->query($sql_)->result_array();
	return $result;
	}


	public function getsearchVendorList($category_id,$vendor_id){
        if(empty($category_id) || empty($vendor_id)) {
            $sql_ = "SELECT products.vendor_id,COUNT(products.id) AS pcount,vendors.name FROM products INNER JOIN vendors ON vendors.id = products.vendor_id WHERE products.status = '1' GROUP BY products.vendor_id ORDER BY COUNT(products.id) DESC";
        }
        if(!empty($category_id)) {
            $sql_ = "SELECT products.vendor_id,COUNT(products.id) AS pcount,vendors.name FROM products INNER JOIN vendors ON vendors.id = products.vendor_id WHERE products.status = '1' AND products.category_id = '" . $category_id . "' GROUP BY products.vendor_id,products.category_id ORDER BY COUNT(products.id) DESC";
        }
        if(!empty($vendor_id)){
            $sql_ = "SELECT products.vendor_id,COUNT(products.id) AS pcount,vendors.name,products.category_id FROM products INNER JOIN vendors ON vendors.id = products.vendor_id WHERE products.status = '1' And products.vendor_id = '".$vendor_id."' GROUP BY products.vendor_id ORDER BY COUNT(products.id) DESC";
        }
        $result = $this->db->query($sql_)->result_array();
		return $result;
		}

        /////search vendors on category/shop page sidebar//////
        public function getsearchVendorListMainProducts($search){

            $sql_ = 'SELECT category_id AS category_id,vendor_id AS id,vender_name AS NAME,COUNT(vendor_id) AS p_count FROM ' . $this->db->dbprefix($this->_filter_view) . '  WHERE (category_name LIKE "%'.$search.'%" || vender_name LIKE "%'.$search.'%" || product_description LIKE "%'.$search.'%" || short_description LIKE "%'.$search.'%" || sku LIKE "%'.$search.'%") GROUP BY vendor_id   ORDER BY product_id ASC';
            $result = $this->db->query($sql_)->result_array();
            return $result;
        }
        /////search vendors list by category id on category/shop page sidebar//////
        public function searchCategoryVendorsList($cateogry_id){

            $sql_ = 'SELECT COUNT(*) AS p_count FROM ' . $this->db->dbprefix($this->_view) . '  WHERE  category_id = "'.$cateogry_id.'"     ORDER BY id ASC';
            $result = $this->db->query($sql_)->result_array();
            return $result;
        }
















	public function getactiveList($category_id){
		$record = array();
		$sql_ = 'SELECT * FROM '.$this->db->dbprefix($this->_table).' where status= "1" order by display_order asc';
		$result = $this->db->query($sql_)->result_array();
        foreach($result as $single)
        {
			$vendors_count = $this->vendor_product_count($single['id'],$category_id);
     array_push($record, ['id' => $single['id'], 'name' => $single['name'], 'p_count' => $vendors_count]);
        }

		return $record;
		}
	
 public function vendor_product_count($id,$category_id)
 {

     ///////// Get Categories ////////////
	 $category_array= array();
	 $quers = "Select id from categories where id = '".$category_id."' || is_parent= '".$category_id."'";
	
	$cat_query = $this->db->query($quers)->result_array();
	$and ="";
	foreach($cat_query as $singleCat)
	{
		
		array_push($category_array, $singleCat['id']);
	
	}
	$categories = implode(",",$category_array);
	$and .= " and category_id IN (".$categories .")";
	


$qq = "Select count(id) as p_count from products where vendor_id = '".$id."' and status = '1' $and ";
$query = $this->db->query($qq)->row();
$p_count = $query->p_count;
if($p_count=="")
{
	$p_count = 0;
}
return$p_count;
 }

	public function insert($data){

	$_sql = 'SELECT * FROM '.$this->db->dbprefix($this->_table).' WHERE name= "'.$data['name'].'"  LIMIT 1';
	$record = $this->db->query($_sql)->row();
	if (empty($record))
	{
	$sql_ = 'INSERT INTO '.$this->db->dbprefix($this->_table).' (name,display_order) VALUES ("'.$data['name'].'","'.$data['display_order'].'")';
	$this->db->query($sql_);
	return "inserted";
	}
	else{

	return "error";
	}





	}

	public function update($data){
	$_sql = 'SELECT * FROM '.$this->db->dbprefix($this->_table).' WHERE name= "'.$data['name'].'" and id!="'.$data['id'].'"  LIMIT 1';
	$record = $this->db->query($_sql)->row();
	if (empty($record))
	{

	$sql_ ="update ".$this->db->dbprefix($this->_table)."  set name = '".$data['name']."',display_order = '".$data['display_order']."',status = '".$data['status']."' where id = '".$data['id']."'";
	$this->db->query($sql_);
	return "success";
	}
	else{
	return "error";
	}

	}



	public function delete($id){
	$status = "error";
	$_sql2 = 'SELECT * FROM '.$this->db->dbprefix($this->_table_products).' WHERE vendor_id="'.$id.'"';
	$record2 = $this->db->query($_sql2)->row();
	if(empty($record2))
	{
	$status = "success";
	$sql_ = 'DELETE FROM '.$this->db->dbprefix($this->_table).' WHERE id = '.$id;
	$this->db->query($sql_);
	}
	return $status;
	}


















	}