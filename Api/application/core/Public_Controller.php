<?php
/**
 * Base Controller for public module
 */
class Public_Controller extends CI_Controller {
	
	//protected $layout = 'default';
	protected $layoutPath = 'shared/layouts/';
	// Constructor
	public function __construct()
	{
		
		parent::__construct();
		$this->set_layout('default');
	}

	public function set_layout($layout){
		return $this->layout = $this->layoutPath.$layout;
	}
}