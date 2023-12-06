<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Listings_Model extends CI_Model {


public function __construct() {
parent::__construct();
}

public function getBranches($term=NULL){
$result = getBranches($term);
return $result;
}


public function getCustomers($term,$Bid){
	$cond = "";
	if($Bid!='')
	{
		$cond = " And bid = '".$Bid."'";
	}
  $query = "select top 20 Cid Id,CCode + ' - ' + Cname CName from CustFile Where  isnull(IsDeleted,0)=0 and (CName like '%".$term."%' OR CCode like '%".$term."%') $cond  order by Cid";	
$result = $this->db->query($query)->result_array();
return $result;
}



public function getUsers($term=NULL){
//$result = getUsers($term);
	
 $query = "select top 20 Cid Id,CCode + ' - ' + Cname CName from Emp Where  isnull(IsDeleted,0)=0 and (CName like '%".$term."%' OR CCode like '%".$term."%')  order by Cid";	
$result = $this->db->query($query)->result_array();	
return $result;
}



public function GetSupplierList($term=NULL){
//$result = getUsers($term);

$query = "select top 20 Cid Id,CCode + ' - ' + Cname CName from SupplierFile Where  isnull(IsDeleted,0)=0 and (Cname like '%".$term."%' OR CCode like '%".$term."%')  order by Cid";	
$result = $this->db->query($query)->result_array();	
return $result;
}


public function GetExpenseList($term=NULL){
//$result = getUsers($term);

 $query = "select top 20 GId Id,Code + ' - ' + NameArb CName from Expense Where  isnull(IsDeleted,0)=0 and (NameArb like '%".$term."%' OR Code like '%".$term."%')  order by GId";	
$result = $this->db->query($query)->result_array();	
return $result;
}


public function getProducts($term){

$query = "select TOP 20 Pid Id,Pcode + ' - ' + Pname CName from Product Where
isnull(IsDeleted,0)=0  and (PCode like '%".$term."%' or PName like '%".$term."%')   order by Pid";	
$result = $this->db->query($query)->result_array();	
//$result = getProducts($term);
return $result;
}

public function getProductsWithCode($term){

$query = "select TOP 20 Pcode Id,Pcode + ' - ' + Pname CName from Product Where
isnull(IsDeleted,0)=0  and (PCode like '%".$term."%' or PName like '%".$term."%')   order by Pid";
$result = $this->db->query($query)->result_array();
//$result = getProductsWithCode($term);
return $result;
}


public function getProductsWithOutCode($term){

$query = "select TOP 20 Pcode Id, Pname CName from Product Where
isnull(IsDeleted,0)=0  and (PCode like '%".$term."%' or PName like '%".$term."%')   order by Pid";
$result = $this->db->query($query)->result_array();
//$result = getProductsWithCode($term);
return $result;
}


public function getProductGroup($term=NULL){
	
$query = "select TOP 20 Gid  Id,Code + ' - ' + NameArb CName from productgroup Where
isnull(IsDeleted,0)=0  and (Code like '%".$term."%' or NameArb like '%".$term."%')   order by Gid";	
$result = $this->db->query($query)->result_array();	
//$result = getProductGroup($term);
return $result;
}
public function GetPurTypeList($term=NULL){
$query = "select TOP 20 Cid Id,CCode + ' - ' + Cname CName  from Pur_Type 
Where isnull(IsDeleted,0)=0   and (Cid like '%".$term."%' or CCode like '%".$term."%')   order by Cid";	
$result = $this->db->query($query)->result_array();	
return $result;
}
	
	
public function GetCustAreaList($term=NULL){
$query = "select TOP 20 GId Id,Code + ' - ' + NameArb CName  from CustArea 
Where GId like '%".$term."%' or Code like '%".$term."%'   order by GId";	
$result = $this->db->query($query)->result_array();	
return $result;
}
	
	
	
public function GetPurPurchaserList($term=NULL){
$query = "select TOP 5 Cid Id,CCode + ' - ' + Cname CName  from Purchaser 
Where isnull(IsDeleted,0)=0   and (Cid like '%".$term."%' or CCode like '%".$term."%')   order by Cid";	
$result = $this->db->query($query)->result_array();	
return $result;
}
	
	
public function GetProductType($term=NULL){
$query = "select TOP 20 Cid Id,CCode + ' - ' + Cname CName  from ProductType 
Where  (Cid like '%".$term."%' or CCode like '%".$term."%')   order by Cid";	
$result = $this->db->query($query)->result_array();	
return $result;
}
public function GetSupplierGroup($term=NULL){
$query = "select TOP 20 Gid Id,Code + ' - ' + NameArb CName  from SupplierGroup 
Where  (Gid like '%".$term."%' or Code like '%".$term."%' or NameArb like '%".$term."%')   order by Gid";	
$result = $this->db->query($query)->result_array();	
return $result;
}

}