<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Lottery extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Lottery' ));
		$this->co->init();

		$ir = $this->co->whoami();
		
		$this->co->page('internal/pages/lottery');
	}
	
	public function massbuy()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Buy Lottery Tickets' ));
		$this->co->init();

		$ir = $this->co->whoami();
		$amt = $this->input->post('amount');
		$cnt = $amt;
		
		if($ir['money'] < $amt * 25) {
			goto endpage;
		}
		
		if($this->db->select('*')->from('lotterytickets')->where('lt_user', $ir['userid'])->count_all_results() > 4999) {
			$this->co->notice('Sorry, you can only buy a maximum of 5,000 lottery tickets per week.');
			goto endpage;
		}
		
		if($this->input->post('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		$list = array();
		
		call:
		foreach(range(1, $cnt) as $id) {
			
			$numbers = array();
			foreach(range(1,5) as $count) {
				$numbers[$count] = rand(1, 10);
			}
			
			if($this->db->select('*')->from('lotterytickets')->where('lt_user', $ir['userid'])->where('lt_num_1', $numbers[1])->where('lt_num_2', $numbers[2])->where('lt_num_3', $numbers[3])->where('lt_num_4', $numbers[4])->where('lt_num_5', $numbers[5])->count_all_results() == 0) {
				$cnt--;
				
				$list[] = array(
					'lt_user' => $ir['userid'],
					'lt_time' => now(),
					'lt_num_1' => $numbers[1],
					'lt_num_2' => $numbers[2],
					'lt_num_3' => $numbers[3],
					'lt_num_4' => $numbers[4],
					'lt_num_5' => $numbers[5]
				);
			}
			
		}
		
		if($cnt > 0) {
			goto call;
		}		
		
		$this->co->statistics_up('lottery_total_tickets', $amt);
		$this->db->insert_batch('lotterytickets', $list);
		$this->co->remove_money($ir['username'], 25 * $amt);
		$this->co->update_config('lottery_jackpot', $this->co->config['lottery_jackpot'] + (5 * $amt));
		$this->co->notice('You have bought ' . $amt . 'x lucky lottery tickets for $' . number_format($amt * 25, 2) . '!');
		endpage:
		$this->co->page('internal/pages/buy-lottery');
	}
	
	public function buy()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Buy Lottery Tickets' ));
		$this->co->init();

		$ir = $this->co->whoami();
		
		if($this->input->post()) {
			purchase:
		
			if($ir['money'] < 25) {
				goto endpage;
			}
		
			if($this->input->post('__unique__') != $this->co->get_session()) {
				show_404();
			}
			
			$type = ($this->input->post('action') == 'lucky' ? 'lucky' : 'manual');
			$arrays = array(
				'lottery_1',
				'lottery_2',
				'lottery_3',
				'lottery_4',
				'lottery_5'
			);
			
			$valid = FALSE;
			$numbers = array();
			if($type == 'manual') {
				
				$cnt = 0;
				foreach($arrays as $val) {
					$this_val = $this->input->post($val);
					
					if(!$this_val || $this_val < 1 || $this_val > 10) {
						$this->co->notice('Sorry, you can only select numbers between 1-10 for your lottery ticket.');
						goto endpage;
					}
					
					$cnt++;
					$numbers[$cnt] = $this_val;
				}
				
				if($cnt == 5) {
					$valid = TRUE;
				}
				
			} else {
			
				foreach(range(1,5) as $cnt) {
					$numbers[$cnt] = rand(1, 10);
				}
				
				$valid = TRUE;
			}
			
			if($valid == TRUE) {
			
				if($this->db->select('*')->from('lotterytickets')->where('lt_user', $ir['userid'])->where('lt_num_1', $numbers[1])->where('lt_num_2', $numbers[2])->where('lt_num_3', $numbers[3])->where('lt_num_4', $numbers[4])->where('lt_num_5', $numbers[5])->count_all_results() > 0) {
					if($type == 'lucky') {
						goto purchase;
					} else {
						$this->co->notice('Sorry, you already have a lottery ticket with these numbers.');
						goto endpage;
					}
				}
				
				if($this->db->select('*')->from('lotterytickets')->where('lt_user', $ir['userid'])->count_all_results() > 4999) {
					$this->co->notice('Sorry, you can only buy a maximum of 5,000 lottery tickets per week.');
					goto endpage;
				}
				
				$this->db->insert('lotterytickets', array(
						'lt_user' => $ir['userid'],
						'lt_time' => now(),
						'lt_num_1' => $numbers[1],
						'lt_num_2' => $numbers[2],
						'lt_num_3' => $numbers[3],
						'lt_num_4' => $numbers[4],
						'lt_num_5' => $numbers[5]
					)
				);
				
				$this->co->remove_money($ir['username'], 25);
				$this->co->update_config('lottery_jackpot', $this->co->config['lottery_jackpot'] + 5);
				$this->co->statistics_up('lottery_total_tickets');
				$this->co->notice('We have successfully registered your ticket and charged $25 for your ticket!');
			
			} else {
				$this->co->notice('Sorry, an error occurred while trying to register your lottery tickets.');
			}
		
		}
		
		endpage:
		$this->co->page('internal/pages/buy-lottery');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */