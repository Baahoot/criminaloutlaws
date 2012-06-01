<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Inbox extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->init();

		$ir = $this->co->whoami();
		$cnt = ($ir['new_mail'] > 0) ? ' ('.$ir['new_mail'].')' : '';
		$this->co->set(array( 'title' => 'Criminal Outlaws | Inbox'));
		$this->co->storage['cnt'] = $cnt;
		
		/* This picks out stuff we don't need from the default user field config */
		$ud = $this->co->user_default; foreach($ud as $idnumber=>$idvalue) { if($idvalue == 'online.laston') { unset($ud[$idnumber]); break; } }
		
		$this->co->storage['inbox'] = $this->db->query("SELECT mail.*, ".implode(', ', $ud)." FROM mail LEFT JOIN users ON mail.mail_from=users.userid WHERE mail.mail_to = ? ORDER BY mail.mail_time DESC LIMIT 25", array($ir['userid']))->result_array();
		
		$this->db->query("UPDATE mail SET mail_read = 1 WHERE mail_to = ? AND mail_read = 0", $ir['userid']);
		$this->db->query("UPDATE users SET new_mail = 0 WHERE userid = ? LIMIT 1", $ir['userid']);
		$this->co->page('internal/pages/inbox');
		
	}
	
	public function archive()
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->init();

		$ir = $this->co->whoami();
		$cnt = ($ir['new_mail'] > 0) ? ' ('.$ir['new_mail'].')' : '';
		$this->co->set(array( 'title' => 'Criminal Outlaws | Inbox'));
		$this->co->storage['cnt'] = $cnt;
		
		/* This picks out stuff we don't need from the default user field config */
		$ud = $this->co->user_default; foreach($ud as $idnumber=>$idvalue) { if($idvalue == 'online.laston') { unset($ud[$idnumber]); break; } }
		
		$inbox = $this->db->query("SELECT mail.*, username_cache.* FROM mail LEFT JOIN username_cache ON mail.mail_from = username_cache.userid WHERE mail.mail_to = ? OR mail.mail_from = ? ORDER BY mail.mail_time DESC LIMIT 25", array($ir['userid'], $ir['userid']))->result_array();
		
		if(count($inbox) == 0) {
			show_404();
		}
		
		foreach($inbox as $i) {
		
			$a = $this->db->query("SELECT * FROM username_cache WHERE userid = ? LIMIT 1", array( $i['mail_to'] ))->result_array();
			$a = $a[0];
		
			if($i['mail_to'] == $ir['userid']) {
				$i['from_name'] = $a['username'];
				$i['from_id'] = $a['userid'];
				$i['to_name'] = $i['username'];
				$i['to_id'] = $i['userid'];
			} else {
				$i['from_name'] = $i['username'];
				$i['from_id'] = $i['userid'];
				$i['to_name'] = $a['username'];
				$i['to_id'] = $a['userid'];
			}
			
			$output[] = array(
				'id' => $i['mail_id'],
				'time' => unix_to_human($i['mail_time']),
				'type' => ($i['mail_to'] == $ir['userid'] ? 'received' : 'sent'),
				'from_username' => $i['from_name'],
				'from_userid' => $i['from_id'],
				'to_username' => $i['to_name'],
				'to_userid' => $i['to_id'],
				'subject' => $i['mail_subject'],
				'message' => $i['mail_text']
			);
		}
		
		if(count($output) == 0) {
			show_404();
		}
		
		$this->load->helper('csv');
		echo array_to_csv($output, $ir['username'] . '-'.now().'.archives.csv');	
		
	}
	
	public function create() {
		$to = $this->input->get('to');
		
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Compose Mail'));
		$this->co->init();

		$ir = $this->co->whoami();
		$userid = $this->co->user['userid'];
		
		if($to) {
			$this->co->storage['contactlist'] = array();
			$usr = $this->db->query("SELECT userid FROM username_cache WHERE username = ? LIMIT 1", array( $to ))->result_array();
			$usr = $usr[0]['userid'];
		} else {
			$this->co->storage['contactlist'] = $this->db->query("SELECT contactlist.*, username_cache.username FROM contactlist LEFT JOIN username_cache ON contactlist.cl_ADDED=username_cache.userid WHERE contactlist.cl_ADDER= ? ORDER BY username_cache.username ASC", array( $userid ))->result_array();
		}
		
		if(isset($usr)) {
			$this->co->storage['create_mail'] = $this->db->query("SELECT mail.*, username_cache.username FROM mail LEFT JOIN username_cache ON mail.mail_from=username_cache.userid WHERE (mail.mail_from = ? AND mail.mail_to = ?) OR (mail.mail_from = ? AND mail.mail_to = ?) ORDER BY mail.mail_time DESC LIMIT 5", array($usr, $userid, $userid, $usr))->result_array();
			//echo $this->db->last_query();
		} else {
			$this->co->storage['create_mail'] = array();
		}
		
		if($this->input->post('__unique__') == $this->co->get_session()) {
		
			$err = 0;
			$send_to = ($this->input->post('contact') != '0' ? $this->input->post('contact') : $this->input->post('username'));
		
			if( ! $this->input->post('username') && ! $this->input->post('contact')) {
				$this->co->notice('Sorry, you need to enter a recipient for your mail');
				$err = 1;
			}
			
			if( ! $this->input->post('subject')) {
				$this->co->notice('Sorry, it is mandatory that you enter a subject for your mail.');
				$err = 1;
			}
			
			if( ! $this->input->post('message')) {
				$this->co->notice('Sorry, you need to enter a message.');
				$err = 1;
			}
			
			if( substr_count($this->input->post('message'), 'http://') > 2 ) {
				$this->co->notice('Sorry, our system has detected multiple links and has denied your request.');
				$err = 1;
			}
			
			if( strlen($this->input->post('message')) < 1 ) {
				$this->co->notice('Sorry, your message must be at least 1 character.');
				$err = 1;
			}
			
			if( strlen($this->input->post('message')) > 4000 ) {
				$this->co->notice('Sorry, your message cannot exceed 4000 characters.');
				$err = 1;
			}
			
			if( $send_to == $ir['username'] ) {
				$this->co->notice('Sorry, you cannot send messages to yourself.');
				$err = 1;
			}
			
			if( ! $this->co->user_exists($send_to, 'USERNAME_ONLY')) {
				$this->co->notice('You cannot send mail to users who do not exist.');
				$err = 1;
			}
			
			if($err == 0) {
				$gusr = $this->db->select('userid')->from('username_cache')->where('username', $send_to)->get()->result_array();
				$gusr = $gusr[0]['userid'];
				
				if( ! isset($gusr)) {
					$this->co->notice('Your message could not be sent due to an unexpected error.');
				} else {
				
					$this->db->insert("mail", array(
							'mail_read' => 0,
							'mail_from' => $this->co->user['userid'],
							'mail_to' => $gusr,
							'mail_time' => now(),
							'mail_subject' => $this->input->post('subject'),
							'mail_text' => $this->input->post('message')
						)
					);
				
					$this->co->notice('You have sent your message successfully to '.$send_to.'!');
					$this->db->query("UPDATE users SET new_mail = new_mail + 1 WHERE username = ? LIMIT 1;", array( $send_to ));
				
				}
				
				$this->co->redirect(base_url() . 'inbox');
			}
		
		}
		
		$this->co->page('internal/pages/create_mail');
	}
	
	public function delete() {
		$id = $this->input->get('id');
		$this->co->allow_jail(); $this->co->allow_hospital();
		$sess = $this->input->get('__sess__');
		
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Delete Mail'));
		$this->co->init();

		$ir = $this->co->whoami();
		
		if(!isset($id)) {
			show_404();
		}
		
		if($sess != $this->co->get_session()) {
			show_404();
		}
		
		$q = $this->db->query("DELETE FROM mail WHERE mail_to = ? AND mail_id = ? LIMIT 1", array( $ir['userid'], $id ));
		
		if($this->db->affected_rows() > 0) {
			$this->co->notice('The mail you selected has successfully been deleted!');
		} else {
			$this->co->notice('The system could not process the request you tried to make.');
		}
		
		$this->co->redirect(base_url() . 'inbox');		
	}


}