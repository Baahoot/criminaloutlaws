<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Events extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->init();

		$ir = $this->co->whoami();
		$cnt = ($ir['new_events'] > 0) ? ' ('.$ir['new_events'].')' : '';
		$this->co->set(array( 'title' => 'Criminal Outlaws | Events'));
		$this->co->storage['cnt'] = $cnt;
		
		$this->co->storage['events'] = $this->db->query("SELECT * FROM events WHERE evUSER = ? ORDER BY evTIME DESC LIMIT 10;", $ir['userid'])->result_array();
		$this->db->query("UPDATE events SET evREAD = 1 WHERE evUSER = ? AND evREAD = 0", $ir['userid']);
		$this->db->query("UPDATE users SET new_events = 0 WHERE userid = ? LIMIT 1", $ir['userid']);
		$this->co->page('internal/pages/events');
		
	}
	
	public function delete() {
		$id = $this->input->get('id');
		$sess = $this->input->get('__sess__');
		
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Delete Event'));
		$this->co->init();

		$ir = $this->co->whoami();
		
		if(!isset($id)) {
			show_404();
		}
		
		if($sess != $this->co->get_session()) {
			show_404();
		}
		
		$q = $this->db->query("DELETE FROM events WHERE evUSER = ? AND evID = ? LIMIT 1", array( $ir['userid'], $id ));
		
		if($this->db->affected_rows() > 0 && ! $this->input->is_ajax_request()) {
			$this->co->notice('The event you selected has successfully been deleted!');
		}
		
		else if( ! $this->input->is_ajax_request()) {
			$this->co->notice('The system could not process the request you tried to make.');
		}
		
		$this->co->redirect(base_url() . 'events');		
	}

}