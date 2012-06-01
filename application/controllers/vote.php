<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Vote extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Vote for Us' ));
		$ir = $this->co->whoami();
		
		$this->co->page('internal/pages/vote');		
	}
	
}