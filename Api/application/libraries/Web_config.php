<?php
class Web_config
{
  public function __construct()
  {
  		//$this->setSiteConfig();
  		define('SITE_ASSETS_PATH',base_url().'assets/site/');
		define('SITE_UPLOADS_PATH',base_url().'uploads/');
  }
  
  	public function setSiteConfig(){
		$ci = &get_instance ();
		$countries = array ();
		$table = $ci->db->dbprefix . 'site_settings';
		$ci->db->select ( '*' );
		$q = $ci->db->get ( $table );
		if ($q->num_rows () > 0) {
			foreach ( $q->result () as $row ) {
				foreach ($row as $k=>$v){
					define(strtoupper($k) , $v);
				}
			}
		}
	}
}
?>