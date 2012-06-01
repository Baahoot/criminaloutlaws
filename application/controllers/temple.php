<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Temple extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Gold Temple' ));
		$this->co->init();

		$ir = $this->co->whoami();
		
		$this->co->page('internal/pages/goldtemple');	
	}
	
	public function order()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Gold Temple' ));
		$this->co->init();

		$ir = $this->co->whoami(array(
				'users.exp',
				'userstats.IQ'
			)
		);
		
		if( ! $this->input->get('action')) {
			show_404();
		}
		
		$action = $this->input->get('action');
	
		if($action == "exp" && $this->input->get('__unique__') == $this->co->get_session())
		{
			$amount = 100;
			
			if($ir['crystals'] < $amount) {
				/* Not enough crystals! */
				$this->co->notice('Sorry, you need '.($amount - $ir['crystals']).' more gold to see your EXP levels!');
				$this->co->redirect(base_url() . 'temple');
			}
			
			$alt = $this->co->__internal_user();
			$perc = ceil( ($ir['exp'] / $alt['exp_needed']) * 100);
			$this->co->remove_crystals($ir['username'], $amount);
			$this->co->notice('Thanks for your purchase. We will send you an event with your EXP levels shortly.');
			$this->co->statistics_up('total_gold_traded', $amount);
			$this->co->event_add($ir['username'], "Your EXP percentage is ".$perc."% with your current EXP being ".$ir['exp']." and ".($alt['exp_needed']-$ir['exp'])." more EXP needed to level up!");
			$this->co->redirect(base_url() . 'temple');
		}
		
		elseif($action == "energy")
		{
		
			if($this->input->get_post('__unique__') == $this->co->get_session()) {
				
				if( ! $this->input->post('gold') || $this->input->post('gold') > $ir['crystals'] || $this->input->post('gold') < 1) {
					$this->co->notice('Sorry, you do not have this much gold to trade.');
					$this->co->redirect(base_url() . 'temple/order?action=energy');
				}
				
				elseif($ir['energy'] >= $ir['maxenergy']) {
					$this->co->notice('Sorry, you already have full power so you do not need to trade any gold in.');
					$this->co->redirect(base_url() . 'temple');
				}
				
				elseif( $this->input->post('gold') + $ir['energy'] > $ir['maxenergy'] ) {
					$this->co->notice('Sorry, you cannot gain this much energy as you will already have fully refilled.');
					$this->co->redirect(base_url() . 'temple');
				}
				
				else {
					$energy = $this->input->post('gold');
					$ir['energy'] += $energy;
					$ir['crystals'] -= $energy;
					$this->co->statistics_up('total_gold_traded', $energy);
					$this->db->set('crystals', $ir['crystals'])->set('energy', $ir['energy'])->where('userid', $ir['userid'])->update('users');
					$this->co->notice('You gained '.$energy.' energy by trading in '.$energy.' gold!');
					$this->co->redirect(base_url() . 'temple');
				}
			
			}
		
			$this->co->page('internal/pages/goldtemple-energy');
		}
		
		elseif($action == "iq") {
		
			if($this->input->get_post('__unique__') == $this->co->get_session()) {
				
				if( ! $this->input->post('gold') || $this->input->post('gold') > $ir['crystals'] || $this->input->post('gold') < 1) {
					$this->co->notice('Sorry, you do not have this much gold to trade.');
					$this->co->redirect(base_url() . 'temple/order?action=energy');
				}
				
				else {
					$cost = $this->input->post('gold');
					$gain = $cost * 2;
					
					$ir['IQ'] += $gain;
					
					$this->co->statistics_up('total_gold_traded', $cost);
					$this->co->remove_crystals($ir['username'], $cost);
					$this->db->set('IQ', $ir['IQ'])->where('userid', $ir['userid'])->update('userstats');
					$this->co->notice('You gained '.$gain.' intelligence on your stats by trading in '.$cost.' gold!');
					$this->co->redirect(base_url() . 'temple');
				}
			
			}
		
			$this->co->page('internal/pages/goldtemple-iq');
		
		}
		
		else {
			show_404();
		}
		
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */