<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MY_Co
{

	var $setting = array( 'title' => 'Criminal Outlaws' );
	var $s = array();
	var $user = false;
	var $redis = false;
	var $config = false;
	var $storage = false;
	var $notice = false;
	var $user_default = array(
		'users.userid',
		'users.is_ajax',
		'users.is_hp_bonus',
		'users.sessid',
		'users.username',
		'users.jobrank',
		'users.badges',
		'users.level',
		'users.last_upgraded',
		'users.exp',
		'users.display_pic',
		'users.signedup',
		'users.donator',
		'users.money',
		'users.crystals',
		'online.laston',
		'users.lastip',
		'users.energy',
		'users.maxenergy',
		'users.will',
		'users.maxwill',
		'users.brave',
		'users.maxbrave',
		'users.hp',
		'users.maxhp',
		'users.lastrest_life',
		'users.lastrest_other',
		'users.location',
		'users.hospital',
		'users.jail',
		'users.user_level',
		'users.gender',
		'users.gang',
		'users.bankmoney',
		'users.attacking',
		'users.contact_count',
		'users.new_events',
		'users.new_mail',
		'users.force_logout'
	);
	
	var $interest = array(
		1 => array(
			'interest_id' => 1,
			'min_money' => 0,
			'interest' => '0.01',
			'cost' => 25
		),
		2 => array(
			'interest_id' => 2,
			'min_money' => 150,
			'interest' => '0.02',
			'cost' => 100
		),
		3 => array(
			'interest_id' => 3,
			'min_money' => 1500,
			'interest' => '0.04',
			'cost' => 600
		),
		4 => array(
			'interest_id' => 4,
			'min_money' => 2800,
			'interest' => '0.07',
			'cost' => 2100
		),
		5 => array(
			'interest_id' => 5,
			'min_money' => 6000,
			'interest' => '0.10',
			'cost' => 3800
		),
		6 => array(
			'interest_id' => 6,
			'min_money' => 15000,
			'interest' => '0.15',
			'cost' => 9300
		),
		7 => array(
			'interest_id' => 7,
			'min_money' => 42000,
			'interest' => '0.20',
			'cost' => 21000
		),
		8 => array(
			'interest_id' => 8,
			'min_money' => 99000,
			'interest' => '0.35',
			'cost' => 30000
		),
		9 => array(
			'interest_id' => 9,
			'min_money' => 280000,
			'interest' => '0.49',
			'cost' => 63100
		),
		10 => array(
			'interest_id' => 10,
			'min_money' => 1200000,
			'interest' => '0.61',
			'cost' => 145000
		),
		11 => array(
			'interest_id' => 11,
			'min_money' => 4900000,
			'interest' => '0.88',
			'cost' => 835000
		)
	);
	
	var $userlevels = array(
		1 => array(
			'ul_id' => 1,
			'ul_userlevel' => 7,
			'ul_keyword' => 'admin',
			'ul_single' => 'Executive',
			'ul_name' => 'Executives',
			'ul_color' => '1A8ED6',
			'ul_desc' => 'Responsible for the corporate strategies of the game.'
		),
		2 => array(
			'ul_id' => 2,
			'ul_userlevel' => 6,
			'ul_keyword' => 'subadmin',
			'ul_single' => 'Administrator',
			'ul_name' => 'Administrators',
			'ul_color' => '627178',
			'ul_desc' => 'Responsible for in-game management.'
		),
		3 => array(
			'ul_id' => 3,
			'ul_userlevel' => 5,
			'ul_keyword' => 'moderator',
			'ul_single' => 'Moderator',
			'ul_name' => 'Moderators',
			'ul_color' => '96778F',
			'ul_desc' => 'Responsible for fair play and content moderation.'
		),
		4 => array(
			'ul_id' => 4,
			'ul_userlevel' => 4,
			'ul_keyword' => 'secretary',
			'ul_single' => 'Secretary',
			'ul_name' => 'Secretaries',
			'ul_color' => '8D29CC',
			'ul_desc' => 'Responsible for improving users gameplay.'
		),
		5 => array(
			'ul_id' => 5,
			'ul_userlevel' => 3,
			'ul_keyword' => 'helper',
			'ul_single' => 'Helper',
			'ul_name' => 'Helpers',
			'ul_color' => '508770',
			'ul_desc' => 'Responsible for assisting others with the game.'
		),
		6 => array(
			'ul_id' => 6,
			'ul_userlevel' => 2,
			'ul_keyword' => 'support',
			'ul_single' => 'Official Game Support',
			'ul_name' => 'Official Game Support',
			'ul_color' => '8C711F',
			'ul_desc' => 'The official game support team players.'
		),
		7 => array(
			'ul_id' => 7,
			'ul_userlevel' => 8,
			'ul_keyword' => 'beta-tester',
			'ul_single' => 'Beta Tester',
			'ul_name' => 'Beta Testers',
			'ul_color' => '47573D',
			'ul_desc' => 'Helping test the new releases of the game.'
		)
	);
	
	var $houses = array(
		1 => array(
			'hID' => 1,
			'hNAME' => 'Cardboard Box',
			'hPRICE' => 0,
			'hWILL' => 100
		),
		2 => array(
			'hID' => 2,
			'hNAME' => 'Shack',
			'hPRICE' => 250,
			'hWILL' => 110
		),
		3 => array(
			'hID' => 3,
			'hNAME' => 'Estate Block',
			'hPRICE' => 600,
			'hWILL' => 125
		),
		4 => array(
			'hID' => 4,
			'hNAME' => 'Shared Apartment',
			'hPRICE' => 2400,
			'hWILL' => 140
		),
		5 => array(
			'hID' => 5,
			'hNAME' => 'Rowhouse',
			'hPRICE' => 4500,
			'hWILL' => 150
		),
		6 => array(
			'hID' => 6,
			'hNAME' => 'Bungalow',
			'hPRICE' => 7000,
			'hWILL' => 190
		),
		7 => array(
			'hID' => 7,
			'hNAME' => 'Semi-Detached House',
			'hPRICE' => 12000,
			'hWILL' => 230
		),
		8 => array(
			'hID' => 8,
			'hNAME' => 'Detached House',
			'hPRICE' => 25000,
			'hWILL' => 275
		),
		9 => array(
			'hID' => 9,
			'hNAME' => 'Penthouse',
			'hPRICE' => 40000,
			'hWILL' => 340
		),
		10 => array(
			'hID' => 10,
			'hNAME' => 'Villa',
			'hPRICE' => 140000,
			'hWILL' => 400
		),
		11 => array(
			'hID' => 11,
			'hNAME' => 'Mansion',
			'hPRICE' => 400000,
			'hWILL' => 475
		),
		12 => array(
			'hID' => 12,
			'hNAME' => 'Farmhouse',
			'hPRICE' => 800000,
			'hWILL' => 575
		),
		13 => array(
			'hID' => 13,
			'hNAME' => 'Castle',
			'hPRICE' => 1600000,
			'hWILL' => 700
		),
		14 => array(
			'hID' => 14,
			'hNAME' => 'Ranch',
			'hPRICE' => 4000000,
			'hWILL' => 920
		),
		15 => array(
			'hID' => 15,
			'hNAME' => 'Private Island',
			'hPRICE' => 12000000,
			'hWILL' => 1150
		)
	);
	
	var $courses = array(
		1 => array(
			'crID' => 1,
			'crNAME' => 'Professional English Course',
			'crDESC' => 'A course which improves your knowledge on english',
			'crCOST' => 2300,
			'crENERGY' => 2,
			'crDAYS' => 16,
			'crSTR' => 0,
			'crGUARD' => 0,
			'crLABOUR' => 0,
			'crAGIL' => 0,
			'crIQ' => 50
		),
		2 => array(
			'crID' => 2,
			'crNAME' => 'National Police Starter Course',
			'crDESC' => 'A course which gives you initial knowledge on the state police',
			'crCOST' => 200,
			'crENERGY' => 4,
			'crDAYS' => 6,
			'crSTR' => 5,
			'crGUARD' => 0,
			'crLABOUR' => 0,
			'crAGIL' => 0,
			'crIQ' => 10
		),
		3 => array(
			'crID' => 3,
			'crNAME' => 'Karate Course',
			'crDESC' => 'A course which teaches you self-defence and agility techniques',
			'crCOST' => 6000,
			'crENERGY' => 12,
			'crDAYS' => 20,
			'crSTR' => 0,
			'crGUARD' => 20,
			'crLABOUR' => 0,
			'crAGIL' => 10,
			'crIQ' => 15
		),
		4 => array(
			'crID' => 4,
			'crNAME' => 'Builder Course',
			'crDESC' => 'A month course which improves your strength and labour significantly',
			'crCOST' => 12000,
			'crENERGY' => 20,
			'crDAYS' => 31,
			'crSTR' => 25,
			'crGUARD' => 0,
			'crLABOUR' => 30,
			'crAGIL' => 0,
			'crIQ' => 5
		),
		5 => array(
			'crID' => 5,
			'crNAME' => 'Computer Science (Undergraduate) Degree',
			'crDESC' => 'A 10 day course which improves your knowledge on computer sciences.',
			'crCOST' => 6500,
			'crENERGY' => 100,
			'crDAYS' => 10,
			'crSTR' => 0,
			'crGUARD' => 0,
			'crLABOUR' => 10,
			'crAGIL' => 10,
			'crIQ' => 30
		),
		6 => array(
			'crID' => 6,
			'crNAME' => 'Computer Science (Postgraduate) PhD',
			'crDESC' => 'A 20 day course which officially certifies you as a computer scientist.',
			'crCOST' => 10000,
			'crENERGY' => 100,
			'crDAYS' => 20,
			'crSTR' => 0,
			'crGUARD' => 0,
			'crLABOUR' => 20,
			'crAGIL' => 20,
			'crIQ' => 100
		)
	);
	
	var $itemtypes = array(
		1 => array(
			'itmtypeid' => 1,
			'itmtypename' => 'Melee'
		),
		2 => array(
			'itmtypeid' => 2,
			'itmtypename' => 'Armor'
		),
		3 => array(
			'itmtypeid' => 3,
			'itmtypename' => 'Collectables'
		),
		4 => array(
			'itmtypeid' => 4,
			'itmtypename' => 'Pistols'
		),
		5 => array(
			'itmtypeid' => 5,
			'itmtypename' => 'Rifles'
		),
		6 => array(
			'itmtypeid' => 6,
			'itmtypename' => 'Hand Weapons'
		),
		7 => array(
			'itmtypeid' => 7,
			'itmtypename' => 'Shotguns'
		),
		8 => array(
			'itmtypeid' => 8,
			'itmtypename' => 'Sub-Machine Guns'
		),
		9 => array(
			'itmtypeid' => 9,
			'itmtypename' => 'Machine Guns'
		),
		10 => array(
			'itmtypeid' => 10,
			'itmtypename' => 'Misc.'
		)
	);
	
	var $crimegroups = array(
		1 => array(
			'cgID' => 1,
			'cgNAME' => 'In the streets',
			'cgMINLEVEL' => 1
		),
		2 => array(
			'cgID' => 2,
			'cgNAME' => 'By the estates',
			'cgMINLEVEL' => 1
		) /* ,
		3 => array(
			'cgID' => 3,
			'cgNAME' => 'In the main city',
			'cgMINLEVEL' => 3
		),
		4 => array(
			'cgID' => 4,
			'cgNAME' => 'In an affluent area',
			'cgMINLEVEL' => 5
		),
		5 => array(
			'cgID' => 5,
			'cgNAME' => 'In the private areas',
			'cgMINLEVEL' => 7
		),
		6 => array(
			'cgID' => 6,
			'cgNAME' => 'Billionaires\' Club',
			'cgMINLEVEL' => 12
		) */
	);
	
	var $shops = array(
		1 => array(
			'shopID' => 1,
			'shopLOCATION' => 1,
			'shopNAME' => 'New Alberts',
			'shopDESCRIPTION' => 'The number one place to get all the guns you need!'
		),
		2 => array(
			'shopID' => 2,
			'shopLOCATION' => 1,
			'shopNAME' => 'Masters Knives',
			'shopDESCRIPTION' => 'You know me... I sell all the cheapest knives there are to be bought!'
		),
		3 => array(
			'shopID' => 3,
			'shopLOCATION' => 1,
			'shopNAME' => 'Black Street Joes',
			'shopDESCRIPTION' => 'The finest weapons available in New York in todays world'
		)
	);
	
	var $cities = array(
		1 => array(
			'cityid' => 1,
			'cityname' => 'New York',
			'citydesc' => 'The city where the rate of poor living is high with a ever-growing crime rate',
			'citycost' => 100,
			'cityminlevel' => 1
		),
		2 => array(
			'cityid' => 2,
			'cityname' => 'New Orleans',
			'citydesc' => 'This city is where newcomers come to increase their arsenal',
			'citycost' => 1500,
			'cityminlevel' => 2
		),
		3 => array(
			'cityid' => 3,
			'cityname' => 'Michigan',
			'citydesc' => 'Michigan is a state where machinery and production is its main source of economical development',
			'citycost' => 4200,
			'cityminlevel' => 5
		),
		4 => array(
			'cityid' => 4,
			'cityname' => 'Atlanta',
			'citydesc' => 'The city which offers higher quality weaponry, opportunities and money opportunities',
			'citycost' => 9500,
			'cityminlevel' => 7
		),
		5 => array(
			'cityid' => 5,
			'cityname' => 'Alaska',
			'citydesc' => 'A lower crime rate with bigger opportunities to make money through investments',
			'citycost' => 14000,
			'cityminlevel' => 9
		),
		6 => array(
			'cityid' => 6,
			'cityname' => 'Los Angeles',
			'citydesc' => 'One of the lowest crime rates in the US with huge security available for those with a lot to lose',
			'citycost' => 20000,
			'cityminlevel' => 12
		),
		7 => array(
			'cityid' => 7,
			'cityname' => 'California',
			'citydesc' => 'Crime rates are higher than Los Angeles, but has huge opportunities to make money',
			'citycost' => 34000,
			'cityminlevel' => 14
		),
		8 => array(
			'cityid' => 8,
			'cityname' => 'Washington',
			'citydesc' => 'The most security tightened cities but very expensive to live in. Crime rates almost cease to exist in this city',
			'citycost' => 49000,
			'cityminlevel' => 18
		),
		9 => array(
			'cityid' => 9,
			'cityname' => 'Area 51',
			'citydesc' => 'An exclusive pass to the most confidential location in the world where all types of discoveries and high tech weapons can be bought - only the best get here',
			'citycost' => 1000000,
			'cityminlevel' => 30
		)
	);

	function __construct()
	{
		$CI =& get_instance();
		//$CI->form_validation->set_error_delimiters( '<br /><div class="response error-note">Error: ', '</div>' );
		
		if(constant('ONLINE') == FALSE):
			//$CI->output->enable_profiler(TRUE);
		endif;
		
		if(1 == 0 && constant('ONLINE') == TRUE ) {
			echo $CI->load->view('temporary', '', true);
			exit;
		}
				
		$CI->load->config('redis');
		$this->redis = ($CI->config->item('redis_active'));
	}
	
	/* Undocumented code */
	
	public function add_inventory($itemid, $userid = 0, $qty = 1) {
		global $CI;
		$userid = ($userid > 0) ? $userid : $this->user['userid'];
		
		$is_bought = $CI->db->query("SELECT COUNT(*) AS cnt FROM inventory WHERE inv_itemid = ? AND inv_userid = ?", array( $itemid, $userid ))->result_array();
		$is_bought = $is_bought[0]['cnt'];
		
		if($is_bought > 0) {
			$CI->db->query("UPDATE inventory SET inv_qty = inv_qty + ? WHERE inv_itemid = ? AND inv_userid = ?", array( $qty, $itemid, $userid ));
		} else {
			$CI->db->insert("inventory", array(
					'inv_itemid' => $itemid,
					'inv_userid' => $userid,
					'inv_qty' => $qty
				)
			);
		}
		
		return TRUE;
	}
	
	public function remove_inventory($itemid, $userid = 0, $qty = 1) {
		global $CI;
		$userid = ($userid > 0) ? $userid : $this->user['userid'];
		
		$is_bought = $CI->db->query("SELECT COUNT(*) AS cnt FROM inventory WHERE inv_itemid = ? AND inv_userid = ?", array( $itemid, $userid ))->result_array();
		$is_bought = $is_bought[0]['cnt'];
		
		if($is_bought == 0) {
			return FALSE;
		}
		
		$CI->db->query("UPDATE inventory SET inv_qty = inv_qty - ? WHERE inv_itemid = ? AND inv_userid = ?", array( $qty, $itemid, $userid ));
		$CI->db->query("DELETE FROM inventory WHERE inv_qty < 1");
		
		return TRUE;
	}
	
	public function pro_only() {
		if($this->user['donator'] < now()) {
			
			$this->notice('Sorry, you need to have a PRO membership to use this feature!');
			$this->redirect(base_url() . 'pro');
		}
	}
	
	public function redirect($uri) {
		global $CI;
		if(!$CI->input->is_ajax_request()) {
			redirect($uri, 'location');
		} else {
			echo '<div id="redirect">' . ($uri) . '</div>';
			echo '<meta http-equiv="refresh" content="2; ' . $uri . '" />';
		}
		exit;
	}
	
	public function get_house($item, $id, $is_multiple = 0) {
		$o = array();
		if($item == 'id') { $im = 'hID'; }
		if($item == 'name') { $im = 'hNAME'; }
		if($item == 'price') { $im = 'hPRICE'; }
		if($item == 'will') { $im = 'hWILL'; }
		
		foreach($this->houses as $n=>$array) {
			if($array[$im] == $id) { $o[] = $array; }
		}
		
		return (count($o) == 1 && ! $is_multiple) ? $o[0] : $o;
	}
	
	public function get_houses() {
		return $this->houses;
	}
	
	public function get_item_type($item, $id, $is_multiple = 0) {
		$o = array();
		foreach($this->itemtypes as $n=>$array) {
			if($array[$item] == $id) { $o[] = $array; }
		}
		return (count($o) == 1 && ! $is_multiple) ? $o[0] : $o;
	}
	
	public function get_item_types() {
		return $this->itemtypes;
	}
	
	public function get_shop($item, $id, $is_multiple = 0) {
		$o = array();
		foreach($this->shops as $n=>$array) {
			if($array[$item] == $id) { $o[] = $array; }
		}
		return (count($o) == 1 && ! $is_multiple) ? $o[0] : $o;
	}
	
	public function get_shops() {
		return $this->shops;
	}
	
	public function get_city($item, $id, $is_multiple = 0) {
		$o = array();
		foreach($this->cities as $n=>$array) {
			if($array[$item] == $id) { $o[] = $array; }
		}
		return (count($o) == 1 && ! $is_multiple) ? $o[0] : $o;
	}
	
	public function get_cities() {
		return $this->cities;
	}
	
	function since($time)
	{
    	$time = now() - $time;
    	$tokens = array (
    	    31536000 => 'year',
    	    2592000 => 'month',
    	    604800 => 'week',
    	    86400 => 'day',
    	    3600 => 'hour',
    	    60 => 'minute',
    	    1 => 'second'
    	);

    	foreach ($tokens as $unit => $text) {
    	    if ($time < $unit) continue;
    	    $numberOfUnits = floor($time / $unit);
    	    return $numberOfUnits . ' ' . $text . ( ($numberOfUnits>1) ? 's' : '' );
    	}
    	
    	return FALSE;
	}
	
	public function get_statistics( $userid = 0, $additional = array() ) {
		global $CI;
		$userid = ($userid > 0 ? $userid : $this->user['userid']);
		
		if(count($additional) > 0)
		{
			$q = $CI->db->select('*')->from('statistics')->where_in('stat_name', $additional)->where('userid', $userid)->get();
		} else {
			$q = $CI->db->select('*')->from('statistics')->where('userid', $userid)->get();
		}

		if($q->num_rows() == 0) {
			return FALSE;
		}
		
		$result = array();
		foreach($q->result_array() as $i=>$r) {
			$result[ $r['stat_name'] ] = $r['stat_value'];
		}
		
		return $result;
	}
	
	public function statistics_set( $stat_name, $stat_value, $userid = 0, $increase = 0 ) {
		global $CI;
		$userid = ($userid > 0 ? $userid : $this->user['userid']);
		
		if($increase == 1) {
			$CI->db->query("UPDATE statistics SET stat_value = stat_value + ? WHERE stat_name = ? AND userid = ? LIMIT 1", array( $stat_value, $stat_name, $userid ));
		} else {
			$CI->db->query("UPDATE statistics SET stat_value = ? WHERE stat_name = ? AND userid = ? LIMIT 1", array( $stat_value, $stat_name, $userid ));
		}
		
		if($CI->db->affected_rows() == 0) {
			$CI->db->insert('statistics', array(
					'userid' => $userid,
					'stat_name' => $stat_name,
					'stat_value' => $stat_value
				)
			);
		}
		
		return TRUE;
	}
	
	public function statistics_up( $stat_name, $stat_value = 1, $userid = 0 ) {
		if($stat_value == 0) { return false; }
		return $this->statistics_set( $stat_name, $stat_value, $userid, 1 );
	}

	public function __compare_stat($stat) {
		global $CI;
		if($stat != 'strength' && $stat != 'agility' && $stat != 'labour' && $stat != 'IQ' && $stat != 'guard' && $stat != 'total') { return; }
		if($stat == 'total') {
			$res = $CI->db->query("SELECT COUNT(*) AS cnt FROM userstats LEFT JOIN users ON userstats.userid=users.userid WHERE (userstats.strength + userstats.agility + userstats.labour + userstats.IQ + userstats.guard) >= ? AND userstats.userid != ? AND users.user_level != 0", array($this->user['strength']+$this->user['agility']+$this->user['labour']+$this->user['IQ']+$this->user['guard'], $this->user['userid']))->result_array();
		} else {
			$res = $CI->db->query("SELECT COUNT(userstats.".$stat.") AS cnt FROM userstats LEFT JOIN users ON userstats.userid=users.userid WHERE userstats.".$stat." >= ? AND userstats.userid != ? AND users.user_level != 0", array($this->user[$stat], $this->user['userid']))->result_array();
		}
		$res = $res[0];
		return 1+$res['cnt'];
	}
	
	public function __compare_all_stats() {
		global $CI;
		$cct = "userstat-" . $this->user['userid'];
		$i = $CI->redis->get($cct);
		
		if($i) {
			return $i;
		} else {
			$j = array(
				'strength' => $this->__compare_stat('strength'),
				'agility' => $this->__compare_stat('agility'),
				'labour' => $this->__compare_stat('labour'),
				'guard' => $this->__compare_stat('guard'),
				'IQ' => $this->__compare_stat('IQ'),
				'total' => $this->__compare_stat('total')
			);
			
			$CI->redis->set($cct, $j, 60*60*48);
			return (array) $j;
		}
	}
	
	public function breadcrumbs($a) {
		if( ! is_array($a)) { return false; }
		$this->storage['breadcrumbs'] = $a;
		return true;
	}
	
	public function get_breadcrumbs() {
		$breadcrumbs = $this->storage['breadcrumbs'];
		$i = 1;
		foreach($breadcrumbs as $name=>$link) {
			if($i) {
				$result[] = $name;
				$i = 0;
			} else {
				$result[] = '<a href="'. (substr($link, base_url()) > 0 ? $link : base_url() . $link) .'" rel="ajax">'.$name.'</a>';
			}
		}
		return '<div class="breadcrumbs">' . implode(' &middot; ', $result) . '</div>';
	}
	
	function parse_bbcode($str = '', $max_images = 0){
		$str = nl2br($str);
	
		$find = array(
			"'\[b\](.*?)\[/b\]'is",
			"'\[i\](.*?)\[/i\]'is",
			"'\[u\](.*?)\[/u\]'is",
			"'\[s\](.*?)\[/s\]'is",
			"'\[img\](.*?)\[/img\]'i",
			"'\[url\](.*?)\[/url\]'i",
			"'\[url=(.*?)\](.*?)\[/url\]'i",
			"'\[link\](.*?)\[/link\]'i",
			"'\[link=(.*?)\](.*?)\[/link\]'i",
			"'\[left\](.*?)\[/left\]'is",
			"'\[center\](.*?)\[/center\]'is",
			"'\[right\](.*?)\[/right\]'is",
			"'\[br\]'is",
			"'\[title\](.*?)\[/title\]'i",
			"'\[title=(.*?)\](.*?)\[/title\]'i",
			"'\[color=(#[a-zA-Z0-9]*?|[a-zA-Z0-9]*?)\](.*?)\[/color\]'i",
			"'\[highlight=(#[a-zA-Z0-9]*?|[a-zA-Z0-9]*?)\](.*?)\[/highlight\]'i"
		);

		$replace = array(
			'<strong>\\1</strong>',
			'<em>\\1</em>',
			'<u>\\1</u>',
			'<s>\\1</s>',
			'<img border="0" style="max-width:100%; max-height:500px;" src="\\1" alt="" />',
			'<a style="font-size:12px;" href="\\1">\\1</a>',
			'<a style="font-size:12px;" href="\\1">\\2</a>',
  			'<a style="font-size:12px;" href="\\1">\\1</a>',
			'<a style="font-size:12px;" href="\\1">\\2</a>',
			'<div align="left">\\1</div>',
			'<div align="center">\\1</div>',
			'<div align="right">\\1</div>',
			'<br />',
			'<h3 style="font-family:\'Helvetica Neue\', verdana, arial; font-size:24px; margin:0; ">\\1</h3>',
			'<h3 style="">\\1</h3>',
			'<font color="\\1">\\2</font>',
			'<span style="float:none; background:\\1; padding:10px;">\\2</span>'
		);

		$return = preg_replace($find, $replace, $str);
		$return = parse_smileys($return, $this->base(true) . '/emoticons');
		return $return;
	}
	
	public function __internal_user() {
		if(!$this->user) { $this->whoami(); }
		if(isset($this->user[0])) { $this->user = $this->user[0]; }

		$output['username'] = $this->username();
		$output['money'] = number_format($this->user['money'], 2);
		$output['money'] = '$' . $output['money'];
		if($output['money'] > 0) { $output['money'] = '<font color="red">' . $output['money'] . '</font>'; }
		$output['crystals'] = number_format($this->user['crystals']);
		$output['level'] = number_format($this->user['level'], 0);
		$output['daysold'] = $this->days_elapsed($this->user['signedup']);
		$output['donatordays'] = ($this->user['donator'] > now()) ? ceil(($this->user['donator'] - now()) / (60 * 60 * 24)) : 0;
		$output['type'] = ($output['donatordays'] > now()) ? '<span class="pro">PRO</span> (for another ' . $this->since($this->user['donator']) . ')' : 'Basic';
		$upgraded = ($this->user['last_upgraded'] > 0 ? $this->days_elapsed($this->user['signedup']) : $output['daysold']);
		$upgraded = ($upgraded == 0) ? 1 : $upgraded;
		
		$output['exp_needed'] = (int) ((($this->user['level']+1)*($this->user['level']+1)*($this->user['level']+1))*(13.95+(35.95 * ($upgraded * 0.025)))); /* Levelling up algorithm! */
		if($this->user['exp'] > $output['exp_needed']) { $output['level'] .= " <span style='float:right;'>[<a href='".base_url()."upgrade?__unique__=".$this->get_session()."' rel='ajax'>Upgrade</a>]</span>"; }
		$output['badges'] = ($this->badges()) ? '<span class="badge-p">'. $this->badges() . '</span>' : '';
		
		if($this->user['donator'] > now()) {
		
			$add = '';
			$cnt = 0;
			foreach(range(0, count($this->user['badges'])) as $i) {
				$cnt++;
				if($cnt == 3) { $cnt = 0; $add .= '<br />'; }
			}
		
			$output['badges'] = '<span class="pro" style="position:relative; top:-2px; float:left; font-size:8px; margin-right:8px; text-shadow:none; ">PRO</span> <span style="float:left;">' . $output['badges'] . '</span>' . $add;
		}
		
		$this->user['energy'] = ($this->user['energy'] > $this->user['maxenergy'] ? $this->user['maxenergy'] : $this->user['energy']);
		$this->user['will'] = ($this->user['will'] > $this->user['maxwill'] ? $this->user['maxwill'] : $this->user['will']);
		$this->user['hp'] = ($this->user['hp'] > $this->user['maxhp'] ? $this->user['maxhp'] : $this->user['hp']);
		$this->user['brave'] = ($this->user['brave'] > $this->user['maxbrave'] ? $this->user['maxbrave'] : $this->user['brave']);
		
		$output['energy_perc'] = round(($this->user['energy']/$this->user['maxenergy'])*100);
		$output['will_perc'] = round(($this->user['will']/$this->user['maxwill'])*100);
		$output['hp_perc'] = round(($this->user['hp']/$this->user['maxhp'])*100);
		$output['brave_perc'] = round(($this->user['brave']/$this->user['maxbrave'])*100);
		$output['hospital_count'] = $this->config['hospital_count'];
		$output['jail_count'] = $this->config['jail_count'];
		$output['force_logout'] = $this->user['force_logout'];
		
		$output['energy_value'] = $this->user['energy'] . ' / ' .$this->user['maxenergy'];
		$output['energy_time'] = ($output['energy_perc'] < 100 ? $this->seconds_to_mins($this->config['next_update']) : '0:00');
		
		$output['will_value'] = $output['will_perc'] . '%';
		$output['will_time'] = ($output['will_perc'] < 100 ? $this->seconds_to_mins($this->config['next_update']) : '0:00');
		
		$output['brave_value'] = $this->user['brave'] . ' / ' .$this->user['maxbrave'];
		$output['brave_time'] = ($output['brave_perc'] < 100 ? $this->seconds_to_mins($this->config['next_update']) : '0:00');
		
		$output['hp_value'] = $this->user['hp'] . ' / ' .$this->user['maxhp'];
		$output['hp_time'] = ($output['hp_perc'] < 100 ? $this->seconds_to_mins($this->config['next_update']) : '0:00');
		
		$output['notifications'] =  $this->user['new_events'] + $this->user['new_mail'];
		$output['events'] = number_format($this->user['new_events']);
		$output['mail'] = number_format($this->user['new_mail']);
		
		return (array) $output;
	}
	
	public function seconds_to_mins($input) {
		if($input > now()) { $input -= now(); }
		$is_mins = 0;
		
		if($input > 60) {
			$is_mins = floor($input / 60);
			$input -= $is_mins * 60;
		}
		
		if($input < 10) {
			$input = '0' . $input;
		}
		
			return ($is_mins > 0 ? $is_mins . ':' . $input : '0:' . $input);
	}
	
	public function get_config() {
		global $CI;
		if($this->config) { return $this->config; }
		
		$cii = $CI->redis->get("system-cache"); if($cii) { return (array) json_decode($cii, TRUE); }
		$r = $CI->db->query("SELECT cache_item, cache_value FROM cache WHERE 1=1")->result_array();
		$set = array();
		
		foreach($r as $i=>$v) {
			$set[$v['cache_item']] = $v['cache_value'];
		}
		
		if(count($set) == 0) {
			$CI->db->insert("config", array(
					array(
						'config_item' => 'hospital_count',
						'config_value' => 0
					),
					array(
						'config_item' => 'jail_count',
						'config_value' => 0
					),
					array(
						'config_item' => 'sync_day',
						'config_value' => now()
					),
					array(
						'config_item' => 'sync',
						'config_value' => now()
					)
				)
			);
		}
		
		$CI->redis->set("system-cache", json_encode($set), 60*2);
		return $set;
	}
	
	public function update_config($name, $value) {
		global $CI;
		if($this->config[$name] == $value) { return; }
		$CI->db->query("UPDATE cache SET cache_value = ? WHERE cache_item = ? LIMIT 1", array($value, $name));
		
		/* if($CI->db->affected_rows() == 0) {
			$CI->db->insert("cache", array(
					'cache_item' => $name,
					'cache_value' => $value
				)
			);
		} */
		
		$this->config[$name] = $value;
		$CI->redis->delete("system-cache");
		return true;
	}
	
	public function days_elapsed($time) {
    	$datediff = now() - $time;
    	return floor($datediff/(60*60*24)); /* days */
	}
	
	public function is_locked() {
		if($this->user['hospital'] > time()) { return array('type' => 'hospital', 'until' => $this->user['hospital']); }
		if($this->user['jail'] > time()) { return array('type' => 'jail', 'until' => $this->user['jail']); }
		return FALSE;
	}
	
	public function page($url) {
		global $CI;
		$CI->load->view('internal/header');
		$CI->load->view($url);
		$CI->load->view('internal/footer');
	}
	
	public function username() {
		return $this->username_format($this->user, 1, 'NO_PRO_ID');
	}
	
	public function username_format($userdata, $a = 0, $show_online = 1) {
		global $CI;
		
		$username = $userdata['username'];
		if($userdata['user_level'] > 1) {
			$uldata = array();
			foreach($this->userlevels as $i => $r) { if($r['ul_userlevel'] == $userdata['user_level']) { $uldata = $r; break; } }
			$username = '<font style="color:#'.$uldata['ul_color'].';	">' . $userdata['username'] . '</font>';
		}
		
		if(!isset($userdata['laston'])) {
			$_this = $CI->db->select('*')->from('online')->where('userid', $userdata['userid'])->where('laston >', now() - 60*15)->get();
			$_this = $_this->result_array();
			$_this = (isset($_this[0])) ? $_this[0] : 0;
		} else {
			$_this = (now() - 60*15 < $userdata['laston'] ? 1 : 0);
		}
		
		$online = '';
		
		if(isset($_this) && $_this > 0 && $show_online > 0) {
			$online = ' <font class="useron" style="" title="'.$userdata['username'].' is online">&nbsp;</font>';
		} elseif($show_online > 0) {
			$online = ' <font class="useroff" style="" title="'.$userdata['username'].' is offline">&nbsp;</font>';
		}
		
		if($show_online == 2) {
			return str_replace('style=""', 'style="float:none;"', $online);
		}

		if( ! $a) {
			return '<a style="padding:0px; font-size:13px; font-weight:normal;" href="'.base_url().'user/'.$userdata['username'].'" rel="ajax">'.$username . ( $show_online != 'NO_PRO_ID' ? ' ['. $userdata['userid'] .']' : '') .'</a>'  . ($userdata['donator'] > now() ? '<a title="This user is currently a Pro Outlaw"><span class=\'pro pro-padding\'>PRO</span></a>' : '') . $online;
		}
		
		return $username . ( $show_online != 'NO_PRO_ID' ? ' ['. $userdata['userid'] .']' : '') . ($userdata['donator'] > now() && $show_online != 'NO_PRO' && $show_online != 'NO_PRO_ID' ? '<a title="You are currently a Pro Outlaw"><span class=\'pro pro-padding\'>PRO</span></a>' : '');
	}
	
	public function is_multi($ip) {
		global $CI;
		$q = $CI->db->query('SELECT COUNT(*) AS cnt FROM users WHERE lastip_signup = ? LIMIT 10;', array($ip))->result_array();
		$output = $q[0]['cnt'];
		return ($output > 4 ? TRUE : FALSE);
	}
	
	public function event_add($username, $message, $is_userid = FALSE) {
		global $CI;
		if($is_userid) { $user['userid'] = $username; } else if($this->user_exists($username) == FALSE) { return FALSE; }
		if( ! $is_userid) { $user = $this->get_user($username, 'userid'); }
		
		$CI->db->insert("events", array(
				'evUSER' => $user['userid'],
				'evTIME' => time(),
				'evREAD' => 0,
				'evTEXT' => $message
			)
		);
		
		if($is_userid) {
			$CI->db->query("UPDATE users SET new_events = new_events + 1 WHERE userid = ? LIMIT 1", array($username));
		} else {
			$CI->db->query("UPDATE users SET new_events = new_events + 1 WHERE username = ? LIMIT 1", array($username));
		}
		return TRUE;
	}
	
	public function add_money($username, $amount) {
		return $this->change_money($username, $amount, '+');
	}
	
	public function remove_money($username, $amount) {
		return $this->change_money($username, $amount, '-');
	}
	
	public function change_money($username, $amount, $type) {
		global $CI;
		if($this->user_exists($username) == FALSE) { return FALSE; }
		$amount = number_format($amount, 2);
		$amount = str_replace(',', '', $amount);
		$t = ($type == '+') ? '+' : '-';
		$CI->db->query("UPDATE users SET money = money".$t.$amount." WHERE username = ? LIMIT 1", array($username));
		return true;
	}
	
	public function add_crystals($username, $amount) {
		return $this->change_crystals($username, $amount, '+');
	}
	
	public function remove_crystals($username, $amount) {
		return $this->change_crystals($username, $amount, '-');
	}
	
	public function change_crystals($username, $amount, $type) {
		global $CI;
		if($this->user_exists($username) == FALSE) { return FALSE; }
		$amount = (int) $amount;
		$t = ($type == '+') ? '+' : '-';
		$CI->db->query("UPDATE users SET crystals = crystals".$t.$amount." WHERE username = ? LIMIT 1", array($username));
		return true;
	}
	
	public function get_user($username, $data = array(), $is_cached = FALSE) {
		global $CI;
		if( !is_array($data)) { $data = $this->user_default; }
		$data = array_merge($data, array( 'users.maxwill', 'users.location' ));
		$add_merge = array();
		if($this->user_exists($username) == FALSE || ! is_array($data)) { return FALSE; }
		
			$cchr = "user_get-" . md5( implode('', $data) . $username );
			$cch = ($is_cached && $this->redis) ? $CI->redis->get($cchr) : '';
			if(isset($cch) && strlen($cch) > 0) { return $cch; }
		
			$select_string = '';
			
			if( count( preg_grep('/userstats.(.*)/', $data) ) > 0 ) {
				$select_string .= ' LEFT JOIN userstats ON users.userid=userstats.userid';
			}
			
			if( count( preg_grep('/online.(.*)/', $data) ) > 0 && ! $this->redis) {
				$select_string .= ' LEFT JOIN online ON online.userid=users.userid';
			}
			
			if( count( preg_grep('/usersigs.(.*)/', $data) ) > 0 && ! $this->redis) {
				$select_string .= ' LEFT JOIN usersigs ON usersigs.userid=users.userid';
			}
			
			if( (count( preg_grep('/jobs.(.*)/', $data) ) > 0 || count( preg_grep('/jobranks.(.*)/', $data) ) > 0) && ! $this->redis) {
				$select_string .= ' LEFT JOIN jobranks ON users.jobrank=jobranks.rank_id LEFT JOIN jobs ON jobranks.rank_job=jobs.job_id';
			}
		
		$q = $CI->db->query("SELECT ". implode(', ', $data) ." FROM users".$select_string." WHERE username = ? LIMIT 1", array($username))->result_array();
		
		$output = $q[0];
		if(isset($output['badges'])) { $output['badges'] = (strstr($output['badges'], '|')) ? explode('|', $output['badges']) : array( $output['badges'] ); }
		
		$house = $this->get_house('will', $output['maxwill']);
		$city = $this->get_city('cityid', $output['location']);
		$output = array_merge($output, $house, $city);
		
		if($this->redis):
		
			if( count( preg_grep('/online.(.*)/', $data) ) > 0 ) {
				$add_merge['laston'] = $this->redis->get('laston-' . $output['userid']);
			}

			$output = array_merge($output, $add_merge);
		endif;
		
		if($is_cached && $this->redis) { $CI->redis->set($cchr, $output, 60*5); } /* Delay for 5 minutes */
		return $output;
	}
	
	public function add_badge($username, $badge) {
		global $CI;
		if(!$this->user_exists($username, 'USERNAME_ONLY')) { return; }
		if(isset($this->user) && $username == $this->user['username']) { $u = $this->user; } else {
			$u = $this->get_user($username, array( 'users.badges' ));
		}
		
		if(!is_array($u['badges']) && strlen($u['badges']) > 0) { $u['badges'] = array( $u['badges'] ); }
		if(is_array($u['badges']) && in_array($badge, $u['badges'])) {
			return false;
		}
		
		if(is_array($u['badges'])) { $u['badges'] = array_merge( $u['badges'], array($badge) ); } else { $u['badges'] = array( $badge ); }
		$CI->db->query("UPDATE users SET badges = ? WHERE username = ? LIMIT 1", array( implode('|', $u['badges']), $username ));
		return true;		
	}
	
	public function remove_badge($username, $badge) {
		global $CI;
		if(!$this->user_exists($username, 'USERNAME_ONLY')) { return; }
		if(isset($this->user) && $username == $this->user['username']) { $u = $this->user; } else {
			$u = $this->get_user($username, array( 'users.badges' ));
		}
		
		if(!is_array($u['badges']) && strlen($u['badges']) > 0) { $u['badges'] = array( $u['badges'] ); }
		if(is_array($u['badges']) && ! in_array($badge, $u['badges'])) {
			return false;
		}
		
		foreach($u['badges'] as $no=>$va) {
			if($va == $badge) { 
				$num = $no; break;
			}
		}
		
		unset($u['badges'][$num]);
		$CI->db->query("UPDATE users SET badges = ? WHERE username = ? LIMIT 1", array( implode('|', $u['badges']), $username ));
		return true;		
	}
	
	public function user_exists($username, $login_name = FALSE) {
		global $CI;
		$username = strtolower($username);
		
		if(isset($this->storage['user_exists'][$username])) {
			return ( $this->storage['user_exists'][$username] ) ? TRUE : FALSE;
		}
		
		$cchr = "user_exist-" . $username;
		$cch = $CI->redis->get($cchr);
		
		if( ! $cch)
		{
			if($login_name == 'LOGIN_ONLY') { 
				
				$q = $CI->db->query("SELECT COUNT(*) AS cnt FROM users WHERE LOWER(login_name) = ? LIMIT 1;", array($username));
			} else if($login_name == 'USERNAME_ONLY') { 
				$q = $CI->db->query("SELECT COUNT(*) AS cnt FROM users WHERE LOWER(username) = ? LIMIT 1;", array($username));
			} else {
				$q = $login_name == FALSE ?	$CI->db->query("SELECT COUNT(*) AS cnt FROM users WHERE LOWER(username) = ? OR LOWER(login_name) = ? LIMIT 1;", array($username, $username)) : $CI->db->query("SELECT COUNT(*) AS cnt FROM username_cache WHERE LOWER(username) = ? LIMIT 1;", array($username));
			}
			
			$q = $q->result_array();
			
			$output = $q[0]['cnt'];
			if($output > 0) { $CI->redis->set($cchr, $output, 60*60*24); } /* Cache for 24 hours */
		} else {
			$output = $cch;
		}
		
		$output = (isset($output) && $output > 0 ? TRUE : FALSE);
		
		$this->storage['user_exists'][$username] = $output;
		return $output;
	}
	
	public function badges() {
		if( ! $this->user) { return; }
		return $this->get_badges($this->user, 'medium');
	}
	
	public function get_badges($userdata, $size = 'normal') {
		global $CI;
		$output = array();
		$size_html = ($size == 'small') ? " width='10' height='10'" : " width='16' height='16'";
		$size_html = ($size == 'medium') ? " width='12' height='12'" : $size_html;
		
		if(!is_array($userdata['badges'])) { $userdata['badges'] = (substr_count($userdata['badges'], '|') > 0 ? explode('|', $userdata['badges']) : array( $userdata['badges'] )); }
		
		if( count($userdata['badges']) > 0 && in_array('verified', $userdata['badges']) ) {
			$output[] = "<img src='".$this->base(true)."/badges/verified.gif' border='0'".$size_html." title='".$userdata['username']." is a verified member' />";
		}
		
		if( count($userdata['badges']) > 0 && in_array('preregistration', $userdata['badges']) ) {
			$output[] = "<img src='".$this->base(true)."/badges/preregistration.png' border='0'".$size_html." title='".$userdata['username']." signed up during the pre-registration period' />";
		}
		
		if( count($userdata['badges']) > 0 && in_array('facebook', $userdata['badges']) ) {
			$output[] = "<img src='".$this->base(true)."/badges/facebook.gif' border='0'".$size_html." title='".$userdata['username']." is using Facebook Connect to play Criminal Outlaws' />";
		}
		
		if( count($userdata['badges']) > 0 && in_array('refer', $userdata['badges']) ) {
			$output[] = "<img src='".$this->base(true)."/badges/refer.gif' border='0'".$size_html." title='".$userdata['username']." has referred people to Criminal Outlaws!' />";
		}
		
		if( count($userdata['badges']) > 0 && in_array('beta', $userdata['badges']) ) {
			$output[] = "<img src='".$this->base(true)."/badges/beta.png' border='0'".$size_html." title='".$userdata['username']." has been a beta tester!' />";
		}
		
		return (count($output)) ? implode('&nbsp;', $output) : '';
	}
	
	public function get_interface() {
		global $CI;
		
		if($this->user['jail'] > now()) {
			return 'JAIL';
		} 
		
		else if($this->user['hospital'] > now()) {
			return 'HOSPITAL';
		}
		
		else {
			return 'STANDARD';
		}
	}
	
	public function whoami($data = array(), $force_refresh = FALSE) {
		global $CI, $ALLOW_JAIL, $ALLOW_HOSPITAL, $ALLOW_ATTACK;
		$id = $this->get_session();
		if($id == FALSE) { return; }
		
		$cchr = 'user-' . $id;
		$cch = "";
		
		$add_merge = array();
		if($this->user && ! $force_refresh) { } else if(count($data) > 0) {
			$data = array_merge($data, $this->user_default);
			$data = array_unique($data);
		} else {
			$data = $this->user_default;
		}
		
		$select_string = '';
			
		if( count( preg_grep('/userstats.(.*)/', $data) ) > 0 ) {
			$select_string .= ' LEFT JOIN userstats ON users.userid=userstats.userid';
		}
		
		if( count( preg_grep('/cities.(.*)/', $data) ) > 0 ) {
			$select_string .= ' LEFT JOIN cities ON users.location=cities.cityid';
		}
			
		if( count( preg_grep('/houses.(.*)/', $data) ) > 0 ) {
			$select_string .= ' LEFT JOIN houses ON users.maxwill=houses.hWILL';
		}
		
		if( count( preg_grep('/usersigs.(.*)/', $data) ) > 0 && ! $this->redis) {
				$select_string .= ' LEFT JOIN usersigs ON usersigs.userid=users.userid';
		}
			
		if( count( preg_grep('/online.(.*)/', $data) ) > 0 && ! $this->redis) {
				$select_string .= ' LEFT JOIN online ON online.userid=users.userid';
		}
		
		if($this->redis) {
			foreach($data as $dataid=>$datakey) { if($datakey == 'online.laston') unset($data[$dataid]); }
		}
		
		$q = $CI->db->query("SELECT ".implode(', ', $data)." FROM users".$select_string." WHERE users.sessid = ? LIMIT 1;", array( $id ))->result_array();
			
		if( ! count($q)) { $this->logout_user(); }
		$q = $q[0];
		
		if($q['force_logout'] == 1) {
			$this->logout_user();
		}
		
		$house = $this->get_house('will', $q['maxwill']);
		$city = $this->get_city('cityid', $q['location']);
		$q = array_merge($q, $house, $city);
		
		if($this->redis):
			
			if( count( preg_grep('/online.(.*)/', $data) ) > 0 ) {
				$add_merge['laston'] = $this->redis->get('laston-' . $q['userid']);
			}
			
			$q = array_merge($q, $add_merge);
		endif;
		
		$this->update_online($q);
		
		$qr[0] = $q;
		if(isset($qr[0]['force_decode']) && $qr[0]['force_decode'] == 1) { $this->logout_user(); }
		$qr[0]['badges'] = (strstr($qr[0]['badges'], '|')) ? explode('|', $qr[0]['badges']) : array( $qr[0]['badges'] );
		if($this->user) { $this->user = array($this->user, $qr[0]); } else { $this->user = $qr[0]; }
		
		if($ALLOW_ATTACK == 0 && $qr[0]['attacking'] > 0) {
			$usr = $CI->db->select('username')->from('username_cache')->where('userid', $qr[0]['attacking'])->get()->result_array();
			$usr = $usr[0]['username'];
			$perc = rand( 0.1 , 0.9 );
			$this->notice('You fled your battle against '.$usr.' and lost '.($perc * 100).'% of your EXP!');
			
			$CI->db->query("UPDATE users SET attacking = 0, exp = ((exp / 100) * ".$perc.") WHERE userid = ? LIMIT 1", array( $qr[0]['userid'] ));
			$this->redirect(base_url() . 'home');
		} else if($qr[0]['hospital'] > now() && $ALLOW_HOSPITAL == 1) {
		
		} elseif($qr[0]['hospital'] > now() && $qr[0]['jail'] <= now()) {
			//if( ! $CI->input->is_ajax_request()) { $this->notice('Sorry, you cannot access this while your in hospital.'); }
			$this->redirect(base_url() . 'hospital');
		}
		
		if($qr[0]['jail'] > now() && $ALLOW_JAIL == 1) {
		
		} elseif($qr[0]['jail'] > now()) {
			//if( ! $CI->input->is_ajax_request()) { $this->notice('Sorry, you cannot access this while your in jail.'); }
			$this->redirect(base_url() . 'jail');
		}
		
		return (array) $qr[0];
	}
	
	public function update_online($ar) {
		global $CI;
		
		if($this->user['force_logout'] == 1) {
			$this->notice('The system or a member of staff forced you to logout of your account');
			$this->logout_user();
		}
		
		if($this->redis) {
			$CI->redis->set('laston-'. $this->user['userid'], now(), 10);
			return;
		}
		
		$i = $CI->db->query("SELECT COUNT(*) AS cnt FROM online WHERE userid = ?", array($ar['userid']))->result_array();
		$i = $i[0]['cnt'];
		
		if(!$i) {
			$CI->db->insert("online", array('userid' => $ar['userid'], 'laston' => now()));
		} else {
			$CI->db->query("UPDATE online SET laston = ? WHERE userid = ?", array(now(), $ar['userid']));
		}
		
		return;
	}
	
	public function user_cache_clear() {
		global $CI;
		$id = $this->get_session();
		if($id == FALSE) { return; }
		$cchr = 'user-' . $id;
		$cch = $CI->redis->delete($cchr);
	}
	
	public function set($array) {
		foreach($this->setting as $n=>$v) {
			if($array[$n]) {
				$out[$n] = $array[$n];
			} else {
				$out[$n] = $value;
			}
		}
		
		$this->s = $out;
	}
	public function get($n) {
		echo $this->s[$n];
	}
	
	public function mail($to, $username, $subject, $message) {
		global $CI;
		
		$CI->load->library('postmark');
		$CI->postmark->to($to, $username);
		$CI->postmark->subject($subject);
		$CI->postmark->message_plain($message);
		@$CI->postmark->send(); /* If we run out of credit, don't fail the whole site */
	}
	
	public function is_referer() {
		global $CI;
		return ($CI->session->userdata('referer') == TRUE);
	}
	
	public function get_referer() {
		global $CI;
		if($this->is_referer()) { return $CI->session->userdata('referer'); } return FALSE;
	}
	
	public function set_referer($id) {
		global $CI;
		$CI->session->set_userdata('referer', $id); return TRUE;
	}
	
	public function is_attack() {
		global $ALLOW_ATTACK;
		$this->storage['attack'] = 1;
		$ALLOW_ATTACK = 1;
	}
	
	public function allow_jail() {
		global $ALLOW_JAIL;
		$ALLOW_JAIL = 1;
	}

	public function allow_hospital() {
		global $ALLOW_HOSPITAL;
		$ALLOW_HOSPITAL = 1;
	}
	
	public function init() {
		global $CI;
		//run
		
		$this->config = $this->get_config();
		
		/* START STOCK MARKET RUN */
		if($this->config['sync_stock'] <= now()) {
		
			$CI->db->query("UPDATE stock_stocks SET stockUD = 1, stockCHANGE = 0, stockNPRICE = stockOPRICE WHERE stockNPRICE < 0");
			$stocks = $CI->db->select('stockID, stockNPRICE')->from('stock_stocks')->get()->result_array();
			
			foreach($stocks as $i=>$r) {
				$rand = mt_rand( 1, 2 );
				
				if($rand == 2) {
					$mr = mt_rand( 10, 75 );
					$r['stockNPRICE'] -= $mr;
					$CI->db->set('stockUD', 0)->set('stockCHANGE', $mr)->set('stockNPRICE', $r['stockNPRICE'])->where('stockID', $r['stockID'])->update('stock_stocks');
				}
				
				else {
					$mr = mt_rand( 10, 95 );
					$r['stockNPRICE'] += $mr;
					$CI->db->set('stockUD', 1)->set('stockCHANGE', $mr)->set('stockNPRICE', $r['stockNPRICE'])->where('stockID', $r['stockID'])->update('stock_stocks');
				}
				
				/* A potential of them crashing! */
				$sel = $CI->db->select('stockID, stockNAME')->from('stock_stocks')->where('stockNPRICE < 0')->get();
				foreach($sel->result_array() as $i2=>$r2) {
					$hol = $CI->db->select('holdingID, holdingUSER')->from('stock_holdings')->where('holdingSTOCK', $r2['stockID'])->get();
					if($hol->num_rows() == 0) {
						continue;
					}
				
					$r3 = $hol->result_array();
					$this->event_add( $r3[0]['holdingUSER'], "The stock for {$r2['stockNAME']} has crashed so you've lost all your shares!", TRUE );
					
					if($sel->num_rows() > 0) {
						$CI->db->query("DELETE FROM stock_holdings WHERE holdingSTOCK = ?", array( $r2['stockID'] ));
					}
				}
				$CI->db->query("UPDATE stock_stocks SET stockUD = 1, stockCHANGE = 0, stockNPRICE = stockOPRICE WHERE stockNPRICE < 0");
				
			}
		
			$this->update_config('sync_stock', now() + 60 * mt_rand( 5, 15 ));
		}
		
		/* START LOTTERY RUN */
		if($this->config['sync_lottery'] <= now()) {
		
			$winners = array();
			$winning_numbers = array(
				1 => rand(1, 10),
				2 => rand(1, 10),
				3 => rand(1, 10),
				4 => rand(1, 10),
				5 => rand(1, 10)
			);
			
			$db_array = array(
				$winning_numbers[1],
				$winning_numbers[2],
				$winning_numbers[3],
				$winning_numbers[4],
				$winning_numbers[5]
			);
			
			$query = $CI->db->
				select('*')->
				from('lotterytickets')->
				join('username_cache', 'lotterytickets.lt_user = username_cache.userid')->
				or_where_in('lt_num_1', $db_array)->
				or_where_in('lt_num_2', $db_array)->
				or_where_in('lt_num_3', $db_array)->
				or_where_in('lt_num_4', $db_array)->
				or_where_in('lt_num_5', $db_array)->
				get();
			
			$new_prize_fund = $this->config['lottery_jackpot'];
			foreach($query->result_array() as $wid => $wi) {
				
				if( in_array($wi['userid'], $winners) ) {
					/* Sorry, you've already collected your reward. */
					continue;
				}
			
				$numbers = array(
					1 => 0,
					2 => 0,
					3 => 0,
					4 => 0,
					5 => 0,
					6 => 0,
					7 => 0,
					8 => 0,
					9 => 0,
					10 => 0
				);
				$numbers[$wi['lt_num_1']]++;
				$numbers[$wi['lt_num_2']]++;
				$numbers[$wi['lt_num_3']]++;
				$numbers[$wi['lt_num_4']]++;
				$numbers[$wi['lt_num_5']]++;
				
				$is_invalid = 0;
				$result = array(
					$winning_numbers[1],
					$winning_numbers[2],
					$winning_numbers[3],
					$winning_numbers[4],
					$winning_numbers[5]
				);
				
				foreach($result as $each_num) {
					
					if( @$numbers[ $each_num ] > 0 ) {
						$numbers[ $each_num ]--;
					}
					else
					{
						$is_invalid = 1;
					}
					
				}
				
				if($is_invalid == 1) {
					/* This is not a winning entry, so let's close it off! */
					continue;
				}
				else
				{
					$winners[] = $wi['userid'];
					$new_prize_fund = 0;
				}
			}
			
			if(count($winners) > 0)
			{
				$prize = round( $this->config['lottery_jackpot'] / count( $winners ), 2);
				$CI->db->set('money = money + ' . $prize)->where_in('userid', $winners)->update('users');
				
				foreach($winner as $each_winner)
				{
					if($prize == 0) { continue; }
					$this->event_add($each_winner, 'You won the lottery! You have been awarded $' . number_format( $prize, 2) . ' for your win!', TRUE);
				}
		
			}
		
			$storage_output = serialize(
				array(
					'winners' => $winners,
					'amount' => $this->config['lottery_jackpot']
				)
			);
			
			$new_prize_fund += rand(50000, 500000) + (count($winners) * 20);
			
			$CI->db->query("TRUNCATE TABLE lotterytickets");
			$this->update_config('sync_lottery', now() + 60*60*24*3);
			$this->update_config('lottery_winners', $storage_output);
			$this->update_config('lottery_jackpot', $new_prize_fund);
			/* Lottery prize won and succeeded! */
		}
		
		/* START 15 MINUTE CRON JOB */
		$max_last_updated = 60*10;
		if($this->config['sync'] < now() - $max_last_updated) {
			
			$times = floor((now() - $this->config['sync']) / $max_last_updated);
			/* $times = ($times > 2) ? 2 : abs($times); */
			$times = range( 1, abs( $times ) );
			
			foreach($times as $i):
				$query[] = 'UPDATE users SET brave = brave + ( (maxbrave / 10) + 0.5 ) WHERE brave < maxbrave';
				$query[] = 'UPDATE users SET brave = maxbrave WHERE brave > maxbrave';
				$query[] = 'UPDATE users SET hp = hp + ( maxhp / 3 ) WHERE hp < maxhp';
				$query[] = 'UPDATE users SET hp = maxhp WHERE hp > maxhp';
				$query[] = 'UPDATE users SET energy = energy + ( maxenergy / ( 12.5 ) ) WHERE energy < maxenergy AND donator < ' . now();
				$query[] = 'UPDATE users SET energy = energy + ( maxenergy / 6.25 ) WHERE energy < maxenergy AND donator >= ' . now();
				$query[] = 'UPDATE users SET energy = maxenergy WHERE energy > maxenergy';
				$query[] = 'UPDATE users SET will = will + 10 WHERE will < maxwill';
				$query[] = 'UPDATE users SET will = maxwill WHERE will > maxwill';
				foreach($query as $this_query) { $o = $CI->db->query($this_query); }
			endforeach;
			
			/* ---- $item_policing = $CI->db->query("SELECT items.caught, items.itmname, inventory.* FROM items LEFT JOIN inventory ON items.itmid=inventory.inv_itemid WHERE items.caught > " . rand(0.00, 1.00) . " ORDER BY rand() LIMIT 100" )->result_array();
			
			foreach($item_policing as $i => $row) {
				$is_jail = ($row['caught'] > rand(0.01, 1.00) ? TRUE : FALSE);
				
				if($is_jail) {
					$mins = rand(15,40);
					$CI->db->set('jail', now() + 60*$mins)->set('jail_reason', 'Caught with the '.$row['itmname'].' item by the police')->where('userid', $row['inv_userid'])->where('jail <', now())->update('users');
					$this->event_add($row['inv_userid'], "You were sent to jail for {$mins} minutes because you got caught with the {$row['itmname']} item in your inventory.", TRUE);
					$jail++;
				}
			} ----- */
			
			/* Courses */
			
			$courses = $this->courses;
			
			if(count($courses) > 0) {
				
				foreach($courses as $i => $r) {
					
					$coursesql = array();
					$coursedetails = array();
					
					if($r['crSTR'] > 0) {
						$coursesql[] = 'userstats.strength = userstats.strength + ' . $r['crSTR'];
						$coursedetails[] = $r['crSTR'] . ' power';
					}
					
					if($r['crGUARD'] > 0) {
						$coursesql[] = 'userstats.guard = userstats.guard + ' . $r['crGUARD'];
						$coursedetails[] = $r['crSTR'] . ' defence';
					}
					
					if($r['crLABOUR'] > 0) {
						$coursesql[] = 'userstats.labour = userstats.labour + ' . $r['crLABOUR'];
						$coursedetails[] = $r['crSTR'] . ' labour';
					}
					
					if($r['crAGIL'] > 0) {
						$coursesql[] = 'userstats.agility = userstats.agility + ' . $r['crAGIL'];
						$coursedetails[] = $r['crAGIL'] . ' speed';
					}
					
					if($r['crIQ'] > 0) {
						$coursesql[] = 'userstats.IQ = userstats.IQ + ' . $r['crIQ'];
						$coursedetails[] = $r['crIQ'] . ' intelligence';
					}
					
					$users = $CI->db->select('userid')->from('users')->where('course', $r['crID'])->where('course_expires <=', now())->get();	
					$inserts = array();
					$duplicates = array();
					foreach($users->result_array() as $i2 => $r2) {
						if( isset($duplicates[ $r2['userid'] ]) ) { continue; }  $duplicates[ $r2['userid'] ] = $r2;
						$coursedetails = implode(', ', $coursedetails);
						$inserts[] = array( 'userid' => $r2['userid'], 'courseid' => $r['crID'] );
						$this->event_add($r2['userid'], "Congratulations! You have now completed the {$r['crNAME']} course and have gained {$coursedetails}!", TRUE);
					}
					
					if(count($inserts) > 0) {
						$CI->db->insert_batch("coursesdone", $inserts);
					}
					
					if(count($coursesql) > 0) {
						$update_sql = implode(', ', $coursesql);
						$CI->db->query("UPDATE userstats LEFT JOIN users ON userstats.userid = users.userid SET ".$update_sql." WHERE users.course = ? AND users.course_expires <= " . now(), array( $r['crID'] ) );
					}
					
				}
				
				$CI->db->query("UPDATE users SET course = 0, course_expires = 0 WHERE course_expires <= ?", array( now() ));
			}
			
			$jail_count = $CI->db->select('username')->from('users')->where('jail >', now())->count_all_results();
			$hospital_count = $CI->db->select('username')->from('users')->where('hospital >', now())->count_all_results();
			
			$this->update_config('jail_count', $jail_count);
			$this->update_config('hospital_count', $hospital_count);
			$this->update_config('sync', now());
		}
		/* END 15 MINUTE CRON JOB */
		
		
		/* START DAY CRON JOB */
		$max_last_updated = 60*60*24;
		if($this->config['sync_day'] < now() - $max_last_updated) {
			
			$d = date('w', now());
			
			if($d == 5) {
				/* It's Friday, Friday, Friday! */
				
				$list = $CI->db->select('userid, jobwage')->from('users')->where('jobwage >', 0)->get()->result_array();
				
				foreach($list as $i => $r) {
					$this_userid = $r['userid'];
					$this_jobwage = $r['jobwage'];
					
					$this->event_add($this_userid, 'It\'s Payday! You have been paid $'.number_format($this_jobwage, 2).' from your work directly into your account!', TRUE);
				}
				
				$CI->db->query("UPDATE users SET money = money + jobwage, jobwage = 0 WHERE jobwage > 0");
			}
			
			$query[] = 'TRUNCATE TABLE votes';
			$query[] = 'UPDATE users SET maxhp = maxhp - is_hp_bonus, is_hp_bonus = 0 WHERE is_hp_bonus > 0';
			$query[] = 'UPDATE users SET hp = maxhp WHERE hp > maxhp';
			$query[] = 'UPDATE users SET bankmoney = bankmoney + (bankmoney * (bankinterest / 100)) WHERE bankmoney > 0';
			foreach($query as $this_query) { $o = $CI->db->query($this_query); }
			
			$this->update_config('sync_day', now());
		}
		/* END DAY CRON JOB */

		
		$this->config['next_update'] = ($this->config['sync'] + 60*10) - now();
		$this->config['next_day_update'] = ($this->config['sync_day'] + 60*60*24) - now();
	}
	
	public function get_session() {
		global $CI;
		$cookie = $CI->input->cookie($CI->config->item('session_name'));
		if(strlen($cookie) != 18) { return FALSE; }
		return $cookie ? $cookie : FALSE;
	}
	
	public function notice($m) {
		global $CI;
		if($CI->uri->uri_string() == "") { return; }
		$CI->session->set_flashdata("notice", $m); $this->notice = $m; return true;
	}
	
	public function get_notice() {
		global $CI;
		$i = $this->notice; if(isset($i)) { $this->notice = FALSE; }
		return ($i) ? $i : $CI->session->flashdata("notice");
	}
	
	public function login_user($username, $password, $salt) {
		global $CI;
		if($this->is_logged_in() == TRUE) { return false; }
		if($this->user_exists($username, 'LOGIN_ONLY') == FALSE) { return false; }
		$pass = $this->hmac($CI->config->item('db_hash') . $salt, $password);
		$g = random_string('alnum', 18);
		$CI->input->set_cookie( $CI->config->item('session_name'), $g, 60*60*24*31 );
		$CI->db->query("UPDATE users SET sessid = ?, lastip_login = ?, force_logout = 0, last_login = ? WHERE login_name = ? AND userpass = ? LIMIT 1", array( $g, $CI->input->ip_address(), now(), $username, $pass ));
		return true;	
	}
	
	public function raw_login($userid) {
		global $CI;
		if($this->is_logged_in() == TRUE) { return false; }
		$g = random_string('alnum', 18);
		$CI->db->query("UPDATE users SET sessid = ?, lastip_login = ?, force_logout = 0, last_login = ? WHERE userid = ? LIMIT 1", array( $g, $CI->input->ip_address(), now(), $userid ));
		$CI->input->set_cookie( $CI->config->item('session_name'), $g, 60*60*24*31 );
		return true;
	}
	
	public function logout_user() {
		global $CI;
		delete_cookie($CI->config->item('session_name'));
		redirect(base_url() . 'login', 'location');
		return true;
	}
	
	/*------------------------------
	    base()
	  - This ensures web delivery is automatically offloaded to cdn.criminaloutlaws.com after it is pushed
	 ------------------------------*/
	public function base($return = FALSE)
	{
		global $CI;
		return 'http://'.$_SERVER['HTTP_HOST'] . $return;
	}
	
	/*------------------------------
	    is_logged_in()
	  - This function detects whether the website visitor is logged in so we can process his request
	------------------------------*/
	public function is_logged_in()
	{
		global $CI;
		if($CI->input->cookie($CI->config->item('session_name')) && strlen($CI->input->cookie($CI->config->item('session_name'))) == 18) { return TRUE; }
		return FALSE;
	}
	
	/*------------------------------
	    must_login()
	  - This extends from is_logged_in() to ensure that non-logged in users are sent to the login page
	------------------------------*/
	public function must_login()
	{
		global $CI;
		$redir = FALSE;
		if($this->is_logged_in() == FALSE) {
			$redir = base_url() . 'login';
			if(urlencode($CI->uri->uri_string())) { $redir .= '?return=/' . urlencode($CI->uri->uri_string()); }
			if(isset($redir)) { $this->notice('Sorry, you need to be logged in to access this area of the website.'); redirect($redir, 'location'); }
		}
		return FALSE;
	}
	
	/*------------------------------
	    must_logout()
	  - This offers the reverse functionality from the must_login() above w/ the ability to return to previous page!
	------------------------------*/
	public function must_logout()
	{
		global $CI;
		if($this->is_logged_in() == FALSE) { return FALSE; }
		$return = $CI->input->get('return');
		if(substr($return, 0, 1) == "/") { $return = substr($return, 1, strlen($return)); }
		$redir = ($CI->input->get('return')) ? base_url() . $return : base_url() . 'home';
		if(isset($redir)) { redirect($redir, 'location'); }
	}
	
	/*------------------------------
	    hmac()
	  - A simplified version of the HMAC encoder for password encryption
	------------------------------*/		
	public function hmac($key, $data)
	{
		$b = 64; /* How many bytes to encode the string */
		
		if(strlen($key) > $b)
		{
			$key = pack("H*",md5($key));
		}
		
		$key = str_pad($key, $b, chr(0x00));
		$ipad = str_pad('', $b, chr(0x36));
		$opad = str_pad('', $b, chr(0x5c));
		$k_ipad = $key ^ $ipad ;
		$k_opad = $key ^ $opad;
		$message = $k_opad . pack("H*",md5($k_ipad . $data));
		return base64_encode(md5($message));
	}
	
}

/* End of file Co.php */