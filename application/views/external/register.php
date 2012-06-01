<?php echo recaptcha_setup(); ?>

<form action="<?php echo base_url() . 'register' . ($this->input->get('return') ? '?return=' . $this->input->get('return') : ''); ?>" accept-charset="utf-8" class="stn-form label-inline simple form-signup" method="post">
		<?php $in = $this->input->post('info'); ?>
		<h5 class="title-lightblue">Create New Account</h5>
		
		<?php $i = 'username'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Username <em class="required">*</em>', $i); ?>
			<?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 41, 'style' => 'width:62%;', 'maxlength' => 16 ) ); ?> <a class="help" href="javascript:;"><span>This is your in-game alias that other users will see you as.</span></a></p>
			<?php echo $f; ?>
		</div>
		
		<?php $i = 'password'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Password <em class="required">*</em>', $i); ?>
			<?php echo form_password( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 41, 'style' => 'width:62%;' ) ); ?> <a class="help" href="javascript:;"><span>This is how you will access your account. Make it unique and hard.</span></a></p>
			<?php echo $f; ?>
		</div>
		
		<?php $i = 'cpassword'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('<i>Repeat</i> Password <em class="required">*</em>', $i); ?>
			<?php echo form_password( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 41, 'style' => 'width:62%;' ) ); ?> <a class="help" href="javascript:;"><span>Repeat your password entered above to confirm you've entered it correctly.</span></a></p>
			<?php echo $f; ?>
		</div>
		
		<?php $i = 'email'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Email Address <em class="required">*</em>', $i); ?>
			<?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 41, 'style' => 'width:62%;' ) ); ?> <a class="help" href="javascript:;"><span>Your e-mail address you'd like to associate with your account.</span></a></p>
			<?php echo $f; ?>
		</div>
		
		<?php $i = 'cemail'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('<i>Repeat</i> Email <em class="required">*</em>', $i); ?>
			<?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 41, 'style' => 'width:62%;' ) ); ?> <a class="help" href="javascript:;"><span>Repeat your e-mail address to let us know you have entered it correctly.</span></a></p>
			<?php echo $f; ?>
		</div>
		
		<?php $i = 'gender'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="controlset field">
				<p class="form-label form-label-blue"><?php echo form_label('Gender <em class="required">*</em>', $i); ?></p>
				
				<div class="controlset-fields" style="width:69%;">
					<p class="form-box"><?php echo form_radio( array( 'id' => 'g-male', 'name' => 'info['.$i.']', 'value' => 'Male', 'checked' => (@$_POST['info']['gender'] == 'Male' || ! count($_POST)) ? TRUE : FALSE ) ); ?> 
					<?php echo form_label('Male', 'g-male'); ?>
					
					<?php echo form_radio( array( 'id' => 'g-female', 'name' => 'info['.$i.']', 'value' => 'Female', 'checked' => (@$_POST['info']['gender'] == 'Female') ? TRUE : FALSE ) ); ?> 
					<?php echo form_label('Female', 'g-female'); ?></p>
					</div>
				<?php echo $f; ?>
			</div>
		
		<?php $i = 'referer'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Referred By', $i); $agi = $this->input->post('info'); ?>
			<?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => (isset($agi[$i]) ? $this_in : ($this->co->is_referer() ? $this->co->get_referer() : '')), 'size' => 41, 'style' => 'width:62%;' ) ); ?> <a class="help" href="javascript:;"><span>If you was recommended to join by a friend, enter their username here to reward them.</span></a></p>
			<?php echo $f; ?>
		</div>

		<?php $i = 'recaptcha_response_field'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error($i, '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field center <?php echo $err; ?>" style="width:460px;"><p class="form-label form-label-blue"><label>Captcha <em class="required">*</em></label></p><div id="recaptcha_widget" style="display:none"><div id="recaptcha_image" class="captcha-box" onclick="Recaptcha.reload()"></div><!-- div class="captcha-link"><a href="javascript: Recaptcha.reload()">Get another CAPTCHA</a> | <div class="recaptcha_only_if_image" style="display:inline;"><a href="javascript: Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div><div class="recaptcha_only_if_audio" style="display:inline;"><a href="javascript: Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div></div --><p class="form-label form-label-blue" style="padding-top:10px; margin-left:-14px;"><label>&nbsp;</label><?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => $i, 'value' => set_value('', $this_in), 'size' => 41 ) ); ?><a class="help" href="javascript: Recaptcha.showhelp()" title="Help on Captcha"></a></p><?php echo $f; ?></div></div>

		
		<?php echo recaptcha_get_html($this->config->item('recaptcha_public')); ?>
			
			<div class="center">
				<button type="submit" class="light-blue xlarge"><p class="text-small">Create your account</p></button>
			</div>
			
			<div class="response center">&nbsp;</div>
			
			<div class="loading"><div><img src="<?php $this->co->base(); ?>/images/pac.gif" border="0" /> <font>Loading</font></div></div>
		
		</form>