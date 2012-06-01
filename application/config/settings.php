<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| CUSTOM GAME SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to run the game securely
*/

$config['session_name'] = 'coset';
$config['db_hash'] = '1234'; /* Do not touch this! It requires everyone to reset their password. */
$config['recaptcha_public'] = '';
$config['recaptcha_private'] = '';

$config['major-release'] = 'falcon';
$config['minor-release'] = 0001;

$config['contact-limit'] = 60;
$config['bank-cost'] = 25;
$config['gold-list-fee'] = 10;
$config['gender-change'] = 1500;
$config['signature-cost'] = 2500;
$config['cdn_user_url'] = 'http://' . $_SERVER['HTTP_HOST'];

/* This is to configure XP updates. If you set it to 2, it's double XP. If you set it to 3, it's triple XP and so on. Put 1 to disable. */

$config['paypal'] = 'xxx@xx.com'; // PayPal email
$config['paypal-item-name'] = 'CriminalOutlaws.com PRO Subscription';
$config['paypal-currency'] = 'USD';
$config['paypal-monthly-fee'] = '2.99';
$config['paypal-debug'] = FALSE;

$config['help'] = array(

	'gym' => array(
		'page' => 'internal/help/gym',
		'title' => 'Gym'
	),
	
	'houses' => array(
		'page' => 'internal/help/houses',
		'title' => 'Houses'
	),
	
	'bank' => array(
		'page' => 'internal/help/bank',
		'title' => 'Bank'
	),
	
	'airport' => array(
		'page' => 'internal/help/airport',
		'title' => 'Airport'
	)

);

/* End of file core.php */
/* Location: ./application/config/game/core.php */