<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Job extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami(array(
				'jobwage',
				'joblast',
				'userstats.strength',
				'userstats.IQ',
				'userstats.labour'
			)
		);
		$this->co->set(array( 'title' => 'Criminal Outlaws | ' . ($ir['jobrank'] > 0 ? 'Your Job' : 'Job Centre') ));
		
		if($ir['jobrank'] > 0) {
			$this->co->storage['jobdata'] = $this->db->select('*')->from('jobs')->join('jobranks', 'jobs.job_id = jobranks.rank_job', 'left')->where('jobranks.rank_id', $ir['jobrank'])->get()->result_array();
			$this->co->storage['jobdata'] = $this->co->storage['jobdata'][0];
			$this->co->storage['next_shift'] = $ir['joblast'] + 60*60*24;
			
			$this->co->storage['jobranks'] = $this->db->select('*')->from('jobranks')->where('jobranks.rank_job', $this->co->storage['jobdata']['job_id'])->order_by('rank_wage', 'ASC')->get()->result_array();
			
			$this->co->page('internal/pages/myjob');
		} else {
			$this->co->page('internal/pages/job');
		}
	}
	
	public function leave()
	{
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami(array(
				'jobwage'
			)
		);
		
		if($this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		if($ir['jobrank'] == 0) {
			show_404();
		}
		
		if($ir['jobwage'] > 0) {
			$tax = ($ir['donator'] > now() ? round(($ir['jobwage'] / 10) * 1, 2) : round(($ir['jobwage'] / 10) * 5, 2));
			$total_pay = round($ir['jobwage'] - $tax, 2);
			$ir['money'] += $total_pay;
			
			$this->db->set('jobwage', 0)->set('jobrank', 0)->set('money', $ir['money'])->where('userid', $ir['userid'])->update('users');
			$this->co->notice('You left your job with a early pay of $'.number_format($total_pay, 2).' (with an early pay tax of $'.number_format($tax, 2).')!');
			$this->co->redirect( base_url() . 'job');
		
		} else {
		
			$this->db->set('jobrank', 0)->where('userid', $ir['userid'])->update('users');
			$this->co->notice('You successfully left your job without a early pay as you had no unpaid wages!');
			$this->co->redirect( base_url() . 'job');
		
		}
	}
	
	public function promote()
	{
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami(array(
				'users.jobwage',
				'users.joblast',
				'userstats.strength',
				'userstats.IQ',
				'userstats.labour'
			)
		);
		
		if($this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		if($ir['jobrank'] == 0) {
			show_404();
		}
		
		$jobdata = $this->db->select('*')->from('jobs')->join('jobranks', 'jobs.job_id = jobranks.rank_job', 'left')->where('jobranks.rank_id', $ir['jobrank'])->get()->result_array();
		$jobdata = $jobdata[0];
			
		$jobranks = $this->db->select('*')->from('jobranks')->where('jobranks.rank_job', $jobdata['job_id'])->get()->result_array();
		
		foreach($jobranks as $i=>$d) {
			if($ir['jobrank'] < $d['rank_id'] && ($d['rank_strengthneed'] - $ir['strength'] < 1) && ($d['rank_labourneed'] - $ir['labour'] < 1) && ($d['rank_iqneed'] - $ir['IQ'] < 1)) {
				$upgrade = $d;
			}
		}
		
		
		if( ! isset($upgrade) && ! count($upgrade)) {
			show_404();
		}
		
		$this->co->statistics_up('job_total_promotions');
		$this->db->set('jobrank', $upgrade['rank_id'])->where('userid', $ir['userid'])->update('users');
		$this->co->notice('You were successfully promoted to a '.$upgrade['rank_name'].' from a '.$jobdata['rank_name'].'!');
		$this->co->redirect( base_url() . 'job');
	}
	
	public function earlypay()
	{
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami(array(
				'jobwage',
				'joblast',
				'userstats.strength',
				'userstats.IQ',
				'userstats.labour'
			)
		);
		
		if($this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		if($ir['jobrank'] == 0) {
			show_404();
		}
		
		if($ir['jobwage'] == 0) {
			show_404();
		}
		
		$tax = ($ir['donator'] > now() ? round(($ir['jobwage'] / 10) * 1, 2) : round(($ir['jobwage'] / 10) * 5, 2));
		$total_pay = round($ir['jobwage'] - $tax, 2);
		$ir['money'] += $total_pay;
				
		$this->db->set('jobwage', 0)->set('money', $ir['money'])->where('userid', $ir['userid'])->update('users');
		
		$this->co->statistics_up('job_total_earlypay', $totalpay);
		$this->co->statistics_up('job_total_earlypay_tax', $tax);
		$this->co->statistics_up('job_total_earlypay_times');
		$this->co->notice('You got your job pay of $'.number_format($ir['jobwage'], 2).' which was given an early pay tax of $'.number_format($tax, 2).'!');
		$this->co->redirect( base_url() . 'job');
	}
	
	public function work()
	{
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami(array(
				'jobwage',
				'joblast',
				'userstats.strength',
				'userstats.labour',
				'userstats.IQ'
			)
		);
		
		if($this->input->get('__unique__') != $this->co->get_session()) {
			show_404();
		}
		
		if($ir['joblast'] + 60*60*24 > now()) {
			show_404();
		}
		
		if($ir['jobrank'] == 0) {
			show_404();
		}
		
		$jobdata = $this->db->select('*')->from('jobs')->join('jobranks', 'jobs.job_id = jobranks.rank_job', 'left')->where('jobranks.rank_id', $ir['jobrank'])->get()->result_array();
		$jobdata = $jobdata[0];
		
		$shifts_do = rand( 1, ceil($jobdata['rank_maxhours'] / 7));
		$wage = round($jobdata['rank_wage'] * $shifts_do, 2);
		
		$ir['jobwage'] += $wage;
		$ir['strength'] += $jobdata['rank_strengthgain'];
		$ir['labour'] += $jobdata['rank_labourgain'];
		$ir['IQ'] += $jobdata['rank_iqgain'];
		
		$this->co->statistics_up('job_total_shifts', $shifts_do);
		$this->co->statistics_up('job_total_earnt', $wage);
		$this->db->set('joblast', now())->set('jobwage', $ir['jobwage'])->where('userid', $ir['userid'])->update('users');
		$this->db->set('strength', $ir['strength'])->set('labour', $ir['labour'])->set('IQ', $ir['IQ'])->where('userid', $ir['userid'])->update('userstats');
		$this->co->notice('You earnt $'.number_format($wage, 2).' and stats from doing '.$shifts_do.' shifts as a '.$jobdata['rank_name'].' at '.$jobdata['job_name'] . '!');
		$this->co->redirect( base_url() . 'job');
	}
	
	public function apply()
	{
		$this->co->must_login();
		$this->co->init();
		
		$sess = $this->input->get('__unique__');
		$id = $this->input->get('id');
		
		if(!$sess || !$id) {
			show_404();
		}
		
		$job = $this->db->select('*')->from('jobs')->join('jobranks', 'jobs.job_first = jobranks.rank_id', 'left')->where('jobs.job_id', $id)->get();
		
		if($job->num_rows() == 0) {
			show_404();
		}
		
		$jobdata = $job->result_array();
		$jobdata = $jobdata[0];
		$this->co->storage['job'] = $jobdata;
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Apply for ' . $jobdata['job_name'] ));
		$ir = $this->co->whoami(array(
				'userstats.strength',
				'userstats.labour',
				'userstats.IQ'
			)
		);
		
		if($ir['jobrank'] > 0) {
			show_404();
		}
		
		$this->co->storage['jobrank'] = $jobdata;
		
		if( ($ir['strength'] >= $jobdata['rank_strengthneed']) && ($ir['labour'] >= $jobdata['rank_labourneed']) && ($ir['IQ'] >= $jobdata['rank_iqneed']) ) {
			$this->co->storage['job_result'] = 'We think your qualified for the job. Welcome aboard! You start tomorrow.';
			$this->co->storage['job_me'] = 'Thank you so much. I won\'t let you down!';
			$this->co->storage['result'] = '<p class="center crime-sub crime-success"><span>Result: You got the job! &mdash; <a href="'.base_url().'job" style="font-weight:normal;" rel="ajax"><u>Go to your new job!</u></a></span></p>';
			
			$this->db->set('jobrank', $jobdata['rank_id'])->set('jobwage', 0)->where('userid', $ir['userid'])->update('users');
			
		} else {
			$need = array();
			
			if($ir['strength'] < $jobdata['rank_strengthneed']) {
				$need[] = ($jobdata['rank_strengthneed'] - $ir['strength']) . ' more force';
			}
			
			if($ir['labour'] < $jobdata['rank_labourneed']) {
				$need[] = ($jobdata['rank_labourneed'] - $ir['labour']) . ' more labour';
			}
			
			if($ir['IQ'] < $jobdata['rank_iqneed']) {
				$need[] = ($jobdata['rank_iqneed'] - $ir['IQ']) . ' more intelligence';
			}
			
			$this->co->storage['job_result'] = 'Sorry, we don\'t think your right for the job. You need '.implode(', ', $need).' for this job!';
			$this->co->storage['job_me'] = 'Okay. Thank you for taking your time for the interview. Good day!';
			$this->co->storage['result'] = '<p class="center crime-sub crime-failure"><span>Result: You didn\'t get the job!</span></p>';
		}
		
		$this->co->page('internal/pages/job-apply');		
	}

}