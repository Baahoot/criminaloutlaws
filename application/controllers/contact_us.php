<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Contact_Us extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Contact Us' ));
		$this->co->init();

		$ir = $this->co->whoami(array(
				'users.email'
			)
		);
		
		if($this->input->post('__unique__') == $this->co->get_session()) {
		
			$email = $ir['email'];
		
			if( ! $this->input->post('subject') ) {
				$this->co->notice('Sorry, you need to enter a subject!');
			}
			
			else if( ! $this->input->post('message') ) {
				$this->co->notice('Sorry, you need to enter a message!');
			}
			
			else {
			
				$this->db->insert('tickets', array(
						'ticket_user' => $ir['userid'],
						'ticket_ip' => $this->input->ip_address(),
						'ticket_time' => now(),
						'ticket_subject' => $this->input->post('subject'),
						'ticket_message' => $this->input->post('message'),
						'ticket_seen' => '0'
					)
				);
				
				$_POST = array();
				$this->co->notice('You have successfully sent your message to our support team!');
			
			}
		
		}
		
		$this->co->page('internal/pages/contact_us');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */