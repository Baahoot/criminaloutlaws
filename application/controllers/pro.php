<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Pro extends CI_Controller {

	function mobileipn($code) {
		
		/* Mobile payment gateway */
		if($code != 'qwue3412jrncqure91rjqw') {
			show_404();
		}
		
		if( ! $this->input->get('Note') ) {
			show_404();
		}
		
		if( $this->input->get('Status') != 100 ) {
			show_404();
		}
		
		if(isset($i['txn_id']) && $this->db->select('*')->from('used_txns')->where('txn_id', $this->input->get('SessionID'))->count_all_results() > 0) {
			return false;
		}
		
		$user = $this->input->get('Note');
		$query = $this->db->select('userid')->from('users')->where('userid', $user);
		if( $query->count_all_results() == 0 ) {
			return false;
		}
			
		/* Alright the user exists, let's go ahead and process his details */
		$query = $this->db->select('userid, username, donator, email')->from('users')->where('userid', $user);
		$r = $query->get()->result_array();
		$r = $r[0];
		
		$this->db->insert( 'used_txns', array( 'txn_id' => $this->input->get('SessionID') ) );
		$this->db->insert('mobile_payments', array(
				'payment_time' => now(),
				'payment_user' => $user,
				'payment_network' => $this->input->get('Operator'),
				'payment_number' => $this->input->get('Mobile')
			)
		);
		
		if($r['donator'] > now()) { 
			$new_donator = $r['donator'] + 60*60*24*7;
		} else {
			$new_donator = now() + 60*60*24*7;
		}
		
		$this->co->statistics_up('pro_total_mobile_payments');
		$this->db->set('donator', $new_donator)->where('userid', $r['userid'])->update('users');
		$this->co->event_add($r['userid'], 'Your mobile payment was successful! Your PRO subscription expires on ' . unix_to_human($new_donator), TRUE);
		$this->co->mail($r['email'], $r['username'], "Mobile payment for PRO successful | Criminal Outlaws", $this->load->view('emails/pro-mobile', array('to' => $i['username'], 'expires' => $new_donator, 'order' => $this->input->get('SessionID'), 'network' => $this->input->get('Operator'), 'number' => $this->input->get('Mobile') ), true));
		/* Done! */
	}

	function ipn()
	{
		$this->load->library('paypal_lib');
		
		// Payment has been received and IPN is verified.  This is where you
		// update your database to activate or process the order, or setup
		// the database with the user's order details, email an administrator,

		if ($this->paypal_lib->validate_ipn()) 
		{
			$i = $this->input->post();
			$txn = $i['txn_type'];
			$to = ($this->input->get('user') ? $this->input->get('user') : $i['custom']);
			$i['mc_gross'] = (isset($i['mc_gross']) ? $i['mc_gross'] : @$i['amount1']);
			
			if($i['test_ipn'] == 1 && $this->config->item('paypal-debug') == FALSE) {
				/* We aren't debugging, so let's throw away this request */
				return false;
			}
			
			if( ! $to) {
				return false;
			}
			
			$query = $this->db->select('userid')->from('users')->where('userid', $to);
			if( $query->count_all_results() == 0 ) {
				return false;
			}
			
			/* Alright the user exists, let's go ahead and process his details */
			$query = $this->db->select('userid, username, donator, email')->from('users')->where('userid', $to);
			$r = $query->get()->result_array();
			$r = $r[0];
			
			/* Let's do general tests here */
			//if(strtolower($i['payment_status']) != 'completed') {
				/* They didn't complete the payment */
			//	return false;
			//}
			
			//if($i['payment_type'] != 'instant') {
				/* Sorry, we only accept instant payments. */
			//	return false;
			//}
			
			if($i['receiver_email'] != $this->config->item('paypal')) {
				/* Sorry, we don't want it without the payment to us. */
				return false;
			} 
			
			if($i['mc_currency'] != $this->config->item('paypal-currency')) {
				/* Sorry, it's not the currency we're really looking for */
				return false;
			}
			
			if(isset($i['txn_id']) && $this->db->select('*')->from('used_txns')->where('txn_id', $i['txn_id'])->count_all_results() > 0) {
				return false;
			}
			
			/* Process here */
	
			if($i['item_name'] == $this->config->item('paypal-item-name')) {
				/* Alright, they've purchased the PRO membership */
				
				if($i['mc_gross'] != $this->config->item('paypal-monthly-fee')) {
					/* The aren't paying us what we want! */
					return false;
				}
				
				if(isset($i['txn_id'])) {
					/* Let's prevent the txn being used again! */
					$this->db->insert( 'used_txns', array( 'txn_id' => $i['txn_id'] ) );
				}
				
				if( $txn == "subscr_signup" && strtolower($i['payment_status']) == 'completed' && $i['payment_type'] == 'instant'):
					/* First time user */
					
					$this->db->insert('payments', array(
							'payment_started' => now(),
							'payment_last' => now(),
							'payment_item' => 'PRO Membership',
							'payment_amount' => $this->config->item('paypal-monthly-fee'),
							'payment_total' => $this->config->item('paypal-monthly-fee'),
							'payment_user' => $to,
							'payment_status' => 'successful'
						)
					);
					
					if($r['donator'] > now()) {
						$new_date = $r['donator'] + 60*60*24*30;
					} else {
						$new_date = now() + 60*60*24*30;
					}
					
					$this->co->statistics_up('pro_total_paypal_payments');
					$this->db->set('donator', $new_date)->where('userid', $to)->update('users');
					$amnt = $this->config->item('paypal-monthly-fee');
					$this->co->event_add($to, 'Your first payment of $'.$amnt.' was successful. Welcome to PRO!', TRUE);
					
					$this->co->mail($r['email'], $r['username'], "Payment successful for PRO membership | Criminal Outlaws", $this->load->view('emails/pro-new', array('to' => $i['username'], 'next_billed' => now() + 60*60*24*30, 'txn' => $i['txn_id'], 'payer_email' => $i['payer_email'], 'payment_via' => 'PayPal'), true));
				
				elseif( $txn == "subscr_payment" && strtolower($i['payment_status']) == 'completed' && $i['payment_type'] == 'instant' ):
					/* Renewal payment - successful */
					
					$this->db->set('payment_last', now())->set('payment_total = payment_total + ', $this->config->item('paypal-monthly-fee'))->set('payment_status', 'successful')->where('payment_user', $to)->update('payments');
					
					if($r['donator'] > now()) {
						$new_date = $r['donator'] + 60*60*24*30;
					} else {
						$new_date = now() + 60*60*24*30;
					}
					
					$this->db->set('donator', $new_date)->where('userid', $to)->update('users');
					$amnt = $this->config->item('paypal-monthly-fee');
					//$this->co->event_add($to, 'You have been successfully charged $'.$amnt.' with PayPal for your PRO membership.', TRUE);
					
					//$this->co->mail($r['email'], $r['username'], "Membership Renewed | Criminal Outlaws", $this->load->view('emails/pro-new', array('to' => $i['username'], 'next_billed' => now() + 60*60*24*30, 'txn' => $i['txn_id'], 'payer_email' => $i['payer_email'], 'payment_via' => 'PayPal'), true));
				
				elseif( $txn == "subscr_failed" ):
					/* Renewal payment - failed */
					
					$this->db->set('payment_status', 'failed')->where('payment_user', $to)->update('payments');
					
					$amnt = $this->config->item('paypal-monthly-fee');
					$this->co->event_add($to, 'We were unable to charge you $'.$amnt.' with PayPal. Please check with PayPal and we will charge you respectively again.', TRUE);
					
					$this->co->mail($r['email'], $r['username'], "Payment Failed | Criminal Outlaws", $this->load->view('emails/pro-failed', array('to' => $i['username'], 'next_billed' => now() + 60*60*24*30, 'amount' => $amnt, 'expires' => $r['donator'], 'txn' => $i['txn_id'], 'payer_email' => $i['payer_email'], 'payment_via' => 'PayPal'), true));
				
				elseif( $txn == "subscr_cancelled" ):
					/* Cancelled */
					
					$this->db->set('payment_status', 'cancelled')->where('payment_user', $to)->update('payments');
					$this->co->event_add($to, 'Your subscription for PRO has been cancelled through PayPal. You will not be billed any longer.', TRUE);
					
					$this->co->mail($r['email'], $r['username'], "Subscription Cancelled | Criminal Outlaws", $this->load->view('emails/pro-cancelled', array('to' => $i['username']), true));
				
				else:
					return FALSE;
				endif;
				
			} else {
				/* They've not purchased what we wanted them to buy. Never mind! */
			}

		} else {
			show_404();
		}
	
	}

	public function cancel()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws' ));
		$ir = $this->co->whoami();
		
		$this->co->notice('You did not complete your purchase with PayPal.');
		$this->co->redirect( base_url() . 'pro');
	}
	
	public function success()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws' ));
		$ir = $this->co->whoami();
		
		$this->co->notice('Payment successful! Please wait a couple of minutes to receive your membership.');
		$this->co->redirect( base_url() . 'pro');
	}

	public function index()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | PRO' ));
		$ir = $this->co->whoami();
		
		$this->co->page('internal/pages/pro');	
	}
		
}