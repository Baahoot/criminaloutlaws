<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Notifications extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami();
		$alt = $this->co->__internal_user();
		
		if($alt['notifications'] == 0) {
			show_404();
		}
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Notifications ('.$alt['notifications'].')' ));
		
		$this->co->storage['notifications_count'] = $alt['notifications'];
		$this->co->page('internal/pages/notifications');
	}
	
}