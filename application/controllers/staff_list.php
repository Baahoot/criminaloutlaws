<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Staff_List extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Staff List' ));
		$ir = $this->co->whoami();
		
		$this->co->storage['staff_list'] = $this->db->select('*')->from('users')->where('user_level >', 1)->order_by('userid', 'ASC')->get()->result_array();
		
		$this->co->storage['staff_count'] = array();
		
		foreach($this->co->storage['staff_list'] as $i => $r) {
			$this->co->storage['staff_count'][$r['user_level']] = (isset($this->co->storage['staff_count'][$r['user_level']]) ? $this->co->storage['staff_count'][$r['user_level']] : 0);
			$this->co->storage['staff_count'][$r['user_level']]++;
		}
		
		$this->co->page('internal/pages/staff_list');	
	}
		
}