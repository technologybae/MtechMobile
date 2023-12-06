<?php
/**
 * Base Controller for auth module
 */
class Auth_Controller extends CI_Controller {
	protected $layoutPath = 'shared/layouts/';
	// Constructor
	public function __construct()
	{
		parent::__construct();
		$this->set_layout('default');
		$this->verify_auth();
	}

	// Verify user authentication
	protected function verify_auth($redirect_url = 'register')
	{
		// obtain user data from session; redirect to Login page if not found
		if ($this->session->has_userdata('front_user'))
			$this->mUser = $this->session->userdata('front_user');
		else
			redirect($redirect_url);
	}

	public function set_layout($layout){
		return $this->layout = $this->layoutPath.$layout;
	}
}