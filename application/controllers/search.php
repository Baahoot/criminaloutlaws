<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Search extends CI_Controller {

	public function suggestions()
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Search Suggestions' ));
		$ir = $this->co->whoami();
		
		if($this->input->get_post('q') && strlen($this->input->get_post('q')) < 17) {
			$q = $this->input->get_post('q');
			$q = "\"{$q}\"* {$q}*";
			
			$get_from_cache = $this->db->query("SELECT *, MATCH(username) AGAINST (? IN BOOLEAN MODE) AS score FROM username_cache LEFT JOIN online ON username_cache.userid = online.userid WHERE MATCH(username) AGAINST (? IN BOOLEAN MODE) ORDER BY score ASC LIMIT 5;", array($q, $q))->result_array();
			
			$users = array();
			if(count($get_from_cache) > 0) {
			
				foreach($get_from_cache as $i => $id) {
					$users[ $id['userid'] ] = array(
						'username' => $id['username'],
						'online' => ($id['laston'] > now()-60*15 ? '1' : '0')
					);
				}
			
			}
			
			header("Content-Type: text/javascript");
			echo json_encode(array(
					'count' => count($get_from_cache),
					'users' => $users
				)
			);
		
		}
	}

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Search' ));
		$ir = $this->co->whoami();
		
		if($this->input->get_post('q') && strlen($this->input->get_post('q')) < 17) {
			$q = $this->input->get_post('q');
			$q = '+' . $q . '*';
			
			$get_from_cache = $this->db->query("SELECT *, MATCH(username) AGAINST (? IN BOOLEAN MODE) AS score FROM username_cache WHERE MATCH(username) AGAINST (? IN BOOLEAN MODE) ORDER BY score ASC", array($q,$q))->result_array();
			
			$ids = array();
			foreach($get_from_cache as $i => $id) {
				$ids[] = $id['userid'];
			}
			
			$count = count($ids);
			
			if($count > 0) {
				$userq = $this->db->select($this->co->user_default)->from('users')->join('online', 'users.userid = online.userid', 'left')->where_in('users.userid', $ids)->get()->result_array();
				
				foreach($userq as $id => $r)
				{
					if($this->input->get_post('q') == $r['username'])
					{
						/* We've found someone who's an exact match! */
						$this->co->redirect( base_url() . 'user/' . $r['username'] );
					}
				}
				
			} else {
				//no results
			}
			
			$this->co->storage['count'] = $count;
			$this->co->storage['users'] = (isset($userq) ? $userq : array());
			
		}
		
		$this->co->page('internal/pages/search');	
	}
		
}