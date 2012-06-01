<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Refer extends CI_Controller {

	function id($referer) {	
		if($referer == '') { show_404(); }
		$this->co->set_referer($referer);
		redirect(base_url(), 'location');
	}

}

/* End of file account.php */
/* Location: ./application/controllers/account.php */