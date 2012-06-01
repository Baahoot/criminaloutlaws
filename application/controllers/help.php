<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Help extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Help' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		$this->co->page('internal/pages/help');	
	}
	
	public function faq()
	{
		$this->co->allow_jail(); $this->co->allow_hospital();
		$routing = $this->config->item('help');
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami();
		
		$i = $this->input->get('item');
		if( ! isset( $routing[$i] ) ) {
			$this->co->set(array( 'title' => 'Criminal Outlaws | Help Page Currently Unavailable' ));
			$this->co->page('internal/help/unavailable');
			//show_404();
		} else {
			$r = $routing[$i];
			$this->co->set(array( 'title' => 'Criminal Outlaws | '.$r['title'].' Help' ));
			$this->co->page($r['page']);
		}
	}
		
}