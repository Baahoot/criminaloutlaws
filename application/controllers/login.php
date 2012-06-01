<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Login extends CI_Controller {

	public $salt = false;
	public $user = false;
	public $pass = false;

	function username_exists($username) {
		if($this->co->user_exists($username, 'LOGIN_ONLY') == 0) { $this->form_validation->set_message('username_exists', 'The username you have entered does not exist.'); return false; } return true;
	}
	
	public function account_exist($unused) {
		$user = $this->input->post('info');
		$username = $user['username'];
		$password = $user['password'];
		
		if( ! $username || ! $password ) { $this->form_validation->set_message('account_exist', 'We could not find an account with the information you provided.'); 	return false; }
		
		$slt = $this->db->query("SELECT pass_salt FROM users WHERE login_name = ? LIMIT 1", array( $username ))->result_array();
		$this->salt = $slt[0]['pass_salt'];
		
		if( ! $this->salt) {
			$this->form_validation->set_message('account_exist', 'We could not find an account with the information you provided.');
			return false;
		}
		
		$password = $this->co->hmac($this->config->item('db_hash') . $this->salt, $password);
		
		$res = $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE login_name = ? AND userpass = ? LIMIT 1", array( $username, $password ))->result_array();
		if($res[0]['cnt'] == 0) { $this->form_validation->set_message('account_exist', 'We could not find an account with the information you provided.'); return false; }
		
		$this->user = $username;
		$this->pass = $user['password'];
		
		return true;
	}

	public function index()
	{
		$this->co->must_logout();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Login' ));
		$this->co->init();

		/* Rules */
		$this->form_validation->set_rules('info[username]', 'username', 'required|alpha_dash|callback_username_exists|callback_account_exist');
		$this->form_validation->set_rules('info[password]', 'password', 'required');

		/* Process */
		if($this->form_validation->run()) {
			if($this->co->login_user($this->user, $this->pass, $this->salt)) {
				$uri = ($this->input->get('return')) ? substr($this->input->get('return'), 1, strlen($this->input->get('return'))-1) : 'home';

				/* It's a success! */
				$this->co->redirect(base_url() . $uri);
			} else {
				$this->co->notice('Our system cannot log you in right now due to an unexpected problem. Please try again later.');
				$this->co->redirect(base_url() . 'login');
			}
		} else {
			$this->load->view('external/header');
			$this->load->view('external/holder-open');
			$this->load->view('external/login');
			$this->load->view('external/holder-close');
			$this->load->view('external/footer');
		}
		
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
			$q = $this->db->query("SELECT userid FROM facebook_user WHERE fb_user_id = ? LIMIT 1", array( $i['id'] ))->result_array();
			
			if(isset($q[0]['userid'])) {
				$this->db->query("UPDATE facebook_user SET fb_access_key = ? WHERE fb_user_id = ? LIMIT 1", array( $i['access_token'], $i['id'] ));
				$this->facebook->complete();
				$this->co->raw_login($q[0]['userid']);
				redirect(base_url() . ($this->input->get('return')) ? substr($this->input->get('return'), 1, strlen($this->input->get('return'))-1) : 'home');
			} else {
				redirect(base_url() . 'register/facebook' . ($this->input->get('return')) ? substr($this->input->get('return'), 1, strlen($this->input->get('return'))-1) : 'home');
			}
		}
	}
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */