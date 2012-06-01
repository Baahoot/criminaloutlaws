<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class User extends CI_Controller {

	public function lookup( $username )
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->load->helper('smiley');
		$this->co->init();
		$ir = $this->co->whoami();
		
		if(!$username) {
			show_404();
		}
		
		if($this->co->user_exists($username, 'USERNAME_ONLY') == false) {
			show_404();
		}
		
		$r = $this->co->get_user($username, array_merge(
				$this->co->user_default,
				array(
					'users.user_duties',
					'users.last_login',
					'users.display_pic',
					'usersigs.signature',
					'jobranks.rank_name',
					'jobs.job_name'
				)
			)
		);
		
		$this->co->storage['profile'] = $r;
		$this->co->set(array( 'title' => 'Criminal Outlaws | Profile for ' . $r['username'] ));
		$this->co->statistics_up('total_profiles_viewed');
		$this->co->page('internal/pages/profile');	
	}
		
}