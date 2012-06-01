<?php

$misc = array(
	'interface' => $this->co->get_interface(),
	'time' => unix_to_human(now()),
	'major' => $this->config->item('major-release'),
	'minor' => $this->config->item('minor-release'),
	'render_time' => $this->benchmark->elapsed_time(),
	'memory_usage' => $this->benchmark->memory_usage()
);

$output = json_encode(array( 'result' => 'success', 'user' => $this->co->storage['me'], 'misc' => $misc));

/* Beautifier */

$output = Ajax::indent($output);
echo $output;