<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Facebook
{

	public $app_id;
	public $app_secret;
	public $app_cookie;
	public $user;

	function __construct()
	{
		$CI =& get_instance();
		$CI->load->config('facebook');
		$this->app_id = $CI->config->item('facebook_app_id');
		$this->app_secret = $CI->config->item('facebook_api_secret');
		$this->app_cookie = 'fbsr_' . $this->app_id;
	}
	
	function complete()
	{
		global $CI;
		$CI->redis->delete($this->app_cookie . $CI->input->ip_address());
	}
	
	function get_facebook_cookie()
	{
		global $CI;
		$app_id = $this->app_id;
		$app_secret = $this->app_secret;
		
		$args = array();
		parse_str(trim(@$_COOKIE[$this->app_cookie], '\\"'), $args);
		ksort($args);
		if(count($args) == 0 && ! $CI->co->is_logged_in()) { $CI->co->notice('Please click the \'Connect to Facebook\' to login using Facebook.'); redirect(base_url() . 'login');return false; }
		return (array) $args;
	}
	
	function getUser()
	{
		global $CI;
		
			$o = $CI->redis->get($this->app_cookie . $CI->input->ip_address());
			if(is_array($o)) {
				$output = $o;
			} else {
               $cookie = $this->get_facebook_cookie();
               $user = @json_decode(file_get_contents(
                               'https://graph.facebook.com/me?access_token=' .
                               urlencode($cookie['access_token'])), true);
                
                
                if( ! is_array($user)) {
                	
                	if( ! $CI->co->is_logged_in()) {
          	         	$CI->co->notice('We could not connect to your Facebook account. Please try again later.');
            	    	redirect(base_url() . 'login');
            	    } else {
            	    	$CI->co->notice('We could not connect to your Facebook account. Please try again later.');
            	    	redirect(base_url() . 'preferences/facebook_connections');
            	    }
            	    
                	return;
                }
                
				$output = array_merge($cookie, $user);
				$CI->redis->write($output, $this->app_cookie . $CI->input->ip_address());
			}
			
		$this->user = $output;
		return $output;
	}
		
		function signup_notice($username) {
			global $CI;
			$cookie = $this->get_facebook_cookie();
			if(!isset($this->user)) { $this->getUser(); }
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/" . ( $this->user['id'] ) . "/feed");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array(
					'access_token' => $cookie['access_token'],
					'message' => 'I have signed up as ' . (isset($username) ? $username : 'a player') . ' on Criminal Outlaws!',
					'description' => 'With thousands of other people playing in real-time, you can join in the fun of playing a criminal person in a land where living is tough but the leader can dominate and own the whole city. Become a real leader and play this addictive but very fun game! And it\'s absolutely FREE to play!',
					'source' => 'CriminalOutlaws.com',
					'link' => base_url() . 'refer/id/' . $username,
					'name' => 'Criminal Outlaws',
					'caption' => 'A online multiplayer criminal-based RPG game for anyone to play'
				)
			);

			$result = curl_exec($ch);
			curl_close($ch);
			return;
		}

        function getFriendIds($include_self = TRUE){
                $cookie = $this->get_facebook_cookie();
                $friends = @json_decode(file_get_contents(
                                'https://graph.facebook.com/me/friends?access_token=' .
                                $cookie['access_token']), true);
                $friend_ids = array();
                foreach($friends['data'] as $friend){
                        $friend_ids[] = $friend['id'];
                }
                if($include_self == TRUE){
                        $friend_ids[] = $cookie['uid'];                 
                }       

                return array_merge($cookie, $friend_ids);
        }

        function getFriends($include_self = TRUE){
                $cookie = $this->get_facebook_cookie();
                $friends = @json_decode(file_get_contents(
                                'https://graph.facebook.com/me/friends?access_token=' .
                                $cookie['access_token']), true);
                
                if($include_self == TRUE){
                        $friends['data'][] = array(
                                'name'   => 'You',
                                'id' => $cookie['uid']
                        );                      
                }       

                return array_merge($cookie, $friends['data']);
        }

        function getFriendArray($include_self = TRUE){
                $cookie = $this->get_facebook_cookie();
                $friendlist = @json_decode(file_get_contents(
                                'https://graph.facebook.com/me/friends?access_token=' .
                                $cookie['access_token']), true);
                $friends = array();
                foreach($friendlist['data'] as $friend){
                        $friends[$friend['id']] = $friend['name'];
                }
                if($include_self == TRUE){
                        $friends[$cookie['uid']] = 'You';                       
                }       

                return array_merge($cookie, $friends);
        }

	
}

/* End of file Co.php */