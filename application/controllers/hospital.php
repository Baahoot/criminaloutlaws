<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Hospital extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_hospital();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Hospital ('.$this->co->config['hospital_count'].')' ));
		$ir = $this->co->whoami();
		
		$this->co->storage['patients'] = $this->db->select('*')->from('users')->where('hospital >', now())->order_by('hospital', 'ASC')->get()->result_array();
		
		if(count($this->co->storage['patients']) != $this->co->config['hospital_count']) {
			$this->co->update_config('hospital_count', count($this->co->storage['patients']));
		}
		
		$this->co->page('internal/pages/hospital');		
	}

}