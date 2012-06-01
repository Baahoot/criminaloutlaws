<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Stocks extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Stock Market' ));
		$this->co->init();

		$ir = $this->co->whoami();
		
		$this->co->page('internal/pages/stockmarket');
	}
	
	public function sell()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Sell Stocks' ));
		$this->co->init();

		$ir = $this->co->whoami();
		
		if($this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		if( ! $this->input->get('id') ) {
			show_404();
		}
		
		$q = $this->db->select('*')->from('stock_holdings')->join('stock_stocks', 'stock_stocks.stockID = stock_holdings.holdingSTOCK')->where('holdingUSER', $this->co->user['userid'])->where('stockID', $this->input->get('id'))->get();
		
		if($q->num_rows() == 0) {
			show_404();
		}
		
		$q = $q->result_array();
		
		if($q[0]['stockNPRICE'] < 0) {
			$q[0]['stockNPRICE'] = 0;
		}
		
		$formula = $q[0]['stockNPRICE'] * $q[0]['holdingQTY'];
		$this->co->add_money($ir['username'], $formula);
		$this->co->statistics_up('total_stock_sold', $q[0]['holdingQTY']);
		$this->db->where('holdingSTOCK', $this->input->get('id'))->delete('stock_holdings');
		$this->co->notice('You sold all of your '.$q[0]['holdingQTY'].'x '.$q[0]['stockNAME'].' stock for $'.number_format($formula, 2).'!');
		$this->co->redirect( base_url() . 'stocks/view' );
	}
	
	public function view()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | My Stocks' ));
		$this->co->init();

		$ir = $this->co->whoami();
		
		$this->co->page('internal/pages/mystock');
	}
	
	public function buy()
	{
		$this->co->must_login();
		$this->co->init();

		$ir = $this->co->whoami();
		
		if( ! $this->input->get('id') ) {
			show_404();
		}
		
		$stock = $this->db->select('stockID, stockNAME, stockOPRICE, stockNPRICE, stockCHANGE, stockUD')->from('stock_stocks')->where('stockID', $this->input->get('id'))->get();
		if($stock->num_rows() == 0) {
			show_404();
		}
		
		$stock = $stock->result_array();
		$stock = $stock[0];
		$this->co->storage['stock'] = $stock;
		
		if($this->input->post('__unique__') == $this->co->get_session()) {
			/* We've bought stocks.. actually, not yet! */
			
			$amount = abs(@intval( $this->input->post('amount') ));
			
			if( ! $amount || $amount < 0 ) {
				$this->co->notice('Sorry, you did not enter a valid amount of stock to buy.');
				$this->co->redirect( base_url() . 'stocks/buy?id=' . $this->input->get('id') );
			}
			
			$total = $stock['stockNPRICE'] * $amount;
			
			if($ir['money'] <= $total) {
				$this->co->notice('Sorry, you do not have enough money to buy this much stock.');
				$this->co->redirect( base_url() . 'stocks/buy?id=' . $this->input->get('id') );
			}
			
			if($total <= 0) {
				$this->co->notice('Sorry, this company has gone bankrupt so you cannot currently buy shares.');
				$this->co->redirect( base_url() . 'stocks/buy?id=' . $this->input->get('id') );
			}
			
			$this->co->statistics_up('total_stock_bought', $amount);
			if($this->db->select('*')->from('stock_holdings')->where('holdingUSER', $ir['userid'])->where('holdingSTOCK', $stock['stockID'])->count_all_results() > 0) {
				$this->db->query("UPDATE stock_holdings SET holdingQTY = holdingQTY + ? WHERE holdingUSER = ? AND holdingSTOCK = ? LIMIT 1", array( $amount, $ir['userid'], $stock['stockID'] ));
			} else {
				$this->db->insert('stock_holdings', array(
						'holdingUSER' => $ir['userid'],
						'holdingSTOCK' => $stock['stockID'],
						'holdingQTY' => $amount
					)
				);
			}
			
			$this->co->remove_money($ir['username'], $total);
			$this->db->insert('stock_records', array(
					'recordUSER' => $ir['userid'],
					'recordTIME' => now(),
					'recordTEXT' => $ir['username'] . ' has successfully bought '.$amount.' of '.$stock['stockNAME'].' stock for $'.number_format($total, 2)
				)
			);
			
			$this->co->notice('You\'ve successfully bought '.$amount.' of '.$stock['stockNAME'].' stock for $'.number_format($total, 2).'');
		}
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Buy '.$this->co->storage['stock']['stockNAME'].' Stock' ));
		$this->co->page('internal/pages/buystock');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */