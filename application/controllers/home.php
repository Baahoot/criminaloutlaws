<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Home extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_jail();
		$this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Home' ));
		$this->co->init();
		
		$id = $this->co->whoami(array( 'userstats.*' ));
		
		$this->co->storage['notepad_cost'] = 1000.00;
		$item = $this->db->query("SELECT notepad, notepad_updated FROM usernotepads WHERE userid = ? LIMIT 1", array($id['userid']));
		
		if($this->input->post('action') == $this->co->get_session())
		{
			$this->db->query("UPDATE usernotepads SET notepad = ?, notepad_updated = ? WHERE userid = ". $id['userid'] ." LIMIT 1;", array( $this->input->post('notepad'), now() ));
			
			if($item->num_rows() == 0) {
				$this->co->storage['notepad_purchased'] = 0;
				$this->co->notice('Sorry, you need to buy a notepad before you can use it!');
			} else {
				$this->co->storage['notepad_purchased'] = 1;
				$this->co->storage['notepad'] = $this->input->post('notepad');
				$this->co->storage['updated'] = 'Last saved 0 seconds ago';
			}
			
		} else {
			$m = $item->result_array();
			
			if(isset($m[0]['notepad_updated']) && $m[0]['notepad_updated'] > 0) {
				$this->co->storage['notepad_purchased'] = 1;
				$this->co->storage['notepad'] = $m[0]['notepad'];
				$this->co->storage['updated'] = 'Last saved ' . $this->co->since($m[0]['notepad_updated']) . ' ago';
			} elseif(isset($m[0])) {
				$this->co->storage['notepad_purchased'] = 1;
				$this->co->storage['notepad'] = '';
				$this->co->storage['updated'] = 'Never saved';
			} else {
				$this->co->storage['notepad_purchased'] = 0;
			}
		}
		
		if($this->input->get('buy') == 'notepad' && $this->co->storage['notepad_purchased'] == 0) {
			if($this->co->user['money'] > $this->co->storage['notepad_cost']) {
				$this->db->insert("usernotepads", array(
						'notepad' => '',
						'notepad_updated' => 0,
						'userid' => $this->co->user['userid']
					)
				);
				$this->co->remove_money($this->co->user['username'], $this->co->storage['notepad_cost']);
			
				$this->co->notice('You\'ve just bought a notepad from the shop for $' . $this->co->storage['notepad_cost']);
				$this->co->storage['notepad_purchased'] = 1;
				$this->co->storage['notepad'] = '';
				$this->co->storage['updated'] = 'Never saved';
			} else {
				$this->co->notice('Sorry, you need $' . $this->co->storage['notepad_cost'] . ' to buy a notepad from the shop');
			}
			
		}
		
		$this->co->page('internal/pages/home');
	}
	
	public function logout() {
		if( ! $this->input->get('__session__') || $this->input->get('__session__') != $this->co->get_session()) {
			show_404();
		}
		
		//$this->co->notice('You have successfully logged out of your account. Thank you for playing!');
		$this->co->logout_user();
	}
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */