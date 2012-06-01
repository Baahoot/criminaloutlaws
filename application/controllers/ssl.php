<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Ssl extends CI_Controller {

	public function index()
	{
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->init();
		
		if($this->input->server('HTTP_HOST') == 'game.ssl.dotcloud.com') {
			//On SSL
			$ssl = 1;
			$url = 'http://www.criminaloutlaws.com/' . $this->input->get('redirect');
		} else {
			//Not on SSL
			$ssl = 0;
			$url = 'https://game.ssl.dotcloud.com/' . $this->input->get('redirect');
		}
		
		if($this->co->is_logged_in()) {
			$ir = $this->co->whoami();
			$this_cookie = get_cookie($this->config->item('session_name'));
			
			$cookie = array(
				'name'   => $this->config->item('session_name'),
				'value'  => $this_cookie,
				'expire' => 60*60*24,
				'domain' => ($ssl == 1 ? '.criminaloutlaws.com' : 'game.ssl.dotcloud.com'),
				'path'   => '/',
				'secure' => ($ssl = 1 ? FALSE : TRUE)
			);
			set_cookie($cookie);
			
			if($this->input->get('__unique__') == $this->co->get_session()) {
				delete_cookie($this->config->item('session_name'));
			}
			
		}
		
		redirect($url);
		
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */