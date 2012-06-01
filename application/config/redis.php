<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Config for the Redis library
 *
 * @see ../libraries/Redis.php
 */

// Connection details
$config['redis_active'] = FALSE;
$config['redis_host'] = '';		// IP address or host
$config['redis_port'] = '';				// Default Redis port is 6379
$config['redis_password'] = '';				// Can be left empty when the server does not require AUTH
