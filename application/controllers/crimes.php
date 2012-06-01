<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Crimes extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Crimes' ));
		$this->co->init();
		$ir = $this->co->whoami();
		$this->co->page('internal/pages/crimes');		
	}
	
	public function perform()
	{
		$this->co->must_login();
		$this->co->init();

		$ir = $this->co->whoami(array(
				'users.crimexp',
				'userstats.IQ'
			)
		);
		
		$sess = $this->input->get('__unique__');
		$id = $this->input->get('id');
		
		
		if($sess != $this->co->get_session() || !$id) {
			show_404();
		}
		
		$id = $this->db->select('*')->from('crimes')->where('crimeID', $id)->limit(1)->get()->result_array();
		
		if(!isset($id[0])) {
			show_404();
		}
		
		$r = $id[0];
		$this->co->storage['crimes'] = $r;
		
		if($ir['brave'] < $r['crimeBRAVE']) {
			show_404();
		}
				
		$this->co->set(array( 'title' => 'Criminal Outlaws | Crimes: ' . $r['crimeNAME'] ));
		
		/* This is the algorithm! */
		$algorithm = "\$sucrate = ".str_replace(array("LEVEL","CRIMEXP","EXP","WILL","IQ"), array($ir['level'], $ir['crimexp'], $ir['exp'], $ir	['will'], $ir['IQ']),$r['crimePERCFORM']).";";
		eval($algorithm);

		$this->co->storage['output'] = '';
		$this->co->storage['output'] .= '<p class="center crime-sub"><span>' . $r['crimeITEXT'] . '</span></p>';
		$ir['brave'] -= $r['crimeBRAVE'];

		$this->co->statistics_up('crimes_total');
		$this->db->set( 'brave', $ir['brave'] )->where('userid', $ir['userid'])->update('users');

		if(rand(1,100) <= $sucrate)
		{
			$this->co->statistics_up('crimes_success');
			$this->co->storage['output'] .= '<p class="center crime-sub crime-success"><span>Result: ';
			$this->co->storage['output'] .= (substr_count('{money}', $r['crimeSTEXT']) > 0) ? str_replace("{money}", $r['crimeSUCCESSMUNY'], $r['crimeSTEXT']) : $r['crimeSTEXT'];
			$this->co->storage['output'] .= '</span></p>';
			
			$ir['money'] += $r['crimeSUCCESSMUNY'];
			$ir['crystals'] += $r['crimeSUCCESSCRYS'];
			$ir['exp'] += (int) ($r['crimeSUCCESSMUNY']/8);
			$ir['crimexp'] += $r['crimeXP'];
			
			$this->co->statistics_up('crimes_total_money', $r['crimeSUCCESSMUNY']);
			$this->co->statistics_up('crimes_total_crystals', $r['crimeSUCCESSCRYS']);
	
			$updatedata = array(
				'money' => $ir['money'],
				'crystals' => $ir['crystals'],
				'exp' => $ir['exp'],
				'crimexp' => $ir['crimexp']
			);
	
			$this->db->update('users', $updatedata, array( 'userid' => $ir['userid'] ));
	
			if($r['crimeSUCCESSITEM'])
			{
				$this->co->add_inventory($r['crimeSUCCESSITEM']);
			}
		}
		else
		{
			if(rand(1, 4) != 1)
			{
				$this->co->statistics_up('crimes_failure');
				$this->co->storage['output'] .=  '<p class="center crime-sub crime-failure"><span>Result: ' . $r['crimeFTEXT'] . '</span></p>';
			}
			else
			{
				$this->co->statistics_up('crimes_jailed');
				$this->co->storage['output'] .=  '<p class="center crime-sub crime-jail"><span>Result: ' . $r['crimeJTEXT'] . '</span></p>';
				$jailtime = $r['crimeJAILTIME'] * 60;
				$this->db->where('userid', $ir['userid'])->update('users', array( 'jail' => (($ir['jail'] > now()) ? ($ir['jail'] + $jailtime) : (now() + $jailtime)), 'jail_reason' => $r['crimeJREASON'] ) );
				$this->co->update_config('jail_count', $this->co->config['jail_count'] + 1);
			}
		}
		
		$this->co->page('internal/pages/do_crime');	
	}

}