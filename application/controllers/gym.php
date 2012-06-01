<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Gym extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_jail();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Gym' ));
		$this->co->init();

		$ir = $this->co->whoami(array( 'userstats.*' ));
		
		$this->co->storage['radio'] = 'strength';
		
		if($this->input->post('__unique__') == $this->co->get_session()) {
		
			$on = $this->input->post('on');
			$is_single = TRUE;
			
			if($on != 'strength' && $on != 'agility' && $on != 'guard' && $on != 'labour') {
				$this->co->notice('You did not select a valid stat to work out on.');	
			} else {
			
				$required = array();
				$single = 1;
				$additional = 1.0;
				
				if($this->co->user['energy'] > 9 && $on == 'strength') {
					$required['energy'] = 10;
					$name = 'power';
					$this->co->storage['radio'] = 'strength';
					$max = floor($this->co->user['energy'] / $required['energy']);
				}
				
				if($this->co->user['energy'] > 5 && $on == 'agility') {
					$required['energy'] = 6;
					$name = 'speed';
					$this->co->storage['radio'] = 'agility';
					$max = floor($this->co->user['energy'] / $required['energy']);
				}
				
				if($this->co->user['energy'] > 4 && $on == 'guard') {
					$required['energy'] = 5;
					$name = 'defence';
					$this->co->storage['radio'] = 'guard';
					$max = floor($this->co->user['energy'] / $required['energy']);
				}
				
				if($this->co->user['energy'] > 2 && $on == 'labour') {
					$required['energy'] = 3;
					$name = 'labour';
					$this->co->storage['radio'] = 'labour';
					$max = floor($this->co->user['energy'] / $required['energy']);
				}
				
				$this->co->storage['max'] = $max;
				
				if($ir['jail'] > now()) {
					$additional = rand( 0.1, 0.9 );
				}
				
				/* if($this->co->user['will'] == 0) {
					$required = array();
					unset($name);
					unset($max);
					$this->co->notice('You are too sad to make a visit to the gym at the moment.');
				} */
				
				$incr = ($is_single ? $single : $max);
				
				if($additional < 1) {
					$total_incr = $required['energy'] * $incr;
				} else {
					$total_incr = (($required['energy'] * $incr) * $additional);
				}

				if(count($required) > 0 && $ir['energy'] - $total_incr >= 0) {
					
					$gain = 0;
					for($i=0; $i<$incr; $i++)
					{
						$gain += rand(1,3)/rand(800,1000)*rand(800,1000)*(($ir['will']+20)/150);
						$ir['will']-=rand(1,3);
						if($ir['will'] < 0) { $ir['will']=0; }
					}
					
					
					if($ir['jail'] > now()) {
						$workout /= 2;
					}
					
					$workout = round($gain, 4);
					$ir['energy'] -= $total_incr;
					
					if($ir['energy'] < 0) {
						$this->co->notice('An error occurred while performing your workout in the gym.');
						$this->co->redirect(base_url() . 'gym');
					}
					
					$this->db->query("UPDATE users SET will = ?, energy = ? WHERE userid = ? LIMIT 1", array( $ir['will'], $ir['energy'], $ir['userid'] ));
					$this->db->query("UPDATE userstats SET ".$on." = ".$on." + ".$workout." WHERE userid = ?", array( $ir['userid'] ));
					$this->co->notice('You\'ve just gained '.($workout).' '.$name.' and it has increased to '.($ir[$on]+$workout).'!');
					
					/* Forces the app to reload user data */
					$this->co->user['energy'] -= $total_incr;
					$this->co->user['will'] = $ir['will'];
					$this->co->user[$on] += $workout;
					
					$this->co->statistics_up('gym_total_workouts', $incr);
					$this->co->statistics_up('gym_workouts_' . $on, $workout);
				} else {
					$this->co->notice('You do not have enough power to do this workout.');
				}
				
			}
		
		}
		
		$this->co->page('internal/pages/gym');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */