<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Upgrade extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Upgrade' ));
		$ir = $this->co->whoami();
		$alt = $this->co->__internal_user();
		
		if($ir['exp'] < $alt['exp_needed']) {
			$this->co->notice('Sorry, you cannot upgrade just yet as you do not have adequate EXP.');
			$this->co->redirect(base_url() . '/home');	
		}
		
		$expu=$ir['exp']-$alt['exp_needed'];
		$ir['level']++;
		$ir['exp']=$expu;
		$ir['maxenergy'] += 2;
		$ir['maxbrave'] += 2;
		$ir['maxhp'] += 50;
		
		$this->db->
					set('level', $ir['level'])->
					set('last_upgraded', now())->
					set('exp', $expu)->
					set('maxenergy', $ir['maxenergy'])->
					set('maxbrave', $ir['maxbrave'])->
					set('maxhp', $ir['maxhp'])->
					where('userid', $ir['userid'])->
					update('users');
		
		$this->co->notice('Congratulations, you have successfully upgraded to level '.$ir['level'].'!');
		$this->co->redirect(base_url() . 'home');		
	}
		
}