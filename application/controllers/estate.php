<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Estate extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Real Estates' ));
		$ir = $this->co->whoami();
		
		$this->co->page('internal/pages/estate');		
	}
	
	public function sell()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Sell Property' ));
		$ir = $this->co->whoami();
		
		$sess = $this->input->get('__unique__');
		
		if($sess != $this->co->get_session()) {
			show_404();
		}
		
		if($ir['hWILL'] < 101 || $ir['hPRICE'] == 0) {
			$this->co->notice('Sorry, you do not own a house which has any monetary value.');
			$this->co->redirect(base_url() . 'estate');
		}
		
		$ir['money'] += $ir['hPRICE'];
		$ir['maxwill'] = 100;
		$ir['will'] = ($ir['will'] > $ir['maxwill'] ? 100 : $ir['will']);
		
		$this->db->set('money', $ir['money'])->set('will', $ir['will'])->set('maxwill', $ir['maxwill'])->where('userid', $ir['userid'])->update('users');
		$this->co->notice('You sold your '.$ir['hNAME'].' for $'.number_format($ir['hPRICE'], 2).' and went back to a Cardboard Box!');
		$this->co->redirect(base_url() . 'estate');
		
	}
	
	public function buy()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Buy Property' ));
		$ir = $this->co->whoami();
		
		$id = $this->input->get('id');
		$sess = $this->input->get('__unique__');
		
		if( (!$id) || ($sess != $this->co->get_session()) ) {
			show_404();
		}
		
		$propertydata = $this->co->get_house('id', $id);
		if( ! isset($propertydata['hID'])) {
			$this->co->notice('Sorry, the house you are trying to buy does not exist.');
			$this->co->redirect(base_url() . 'estate');
		}
		
		if($ir['hWILL'] > 100):
		
			if($propertydata['hPRICE'] > $ir['hPRICE']):
				$required_amount = $propertydata['hPRICE'] - $ir['hPRICE'];
				
				if($ir['money'] < $required_amount) {
					$this->co->notice('You need $'.number_format($required_amount - $ir['money'], 2).' more to buy the '.$propertydata['hNAME'].'!');
					$this->co->redirect(base_url() . 'estate');
				}
				
				$ir['money'] -= $required_amount;
				$this->db->set('money', $ir['money'])->set('maxwill', $propertydata['hWILL'])->where('userid', $ir['userid'])->update('users');
				$this->co->notice('You have upgraded to a '.$propertydata['hNAME'].' and have been charged $'.number_format($required_amount, 2) . '!');
			else:
				$give_amount = $ir['hPRICE'] - $propertydata['hPRICE'];
				$ir['money'] += $give_amount;
				$this->db->set('money', $ir['money'])->set('maxwill', $propertydata['hWILL'])->where('userid', $ir['userid'])->update('users');
				$this->co->notice('You have downgraded to a '.$propertydata['hNAME'].' and have been given $'.number_format($give_amount, 2) . '!');
			endif;
			
			$this->co->redirect(base_url() . 'estate');
		else:
		
			if($ir['money'] < $propertydata['hPRICE']) {
				$this->co->notice('You need $'.number_format($propertydata['hPRICE'] - $ir['money'], 2).' more to buy the '.$propertydata['hNAME'].'!');
				$this->co->redirect(base_url() . 'estate');
			}
			
			$ir['money'] -= $propertydata['hPRICE'];
			$ir['will'] = ($ir['will'] > $propertydata['hWILL'] ? $propertydata['hWILL'] : $ir['will']);
			$ir['will'] = ($propertydata['hWILL'] < $ir['maxwill'] ? 0 : $ir['will']);
			$this->db->set('maxwill', $propertydata['hWILL'])->set('will', $ir['will'])->set('money', $ir['money'])->where('userid', $ir['userid'])->update('users');
			$this->co->notice('You have just bought the '.$propertydata['hNAME'].' for $'.number_format($propertydata['hPRICE'], 2).'!');
			$this->co->redirect(base_url() . 'estate');
			
		endif;
		
		$this->co->redirect(base_url() . 'estate');
		
	}

}