<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class About_Us extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | About Us' ));
		$this->co->init();

		$id = $this->co->whoami();
		
		$this->co->page('internal/pages/about_us');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */