<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Airport extends CI_Controller {

	public function visit() {
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Airport' ));
		$this->co->init();

		$ir = $this->co->whoami();
		$city = $this->input->get('city');
		if(!$city || $this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		$citydata = $this->co->cities[$city];
		
		if($ir['location'] == $citydata['cityid']) {
			show_404();
		}
		
		if($citydata['cityminlevel'] > $ir['level']) {
			show_404();
		}
		
		if($citydata['citycost'] > $ir['money']) {
			show_404();
		}
		
		$ir['money'] -= $citydata['citycost'];
		$this->db->set('money', $ir['money'])->set('location', $citydata['cityid'])->where('userid', $ir['userid'])->update('users');
		
		$this->co->statistics_up('total_visits');
		$this->co->notice('You have bought a ticket to '.$citydata['cityname'].' for $'.number_format($citydata['citycost'], 2).'!');
		$this->co->redirect( base_url() . 'airport');
		
	}

	public function index()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Airport' ));
		$this->co->init();

		$id = $this->co->whoami();
		
		$this->co->page('internal/pages/airport');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */