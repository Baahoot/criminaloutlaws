<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Users extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | User List' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		$this->co->storage['per_page'] = 100;
		$this->co->storage['page'] = ($this->input->get('page') > 0 ? $this->input->get('page') : 1);
		$this->co->storage['page']--;
		$this->co->storage['start_from'] = abs($this->co->storage['per_page'] * $this->co->storage['page']);
		$this->co->storage['end_at'] = $this->co->storage['start_from'] + $this->co->storage['per_page'];
		
		// The key is what the URL was read, and the value is what it will be converted to
		$valid_param = array(
			'userid' => 'userid',
			'username' => 'username',
			'level' => 'level',
			'money' => 'money',
			'gold' => 'crystals',
			'gender' => 'gender'
		);
		
		$sort_id = @$valid_param[$this->input->get('sort')];
		
		if($this->input->get('sort') && isset($valid_param[$sort_id])) {
			$sort = $valid_param[$sort_id];
		} else {
			$sort = 'userid';
		}
		
		$userdata = $this->co->user_default;
		foreach($userdata as $sid => $str) { if($str == 'online.laston') { unset($userdata[$sid]); } }
		$this->co->storage['users'] = $this->db->select(implode(', ', $userdata))->from('users')->order_by($sort, ($this->input->get('order') == 'DESC' ? 'DESC' : 'ASC'))->limit($this->co->storage['per_page'], $this->co->storage['start_from'])->get();
		$this->co->storage['users_count'] = $this->db->select(implode(', ', $userdata))->from('users')->count_all_results();
		
		$users = $this->co->storage['users'];
		
		if($this->co->storage['end_at'] > $this->co->storage['users_count']) {
			$this->co->storage['end_at'] = $this->co->storage['users_count'];
		}
		
		if($users->num_rows() == 0) {
			show_404();
		}
		
		
		$base_url = base_url() . 'users';
		
		$compile_url = array();
		
		if($this->input->get('sort')) {
			$compile_url[] = 'sort='.$this->input->get('sort');
		}
		
		if($this->input->get('order')) {
			$compile_url[] = 'order='.$this->input->get('order');
		}
		
		if(count($compile_url)) {
			$base_url .= '?' . implode('&', $compile_url) . '&';
		} else {
			$base_url .= '?';
		}
		
		
		$pages = ceil($this->co->storage['users_count'] / $this->co->storage['per_page']);
		$links = array();
		foreach(range(1, $pages) as $row) {
			$links[] = '<a href="'.$base_url.'page='.$row.'" rel="ajax">'.$row.'</a>';
		}
		
		if(count($links)) {
			$this->co->storage['pagination'] = implode(' ', $links);
		}
		
		$this->co->page('internal/pages/users');	
	}
		
}