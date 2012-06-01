<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Feedback extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Feedback' ));
		$this->co->init();

		$id = $this->co->whoami();
		
		$this->co->page('internal/pages/alpha_feedback');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */