<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Contacts extends CI_Controller {

	public function create()
	{
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami();
		$this->co->pro_only();
		
		if(!$this->input->get('user') || $this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		if(!$this->co->user_exists($this->input->get('user'), 'USERNAME_ONLY') && $this->input->get('user') == $ir['username']) {
			show_404();
		}
		
		$tuser = $this->co->get_user($this->input->get('user'), array( 'users.userid' ));
		$tuserid = $tuser['userid'];
		
		$limit = $this->db->select('*')->from('contactlist')->where('cl_ADDER', $this->co->user['userid'])->limit($this->config->item('contact-limit'))->count_all_results();
		if($limit >= $this->config->item('contact-limit')) {
			$this->co->notice('Sorry, you have reached the '.$this->config->item('contact-limit').' contact limit quota.');
			$this->co->redirect(base_url() . 'user/' . $this->input->get('user'));
		} else if($this->db->select('*')->from('contactlist')->where('cl_ADDER', $this->co->user['userid'])->where('cl_ADDED', $tuserid)->limit($this->config->item('contact-limit'))->count_all_results() > 0) {
			$this->co->notice('Sorry, you have already added '.$this->input->get('user').'!');
		} else {
			$this->db->insert('contactlist', array(
					'cl_ADDER' => $ir['userid'],
					'cl_ADDED' => $tuserid
				)
			);
			
			$ir['contact_count']++;
			$this->co->statistics_up('contacts_total_added');
			$this->db->set('contact_count', $ir['contact_count'])->where('userid', $ir['userid'])->update('users');
			
			if( ! $this->input->is_ajax_request())
			{
				$this->co->notice('You have added '.$this->input->get('user').' to your contact list!');
			}
		}

		$this->co->redirect(base_url() . 'user/' . $this->input->get('user'));
		/* $this->co->redirect(base_url() . 'contacts'); */
	}
	
	public function remove()
	{
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami();
		$this->co->pro_only();
		
		if(!$this->input->get('user') || $this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		if(!$this->co->user_exists($this->input->get('user'), 'USERNAME_ONLY') && $this->input->get('user') == $ir['username']) {
			show_404();
		}
		
		$tuser = $this->co->get_user($this->input->get('user'), array( 'users.userid' ));
		$tuserid = $tuser['userid'];
		
		if($this->db->select('*')->from('contactlist')->where('cl_ADDER', $this->co->user['userid'])->where('cl_ADDED', $tuserid)->limit($this->config->item('contact-limit'))->count_all_results() == 0) {
			$this->co->notice('Sorry, you dont have '.$this->input->get('user').' on your contact list!');
		} else {
			$this->db->where('cl_ADDER', $this->co->user['userid'])->where('cl_ADDED', $tuserid)->delete('contactlist');			
			
			if(! $this->input->is_ajax_request()) {
				$this->co->notice('You have removed '.$this->input->get('user').' to your contact list!');
			}
			
			$ir['contact_count']--;
			$this->co->statistics_up('contacts_total_removed');
			$this->db->set('contact_count', $ir['contact_count'])->where('userid', $ir['userid'])->update('users');
		}
		if($this->input->get('profile') == 1) { $this->co->redirect(base_url() . 'user/' . $this->input->get('user')); } else { $this->co->redirect(base_url() . 'contacts'); }
	}

	public function index()
	{
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami();
		$this->co->pro_only();
		
		$this->co->storage['per_page'] = 50;
		$this->co->storage['page'] = ($this->input->get('page') > 0 ? $this->input->get('page') : 1);
		$this->co->storage['page']--;
		$this->co->storage['start_from'] = abs($this->co->storage['per_page'] * $this->co->storage['page']);
		$this->co->storage['end_at'] = $this->co->storage['start_from'] + $this->co->storage['per_page'];
		
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
		
		$_ids = array();
		foreach($this->db->select('*')->from('contactlist')->where('cl_ADDER', $this->co->user['userid'])->limit($this->config->item('contact-limit'))->get()->result_array() as $i=>$r) {
			$_ids[] = $r['cl_ADDED'];
		}
		
		if(count($_ids)) {
			$this->co->storage['users'] = $this->db->select(implode(', ', $userdata))->from('users')->where_in('userid', $_ids)->order_by($sort, ($this->input->get('order') == 'DESC' ? 'DESC' : 'ASC'))->limit($this->co->storage['per_page'], $this->co->storage['start_from'])->get();
			$this->co->storage['users_count'] = $ir['contact_count'];
		} else {
			$this->co->storage['users'] = FALSE;
			$this->co->storage['users_count'] = FALSE;
		}
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Contact List' ));
		
		$users = $this->co->storage['users'];
		
		if($this->co->storage['end_at'] > $this->co->storage['users_count']) {
			$this->co->storage['end_at'] = $this->co->storage['users_count'];
		}
		
		$base_url = base_url() . 'contacts';
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
		
		$this->co->page('internal/pages/contacts');	
	}
		
}