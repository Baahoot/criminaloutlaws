<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Courses extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Courses' ));
		$ir = $this->co->whoami( array(
				'users.course',
				'users.course_expires'
			)
		);
		
		$this->co->page('internal/pages/courses');		
	}
	
	public function cancel()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Cancel Course' ));
		$ir = $this->co->whoami( array(
				'users.course',
				'users.course_expires'
			)
		);

		$sess = $this->input->get('__unique__');
		
		if($sess != $this->co->get_session() || $ir['course_expires'] <= now() || $ir['course'] == 0) {
			show_404();
		}
		
		$coursedata = $this->co->courses[$ir['course']];
		
		$this->db->set('course', 0)->set('course_expires', 0)->where('userid', $ir['userid'])->update('users');
		$this->co->notice('You have cancelled the '.($coursedata['crNAME']).' and can now start another course!');
		$this->co->redirect( base_url() . 'courses');
	}
	
	public function do_course()
	{
		$this->co->must_login();
		$this->co->init();
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Do Course' ));
		$ir = $this->co->whoami( array(
				'users.course',
				'users.course_expires'
			)
		);
		
		$id = $this->input->get('id');
		$sess = $this->input->get('__unique__');
		
		if($sess != $this->co->get_session() || !$id || $ir['course_expires'] > now()) {
			show_404();
		}
		
		$coursedata = $this->co->courses[$id];
		
		if(!isset($coursedata)) {
			show_404();
		}
		
		$is_done = $this->db->select('*')->from('coursesdone')->where('userid', $ir['userid'])->where('courseid', $id)->count_all_results();
		
		if($is_done > 0) {
			show_404();
		}
		
		/* Start Custom Rules */
		
		if($id == 6 && $this->db->select('*')->from('coursesdone')->where('userid', $ir['userid'])->where('courseid', 5)->count_all_results() == 0) {
			$this->co->notice('You need to complete the Computer Science (Undergraduate) to do this course!');
			$this->co->redirect( base_url() . 'courses');
		}
		
		/* End Custom Rules */

		if($ir['money'] < $coursedata['crCOST']) {
			$more_needed = number_format($coursedata['crCOST'] - $ir['money'], 2);
			$this->co->notice('Sorry, you need another $'.$more_needed.' to do the '.strtolower($coursedata['crNAME']).'!');
			$this->co->redirect( base_url() . 'courses');
		}
		
		$coursedata['crDAYS'] = rand($coursedata['crDAYS'], $coursedata['crDAYS'] + rand(1,8));
		$until_timestamp = now() + (60*60*24*$coursedata['crDAYS']);
		$ir['money'] -= $coursedata['crCOST'];
		$this->db->set('course', $id)->set('course_expires', $until_timestamp)->set('money', $ir['money'])->where('userid', $ir['userid'])->update('users');
		$this->co->statistics_up('courses_total');
		$this->co->statistics_up('courses_total_spent', $coursedata['crCOST']);
		$this->co->notice('You have taken the '.($coursedata['crNAME']).' course for '.$coursedata['crDAYS'].' days costing $'.number_format($coursedata['crCOST'], 2).'!');
		$this->co->redirect( base_url() . 'courses');
	}
	
}