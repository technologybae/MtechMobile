<?php

/**
 * Base Controller for Admin module
 */
class Admin_Controller extends CI_Controller {
	protected $layout = 'layouts/default';
	// Constructor
	public function __construct()
	{
		parent::__construct();
		$this->verify_auth();
	}

	// Verify user authentication
	protected function verify_auth($redirect_url = 'admin/login')
	{
		// obtain user data from session; redirect to Login page if not found
		if ($this->session->has_userdata('admin_user'))
			$this->mUser = $this->session->userdata('admin_user');
		else
			redirect($redirect_url);
	}
}