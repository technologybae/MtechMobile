<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Reports_Model extends CI_Model {


public function __construct() {
parent::__construct();
}


public function getSalesReportGroup($data){
$bid = !empty($data['bid']) ? $data['bid']: '';
$SpType = !empty($data['SpType']) ? $data['SpType']: '0';
$FBillno = !empty($data['FBillno']) ? $data['FBillno']: '';
$TBillno = !empty($data['TBillno']) ? $data['TBillno']: '';

$dt = !empty($data['dt']) ? $data['dt']: null;
$dt2 = !empty($data['dt2']) ? $data['dt2']: null;
$CustSupId = !empty($data['CustSupId']) ? $data['CustSupId']: '0';
$UsrId = !empty($data['UsrId']) ? $data['UsrId']: '0';

$FPid = !empty($data['FPid']) ? $data['FPid']: '0';
$TPrid = !empty($data['TPrid']) ? $data['TPrid']: '0';
$PGroupId = !empty($data['PGroupId']) ? $data['PGroupId']: '0';
$CrAmount = !empty($data['CrAmount']) ? $data['CrAmount']: '0';
$LanguageId = !empty($data['LanguageId']) ? $data['LanguageId']: '1';
$PosId = !empty($data['PosId']) ? $data['PosId']: '2';
$amount_type = !empty($data['amount_type']) ? $data['amount_type']: '=';


$sql_ = "EXEC  GetSalesGroup @bid='".$bid."',@SpType='".$SpType."',@FBillno='".$FBillno."',@TBillno='".$TBillno."',@dt='".$dt."',@dt2='".$dt2."',@CustSupId='".$CustSupId."',@UsrId='".$UsrId."',@FPid='".$FPid."',@TPrid='".$TPrid."',@PGroupId='".$PGroupId."',@CrAmount='".$amount_type."".$CrAmount."'  ,@LanguageId='".$LanguageId."' ,@PosId='".$PosId."'  ";

$result = $this->db->query($sql_)->result_array();
return $result;
}




public function GetSalesGen($data){
	$bid = $data['bid'];
	$GroupByType = !empty($data['GroupByType']) ? $data['GroupByType']: '0';
    $SpType = !empty($data['SpType']) ? $data['SpType']: '0';
	$FBillno = !empty($data['FBillno']) ? $data['FBillno']: '';
	$TBillno = !empty($data['TBillno']) ? $data['TBillno']: '';
	
	$dt = !empty($data['dt']) ? $data['dt']: NULL;
	$dt2 = !empty($data['dt2']) ? $data['dt2']: NULL;
	$CustSupId = !empty($data['CustSupId']) ? $data['CustSupId']: '0';
	$UsrId = !empty($data['UsrId']) ? $data['UsrId']: '0';
	
	
	$CrAmount = !empty($data['CrAmount']) ? $data['CrAmount']: '0';
	$LanguageId = !empty($data['LanguageId']) ? $data['LanguageId']: '1';
	$amount_type = !empty($data['amount_type']) ? $data['amount_type']: '=';
	
	$OrderBy = !empty($data['OrderBy']) ? $data['OrderBy']: '';

	 $sql_ = "EXEC  GetSalesGen @bid='".$bid."',@GroupByType='".$GroupByType."',@SpType='".$SpType."',@FBillno='".$FBillno."',@TBillno='".$TBillno."',@dt='".$dt."',@dt2='".$dt2."',@CustSupId='".$CustSupId."',@UsrId='".$UsrId."',@CrAmount='".$amount_type."".$CrAmount."',@LanguageId='".$LanguageId."',@OrderBy='".$OrderBy."'";
	
	$result = $this->db->query($sql_)->result_array();
	return $result;
	}
	







	public function GetSalesDet($data){
		$bid = !empty($data['bid']) ? $data['bid']: '';
		$GroupByType = !empty($data['GroupByType']) ? $data['GroupByType']: '0';

		$SpType = !empty($data['SpType']) ? $data['SpType']: '0';
		$FBillno = !empty($data['FBillno']) ? $data['FBillno']: '0';
		$TBillno = !empty($data['TBillno']) ? $data['TBillno']: '0';
		
		$dt = !empty($data['dt']) ? $data['dt']: NULL;
		$dt2 = !empty($data['dt2']) ? $data['dt2']: NULL;
		$CustSupId = !empty($data['CustSupId']) ? $data['CustSupId']: '0';
		$UsrId = !empty($data['UsrId']) ? $data['UsrId']: '0';
		
		$FPid = !empty($data['FPid']) ? $data['FPid']: '0';
		$TPrid = !empty($data['TPrid']) ? $data['TPrid']: '0';
		$PGroupId = !empty($data['PGroupId']) ? $data['PGroupId']: '0';
		$CrAmount = !empty($data['CrAmount']) ? $data['CrAmount']: '0';
		$LanguageId = !empty($data['LanguageId']) ? $data['LanguageId']: '1';
		$amount_type = !empty($data['amount_type']) ? $data['amount_type']: '=';
		$OrderBy = !empty($data['OrderBy']) ? $data['OrderBy']: '=';

		
		 $sql_ = "EXEC  GetSalesDet @GroupByType='".$GroupByType."',@bid='".$bid."',@SpType='".$SpType."',@FBillno='".$FBillno."',@TBillno='".$TBillno."',@dt='$dt',@dt2='$dt2',@CustSupId='".$CustSupId."',@UsrId='".$UsrId."',@FPid='".$FPid."',@TPrid='".$TPrid."',@PGroupId='".$PGroupId."',@CrAmount='".$amount_type."".$CrAmount."'  ,@LanguageId='".$LanguageId."',@OrderBy='".$OrderBy."'  ";


		$result = $this->db->query($sql_)->result_array();
		return $result;
		}
		










}