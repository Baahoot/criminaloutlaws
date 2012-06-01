		<div style="margin:10px 0; padding:13px; background:#DEEFFA; color:#52616B; line-height:25px; border:1px solid #547185; font-family:Helvetica Neue, arial; font-size:15px;">
			Thanks for confirming your e-mail address by clicking on the link. Please enter your new desired password below, <b><?php echo $this->co->storage['reset'][0]['username']; ?></b> and we will log you in instantly without needing to login.
		</div>
		
		<form action="<?php echo base_url() . 'reset_password/complete?__id__='.$this->input->get('__id__'); ?>" accept-charset="utf-8" class="stn-form label-inline simple form-reset-update" method="post">
		<?php $in = $this->input->post('info'); ?>
		<br />
		<?php $i = 'password'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('New Password', $i); ?>
			<?php echo form_password( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 40, 'style' => 'width:65%;' ) ); ?></p>
			<?php echo $f; ?>
		</div>
		
		<?php $i = 'cpassword'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Confirm Password', $i); ?>
			<?php echo form_password( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'size' => 40, 'style' => 'width:65%;' ) ); ?></p>
			<?php echo $f; ?>
		</div>
			
			<div class="center">
					<button type="submit" class="light-blue xlarge"><p class="text-small">Reset my password!</p></button>
			</div>
			
			<div class="loading"><div><img src="<?php $this->co->base(); ?>/images/pac.gif" border="0" /> <font>Loading</font></div></div>
		
		<?php echo form_close(); ?>