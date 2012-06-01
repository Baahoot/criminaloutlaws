		<form action="<?php echo base_url() . 'login' . ($this->input->get('return') ? '?return=' . $this->input->get('return') : ''); ?>" accept-charset="utf-8" class="stn-form label-inline simple form-login" method="post">
		<?php $in = $this->input->post('info'); ?>
		<h5 class="title-lightblue">Login into Criminal Outlaws</h5>
		<?php $i = 'username'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Username', $i); ?>
			<?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 40, 'style' => 'width:65%;' ) ); ?></p>
			<?php echo $f; ?>
		</div>
		
		<?php $i = 'password'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Password', $i); ?>
			<?php echo form_password( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'size' => 40, 'style' => 'width:65%;' ) ); ?></p>
			<?php echo $f; ?>
		</div>
			
			<div class="center">
					<button type="submit" class="light-blue xlarge"><p class="text-small">Login into Criminal Outlaws</p></button><p class="form-tiny">OR</p>
					
			<fb:login-button style="display:inline;" size="large" perms="publish_stream, email, offline_access" onlogin="<?php echo base_url(); ?>/login/facebook">Sign in using Facebook</fb:login-button><!-- Facebook -->
			</div>
		
		<?php echo form_close(); ?>