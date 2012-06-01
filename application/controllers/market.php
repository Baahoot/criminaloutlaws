<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Market extends CI_Controller {

	public function item_buy()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Item Market' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		if($this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		$id = $this->input->get('id');
		
		if( ! $id) {
			show_404();
		}
		
		$q = $this->db->select('itemmarket.*, items.itmid, items.itmname, items.itmtype, username_cache.*')->from('itemmarket')->join('items', 'itemmarket.imITEM=items.itmid')->join('username_cache', 'itemmarket.imADDER=username_cache.userid')->where('imID', $id)->get()->result_array();
		
		if( ! is_array($q)) {
			show_404();
		}
		
		$q = $q[0];
		
		if($q['imADDER'] == $ir['userid']) {
			show_404();
		}
		
		if( ($q['imCURRENCY'] == 'money' && $ir['money'] >= $q['imPRICE']) || ($q['imCURRENCY'] == 'crystals' && $ir['crystals'] >= $q['imPRICE']) ) 
		{
			//it's all good - let's carry on
		} else {
			show_404();
		}
		
		$result =  ($q['imCURRENCY'] == 'money' ? '$' : '') . number_format($q['imPRICE'], ($q['imCURRENCY'] == 'money' ? 2 : 0)) . ($q['imCURRENCY'] == 'money' ? '' : ' gold');
		
		$this->co->add_inventory($q['itmid']);
		$this->db->where('imID', $id)->delete('itemmarket');
		
		if($q['imCURRENCY'] == 'money') {
			$add = round($q['imPRICE'] - ($q['imPRICE'] / 10), 2);
			$this->co->add_money($q['username'], $add);
			$this->co->remove_money($ir['username'], $q['imPRICE']);
		} else {
			$add = round($q['imPRICE'] - ($q['imPRICE'] / 10));
			$this->co->add_crystals($q['username'], $add);
			$this->co->remove_crystals($ir['username'], $q['imPRICE']);
		}
		
		$after_fees =  ($q['imCURRENCY'] == 'money' ? '$' : '') . number_format($add, ($q['imCURRENCY'] == 'money' ? 2 : 0)) . ($q['imCURRENCY'] == 'money' ? '' : ' gold');
		
		$this->co->notice('You successfully bought the '.$q['itmname'].' from '.$q['username'].' for '.$result.'!');
		
		$this->co->event_add($q['imADDER'], '<a href="' . base_url() . 'user/' . $ir['username'] . '" rel="ajax">' . $ir['username'] . '</a> [' . $ir['userid'] . '] has bought your ' . $q['itmname'] . ' from the item market for ' . $result . ' ('.$after_fees.' after fees)', TRUE);
		$this->co->redirect( base_url() . 'market/item');
	}


	public function item_remove()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Item Market' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		if($this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		$id = $this->input->get('id');
		
		if( ! $id) {
			show_404();
		}
		
		$q = $this->db->select('itemmarket.*, items.itmid, items.itmname, items.itmtype, username_cache.*')->from('itemmarket')->join('items', 'itemmarket.imITEM=items.itmid')->join('username_cache', 'itemmarket.imADDER=username_cache.userid')->where('imID', $id)->where('imADDER', $ir['userid'])->get()->result_array();
		
		if( ! is_array($q)) {
			show_404();
		}
		
		$q = $q[0];
		
		if($q['imADDER'] != $ir['userid']) {
			show_404();
		}
		
		$this->co->add_inventory($q['itmid']);
		$this->db->where('imID', $id)->delete('itemmarket');
				
		$this->co->notice('You successfully removed your '.$q['itmname'].' from the item market!');
		$this->co->redirect( base_url() . 'market/item');
	}
	
	public function item($action = FALSE)
	{
		if($action == 'buy') {
			return $this->item_buy();
		}
	
		if($action == 'remove') {
			return $this->item_remove();
		}
	
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Item Market' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		$this->co->page('internal/pages/item-market');	
	}
	
	public function gold_create($action = FALSE)
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | List On Gold Market' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		if($this->input->post('post') == 1) {
		
			if( ! $this->input->post('quantity') || ! $this->input->post('price_each') || ! is_numeric($this->input->post('price_each')) ) {
				$this->co->notice('Sorry, you did not fill in all of the fields.');
			}
			
			elseif( $ir['money'] < $this->config->item('gold-list-fee') ) {
				$this->co->notice('You do not have the $' . number_format($this->config->item('gold-list-fee')) . ' needed to list on the market!');
			}
			
			elseif( $this->input->post('price_each') < 0.01 || $this->input->post('price_each') > 100000 ) {
				$this->co->notice('Sorry, you can only sell your gold between $0.01 - $100,000 on the market.');
			}
			
			elseif( $this->input->post('quantity') < 1 || $this->input->post('quantity') > $ir['crystals'] ) {
				$this->co->notice('You do not have this amount of gold to sell on the market.');
			}
			
			else {
				$this->co->remove_money($ir['username'], $this->config->item('gold-list-fee'));
				$this->co->remove_crystals($ir['username'], $this->input->post('quantity'));
			
				$this->db->insert('crystalmarket', array(
						'cmQTY' => $this->input->post('quantity'),
						'cmADDER' => $ir['userid'],
						'cmPRICE' => $this->input->post('price_each')
					)
				);
				
				$this->co->notice('You successfully listed '.$this->input->post('quantity').' gold on the gold market for $'.number_format($this->input->post('price_each'), 2).' with the listing fee of $'.number_format($this->config->item('gold-list-fee'), 2).'!');
				$this->co->redirect( base_url() . 'market/gold' );
			}
		
		}
		
		$this->co->page('internal/pages/create-gold-market');	
	}
	
	public function gold_remove()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Gold Market' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		if($this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		$id = $this->input->get('id');
		
		if( ! $id) {
			show_404();
		}
		
		$q = $this->db->select('crystalmarket.*, username_cache.*, (crystalmarket.cmPRICE * crystalmarket.cmQTY) AS cmTOTAL')->from('crystalmarket')->join('username_cache', 'crystalmarket.cmADDER=username_cache.userid')->where('cmID', $id)->get()->result_array();
		
		if( ! is_array($q)) {
			show_404();
		}
		
		$q = $q[0];
		
		if($q['cmADDER'] != $ir['userid']) {
			show_404();
		}
		
		$this->co->add_money($ir['username'], $this->config->item('gold-list-fee'));
		$this->co->add_crystals($ir['username'], $q['cmQTY']);
		$this->db->where('cmID', $id)->delete('crystalmarket');
				
		$this->co->notice('You successfully removed your listing from the gold market and have been refunded $'.number_format($this->config->item('gold-list-fee'), 2).'!');
		$this->co->redirect( base_url() . 'market/gold');
	}
	
	public function gold_buy()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Gold Market' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		if($this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		$id = $this->input->get('id');
		
		if( ! $id) {
			show_404();
		}
		
		$q = $this->db->select('crystalmarket.*, username_cache.*, (crystalmarket.cmPRICE * crystalmarket.cmQTY) AS cmTOTAL')->from('crystalmarket')->join('username_cache', 'crystalmarket.cmADDER=username_cache.userid')->where('cmID', $id)->get()->result_array();
		
		if( ! is_array($q)) {
			show_404();
		}
		
		$q = $q[0];
		
		if($q['cmADDER'] == $ir['userid']) {
			show_404();
		}
		
		if( $ir['money'] < $q['cmTOTAL'] ) {
			show_404();
		}
		
		if($q['cmTOTAL'] == 1) {
			$after_fees = 1;
		} else {
			$after_fees = round($q['cmTOTAL'] - round($q['cmTOTAL'] / 4, 2), 2);
		}
		
		$this->co->remove_money($ir['username'], $q['cmTOTAL']);
		$this->co->add_crystals($ir['username'], $q['cmQTY']);
		$this->co->add_money($q['username'], $after_fees);
		
		$this->db->where('cmID', $id)->delete('crystalmarket');
		$this->co->notice('You successfully bought '.$q['cmQTY'].' gold from '.$q['username'].' for $'.number_format($q['cmTOTAL'], 2).'!');
		
		$this->co->event_add($q['cmADDER'], '<a href="' . base_url() . 'user/' . $ir['username'] . '" rel="ajax">' . $ir['username'] . '</a> [' . $ir['userid'] . '] has bought your '.number_format($q['cmQTY']).' from the gold market for $' . number_format($q['cmTOTAL'], 2) . ' ($'.number_format($after_fees, 2).' after fees)', TRUE);
		$this->co->redirect( base_url() . 'market/gold' );
	}
	
	public function gold($action = FALSE)
	{
		if($action == 'create') {
			return $this->gold_create();
		}
		
		if($action == 'buy') {
			return $this->gold_buy();
		}
	
		if($action == 'remove') {
			return $this->gold_remove();
		}
	
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Gold Market' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		$this->co->page('internal/pages/gold-market');	
	}
		
}