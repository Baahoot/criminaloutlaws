<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 


class Paypal_Lib {

	var $ipn_response;			// holds the IPN response from paypal	
	var $ipn_data = array();	// array contains the POST values for IPN
	
	var $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
		
		$this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';

		$this->last_error = '';
		$this->ipn_response = '';

		
		//$this->add_field('rm','2');			  // Return method = POST
		//$this->add_field('cmd','_xclick');
		//$this->add_field('currency_code', $this->CI->config->item('paypal_lib_currency_code'));
	    //$this->add_field('quantity', '1');
		//$this->button('Pay Now!');
	}
	
	function validate_ipn()
	{
		// parse the paypal URL
		$url_parsed = parse_url($this->paypal_url);		  

		// generate the post string from the _POST vars aswell as load the
		// _POST vars into an arry so we can play with them from the calling
		// script.
		$post_string = '';	
		 
		if ($this->CI->input->post())
		{
			foreach ($this->CI->input->post() as $field=>$value)
			{ 
				$this->ipn_data[$field] = $value;
				$post_string .= $field . '=' . urlencode(stripslashes($value)) . '&';
			}
		} else {
			return false;
		}
		
		$post_string .= "cmd=_notify-validate"; // append ipn command

		// open the connection to paypal
		$fp = fsockopen($url_parsed['host'], "80", $err_num, $err_str, 30); 
		if(!$fp)
		{
			return false;
		} else { 
			// Post the data back to paypal
			fputs($fp, "POST ".$url_parsed['path']." HTTP/1.1\r\n"); 
			fputs($fp, "Host: ".$url_parsed['host']."\r\n"); 
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
			fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
			fputs($fp, "Connection: close\r\n\r\n"); 
			fputs($fp, $post_string . "\r\n\r\n"); 

			// loop through the response from the server and append to variable
			while(!feof($fp))
				$this->ipn_response .= fgets($fp, 1024); 

			fclose($fp); // close connection
		}

		if (substr_count($this->ipn_response, 'VERIFIED') > 0)
		{
			// Valid IPN transaction.
			return true;		 
		} 
		else 
		{
			return false;
		}
	
	}

}

?>