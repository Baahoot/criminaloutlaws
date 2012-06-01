<?php
if( !$this->input->is_ajax_request()) {
?>	
	<div class="clear"></div>
	
	<div class="grid_12">
	<ul class="navigation black-nav">
		<li class="right"><a href="<?php echo base_url(); ?>reset_password" rel="link-reset">Reset Password</a></li>
		<li class="right"><a href="<?php echo base_url(); ?>register">Register</a></li>
		<li class="right"><a href="<?php echo base_url(); ?>login" rel="link-login">Login</a></li>
		
		<li><a href="<?php echo base_url(); ?>login" rel="link-login">Home</a></li>
		<li><a href="http://blog.criminaloutlaws.com/" target="_blank">Blog</a></li>
	</ul>
	</div>
	
	<div class="clear"></div>
	
	<div class="body-content"><?php } if(($this->uri->uri_string() == "reset_password/complete") && (($this->input->is_ajax_request() && !count($_POST)) || (!$this->input->is_ajax_request())) ) { ?>
	
	<div class="grid_2 co_static">&nbsp;</div>
	
	<div class="grid_8 co_static hp_right">
	
	<?php } else if(($this->uri->uri_string() == "reset_password") && (($this->input->is_ajax_request() && !count($_POST)) || (!$this->input->is_ajax_request())) ) { ?>
	<div class="grid_6 co_static hp_left">			
		<div class="mchild">
	
		<?php if($this->uri->uri_string() == "reset_password"): ?>
			<p class="hp_title">Forgot your password?</p>
			<p class="hp_desc">This is the area that if you have an account, but you've forgotten your password. The way this works is once you fill in the form to the right, you'll receive an email from us (within 10 minutes) with a secure temporary link that allows you to change your password.<br />
			<br />
			Please use this facility responsibility, we have advanced protection mechanisms in place that may ban you if you are caught misusing the system.</p>
			
		<?php else: ?>
			&nbsp;
		<?php endif; ?>
		</div>
	</div>
	<div class="grid_6 co_static hp_right">
	<?php } else if(($this->uri->uri_string() == "login") && (($this->input->is_ajax_request() && !count($_POST)) || (!$this->input->is_ajax_request())) ) { ?>
	<div class="grid_6 co_static hp_left">		
			<div class="mchild">
				<p class="hp_title">Play our free crime-based multiplayer game</p>
				<p class="hp_desc">
				
					Criminal Outlaws is an game where you play to build your riches, form your allies and identify your rivals. You need to use your initiative to make sure you can be smarter than them, and increase your ranks amongst thousands others, and make your way into the biggest and hardest cities where you'll always be welcomed with a new challenge.
				
				</p>
				<p class="hp_desc">
				
					Join one of the most exciting new games online today.
				
				</p>
				<br />
			 </div>
	</div>

	<div class="grid_6 co_static hp_right"> <?php } else {
	?>
	<div class="grid_6 co_static hp_right">
	<?php } ?>