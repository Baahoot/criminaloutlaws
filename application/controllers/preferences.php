<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Preferences extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Preferences' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		$this->co->page('internal/pages/preferences');		
	}
	
	public function change_username()
	{
		$this->co->must_login();
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Preferences &mdash; Change Username' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		//$this->co->statistics_up('gym_total_workouts');
		
		$this->co->page('internal/pages/pref_change_username');	
	}
	
	public function change_signature()
	{
		$this->co->must_login(); 
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->load->helper('smiley');
		$this->load->helper('security');
		$this->load->library('table');
		$this->co->set(array( 'title' => 'Criminal Outlaws | Preferences &mdash; Change Signature' ));
		$this->co->init();
		$ir = $this->co->whoami(array( 'users.userpass', 'users.pass_salt', 'users.email' ));
		
		$cost = $this->config->item('signature-cost');
		$this->co->storage['cnt'] = $this->db->select('*')->from('usersigs')->where('userid', $ir['userid'])->count_all_results();
		
		if($this->input->post('__unique__') == $this->co->get_session()) {
		
			if($this->input->post('__type__') == 'buy' && $ir['money'] >= $cost && $this->co->storage['cnt'] == 0) {
	
				$this->co->remove_money($ir['username'], $cost);
				$this->co->notice('You bought a signature for your profile for $'.number_format($cost).'!');
				$this->co->storage['cnt'] = 1;
				$this->db->insert('usersigs', array(
						'userid' => $ir['userid'],
						'signature' => ''
					)
				);
			
			}
			
			else if($this->input->post('__type__') == 'buy' && $ir['money'] < $cost && $this->co->storage['cnt'] == 0) {
				$this->co->notice('You need $'.number_format($cost).' more to buy a signature for your profile!');
			}
			
			else if($this->co->storage['cnt'] > 0) {
				$this->co->notice('You have successfully updated your signature!');
				$this->db->set('signature', xss_clean( $this->input->post('signature') ) )->where('userid', $ir['userid'])->update('usersigs');
			}
			
			else {
				$this->co->notice('Sorry, an error occured while trying to process your request.');
			}
		
		}
				
		if($this->co->storage['cnt'] == 1) {
			$sig = $this->db->select('*')->from('usersigs')->where('userid', $ir['userid'])->get()->result_array();
			$sig = $sig[0]['signature'];
			$this->co->storage['sig'] = $sig;
		}
		
		$this->co->page('internal/pages/pref_signature');	
	}
	
	public function change_email()
	{
		$this->co->must_login(); 
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Preferences &mdash; Change Email Address' ));
		$this->co->init();
		$this->load->helper('email');
		$ir = $this->co->whoami(array( 'users.userpass', 'users.pass_salt', 'users.email' ));
		
		
		if($this->input->post('__unique__') == $this->co->get_session()) {
		
			$cur_pass_salt = $ir['pass_salt'];
			$cur_pass_sum = $this->co->hmac($this->config->item('db_hash') . $cur_pass_salt, $this->input->post('cur_password'));
		
			if($cur_pass_sum != $ir['userpass']) {
				$this->co->notice('Your current password does not match the one on record, please try again.');
			}
			
			else if($this->input->post('new_email') != $this->input->post('conf_new_email')) {
				$this->co->notice('Your new email address did not match the confirmation field.');
			}
			
			elseif(strlen($this->input->post('new_email')) > 120) {
				$this->co->notice('Sorry, your email address must not exceed 120 characters.');
			}
			
			elseif( ! valid_email($this->input->post('new_email')) ) {
				$this->co->notice('Sorry, your new email address is not valid. Please enter another one which is valid.');
			}
			
			else {
				$this->db->insert('emailchanges', array(
						'userid' => $ir['userid'],
						'time' => now(),
						'old_email' => $ir['email'],
						'new_email' => $this->input->post('new_email')
					)
				);
			
				$this->db->set('email', $this->input->post('new_email'))->where('userid', $ir['userid'])->update('users');
				$this->co->notice('You have successfully changed your email address to '.$this->input->post('new_email').'!');
				$this->co->redirect(base_url() . 'preferences');
			}
		
		}
		
		$this->co->page('internal/pages/pref_change_email');	
	}
	
	public function facebook_connections()
	{
		$this->co->must_login(); 
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Preferences &mdash; Manage Facebook Connections' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		$this->co->storage['facebook_cnt'] = $this->db->select('*')->from('facebook_user')->where('userid', $this->co->user['userid'])->count_all_results();
		
		if($this->co->storage['facebook_cnt'] == 0) {
			
			$this->load->library('facebook');
			if($this->facebook->get_facebook_cookie() && $this->input->get('status') == 'connected')
			{
				$i = $this->facebook->getUser();
				
				if(isset($i['email'])) {
				
					if($this->db->select('*')->from('facebook_user')->where('fb_user_id', $i['id'])->count_all_results() > 0) {
						$ia = $this->db->select('*')->from('facebook_user')->where('fb_user_id', $i['id'])->get()->result_array();
						$ia = $ia[0]['userid'];
						$ib = $this->db->select('username')->from('username_cache')->where('userid', $ia)->get()->result_array();
						
						$this->co->notice('This Facebook account has already been connected to \''.$ib[0]['username'].'\' in Criminal Outlaws!');
					} else {
				
						$this->db->insert("facebook_user", array(
								'userid' => $ir['userid'],
								'fb_access_key' => $i['access_token'],
								'fb_user_id' => $i['id']
							)
						);
				
						$this->co->add_badge($ir['username'], 'facebook');
						$this->co->notice('You have connected '.$i['name'].' to this Criminal Outlaws account and have gained a new badge!');
						$this->co->storage['facebook_cnt'] = 1;
					
					}
				}
			}
			
		} else {
			
			if($this->input->post('__unique__') == $this->co->get_session()) {
				$this->db->where('userid', $ir['userid'])->delete('facebook_user');
				$this->co->remove_badge($ir['username'], 'facebook');
				$this->co->notice('You have disconnected your Facebook account from Criminal Outlaws.');
				$this->co->redirect(base_url() . 'preferences');
			}
			
		}
		
		$this->co->page('internal/pages/pref_facebook');	
	}
	
	public function update_pic()
	{
		$this->co->must_login(); 
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Preferences &mdash; Change Profile Picture' ));
		$this->co->init();
		$ir = $this->co->whoami(array( 'users.display_pic' ));
		
		if($this->input->post('__unique__') == $this->co->get_session()) {
		
			$upload_path = (constant('ONLINE') == TRUE ? '/home/dotcloud/data/' : '/Applications/MAMP/htdocs/RPG/');
		
			if( ! is_dir($upload_path) ) {
				@mkdir( $upload_path, 0777 );
			}
		
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '150';
			$config['file_name'] = $ir['username'] . '_' . random_string('alnum', 15) . '.png';
			$config['overwrite'] = TRUE;
			$config['max_width']  = 0;
			$config['max_height']  = 0;

			$this->load->library('upload', $config);
			
			if( ! $this->upload->do_upload() ) {
				$this->co->notice(strip_tags($this->upload->display_errors()));
			} else {
				$upload = $this->upload->data();
				
				if($upload['is_image'] != 1) {
					$this->co->notice('The file you uploaded was not an image file.');
				}
				
				else {
				
					if($upload['image_width'] != 75 && $upload['image_height'] != 75) {
						
						$config['image_library'] = 'gd2';
						$config['source_image'] = $upload['full_path'];
						$config['new_image'] = $upload['full_path'];
						$config['create_thumb'] = FALSE;
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 75;
						$config['height'] = 75;

						$this->load->library('image_lib', $config);
						$this->image_lib->resize();
						
					}
					
					$this->load->library('cf/cfiles');
					$this->cfiles->cf_container = 'user_avatars';
        			
        			if($ir['display_pic']) {
						$file_name = $ir['display_pic'];
						$this->cfiles->do_object('d', $file_name);
					}
        			
					$file_location = $upload['file_path'];
					$file_name = $upload['file_name'];
        			$this->cfiles->do_object('a', $file_name, $file_location);
					$this->db->set('display_pic', $file_name)->where('userid', $ir['userid'])->update('users');
					$this->co->user['display_pic'] = $file_name;
					unlink( $upload['full_path'] );
					
					$this->co->notice('Your new profile picture has been uploaded successfully. Take a look!');				
				}
			}
		
		}
		
		$this->co->page('internal/pages/pref_change_pic');	
	}
	
	public function update_password()
	{
		$this->co->must_login(); 
		$this->co->allow_jail(); $this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Preferences &mdash; Change Password' ));
		$this->co->init();
		$ir = $this->co->whoami(array( 'users.userpass', 'users.pass_salt' ));
		
		
		if($this->input->post('__unique__') == $this->co->get_session()) {
		
			$cur_pass_salt = $ir['pass_salt'];
			$cur_pass_sum = $this->co->hmac($this->config->item('db_hash') . $cur_pass_salt, $this->input->post('cur_password'));
		
			if($cur_pass_sum != $ir['userpass']) {
				$this->co->notice('Your current password does not match the one on record, please try again.');
			}
			
			else if($this->input->post('new_password') != $this->input->post('conf_new_password')) {
				$this->co->notice('Your new password fields did not match, please try again.');
			}
			
			elseif(strlen($this->input->post('new_password')) < 6 OR strlen($this->input->post('new_password')) > 150) {
				$this->co->notice('Sorry, your password must be at least 6 characters and must not exceed 150 characters.');
			}
			
			else {
				$pass_salt = random_string('alnum', 10);
				$pass_sum = $this->co->hmac( $this->config->item('db_hash') . $pass_salt, $this->input->post('new_password') );
				$this->db->set('userpass', $pass_sum)->set('pass_salt', $pass_salt)->where('userid', $ir['userid'])->update('users');
				
				$this->co->notice('You have successfully changed your password and the changes are effective immediately.');	
			}
		
		}
		
		$this->co->page('internal/pages/pref_change_password');	
	}
	
	public function change_gender()
	{
		$this->co->must_login(); 
		$this->co->allow_hospital();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Preferences &mdash; Change Gender' ));
		$this->co->init();
		$ir = $this->co->whoami();
		
		if($this->input->post('__unique__') == $this->co->get_session()) {
			
			if($ir['money'] < $this->config->item('gender-change')) {
				$this->co->notice('You will need $'.number_format($this->config->item('gender-change') - $ir['money'], 2).' more to change your gender!');
			}
			
			else {
				$set = ($ir['gender'] == 'Male' ? 'Female' : 'Male');
				$this->co->remove_money($ir['username'], $this->config->item('gender-change'));
			
				if(rand(1,3) == 2) {
					$mins = rand(1, 65);
					$this->db->set('gender', $set)->set('hospital', now() + 60*$mins)->set('hospreason', 'Hospitalized during a sex change surgery')->where('userid', $ir['userid'])->update('users');
					$this->co->update_config('hospital_count', $this->co->config['hospital_count'] + 1);
					$this->co->notice('You changed your gender to '.$set.' and was charged $' . number_format($this->config->item('gender-change')) . ' but was hospitalized in the process!');
				} else {
					$this->co->notice('You changed your gender to '.$set.' and was charged $' . number_format($this->config->item('gender-change')) . '!');
					$this->db->set('gender', $set)->where('userid', $ir['userid'])->update('users');
				}
				
				$this->co->redirect(base_url() . 'preferences');
			
			}
		
		}
		
		$this->co->page('internal/pages/pref_change_gender');	
	}
	
}