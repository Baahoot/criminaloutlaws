<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Unlocks extends CI_Controller {

	var $unlocks = array(
		1 => array(
			'id' => 1,
			'title' => 'PRO membership for 10 days',
			'desc' => 'To unlock this achievement, you must complete <b>50 successful attacks</b> against other players.',
			'unit' => 'attacks_won',
			'value' => 50,
			'image' => '/images/pro-large.png',
			'key' => 'pro-membership'
		),
		
		2 => array(
			'id' => 2,
			'title' => 'Gain +5,000 HP for up to 24 hours',
			'desc' => 'To unlock this achievement, you must have generated a total of <b>500</b> hospitalized minutes.',
			'unit' => 'attack_won_total_hospmins',
			'value' => 500,
			'image' => '/images/heart.png',
			'key' => 'plus-hp-5000'
		),
		
		3 => array(
			'id' => 3,
			'title' => 'Gain +500 HP permanently',
			'desc' => 'To unlock this achievement, you must have generated a total of <b>10,000</b> hospitalized minutes.',
			'unit' => 'attack_won_total_hospmins',
			'value' => 10000,
			'image' => '/images/heart_gold.png',
			'key' => 'plus-hp-500-perm'
		)
	);
	
	private function get()
	{
		global $ir, $a;
		$a = array();
		$l = array();
		foreach($this->unlocks as $i=>$r) {
			$l[] = $r['unit'];
		}
		
		$v = $this->db->select('*')->from('unlock_complete')->where('userid', $ir['userid'])->get();
		$unlocked = array();
		foreach($v->result_array() as $i0=>$r0) {
			$unlocked[] = $r0['unlock'];
		}
		
		$i = $this->co->get_statistics(0, $l);
		
		if($i == false)
		{
			$i = array( 1, 2, 3 );
		}
	
		foreach($this->unlocks as $k2=>$v2) {
		
			$true_value = ( @$i[ $v2['unit'] ] ? $i[ $v2['unit'] ] : '0' );
			
				$g = array_merge( $v2, array( 'true_value' => $true_value, 'perc' => (( @$i[ $v2['unit'] ] / $v2['value']) * 100), 'completed' => ( @$i[ $v2['unit'] ] >= $v2['value'] && in_array($v2['id'], $unlocked) ? 1 : 0) )  );
					
				if($g['perc'] > 100) {
					$g['perc'] = 100;
				}
				
				if(@$i[ $v2['unit'] ] > $v2['value']) {
					$g['true_value'] = $v2['value'];
				}
					
				if($this->input->get('id') && $v2['id'] == $this->input->get('id'))
				{
					$a = array();
					$a[] = $g;
					break;
				} else {
					$a[] = $g;
				}
			
		} 
		
		$this->co->storage['un'] = $a;
	}
	
	public function complete()
	{
		global $ir, $a;
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Unlocks' ));
		$this->co->init();

		define('COMPLETE', 1);
		$ir = $this->co->whoami();
		$this->get();
		
		if(count($a) == 0) {
			show_404();
		}
		
		$r = $a[0];
		
		
		if($this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		elseif($r['completed'] == 1) {
			$this->co->notice('Sorry, you have already completed & claimed this unlock.');
		}
		
		elseif($r['perc'] < 100) {
			$this->co->notice('Sorry, you have not completed this unlock so you cannot claim for it.');
		}
		
		else {
			$k = $r['key'];
			
			if($k == "pro-membership") {
				/* Pro membership for 4 days */
				$update = ($ir['donator'] >= now() ? $ir['donator'] + 60*60*24*10 : now() + 60*60*24*10);
				$this->db->set('donator', $update)->where('userid', $ir['userid'])->update('users');
			}
			
			elseif($k == "plus-hp-5000") {
				/* Temporarily give 5,000 extra health to users with this achievement */
				$am = 5000;
				$ir['maxhp'] += $am;
				$this->db->set('hp', $ir['maxhp'])->set('maxhp', $ir['maxhp'])->set('is_hp_bonus', $am)->where('userid', $ir['userid'])->update('users');
			}
			
			elseif($k == "plus-hp-500-perm") {
				/* Permanently add 500 HP */
				$am = 500;
				$ir['maxhp'] += $am;
				$this->db->set('hp', $ir['maxhp'])->set('maxhp', $ir['maxhp'])->where('userid', $ir['userid'])->update('users');
			}
			
			
			$this->db->insert('unlock_complete', array(
					'userid' => $ir['userid'],
					'unlock' => $r['id']
				)
			);
			$this->co->notice('Congratulations, you have successfully claimed your unlock for your challenge!');
			
		}
		
		$this->co->redirect( base_url() . 'unlocks' );
	}

	public function index()
	{
		global $ir, $a;
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Unlocks' ));
		$this->co->init();

		$ir = $this->co->whoami();
		$this->get();
		
		$this->co->storage['un'] = $a;
		$this->co->page('internal/pages/unlocks');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */