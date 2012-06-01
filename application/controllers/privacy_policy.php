<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Privacy_Policy extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Privacy Policy' ));
		$this->co->init();

		$id = $this->co->whoami();
		
		$this->co->page('internal/pages/privacy_policy');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */