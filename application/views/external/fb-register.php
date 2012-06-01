<form action="<?php echo base_url() . 'register/facebook' . ($this->input->get('redirect') ? '?redirect=' . $this->input->get('redirect') : ''); ?>" accept-charset="utf-8" class="stn-form label-inline simple form-signup" method="post">
		<?php $in = $this->input->post('info'); ?>
		<h5 class="title-lightblue"><?php echo defined('FACEBOOK') ? 'Complete registration using <font color="#7EAEED">Facebook</font>' : 'Create an account'; ?></h5>
		
		<?php $i = 'username'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Username <em class="required">*</em>', $i); ?>
			<?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', ($this_in) ? $this_in : FACEBOOK_RURI), 'size' => 41 ) ); ?> <a class="help" href="javascript:;"><span>This is your in-game alias that other users will see you as.</span></a></p>
			<?php echo $f; ?>
		</div>
		
		<?php $i = 'password'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Password <em class="required">*</em>', $i); ?>
			<?php echo form_password( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 41 ) ); ?> <a class="help" href="javascript:;"><span>This is how you will access your account. Make it unique and hard.</span></a></p>
			<?php echo $f; ?>
		</div>
		
		<?php $i = 'cpassword'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('<i>Repeat</i> Password <em class="required">*</em>', $i); ?>
			<?php echo form_password( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 41 ) ); ?> <a class="help" href="javascript:;"><span>Repeat your password entered above to confirm you've entered it correctly.</span></a></p>
			<?php echo $f; ?>
		</div>
		
		<?php if(defined('EMAIL_TAKEN')) { $i = 'email'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Email Address <em class="required">*</em>', $i); ?>
			<?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 41 ) ); ?> <a class="help" href="javascript:;"><span>Your e-mail address you'd like to associate with your account.</span></a></p>
			<?php echo $f; ?>
		</div>
		
		<?php $i = 'cemail'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('<i>Repeat</i> Email <em class="required">*</em>', $i); ?>
			<?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 41 ) ); ?> <a class="help" href="javascript:;"><span>Repeat your e-mail address to let us know you have entered it correctly.</span></a></p>
			<?php echo $f; ?>
		</div> <?php } ?>
		
		<?php $i = 'referer'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Referred By', $i); $agi = $this->input->post('info'); ?>
			<?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => (isset($agi[$i]) ? $this_in : ($this->co->is_referer() ? $this->co->get_referer() : '')), 'size' => 41 ) ); ?> <a class="help" href="javascript:;"><span>If you was recommended to join by a friend, enter their username here to reward them.</span></a></p>
			<?php echo $f; ?>
		</div>
			
			<div class="center">
					<button type="submit" class="light-blue xlarge"><p class="text-small">Complete your registration!</p></button>
			</div>
			
			<div class="response center">&nbsp;</div>
			
			<div class="loading"><div><img src="<?php $this->co->base(); ?>/images/pac.gif" border="0" /> <font>Loading</font></div></div>
		
		</form>