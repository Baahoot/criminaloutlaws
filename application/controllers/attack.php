<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Attack extends CI_Controller {

	var $data = array(
		'users.userid',
		'users.username',
		'users.money',
		'users.crystals',
		'users.exp',
		'users.level',
		'users.jail',
		'users.hospital',
		'users.hospreason',
		'users.energy',
		'users.maxenergy',
		'users.hp',
		'users.maxhp',
		'users.attacking',
		'users.equip_primary',
		'users.equip_secondary',
		'users.equip_armor',
		'users.signedup',
		'users.gang',
		'users.location',
		
		'userstats.strength',
		'userstats.agility',
		'userstats.guard',
		'userstats.IQ'
	);
	
	private function timestamp() {
		return '[' . date('H:i') . '] ';
	}
	
	private function attack_algorithm($user, $opp, $with = '') {
		$equips = $this->co->storage['equips'];
		$context = array();
		
		if($user['userid'] == $this->co->user['userid']) {
			$from = 'You';
			$prefix = 'me_';
			$me = 1;
			$opp_prefix = 'opp_';
			$to = $opp['username'];
		} else {
			$from = $user['username'];
			$prefix = 'opp_';
			$me = 0;
			$opp_prefix = 'me_';
			$to = 'you';
		}
		
		if( $with && $with != 'fists' && ! is_array( $equips[ $prefix . $with ] ) ) {
			show_404();
		}
		
		if($with == 'fists' && $user['hp'] > 0 && $this->co->storage['attack_result'] == 'null') {
			if(rand(1, 2) == 1) {
				$damage = rand( 1, 3 ) * floor(1 + ($user['level'] * rand( 0.1, 1.0 )));
				$context[] = $from . ' used a pair of fists to attack and caused '.$damage.' damage to ' . $to;
				$opp['hp'] -= $damage;
				if(  $opp['hp'] < 0 ) { $opp['hp'] = 0; }
			} else {
				$damage = 0;
				$context[] = $from . ' used a pair of fists to attack and missed you.';
			}
		} elseif($with && $user['hp'] > 0 && $this->co->storage['attack_result'] == 'null') {
		
			$i = ($user['userid'] == $this->co->user['userid'] ? $equips[ 'me_' . $with ] : $equips[ 'opp_' . $with ] );
		
			$grand = rand( 8000 , 12000 );
			$damage = abs((int) ( ( $i['weapon'] * $user['strength'] / ( $opp['guard'] / 1.5 ) ) * abs( $grand / 10000 ) ));
			$hitratio = max( 10 , min( 60 * $user['agility'] / $opp['agility'] , 95 ) );
		
			if(rand( 1, 100 ) <= $hitratio ) {
				/* We've hit the user! */
			
				if( is_array( $equips[ $opp_prefix . 'armor' ] ) ) {
					$damage -= rand( $equips[ $opp_prefix . 'armor' ]['armor'], $equips[ $opp_prefix . 'armor' ]['armor'] * 10);
					$damage = ($damage < 1 ? 1 : $damage);
				}
			
				$opp['hp'] -= $damage;
				if(  $opp['hp'] < 0 ) { $opp['hp'] = 0; }
				$context[] = $from . ' hit ' . $to . ' with <b>' . $i['itmname'] . '</b> and caused '.$damage.' damage.' ;
		
			}
		
			else {
				/* Missed! */
				$context[] = $from . ' tried to hit '.$to.' and missed.';
				$damage = 0;
			}
		
		}
		
		if($user['hp'] < 1) {
			/* MUG BEGIN */
			$user['hp'] = 0;
			$damage = (isset($damage) ? $damage : 0);
			$gain = (1 + ($user['level'] > $opp['level'] ? $user['level'] - $opp['level'] : $opp['level'] - $user['level']) * 1.5) + (abs((1 + $damage) / 80) + ($me == 1 ? $opp['atk_stats']['total_damage_given'] : $user['atk_stats']['total_damage_given']) + 1);
			$gain = $gain * 5;
			$gain = abs( round( $gain ) );
			$opp['exp'] += ($this->config->item('xp') > 1 ? $gain * $this->config->item('xp') : $gain);
			
			if($me == 0 && $this->input->get('action') == 'leave') {
				$user['energy'] = 0;
				$this->co->statistics_up('attacks_left', 1, $opp['userid']);
				$this->co->statistics_up('attacks_lost_left', 1, $user['userid']);
				$context[] = 'You beat up '.$user['username'].' and left them.';
				$this->co->event_add($user['username'], $opp['username'] . ' ['.$opp['userid'].'] attacked you and walked away.');
				$this->co->storage['attack_result'] = 'complete';
				
				return array(
					'context' => $context,
					'from' => $user,
					'opp' => $opp,
					'damage' => $damage
				);
			}
			
			/* The enemy gains crystals or money */	
			if(rand(1, 2) == 1 && $user['crystals'] > 0 && ($me == 1 or ($me == 0 && $this->input->get('action') == 'mug' ))) {
				$am = rand( 1, $user['crystals'] );
				$user['crystals'] -= $am;
				$opp['crystals'] += $am;
				
				if($me == 1) {
					$this->co->statistics_up('attacks_lost', 1, $user['userid']);
					$this->co->statistics_up('attacks_defended', 1, $opp['userid']);
				} else {
					$this->co->statistics_up('attacks_mugged', 1, $opp['userid']);
					$this->co->statistics_up('attacks_lost_mugged', 1, $user['userid']);
				}
				
				
				if($me == 1) {
					$context[] = 'You lost the fight to '.$opp['username'].' and they took '. number_format($am) .' gold from you.';
					$this->co->event_add($opp['username'], $user['username'] . ' ['.$user['userid'].'] tried to attack you and lost. You gained '.number_format($gain).' EXP and '. number_format($am) . ' gold.');
				} else {
					$context[] = 'You mugged '.$user['username'].' and took '. number_format($am) .' gold.';
					$this->co->event_add($user['username'], $opp['username'] . ' ['.$opp['userid'].'] mugged you and took '. number_format($am) . ' gold.');
				}
			}
				
			else if(rand(1, 2) == 1 && $user['money'] > 0 && ($me == 1 or ($me == 0 && $this->input->get('action') == 'mug' ))) {
				$am = rand( 1, $user['money'] );
				$user['money'] -= $am; 
				$opp['money'] += $am;
				
				if($me == 1) {
					$context[] = 'You lost the fight to '.$opp['username'].' and they took $'. number_format($am, 2) .' from you.';
					$this->co->event_add($opp['username'], $user['username'] . ' ['.$user['userid'].'] tried to attack you and lost. You gained '.number_format($gain).' EXP and $'. number_format($am, 2) . '.');
				} else {
					$context[] = 'You mugged '.$user['username'].' and took $'. number_format($am, 2) .'.';
					$this->co->event_add($user['username'], $opp['username'] . ' ['.$opp['userid'].'] mugged you and took $'. number_format($am, 2) .'.');
				}
			}
				
			else if(rand(1, 2) == 1 && (is_array($equips[ $prefix . 'primary' ]) OR is_array($equips[ $prefix . 'secondary' ]))  && ($me == 1 or ($me == 0 && $this->input->get('action') == 'mug' ))) {
					
				if(rand(1, 8) > 5 && is_array($equips[ $prefix . 'primary' ])) {
					/* Primary */
					$this->co->remove_inventory( $equips[ $prefix . 'primary' ]['itmid'], $user['userid'], 1 );
					$this->co->add_inventory( $equips[ $prefix . 'primary' ]['itmid'], $opp['userid'], 1 );
					
					if($me == 1) {
						$context[] = 'You lost the fight to '.$opp['username'].' and they took your '. $equips[ $prefix . 'primary' ]['itmname'] .' from you.';
						$this->co->event_add($opp['username'], $user['username'] . ' ['.$user['userid'].'] tried to attack you and lost. You gained '.number_format($gain).' EXP and a '.$equips[ $prefix . 'primary' ]['itmname'].'.');
					} else {
						$context[] = 'You mugged '.$user['username'].' and took their '. $equips[ $prefix . 'primary' ]['itmname'] .'.';
						$this->co->event_add($user['username'], $opp['username'] . ' ['.$opp['userid'].'] mugged you and took your '. $equips[ $prefix . 'primary' ]['itmname'] .'.');
					}
						
					$user['equip_primary'] = 0;
				}
				
				elseif( rand(1, 8) > 5 && is_array($equips[ $prefix . 'secondary' ]) ) {
					/* Secondary */
					$this->co->remove_inventory( $equips[ $prefix . 'secondary' ]['itmid'], $user['userid'], 1 );
					$this->co->add_inventory( $equips[ $prefix . 'secondary' ]['itmid'], $opp['userid'], 1 );
					
					if($me == 1) {
						$context[] = 'You lost the fight to '.$opp['username'].' and they took your '. $equips[ $prefix . 'secondary' ]['itmname'] .' from you.';
						$this->co->event_add($opp['username'], $user['username'] . ' ['.$user['userid'].'] tried to attack you and lost. You gained '.number_format($gain).' EXP and a '.$equips[ $prefix . 'secondary' ]['itmname'].'.');
					} else {
						$context[] = 'You mugged '.$user['username'].' and took their '. $equips[ $prefix . 'secondary' ]['itmname'] .'.';
						$this->co->event_add($user['username'], $opp['username'] . ' ['.$opp['userid'].'] mugged you and took your '. $equips[ $prefix . 'secondary' ]['itmname'] .'.');
					}
						
					$user['equip_secondary'] = 0;
				}
					
			} elseif($me == 1 or ($me == 0 && $this->input->get('action') == 'mug' )) {
				
				if($me == 1) {
					$context[] = $opp['username'].' has won the fight against '.$user['username'].'.';
					$this->co->event_add($opp['username'], $user['username'] . ' ['.$user['userid'].'] tried to attack you and lost. You gained '.number_format($gain).' EXP.');
				} else {
					$context[] = 'You failed to mug anything from '.$user['username'].'.';
					$this->co->event_add($user['username'], $opp['username'] . ' ['.$opp['userid'].'] attempted to mug you but did not steal anything.');
				}
			}
			
			if($me == 1 OR ($me == 0 && $this->input->get('action') == 'hospitalize')) {
			
				$additional = '';
				
				if($user['gang'] > 0 && $opp['gang'] > 0)
				{
					$war_query = $this->db->query("SELECT * FROM gangwars WHERE (warDECLARER = ? AND warDECLARED = ?) OR (warDECLARED = ? AND warDECLARER = ?)", array( $user['gang'], $opp['gang'], $user['gang'], $opp['gang'] ));

					if($war_query->num_rows() > 0)
					{
						$war = $war_query->result_array();
						$war = $war[0];
					
						$this->co->statistics_up('gangs_fights_done');
						if($me == 1) { $additional = ' and you earnt 3 respect for your gang!'; }
						$ga = $this->db->select('gangRESPECT, gangPRESIDENT, gangNAME')->from('gangs')->where('gangID', $opp['gang'])->get()->result_array();
						$ga = $ga[0];
						$ga['gangRESPECT'] -= 3;
						if($me == 1) {
							$additional = ' and you lost 1 respect for your gang!';
							$this->co->statistics_up('gangs_respect_lost');
							$this->db->query("UPDATE gangs SET gangRESPECT = gangRESPECT + 1 WHERE gangID = ?", array( $opp['gang'] ) );
							$this->db->query("UPDATE gangs SET gangRESPECT = gangRESPECT - 1 WHERE gangID = ?", array( $user['gang'] ) );
						} else {
							$this->co->statistics_up('gangs_respect_won', 3);
							$this->db->query("UPDATE gangs SET gangRESPECT = gangRESPECT - 3 WHERE gangID = ?", array( $opp['gang'] ) );
							$this->db->query("UPDATE gangs SET gangRESPECT = gangRESPECT + 3 WHERE gangID = ?", array( $user['gang'] ) );
						}
					}
				
					//Gang Kill
					if(isset($ga['gangRESPECT']) && $ga['gangRESPECT'] <= 0)
					{
						$this->co->statistics_up('gangs_destroyed');
						$this->db->query("UPDATE users SET gang = 0 WHERE gang = ?", array( $r['gang'] ) );
						
						if($me == 0) {
							$this->co->event_add($ga['gangPRESIDENT'], "Your gang " . $ga['gangNAME'] . " was destroyed by " . $opp['username'] . " in an attack against ".$user['username']."!");
						} else {
							$this->co->event_add($ga['gangPRESIDENT'], "Your gang " . $ga['gangNAME'] . " was destroyed because " . $user['username']." lost battle against " . $opp['username']."!");
						}
						
						$this->db->query("DELETE FROM gangs WHERE gangRESPECT<= 0");
						$this->db->query("DELETE FROM gangwars WHERE warDECLARER = ? or warDECLARED = ?", array( $ga['gangID'], $ga['gangID'] ));
					}
				
				}
			
				$mins = rand( 1, 30 - ( $user['level'] - $opp['level'] ) * 0.75);
				if($me == 0) {
					$context[] = 'You successfully hospitalized '.$user['username'].' for '.$mins.' minutes' . $additional . '.';
					$this->co->statistics_up('attack_won_total_hospmins', $mins, $opp['userid']);
				}
				
				$user['hospital'] = now() + (60 * $mins);
				$user['hospreason'] = ($me == 1 ? 'Attempted to fight ' . $opp['username'] . ' ['.$opp['userid'].']' . ' and lost.' : 'Hospitalized by ' . (rand(1, 3) == 2 ? 'an unknown user' : $opp['username'] . ' ['.$opp['userid'].']'));
				$this->co->update_config('hospital_count', $this->co->config['hospital_count'] + 1);
			}
			
			$user['energy'] = 0;
			
			if($me == 0 && $this->input->get('action') ) {
				$this->co->storage['attack_result'] = 'complete';
			} else {
				$this->co->storage['attack_result'] = 'lost';
			}
			
			/* MUG END */
		}
		
		return array(
			'context' => $context,
			'from' => $user,
			'opp' => $opp,
			'damage' => (isset($damage) ? $damage : 0)
		);
	}

	public function begin()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Attack ' . $this->input->get('username') ));
		$this->co->init();

		$ir = $this->co->whoami(array(
				'users.equip_primary',
				'users.equip_secondary',
				'users.equip_armor',
				'users.gang'
			)
		);
		
		/* They haven't authenticated - something's not right! */
		if($this->input->get('__unique__') != $this->co->get_session()) { show_404(); }
		
		/* Sorry, you can't fight against yourself. Are they alright? */
		if($this->input->get('username') == $ir['username']) { show_404(); }
		
		/* This user doesn't exist, sorry! */
		if($this->co->user_exists($this->input->get('username'), 'USERNAME_ONLY') == FALSE) { show_404(); }
		
		/* Let's pull up the user data! */
		$r = $this->co->get_user($this->input->get('username'), $this->data);
		
		if($r['hp'] <= 1) {
			$this->co->notice('This user has no health and is unable to fight until they gain some health.');
			$this->co->redirect( base_url() . 'user/' . $this->input->get('username') );
		}
		
		if($ir['location'] != $r['location']) {
			$this->co->notice('You cannot fight a user who is not in the same location as you.');
			$this->co->redirect( base_url() . 'user/' . $this->input->get('username') );
		}
		
		if($this->co->days_elapsed($r['signedup']) == 0) {
			$this->co->notice('You can only start attacking players once they are at least 1 day old.');
			$this->co->redirect( base_url() . 'user/' . $this->input->get('username') );
		}
		
		/* if($r['attacking'] == 1) {
			$this->co->notice('This user is currently in battle, so you cannot fight with them.');
			$this->co->redirect( base_url() . 'user/' . $this->input->get('username') );
		} */
		
		if($ir['equip_primary'] == 0 && $ir['equip_secondary'] == 0) {
			$this->co->notice('You cannot fight without any equipped weapons.');
			$this->co->redirect( base_url() . 'user/' . $this->input->get('username') );
		}
		
		if($r['hospital'] >= now() || $r['jail'] >= now()) {
			show_404();
		}
		
		if($ir['energy'] < ceil($ir['maxenergy'] / 2)) {
			$this->co->notice('You need at least 50% energy to begin a battle with a user.');
			$this->co->redirect( base_url() . 'user/' . $this->input->get('username') );
		}
		
		if($ir['gang'] > 0 && $ir['gang'] == $r['gang']) {
			$this->co->notice('You cannot fight with people in the same base as you.');
			$this->co->redirect( base_url() . 'user/' . $this->input->get('username') );
		}
		
		if($ir['attacking'] > 0 && $ir['attacking'] != $r['userid']) {
			$perc = rand( 0.1 , 0.9 );
			$this->co->notice('You fled your battle against '.$r['username'].' and lost '.($perc * 100).'% of your EXP!');
			$this->db->query("UPDATE users SET attacking = 0, exp = ((exp / 100) * ".$perc.") WHERE userid = ? LIMIT 1", array( $ir['userid'] ));
			$this->redirect(base_url() . 'home');
		}
		
		$id = random_string('alnum', 48);
		
		/* Start the fight here. */
		$this->co->statistics_up('attack_total_fights');
		$this->co->statistics_up('attack_total_fights', 1, $r['userid']);
		$this->db->set('attacking', $r['userid'])->where('userid', $ir['userid'])->update('users');
		$this->db->insert('attacks', array(
				'atk_id' => $id,
				'atk_attacker' => $ir['userid'],
				'atk_defender' => $r['userid'],
				'atk_start_time' => now(),
				'atk_end_time' => 0,
				'atk_winner' => 0,
				'atk_log' => serialize(
					array(
						'You walk up to '.$r['username'].' and prepare to start a fight.'
					)
				),
				'atk_stats' => serialize(
					array(
						'total_damage_given' => 0,
						'total_damage_received' => 0,
						'total_rounds' => 0,
						'action' => NULL
					)
				)
			)
		);
		
		$to = base_url() . 'attack/session?data=' . $id;
		
		if($this->input->is_ajax_request()) {
			echo '<script type="text/javascript"> top.location=\'' . $to  . '\'; </script>';
		} else {
			$this->co->redirect( $to );
		}
	}
	
	public function session()
	{
		$this->co->must_login();
		$this->co->is_attack();
			if( ! $this->input->get('data')) { show_404(); }
		$this->co->init();
		$ir = $this->co->whoami(array(
				'users.equip_primary',
				'users.equip_secondary',
				'users.equip_armor',
				
				'users.hospreason',
				
				'userstats.strength',
				'userstats.agility',
				'userstats.guard',
				'userstats.IQ'
			)
		);
		
		if( $this->input->get('with') && $this->input->get('with') != 'primary' && $this->input->get('with') != 'secondary' ) {
			show_404();
		}
		
		if($this->input->get('action') && $this->input->get('action') != 'mug' && $this->input->get('action') != 'leave' && $this->input->get('action') != 'hospitalize') {
			show_404();
		}
		
		$item = $this->db->select('*')->from('attacks')->join('username_cache', 'username_cache.userid = attacks.atk_defender')->where('atk_id', $this->input->get('data'))->where('atk_winner', '0')->where('atk_attacker', $ir['userid'])->get();
		
		if($item->num_rows() == 0) {
			show_404();
		}
		
		$item = $item->result_array();
		$item = $item[0];
		$item['atk_log'] = unserialize($item['atk_log']);
		$item['atk_stats'] = unserialize($item['atk_stats']);
		
		if($item['atk_defender'] != $ir['attacking']) {
			show_404();
		}
		
		$r = array_merge( $item , $this->co->get_user($item['username'], $this->data) );
		
		if($r['attack_result'] == 'complete') {
			$r['hp'] = 0;
		}
		
		/* $r contains all the data we're needing to carry on! */
		$this->co->set(array( 'title' => 'Criminal Outlaws | Attacking ' . $item['username'] ));
		
		/* Let's pull up the user data! */
		$this->co->storage['u'] = $r;
		
		$itmids = array();
		if($ir['equip_primary'] && ! in_array($ir['equip_primary'], $itmids)) { $itmids[] = $ir['equip_primary']; }
		if($ir['equip_secondary'] && ! in_array($ir['equip_secondary'], $itmids)) { $itmids[] = $ir['equip_secondary']; }
		if($ir['equip_armor'] && ! in_array($ir['equip_armor'], $itmids)) { $itmids[] = $ir['equip_armor']; }
		
		if($r['equip_primary'] && ! in_array($r['equip_primary'], $itmids)) { $itmids[] = $r['equip_primary']; }
		if($r['equip_secondary'] && ! in_array($r['equip_secondary'], $itmids)) { $itmids[] = $r['equip_secondary']; }
		if($r['equip_armor'] && ! in_array($r['equip_armor'], $itmids)) { $itmids[] = $r['equip_armor']; }
	
		$q = $this->db->select('items.itmid, items.itmname, items.armor, items.weapon')->from('items')->where_in('itmid', $itmids)->get()->result_array();
		
		$equips = array();
		foreach($q as $no=>$array) {
		
			if($ir['equip_primary'] == $array['itmid']) {
				$equips['me_primary'] = $array;
			}
			
			elseif($ir['equip_secondary'] == $array['itmid']) {
				$equips['me_secondary'] = $array;
			}
			
			elseif($ir['equip_armor'] == $array['itmid']) {
				$equips['me_armor'] = $array;
			}
			
			
			
			if($r['equip_primary'] == $array['itmid']) {
				$equips['opp_primary'] = $array;
			}
			
			elseif($r['equip_secondary'] == $array['itmid']) {
				$equips['opp_secondary'] = $array;
			}
			
			elseif($r['equip_armor'] == $array['itmid']) {
				$equips['opp_armor'] = $array;
			}
		
		}
		
		$equips['me_primary'] = (isset($equips['me_primary']) ? $equips['me_primary'] : 'None');
		$equips['me_secondary'] = (isset($equips['me_secondary']) ? $equips['me_secondary'] : 'None');
		$equips['me_armor'] = (isset($equips['me_armor']) ? $equips['me_armor'] : 'None');
		
		$equips['opp_primary'] = (isset($equips['opp_primary']) ? $equips['opp_primary'] : 'None');
		$equips['opp_secondary'] = (isset($equips['opp_secondary']) ? $equips['opp_secondary'] : 'None');
		$equips['opp_armor'] = (isset($equips['opp_armor']) ? $equips['opp_armor'] : 'None');
		
		$this->co->storage['equips'] = $equips;
		$this->co->storage['commentary'] = ($item['atk_stats']['total_rounds'] > 0 ? '' : 'You prepare to begin attacking your chosen opponent, <b>' . $item['username'] . '</b>.');
		
		$is_err = 0;
		if($this->input->get('action') && ! $this->co->storage['commentary'] && $item['atk_stats']['total_rounds'] == 0) {
			$is_err = 1;
			$this->co->storage['commentary'] = 'An unexpected error occurred during your battle. We\'re on to it.';
		}
		
		$id = random_string('alnum', 48);
		
		if(constant('ONLINE') == TRUE) {
			$this->db->set('atk_id', $id)->where('atk_id', $this->input->get('data'))->update('attacks');
			$this->co->storage['id'] = $id;
		} else {
			$this->co->storage['id'] = $this->input->get('data');
		}
		
		
		/* Attacking algorithm*/
		$random_equip = array();
		if($equips['opp_primary'] != 'None') {
			$random_equip[] = 'primary';
		}
		
		if($equips['opp_secondary'] != 'None') {
			$random_equip[] = 'secondary';
		}
		
		if($equips['opp_primary'] == 'None' && $equips['opp_secondary'] == 'None') {
			$random_equip[] = 'fists';
		}
		
		$this->co->storage['attack_result'] = 'null';
		
		if($r['hp'] == 0) {
			$this->co->storage['attack_result'] = 'won';
			$this->co->statistics_up('attacks_won');
		}
		
		if($this->input->get('with') or $this->input->get('action')) {
		
			if(($this->input->get('with') == 'hospitalize' || $this->input->get('with') == 'mug' || $this->input->get('with') == 'leave') && (now() >= $this->co->config['next_update'] - 10)) {
				$r['hp'] = 0;
				$this->co->storage['attack_result'] = 'won';
			}
			
			$opp_hit = $this->attack_algorithm( $r, $ir, $random_equip[ array_rand($random_equip) ] );
			$ir = $opp_hit['opp']; $r = $opp_hit['from'];
			
			$me_hit = $this->attack_algorithm( $ir, $r, $this->input->get('with') );
			$ir = $me_hit['from']; $r = $me_hit['opp'];
			
			$item['atk_stats']['total_damage_given'] += $me_hit['damage'];
			$item['atk_stats']['total_damage_received'] += $opp_hit['damage'];
			$item['atk_stats']['total_rounds'] ++;
			
			$this->co->statistics_up('total_damage_given', $me_hit['damage']);
			$this->co->statistics_up('total_damage_received', $opp_hit['damage']);
			
			if($this->input->get('action')) {
				$item['atk_stats']['action'] = $this->input->get('action');
			}
			
			$item['atk_log'] = array_merge( $item['atk_log'], $opp_hit['context'], $me_hit['context'] );
			
			$this->co->storage['commentary'] = end($item['atk_log']);
			$this->db->set('atk_log', serialize($item['atk_log']))->set('atk_stats', serialize($item['atk_stats']))->where('atk_id', $this->input->get('data'))->update('attacks');
			
			$r = array_merge( $r, $item );
			$this->co->storage['u'] = $r;
			$this->co->user = $ir;
			
			$ir['energy'] /= rand(1.5, 2.5);
			
			$this->db->
						set('money', $r['money'])->
						set('crystals', $r['crystals'])->
						set('exp', $r['exp'])->
						set('equip_primary', $r['equip_primary'])->
						set('equip_secondary', $r['equip_secondary'])->
						set('hospital', $r['hospital'])->
						set('hospreason', $r['hospreason'])->
						set('energy', $r['energy'])->
						set('hp', $r['hp'])->
						where('userid', $r['userid'])->
						update('users');
			
			
			$this->db->
						set('money', $ir['money'])->
						set('crystals', $ir['crystals'])->
						set('exp', $ir['exp'])->
						set('equip_primary', $ir['equip_primary'])->
						set('equip_secondary', $ir['equip_secondary'])->
						set('hospital', $ir['hospital'])->
						set('hospreason', $ir['hospreason'])->
						set('energy', $ir['energy'])->
						set('hp', $ir['hp'])->
						where('userid', $ir['userid'])->
						update('users');
						
			if($this->co->storage['attack_result'] == 'lost' || $this->co->storage['attack_result'] == 'complete') {
				$this->db->set('attacking', '0')->where('userid', $ir['userid'])->update('users');
				$this->db->set('atk_end_time', now())->set('atk_winner', $r['userid'])->where('atk_id', $this->input->get('data'));
			}
			
		}
		
		if($r['attack_result'] == 'complete') {
			$r['hp'] = 0;
		}
		
		if($r['hp'] == 0 && $this->co->storage['attack_result'] != 'lost' && $this->co->storage['attack_result'] != 'complete') {
			$this->co->storage['attack_result'] = 'won';
		}
		
		$this->co->page('internal/pages/attack');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */