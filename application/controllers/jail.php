<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Jail extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_jail();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Jail ('.$this->co->config['jail_count'].')' ));
		$ir = $this->co->whoami();
		
		$this->co->storage['prisoners'] = $this->db->select('*')->from('users')->where('jail >', now())->order_by('jail', 'ASC')->get()->result_array();
		
		if(count($this->co->storage['prisoners']) != $this->co->config['jail_count']) {
			$this->co->update_config('jail_count', count($this->co->storage['prisoners']));
		}
		
		$this->co->page('internal/pages/jail');		
	}

}