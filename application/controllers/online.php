<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Online extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami();
		
		$max_time = now() - 60*60*24;
		
		$users = $this->db->select(implode(', ', $this->co->user_default))->from('users')->join('online', 'online.userid = users.userid')->where('online.laston >', $max_time)->order_by('online.laston', 'DESC')->get();
		
		$this->co->storage['users'] = $users->result_array();
		$this->co->storage['total_online'] = $users->num_rows();
		$this->co->storage['max_time'] = $max_time;
		
		$this->co->storage['online'] = array(
			'15mins' => 0,
			'hour' => 0,
			'day' => 0
		);
		
		$this->co->storage['online_list'] = array(
			'15mins' => array(),
			'hour' => array(),
			'day' => array()
		);
		
		foreach($users->result_array() as $i => $r) {
			if($r['laston'] > now() - 60*15) { $this->co->storage['online']['15mins']++; $this->co->storage['online_list']['15mins'][] = $r; }
			else if($r['laston'] > now() - 60*60) { $this->co->storage['online']['hour']++; $this->co->storage['online_list']['hour'][] = $r; }
			else if($r['laston'] > now() - 60*60*24) { $this->co->storage['online']['day']++; $this->co->storage['online_list']['day'][] = $r; }
		}
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Users Online ('.$this->co->storage['online']['15mins'].')' ));
		$this->co->page('internal/pages/online');	
	}
		
}