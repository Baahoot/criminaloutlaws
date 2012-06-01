<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Statistics extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Statistics' ));
		$ir = $this->co->whoami();
		
		$stats = array();

		$stats['ttlusers'] = $this->db->select('userid')->from('username_cache')->count_all_results();
		$stats['maleusers'] = $this->db->select('userid')->from('users')->where('gender', 'Male')->count_all_results();
		$stats['femaleusers'] = $this->db->select('userid')->from('users')->where('gender', 'Female')->count_all_results();
		$stats['onusers'] = $this->db->select('userid')->from('online')->where('laston >=', now()-60*15)->count_all_results();
		$stats['activeusers'] = $this->db->select('userid')->from('online')->where('laston >=', now()-60*60*24*30)->count_all_results();
		$stats['fbusers'] = $this->db->select('userid')->from('facebook_user')->count_all_results();

		$stats['m_perc'] = round(($stats['maleusers'] / $stats['ttlusers']) * 100);
		$stats['f_perc'] = round(($stats['femaleusers'] / $stats['ttlusers']) * 100);
		$stats['fb_perc'] = round(($stats['fbusers'] / $stats['ttlusers']) * 100);

		$stats['avgmoney'] = $this->db->select('AVG(money) AS avgmoney, SUM(money) AS ttlmoney, AVG(crystals) AS avgcrystals, SUM(crystals) AS ttlcrystals')->from('users')->get()->result_array();
		$stats['avgbkmoney'] = $this->db->select('AVG(bankmoney) AS avgbkmoney, SUM(bankmoney) AS ttlbkmoney, COUNT(userid) AS cnt')->from('users')->where('bankmoney >', '-1')->get()->result_array();
		$stats['avgmoney'][0]['ttlmoney'] += $stats['avgbkmoney'][0]['ttlbkmoney'];

		$stats['ttlitems'] = $this->db->select('itmid')->from('items')->count_all_results();

		$stats['ttlpro'] = $this->db->select('donator')->from('users')->where('donator >=', now())->count_all_results();
		$stats['ttlevents'] = $this->db->select('ev_ID')->from('events')->count_all_results();
		$stats['ttlmail'] = $this->db->select('mail_id')->from('mail')->count_all_results();
		
		$this->co->storage['stats'] = $stats;
		$this->co->page('internal/pages/stats');	
	}
		
}