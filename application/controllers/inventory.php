<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Inventory extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | My Inventory' ));
		$this->co->init();

		$ir = $this->co->whoami( array(
				'users.equip_primary',
				'users.equip_secondary',
				'users.equip_armor'
			)
		);
		
		$equip_list = array();
		if($ir['equip_primary'] > 0) { $equip_list[] = $ir['equip_primary']; }
		if($ir['equip_secondary'] > 0) { $equip_list[] = $ir['equip_secondary']; }
		if($ir['equip_armor'] > 0) { $equip_list[] = $ir['equip_armor']; }
		
		if(count($equip_list)) {
			$c	= $this->db->query("SELECT * FROM items WHERE itmid IN(".implode(', ', $equip_list).") LIMIT 3;")->result_array();
			foreach($c as $ii=>$aa) {
				if($ir['equip_primary'] == $aa['itmid']) { $q['primary'] = $aa; }
				if($ir['equip_secondary'] == $aa['itmid']) { $q['secondary'] = $aa; }
				if($ir['equip_armor'] == $aa['itmid']) { $q['armor'] = $aa; }
			}
		}
		
		if($ir['equip_primary'] > 0) {
			$this->co->storage['equip_primary'] = $q['primary']['itmname'];
		} else {
			$this->co->storage['equip_primary'] = '<font style="color:#999;">None selected</font>';
		}
		
		if($ir['equip_secondary'] > 0) {
			$this->co->storage['equip_secondary'] = $q['secondary']['itmname'];
		} else {
			$this->co->storage['equip_secondary'] = '<font style="color:#999;">None selected</font>';
		}
		
		if($ir['equip_armor'] > 0) {
			$this->co->storage['equip_armor'] = $q['armor']['itmname'];
		} else {
			$this->co->storage['equip_armor'] = '<font style="color:#999;">None selected</font>';
		}
		
		$inv = $this->db->query("SELECT inventory.inv_id, inventory.inv_qty, items.itmsellprice, items.itmid, items.itmname, items.itmtype, items.effect1_on, items.effect2_on, items.effect3_on, items.weapon, items.armor FROM inventory LEFT JOIN items ON inventory.inv_itemid=items.itmid WHERE inventory.inv_userid = ? AND inventory.inv_qty > 0 ORDER BY items.itmtype ASC, items.itmname ASC", array( $ir['userid'] ))->result_array();
		
		foreach($inv as $i=>$v) {
			$it = $this->co->get_item_type('itmtypeid', $v['itmtype']);
			$this->co->storage['items'][$it['itmtypename']][] = $v;
		}
		
		$this->co->page('internal/pages/inventory');
	}
	
	public function unequip()
	{
		if( ! $this->input->get('val') || $this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		$val = $this->input->get('val');
	
		$this->co->must_login();
		$this->co->allow_hospital();
		$this->co->init();

		$ir = $this->co->whoami( array(
				'users.equip_primary',
				'users.equip_secondary',
				'users.equip_armor'
			)
		);
		
		if($val == 'primary' && $ir['equip_primary']) {
			$this->co->notice('You have successfully unequipped your primary weapon!');
			$this->db->query("UPDATE users SET equip_primary = ? WHERE userid = ? LIMIT 1", array( 0, $ir['userid'] ));
		}
		
		elseif($val == 'secondary' && $ir['equip_secondary']) {
			$this->co->notice('You have successfully unequipped your secondary weapon!');
			$this->db->query("UPDATE users SET equip_secondary = ? WHERE userid = ? LIMIT 1", array( 0, $ir['userid'] ));
		}
		
		elseif($val == 'armor' && $ir['equip_armor']) {
			$this->co->notice('You have successfully unequipped your armor!');
			$this->db->query("UPDATE users SET equip_armor = ? WHERE userid = ? LIMIT 1", array( 0, $ir['userid'] ));
		}
		
		$this->co->redirect(base_url() . 'inventory');
		
	}
	
	public function equip()
	{
		if( ! $this->input->get('id')) {
			show_404();
		}
		
		$inv_id = $this->input->get('id');
	
		$this->co->must_login();
		$this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Equip Item' ));
		$this->co->init();

		$ir = $this->co->whoami( array(
				'users.equip_primary',
				'users.equip_secondary',
				'users.equip_armor'
			)
		);
		
		$inv = $this->db->query("SELECT * FROM inventory LEFT JOIN items ON inventory.inv_itemid=items.itmid WHERE inventory.inv_userid = ? AND inventory.inv_id = ? ORDER BY items.itmtype ASC, items.itmname ASC", array( $ir['userid'], $inv_id ))->result_array();
		
		if( ! isset($inv[0]['inv_id'])) {
			show_404();
		}
		
		if($ir['equip_primary'] == $inv[0]['itmid']) {
			$this->co->notice('You have already equipped the '.$inv[0]['itmname'].' as your primary weapon!');
			$this->co->redirect(base_url() . 'inventory');
		}
		
		if($ir['equip_secondary'] == $inv[0]['itmid']) {
			$this->co->notice('You have already equipped the '.$inv[0]['itmname'].' as your secondary weapon!');
			$this->co->redirect(base_url() . 'inventory');
		}
		
		if($ir['equip_armor'] == $inv[0]['itmid']) {
			$this->co->notice('You have already equipped the '.$inv[0]['itmname'].' as your armor!');
			$this->co->redirect(base_url() . 'inventory');
		}
		
		if($this->input->post('as')) {
			$equip = FALSE;
			
			if($this->input->post('as') == 'armor' && $inv[0]['armor'] > 0) {
				$equip = TRUE;
				$equip_as = 'armor';
			}
			
			if($this->input->post('as') == 'primary' && $inv[0]['weapon'] > 0) {
				$equip = TRUE;
				$equip_as = 'primary';
			}
			
			if($this->input->post('as') == 'secondary' && $inv[0]['weapon'] > 0) {
				$equip = TRUE;
				$equip_as = 'secondary';
			}
			
			if($equip) {
				$this->db->query("UPDATE users SET equip_".$equip_as." = ? WHERE userid = ? LIMIT 1", array($inv[0]['itmid'], $ir['userid']));
				$this->co->notice('The '.$inv[0]['itmname'].' is now equipped as your '.$equip_as );
			} else {
				$this->co->notice('You did not equip the '.$inv[0]['itmname'] . ' item');
			}
			
			$this->co->redirect(base_url() . 'inventory');
			
		}
		
		$this->co->storage['equip'] = $inv;
		$this->co->page('internal/pages/equip');
	}
	
	public function send()
	{
		if( ! $this->input->get('id')) {
			show_404();
		}
		
		$inv_id = $this->input->get('id');
	
		$this->co->must_login();
		$this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Send Item' ));
		$this->co->init();

		$ir = $this->co->whoami( array(
				'users.equip_primary',
				'users.equip_secondary',
				'users.equip_armor'
			)
		);
		
		/* if($ir['level'] < 2) {
			$this->co->notice('You need to be at least level 2 to be able to send items!');
			$this->co->redirect(base_url() . 'inventory');
		} */
		
		$inv = $this->db->query("SELECT * FROM inventory LEFT JOIN items ON inventory.inv_itemid=items.itmid WHERE inventory.inv_userid = ? AND inventory.inv_id = ? ORDER BY items.itmtype ASC, items.itmname ASC", array( $ir['userid'], $inv_id ))->result_array();
		
		if( ! isset($inv[0]['inv_id'])) {
			show_404();
		}
		
		$original_qty = $inv[0]['inv_qty'];
		
		if($ir['equip_primary'] == $inv[0]['itmid'] || $ir['equip_secondary'] == $inv[0]['itmid'] || $ir['equip_armor'] == $inv[0]['itmid'])
		{
			$inv[0]['inv_qty']--;
		}
		
		if($inv[0]['inv_qty'] == 0) {
			show_404();
		}
		
		if($this->input->post('post')) {
		
			$qty = $this->input->post('quantity');
			
			if( ! $this->input->post('username') || ! $this->input->post('quantity')) {
				$this->co->notice('You have not filled in all the fields. Please try again.');
				$this->co->redirect(base_url() . 'inventory/send?id=' . $this->input->get('id') . ($this->input->get('username') ? '&username=' . $this->input->get('username') : ''));
			} elseif( ! $this->co->user_exists($this->input->post('username'), 'USERNAME_ONLY') ) {
				$this->co->notice('The username \''.$this->input->post('username').'\' does not appear to exist!');
				$this->co->redirect(base_url() . 'inventory/send?id=' . $this->input->get('id') . ($this->input->get('username') ? '&username=' . $this->input->get('username') : ''));
			} elseif($this->co->user['username'] == $this->input->post('username')) {
				$this->co->notice('Sorry, you do not sufficient privileges to send yourself items.');
				$this->co->redirect(base_url() . 'inventory/send?id=' . $this->input->get('id') . ($this->input->get('username') ? '&username=' . $this->input->get('username') : ''));
			} if($qty > $inv[0]['inv_qty']) {
				$this->co->notice('You do not have this many of the '.$inv[0]['itmname'].' to send!');
			} else if($qty == 0) {
				$this->co->notice('You did not send any of the '.$inv[0]['itmname'].' in your inventory!');
			} elseif($qty > 0) {
				$total_give = $inv[0]['itmsellprice'] * $qty;
				
				$to = $this->co->get_user($this->input->post('username'), array('users.userid', 'users.username'));				
				$this->co->remove_inventory($inv[0]['itmid'], 0, $qty);
				
				$this->co->event_add($this->input->post('username'), 'You were sent '.$qty.'x '.$inv[0]['itmname'].' to your inventory by ' . $this->co->user['username'] . ' ['.$this->co->user['userid'].']');
				
				$this->co->add_inventory($inv[0]['itmid'], $to['userid'], $qty);
				
				if($this->db->affected_rows() > 0) {
					$this->co->notice('You have successfully sent '.$to['username'].' '.$qty.'x of the '.$inv[0]['itmname'].'!');
				} else {
					$this->co->notice('There was an error trying to sell your items to the local exchange.');
				}
				
			}
			
			$this->co->redirect(base_url() . 'inventory');
		}
		
		$this->co->storage['send_item'] = $inv;
		$this->co->page('internal/pages/send_item');
	}
	
	public function list_item()
	{
		if( ! $this->input->get('id')) {
			show_404();
		}
		
		$inv_id = $this->input->get('id');
	
		$this->co->must_login();
		$this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | List Item' ));
		$this->co->init();

		$ir = $this->co->whoami( array(
				'users.equip_primary',
				'users.equip_secondary',
				'users.equip_armor'
			)
		);
		
		$inv = $this->db->query("SELECT * FROM inventory LEFT JOIN items ON inventory.inv_itemid=items.itmid WHERE inventory.inv_userid = ? AND inventory.inv_id = ? ORDER BY items.itmtype ASC, items.itmname ASC", array( $ir['userid'], $inv_id ))->result_array();
		
		if( ! isset($inv[0]['inv_id'])) {
			show_404();
		}
		
		$original_qty = $inv[0]['inv_qty'];
		
		if($ir['equip_primary'] == $inv[0]['itmid'] || $ir['equip_secondary'] == $inv[0]['itmid'] || $ir['equip_armor'] == $inv[0]['itmid']) { $inv[0]['inv_qty']--; }
		
		if($inv[0]['inv_qty'] < 1) {
			show_404();
		}
		
		$qty = (int) $this->input->post('quantity');
		$qty = ($qty) ? $qty : 1;
		$price_each = $this->input->post('price');
		$price_each = ($price_each) ? $price_each : 100;
		$currency = $this->input->post('currency');
		
		if($this->input->post('post') == 1)
		{
			if($currency == 'money' && $price_each < ($inv[0]['itmsellprice']/4)) {
				$this->co->notice('Sorry, the item cannot be sold lower than 25% of its current sell value.');
				$this->co->redirect(base_url() . 'inventory/list_item?id=' . $inv_id);
			} else if($qty < 1 || $qty > $inv[0]['inv_qty']) {
				$this->co->notice('Sorry, an error occurred whilst trying to process your request.');
				$this->co->redirect(base_url() . 'inventory/list_item?id=' . $inv_id);
			} elseif($this->input->post('price') < 1) {
				$this->co->notice('You cannot ask for negative balance to sell your items.');
				$this->co->redirect(base_url() . 'inventory/list_item?id=' . $inv_id);
			} elseif($currency != 'money' && $currency != 'crystals') {
				$this->co->notice('That currency does not exist. Please select one that exists.');
				$this->co->redirect(base_url() . 'inventory/list_item?id=' . $inv_id);
			} else {
				$am = $qty;
				while($am > 0) {
					$this->db->insert("itemmarket", array(
							'imITEM' => $inv[0]['itmid'],
							'imADDER' => $ir['userid'],
							'imPRICE' => ($currency == 'money' ? $price_each : round($price_each)),
							'imCURRENCY' => $currency
						)
					);
					
					$am--;
				}
				
				$this->co->remove_inventory($inv[0]['itmid'], 0, $qty);
				
				$this->co->notice('You have successfully listed '.$qty.'x '.$inv[0]['itmname'].' on the item market for '.($currency == 'money' ? '$' . number_format($price_each, 2) : round($price_each) . ' gold').' each!');
				$this->co->redirect(base_url() . 'inventory');
			}
		}
		
		$this->co->storage['list_item'] = $inv;
		$this->co->page('internal/pages/list_item');
		
	}
	
	public function use_item()
	{
		if( ! $this->input->get('id')) {
			show_404();
		}
		
		$inv_id = $this->input->get('id');
	
		$this->co->must_login();
		$this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Use Item' ));
		$this->co->init();

		$ir = $this->co->whoami( array(
			)
		);
		
		$inv = $this->db->query("SELECT * FROM inventory LEFT JOIN items ON inventory.inv_itemid=items.itmid WHERE inventory.inv_userid = ? AND inventory.inv_id = ? ORDER BY items.itmtype ASC, items.itmname ASC", array( $ir['userid'], $inv_id ))->result_array();
		
		if( ! isset($inv[0]['inv_id'])) {
			show_404();
		}
		
		if( ! $inv[0]['effect1_on'] && ! $inv[0]['effect2_on'] && ! $inv[0]['effect3_on'] ) {
			show_404();
		}
		
		$names = array( 'effect1', 'effect2', 'effect3' );
		
		foreach($names as $name) {
		
			if($inv[0][$name . '_on'] > 0) {
				$einfo = unserialize($inv[0][$name]);
				
				if($einfo['inc_type'] == "percent") {
					if( in_array($einfo['stat'], array('energy','will','brave','hp')) ) {
						$inc = ceil($ir['max'.$einfo['stat']]/100*$einfo['inc_amount']);
					} else {
						$inc = ceil($ir[$einfo['stat']]/100*$einfo['inc_amount']);
					}
				} else {
					$inc = $einfo['inc_amount'];
				}
				
				if($einfo['dir'] == "pos") {
					if(in_array($einfo['stat'], array('energy','will','brave','hp'))) {
						$ir[$einfo['stat']] = min($ir[$einfo['stat']]+$inc, $ir['max'.$einfo['stat']]);
					} else {
						$ir[$einfo['stat']] += $inc;
					}
				} else {
					$ir[$einfo['stat']] = max($ir[$einfo['stat']]-$inc, 0);
				}
				
				$upd = $ir[$einfo['stat']];
				
				if(in_array($einfo['stat'], array('strength', 'agility', 'guard', 'labour', 'IQ'))) {
					$this->db->query("UPDATE `userstats` SET {$einfo['stat']} = '{$upd}' WHERE userid={$ir['userid']}");
				} else {
					$this->db->query("UPDATE `users` SET {$einfo['stat']} = '{$upd}' WHERE userid={$ir['userid']}");
				}
			
			}
		
		}
		
		$this->co->remove_inventory($inv[0]['itmid']);
		$this->co->statistics_up('inventory_total_used');
		$this->co->notice($inv[0]['itmname'] . ' has been used successfully!');		
		$this->co->redirect(base_url() . 'inventory');
		
	}
	
	public function sell()
	{
		if( ! $this->input->get('id')) {
			show_404();
		}
		
		$inv_id = $this->input->get('id');
	
		$this->co->must_login();
		$this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Sell Item' ));
		$this->co->init();

		$ir = $this->co->whoami( array(
				'users.equip_primary',
				'users.equip_secondary',
				'users.equip_armor'
			)
		);
		
		$inv = $this->db->query("SELECT * FROM inventory LEFT JOIN items ON inventory.inv_itemid=items.itmid WHERE inventory.inv_userid = ? AND inventory.inv_id = ? ORDER BY items.itmtype ASC, items.itmname ASC", array( $ir['userid'], $inv_id ))->result_array();
		
		if( ! isset($inv[0]['inv_id'])) {
			show_404();
		}
		
		$original_qty = $inv[0]['inv_qty'];
		
		if($ir['equip_primary'] == $inv[0]['itmid'] || $ir['equip_secondary'] == $inv[0]['itmid'] || $ir['equip_armor'] == $inv[0]['itmid']) { $inv[0]['inv_qty']--; }
		
		if($inv[0]['inv_qty'] == 0) {
			show_404();
		}
		
		if($this->input->post('amount')) {
		
			if($this->input->post('amount') == 'all') {
			
				$qty = $inv[0]['inv_qty'];
			
			} elseif($this->input->post('amount') == '1') {
				$qty = 1;
			} elseif($this->input->post('amount') == 'none') {
				$qty = 0;
			} elseif($this->input->post('amount') == 'custom') {
				$qty = (int) $this->input->post('custom');
			}
			
			if($qty > $inv[0]['inv_qty']) {
				$this->co->notice('You do not have this many of the '.$inv[0]['itmname'].' to sell!');
			} else if($qty == 0) {
				$this->co->notice('You did not sell any of the '.$inv[0]['itmname'].' in your inventory');
			} elseif($qty > 0) {
				$total_give = $inv[0]['itmsellprice'] * $qty;

				$this->co->remove_inventory($inv[0]['itmid'], 0, $qty);
				$this->co->add_money($ir['username'], $total_give);
				
				if($this->db->affected_rows() > 0) {
					$this->co->notice('You sold '.$qty.'x of the '.$inv[0]['itmname'].' for $' . number_format($total_give, 2));
				} else {
					$this->co->notice('There was an error trying to sell your items to the local exchange.');
				}
				
			}
			
			$this->co->redirect(base_url() . 'inventory');
		}
		
		$this->co->storage['sell_item'] = $inv;
		$this->co->statistics_up('inventory_total_sold');
		$this->co->page('internal/pages/sell_item');
	}

	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */