<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Bank extends CI_Controller {

	public function withdraw()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Bank' ));
		$this->co->init();

		$ir = $this->co->whoami(array(
				'users.bankinterest'
			)
		);
		
		$plan = 0;
		if($ir['bankinterest']) {
			foreach($this->co->interest as $v=>$b) { if($b['interest'] == $ir['bankinterest']) { $plan = $b['interest_id']; } }
		}
		$next = $plan + 1;
		$amount = $this->input->post('amount');
		
		if( ! $amount || $ir['bankmoney'] < 1 || $this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		if( $amount <= 0 || $amount > $ir['bankmoney']) {
			$this->co->notice('You do not have this money to withdraw from your bank account!');
			$this->co->redirect( base_url() . 'bank/home' );
		}
	
		$ir['money'] += $amount;
		$ir['bankmoney'] -= $amount;
		
		$this->db->set('money', $ir['money'])->set('bankmoney', $ir['bankmoney'])->where('userid', $ir['userid'])->update('users');
		$this->co->notice('You withdrew $' . number_format($amount, 2) . ' from your bank account successfully!');
		$this->co->redirect( base_url() . 'bank/home' );
	}

	public function deposit()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Bank' ));
		$this->co->init();

		$ir = $this->co->whoami(array(
				'users.bankinterest'
			)
		);
		
		$plan = 0;
		if($ir['bankinterest']) {
			foreach($this->co->interest as $v=>$b) { if($b['interest'] == $ir['bankinterest']) { $plan = $b['interest_id']; } }
		}
		$next = $plan + 1;
		$amount = $this->input->post('amount');
		
		if( ! $amount || $ir['money'] < 1 || $this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		if( $amount <= 0 || $amount > $ir['money']) {
			$this->co->notice('You do not have this money to deposit in your account!');
			$this->co->redirect( base_url() . 'bank/home' );
		}
	
		if( isset($this->co->interest[$next]) && $amount > round($this->co->interest[$next]['min_money'] - $ir['bankmoney'], 2)) {
			$this->co->notice('Sorry, you can only deposit $' . number_format($this->co->interest[$next]['min_money'] - $ir['bankmoney'], 2) . ' more in your account!');
			$this->co->redirect( base_url() . 'bank/home' );
		}
	
		$ir['money'] -= $amount;
		if($amount != '0.01') { 
			$fee = round(($amount / 100) * 4, 2);
			$fee = ($fee > 50000 ? 50000 : $fee);
		} else {
			$fee = 0;
		}
		$gross = $amount - $fee;
		$ir['bankmoney'] += $gross;
		$this->co->statistics_up('bank_total_costs', $fee);
		$this->co->statistics_up('bank_total_deposited', $gross);
		
		$this->db->set('money', $ir['money'])->set('bankmoney', $ir['bankmoney'])->where('userid', $ir['userid'])->update('users');
		$this->co->notice('You deposited $' . number_format($amount, 2) . ' in your bank account! ($'.number_format($gross, 2).' after fees)');
		$this->co->redirect( base_url() . 'bank/home' );

	}

	public function plan()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Bank' ));
		$this->co->init();

		$ir = $this->co->whoami(array(
				'users.bankinterest'
			)
		);
		
		$plan = 0;
		if($ir['bankinterest']) {
			foreach($this->co->interest as $v=>$b) { if($b['interest'] == $ir['bankinterest']) { $plan = $b['interest_id']; } }
		}
		
		if($this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		if( $plan != 0 && ! is_array( $this->co->interest[$plan] ) ) {
			show_404();
		}
		
		$n = $plan + 1;
		if( is_array( $this->co->interest[$n] ) ) {
			$limit = $this->co->interest[$n]['min_money'];
			$cost = $this->co->interest[$n]['cost'];
		} else {
			$limit = -1;
		}
		
		if($limit == -1) {
			$this->co->notice('Sorry, you already have the highest interest option available.');
		} elseif($cost > $ir['money']) {
			$this->co->notice('You need $'.number_format($cost - $ir['money'], 2).' more to be able to do this!');
		} else {
		
			$this->co->statistics_up('bank_total_costs', ($plan == 0 ? $this->config->item('bank-cost') : $this->co->interest[$n]['interest']));
			if($plan == 0) {
				$this->co->notice('You have successfully opened a bank account for $' . number_format($this->config->item('bank-cost'), 2) . '!');
				$ir['money'] -= $cost;
				$this->db->set('money', $ir['money'])->set('bankinterest', $this->co->interest[$n]['interest'])->set('bankmoney', 0)->where('userid', $ir['userid'])->update('users');
			} else {
				$this->co->notice('You have successfully upgraded to a '.number_format($this->co->interest[$n]['interest'], 2).'% interest account for $'.number_format($cost).'!');
				$ir['money'] -= $cost;
				$this->db->set('money', $ir['money'])->set('bankinterest', $this->co->interest[$n]['interest'])->where('userid', $ir['userid'])->update('users');
			}
			
		}
		
		$this->co->redirect(base_url() . 'bank/home');
		
	}

	public function home()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Bank' ));
		$this->co->init();

		$ir = $this->co->whoami(array(
				'users.bankinterest'
			)
		);
		
		//if
		
		$this->co->page('internal/pages/bank');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */