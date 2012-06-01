		<form action="<?php echo base_url() . 'reset_password'; ?>" accept-charset="utf-8" class="stn-form label-inline simple form-reset" method="post">
		<?php $in = $this->input->post('info'); ?>
		<h5 class="title-lightblue">Reset Your Password</h5>
		<?php $i = 'username'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Username', $i); ?>
			<?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'value' => set_value('', $this_in), 'size' => 40, 'style' => 'width:65%;' ) ); ?></p>
			<?php echo $f; ?>
		</div>
		
		<?php $i = 'email'; $f = ''; $err = ''; $this_in = (isset($in[$i])) ? $in[$i] : FALSE; $f = form_error('info['.$i.']', '<span class="errorText">', '</span>'); if($f) { $err = ' error'; } ?>
		<div class="field<?php echo $err; ?>">
			<p class="form-label form-label-blue"><?php echo form_label('Email Address', $i); ?>
			<?php echo form_input( array( 'class' => 'form-field', 'id' => $i, 'name' => 'info['.$i.']', 'size' => 40, 'style' => 'width:65%;' ) ); ?></p>
			<?php echo $f; ?>
		</div>
			
			<div class="center">
					<button type="submit" class="light-blue xlarge"><p class="text-small">Reset my password</p></button>
			</div>
			
			<div class="loading"><div><img src="<?php $this->co->base(); ?>/images/pac.gif" border="0" /> <font>Loading</font></div></div>
		
		<?php echo form_close(); ?>