<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Register extends CI_Controller {

	var $salt = false;
	var $user = false;
	var $pass = false;

	public function username_taken($username) {
		if($this->co->user_exists($username) == TRUE) { $this->form_validation->set_message('username_taken', 'The username you have entered has already been taken.'); return false; }
		return true;
	}
	
	public function referer_exists($username) {
		if(!$username) { return true; }
		if($this->co->user_exists($username, 'USERNAME_ONLY') == FALSE) { $this->form_validation->set_message('referer_exists', 'The referer username you entered does not exist. Empty to leave blank.'); return false; }
		return true;
	}
	
	public function email_taken($email) {
		$res = $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE LOWER(email) = ? LIMIT 1", array( strtolower($email) ))->result_array();
		if($res[0]['cnt'] > 0) { $this->form_validation->set_message('email_taken', 'The email you have entered has already been taken.'); return false; }
		return true;
	}
	
	public function valid_gender($gender) {
		$im = ($gender == 'Male' || $gender == 'Female') ? TRUE : FALSE;
		if($im == TRUE) { $this->form_validation->set_message('valid_gender', 'You have not selected a valid gender.'); }
		return $im;
	}
	
	public function user_pass_different($unused) {
		$u = $this->input->post('info');
		if(isset($u['username']) && isset($u['password']) && $u['username'] == $u['password']) { $this->form_validation->set_message('user_pass_different', 'Your username must not be the same as your password.'); return FALSE; }
		return TRUE;
	}
	
	public function user_pass_no_include($unused) {
		$u = $this->input->post('info');
		if(isset($u['username']) && isset($u['password']) && strstr($u['password'], $u['username'])) { $this->form_validation->set_message('user_pass_no_include', 'Your password cannot contain your username.'); return FALSE; }
		return TRUE;
	}
		
	public function no_multi($unused) {
		if($this->co->is_multi($this->input->ip_address()) == TRUE) { $this->form_validation->set_message('no_multi', 'You are not allowed to register any more accounts due to our system detecting abusive activity.'); return FALSE; }
		return TRUE;
	}

	function val_recaptcha($string)
	{
		$resp = recaptcha_check_answer($this->config->item('recaptcha_private'),
										$_SERVER["REMOTE_ADDR"],
										$this->input->post("recaptcha_challenge_field"),
										$this->input->post("recaptcha_response_field"));

		if(!$resp->is_valid) {
			$this->form_validation->set_message('val_recaptcha', 'You did not enter the captcha correctly as displayed.');
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
	
	private function finalize()
	{
		global $CI;

		/* Process*/
		if( ! $this->form_validation->run()) {
			$this->load->view('external/header');
			$this->load->view('external/holder-open');
			$this->load->view((defined('FACEBOOK') ? 'external/fb-register' : 'external/register'));
			$this->load->view('external/holder-close');
			$this->load->view('external/footer');
		} else {
			
			$i = $this->input->post('info');
			$i['email'] = strtolower($i['email']);
		
			$pass_salt = random_string('alnum', 10);
			$pass_sum = $this->co->hmac($this->config->item('db_hash') . $pass_salt, $i['password']);
				
			$this->db->insert("users", array(
					'is_ajax' => 1,
					'username' => $i['username'],
					'login_name' => $i['username'],
					'userpass' => $pass_sum,
					'pass_salt' => $pass_salt,
					'level' => 1,
					'money' => $i['referer'] ? 550 : 500,
					'crystals' => 0,
					'donator' => 0,
					'user_level' => 1,
					'energy' => 12,
					'maxenergy' => 12,
					'will' => 100,
					'maxwill' => 100,
					'brave' => 5,
					'maxbrave' => 5,
					'hp' => 100,
					'maxhp' => 100,
					'location' => 1,
					'gender' => $i['gender'],
					'signedup' => now(),
					'email' => $i['email'],
					'bankmoney' => -1,
					'lastip' => $this->input->ip_address(),
					'lastip_signup' => $this->input->ip_address(),
					'badges' => (defined('FACEBOOK') ? 'facebook' : '')
				)
			);
			
			$new_id = $this->db->insert_id();
			
			if(defined('FACEBOOK'))
			{
				$this->db->insert("facebook_user", array(
						'userid' => $new_id,
						'fb_access_key' => FB_TOKEN,
						'fb_user_id' => FB_ID
					)
				);

				$this->facebook->signup_notice($i['username']);
			}
			
			$this->db->insert("username_cache", array(
					'userid' => $new_id,
					'username' => $i['username']
				)
			);
				
			$this->db->insert("userstats", array(
					'userid' => $new_id,
					'strength' => 10,
					'agility' => 10,
					'guard' => 10,
					'labour' => 10,
					'IQ' => 10
				)
			);
			
			if(@$i['referer'] != "") {
				/* Referer has already been checked to see if it exists */
				$this->co->add_badge($i['referer'], 'refer');
				$this->co->add_money($i['referer'], 75);
				$this->co->event_add($i['referer'], 'Thanks for referring '.$i['username'].' to Criminal Outlaws!');
				
				/* Needed to insert schema in the `referrals` table below */
				$refdata = $this->co->get_user($i['referer'], array(
						'users.userid',
						'users.lastip'
					)
				);
				
				/* Let's keep a log for the future in the `referrals` table */
				$this->db->insert("referrals", array(
						'ref_referer' => $refdata['userid'],
						'ref_referred' => $new_id,
						'ref_time' => now(),
						'ref_referer_ip' => $refdata['lastip'],
						'ref_referred_ip' => $this->input->ip_address()
						
					)
				);
				
			}
			
			$this->co->mail($i['email'], (defined('FACEBOOK_NAME')) ? FACEBOOK_NAME : $i['username'], "Welcome to Criminal Outlaws!", $this->load->view('emails/signup', array('to' => (defined('FACEBOOK_NAME')) ? FACEBOOK_NAME : $i['username']), true));
			
			$this->co->raw_login($new_id);
			$uri = ($this->input->get('return')) ? substr($this->input->get('return'), 1, strlen($this->input->get('return'))-1) : 'home';
		
			/* It's a success! */
			$this->co->redirect(base_url() . $uri);
			
		}
		
	}

	public function index()
	{
		$this->co->must_logout();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Create an account' ));
		$this->co->init();
		
		$cm = $this->input->post('info');
		if(is_array($cm)) {
			$_POST['password'] = @$cm['password'];
			$_POST['cpassword'] = @$cm['cpassword'];
			$_POST['email'] = @$cm['email'];
			$_POST['cemail'] = @$cm['cemail'];
		}

		/* Rules */
		$this->form_validation->set_rules('info[username]', 'username', 'required|min_length[3]|max_length[16]|alpha_dash|callback_username_taken|callback_no_multi|callback_user_pass_different');
		$this->form_validation->set_rules('info[password]', 'password', 'required|matches[cpassword]|min_length[6]|max_length[150]|callback_user_pass_no_include');
		$this->form_validation->set_rules('info[cpassword]', 'confirm password', 'required|matches[password]|min_length[6]|max_length[150]');
		$this->form_validation->set_rules('info[email]', 'email', 'required|strtolower|matches[cemail]|valid_email|max_length[120]|callback_email_taken');
		$this->form_validation->set_rules('info[cemail]', 'confirm email', 'required|strtolower|matches[email]|valid_email|max_length[120]');
		$this->form_validation->set_rules('info[gender]', 'gender', 'required|max_length[6]|callback_valid_gender');
		$this->form_validation->set_rules('info[referer]', 'referer', 'max_length[16]|callback_referer_exists');
		$this->form_validation->set_rules('recaptcha_response_field', 'captcha', 'required|callback_val_recaptcha');
	
		$this->finalize();
		
	}
	
	public function facebook()
	{
		$this->co->must_logout();
		$this->co->init();
		$this->load->library('facebook');
		$i = $this->facebook->getUser();

		if( ! isset($i['email'])) {
			redirect(base_url());
		} else {
			define('FACEBOOK', 1);
			define('FACEBOOK_NAME', $i['name']);
			define('FACEBOOK_RURI', end(explode('/', $i['link'])));
			define('FB_ID', $i['id']);
			define('FB_TOKEN', $i['access_token']);
			$this->co->set(array( 'title' => 'Criminal Outlaws | Complete signup with Facebook' ));
			$q = $this->db->query("SELECT userid FROM facebook_user WHERE fb_user_id = ? LIMIT 1", array( $i['id'] ))->result_array();
			
			if( ! isset($q[0]['userid'])) {
			
				$cm = $this->input->post('info');
				if(is_array($cm)) {
					$_POST['password'] = @$cm['password'];
					$_POST['cpassword'] = @$cm['cpassword'];
					$_POST['email'] = @$cm['email'];
					$_POST['cemail'] = @$cm['cemail'];
					$_POST['info']['email'] = $i['email'];
					$_POST['info']['gender'] = ($i['gender'] == 'female') ? 'Female' : 'Male';
				}
		
				/* Rules */
				$this->form_validation->set_rules('info[username]', 'username', 'required|min_length[3]|max_length[16]|alpha_dash|callback_username_taken|callback_no_multi|callback_user_pass_different');
				$this->form_validation->set_rules('info[password]', 'password', 'required|matches[cpassword]|min_length[6]|max_length[150]|callback_user_pass_no_include');
				$this->form_validation->set_rules('info[cpassword]', 'confirm password', 'required|matches[password]|min_length[6]|max_length[150]');
				
				if($this->email_taken($i['email']) == TRUE) {
					define('EMAIL_TAKEN', 1);
					$this->form_validation->set_rules('info[email]', 'email', 'required|strtolower|matches[cemail]|valid_email|max_length[120]|callback_email_taken');
					$this->form_validation->set_rules('info[cemail]', 'confirm email', 'required|strtolower|matches[email]|valid_email|max_length[120]');	
				}
				
				$this->form_validation->set_rules('info[referer]', 'referer', 'max_length[16]|callback_referer_exists');
				$this->finalize();
			} else {
				show_404();
			}
		}
	}

}

/* End of file account.php */
/* Location: ./application/controllers/account.php */