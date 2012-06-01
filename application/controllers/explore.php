<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Explore extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Explore' ));
		$this->co->init();

		$id = $this->co->whoami();
		
		$this->co->storage['online'] = $this->db->select(implode(', ', $this->co->user_default))->from('online')->where('online.laston >', now() - 60*15)->order_by('online.laston', 'DESC')->count_all_results();
		
		$this->co->page('internal/pages/explore');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */