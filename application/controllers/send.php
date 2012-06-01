<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Send extends CI_Controller {

	public function gold()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Send Gold' ));
		$this->co->init();

		$ir = $this->co->whoami();
		$user = $this->input->get('username');
		
		if( ! $this->co->user_exists( $user, 'USERNAME_ONLY') || $user == $ir['username'] ) {
			show_404();
		}
		
		$r = $this->co->get_user($user, array( 'users.userid', 'users.crystals', 'users.hospital', 'users.jail' ));
		
		if( $ir['jail'] > now() || $ir['hospital'] > now() || $r['jail'] > now() || $r['hospital'] > now() ) {
			show_404();
		}
		
		if($this->input->post('__unique__') == $this->co->get_session()) {
		
			$amount = $this->input->post('crystals');
			$amount = round( $amount );
			
			if($amount <= 0 || $amount > $ir['crystals']) {
				$this->co->notice('Sorry, you do not have this amount of gold in possession to send.');
			}
			
			else {
			
				$this->co->statistics_up('total_gold_sent', $amount);
				$this->co->statistics_up('total_gold_received', $amount, $r['userid']);
				
				$this->co->remove_crystals( $ir['username'], $amount );
				$this->co->add_crystals( $user, $amount );
				$this->co->event_add( $user, "<a href='".base_url()."user/".$ir['username']."' rel='ajax'>".$ir['username']."</a> has just sent you ".number_format($amount)." gold!");
				$this->co->notice('You have successfully sent '.number_format( $amount) .' gold to '.$user.'!');
				$this->co->redirect( base_url() . 'user/' . $user );
			}
			
		}
		
		$this->co->page('internal/pages/sendgold');	
	}

	public function money()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Send Money' ));
		$this->co->init();

		$ir = $this->co->whoami();
		$user = $this->input->get('username');
		
		if( ! $this->co->user_exists( $user, 'USERNAME_ONLY') || $user == $ir['username'] ) {
			show_404();
		}
		
		$r = $this->co->get_user($user, array( 'users.userid', 'users.money', 'users.hospital', 'users.jail' ));
		
		if( $ir['jail'] > now() || $ir['hospital'] > now() || $r['jail'] > now() || $r['hospital'] > now() ) {
			show_404();
		}
		
		if($this->input->post('__unique__') == $this->co->get_session()) {
		
			$amount = $this->input->post('money');
			$amount = round( $amount, 2 );
			
			if($amount <= 0 || $amount > $ir['money']) {
				$this->co->notice('Sorry, you do not have this amount of money in possession to send.');
			}
			
			else {
			
				$this->co->statistics_up('total_money_sent', $amount);
				$this->co->statistics_up('total_money_received', $amount, $r['userid']);
			
				$this->co->remove_money( $ir['username'], $amount );
				$this->co->add_money( $user, $amount );
				$this->co->event_add( $user, "<a href='".base_url()."user/".$ir['username']."' rel='ajax'>".$ir['username']."</a> has just sent you $".number_format($amount, 2)." money!");
				$this->co->notice('You have successfully sent $'.number_format( $amount, 2) .' to '.$user.'!');
				$this->co->redirect( base_url() . 'user/' . $user );
			}
			
		}
		
		$this->co->page('internal/pages/sendmoney');	
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */