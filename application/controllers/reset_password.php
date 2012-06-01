<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Reset_Password extends CI_Controller {

	public function username_exists($username) {
		if($this->co->user_exists($username, 'USERNAME_ONLY') == 0) { $this->form_validation->set_message('username_exists', 'The username you have entered does not exist.'); return false; } return true;
	}
	
	function email_exists($email) {
		if($this->db->select('userid')->from('users')->where('email', $email)->limit(1)->count_all_results() == 0) { $this->form_validation->set_message('email_exists', 'The email address you have entered does not exist.'); return false; } return true;
	}
	
	public function account_exist($unused) {
		$info = $this->input->post('info');
		
		$users = $this->db->select('userid, username')->from('users')->where('LOWER(username)', $info['username'])->where('email', $info['email']);
		if($users->count_all_results() == 0) {
			$this->form_validation->set_message('account_exist', 'We could not find an account with these details.');
			return false;
		}
		
		$users = $this->db->select('userid, username')->from('users')->where('LOWER(username)', $info['username'])->where('email', $info['email'])->get()->result_array();
		$userid = $users[0]['userid'];
		define('RESET_UN', $users[0]['username']);
		define('RESET_USERID', $userid);
		
		if($this->db->select('*')->from('reset_passwords')->where('reset_user', $userid)->where('reset_expires >', now())->count_all_results() > 1) {
			$this->form_validation->set_message('account_exist', 'A password reset request has been made recently to this account. Please wait up to 2 hours before trying again.');
			return false;
		}
		
		return true;
	}
	
	public function user_pass_different($unused) {
		$u = $this->input->post('info');
		if(!defined('RESET_UN')) { return true; }
		if(constant('RESET_UN') == $u['password']) { $this->form_validation->set_message('user_pass_different', 'Your username must not be the same as your password.'); return FALSE; }
		return TRUE;
	}
	
	public function user_pass_no_include($unused) {
		$u = $this->input->post('info');
		if(!defined('RESET_UN')) { return true; }
		if(strstr($u['password'], constant('RESET_UN'))) { $this->form_validation->set_message('user_pass_no_include', 'Your password cannot contain your username.'); return FALSE; }
		return TRUE;
	}

	public function index()
	{
		$this->co->must_logout();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Reset Password' ));
		$this->co->init();

		/* Rules */
		$this->form_validation->set_rules('info[username]', 'username', 'required|alpha_dash|callback_username_exists|callback_account_exist');
		$this->form_validation->set_rules('info[email]', 'email address', 'required|email_address|callback_email_exists');


		/* Process */
		if($this->form_validation->run()) {
			$info = $this->input->post('info');
			$str = random_string('alnum', 30);
			$expires = now() + 60*60*2;
			$reset_url = base_url() . 'reset_password/complete?__id__=' . $str;
			
			define('TO', $info['username']);
			define('EMAIL', $info['email']);
			define('CODE', $str);
			define('RESET_EXPIRES', $expires);
			define('RESET_URL', $reset_url);
			
			$this->db->insert('reset_passwords', array(
					'reset_key' => $str,
					'reset_ip' => $this->input->ip_address(),
					'reset_user' => constant('RESET_USERID'),
					'reset_expires' => now() + 60*60*2
				)
			);
			
			$this->co->mail($info['email'], $info['username'], "Password Reset", $this->load->view('emails/reset', '', true));
			
			$this->co->notice('We have sent your password reset details to '.constant('EMAIL').' which expires in 2 hours!');
			$this->co->redirect(base_url() . 'reset_password');
			
		} else {
			$this->load->view('external/header');
			$this->load->view('external/holder-open');
			$this->load->view('external/reset');
			$this->load->view('external/holder-close');
			$this->load->view('external/footer');
		}
		
	}
	
	public function complete()
	{
		$this->co->must_logout();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Set New Password' ));
		$this->co->init();
		
		$key = $this->input->get('__id__');
		$i = $this->input->post('info');
		
		if( ! $key) {
			show_404();
		}
		
		$resetdata = $this->db->select('*')->from('reset_passwords')->join('username_cache', 'username_cache.userid = reset_passwords.reset_user', 'left')->where('reset_expires >', now())->where('reset_key', $key)->where('reset_ip', $this->input->ip_address());
		
		if($resetdata->count_all_results() == 0) {
			$this->co->notice('This password reset request has now expired. Please try again.');
			$this->co->redirect(base_url() . 'reset_password');
		}
		
		$resetdata =  $this->db->select('*')->from('reset_passwords')->join('username_cache', 'username_cache.userid = reset_passwords.reset_user', 'left')->where('reset_expires >', now())->where('reset_key', $key)->where('reset_ip', $this->input->ip_address())->get()->result_array();
		
		$this->co->storage['reset'] = $resetdata;
		
		if(is_array($i)) {
			define('RESET_UN', $resetdata[0]['username']);
			define('RESET_USERID', $resetdata[0]['userid']);
			$_POST['password'] = $i['password'];
			$_POST['cpassword'] = $i['cpassword'];
		}

		/* Rules */
		$this->form_validation->set_rules('info[password]', 'password', 'required|matches[cpassword]|min_length[6]|max_length[150]|callback_user_pass_no_include|callback_user_pass_different');
		$this->form_validation->set_rules('info[cpassword]', 'confirm password', 'required|matches[password]|min_length[6]|max_length[150]');
		
		/* Process */
		if($this->form_validation->run()) {
			$pass_salt = random_string('alnum', 10);
			$pass_sum = $this->co->hmac($this->config->item('db_hash') . $pass_salt, $i['password']);
			
			$this->db->set('userpass', $pass_sum)->set('pass_salt', $pass_salt)->where('userid', $resetdata[0]['userid'])->update('users');
			$this->db->where('reset_key', $key)->delete('reset_passwords');
		
			$this->co->raw_login($resetdata[0]['userid']);
			
			$this->co->notice('Your password has been changed successfully!');
			$this->co->redirect(base_url() . 'home');
			
		} else {
			$this->load->view('external/header');
			$this->load->view('external/holder-open');
			$this->load->view('external/reset_change');
			$this->load->view('external/holder-close');
			$this->load->view('external/footer');
		}

	}

}

/* End of file account.php */
/* Location: ./application/controllers/account.php */