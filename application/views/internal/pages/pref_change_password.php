<h3 class="stylish">
	<a href="<?php echo base_url() . 'preferences'; ?>" rel="ajax">Preferences</a>
	 &rarr; Change Password
</h3>
<p>When changing your password, make sure that it is as strong as possible in order for you to protect your account.</p>
<br />
<form action="<?php echo base_url() . 'preferences/update_password'; ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax">
	<div class="field">
		<input type='hidden' name='__unique__' value='<?php echo $this->co->get_session(); ?>' />
		
		<p class="form-label"><label style="width:150px; text-align:left; height:10px;">Current password</label> <?php echo form_password( array( 'class' => 'form-field', 'name' => 'cur_password', 'value' => '', 'size' => 50) ); ?></p><br><br>
		
		<p class="form-label"><label style="width:150px; text-align:left; height:10px;">Enter new password</label> <?php echo form_password( array( 'class' => 'form-field', 'name' => 'new_password', 'value' => '', 'size' => 50) ); ?></p><br>
		
		<p class="form-label"><label style="width:150px; text-align:left; height:10px;">Confirm new password</label> <?php echo form_password( array( 'class' => 'form-field', 'name' => 'conf_new_password', 'value' => '', 'size' => 50) ); ?></p><br>

		<p></p>

		<button type="submit" class="dark-grey xlarge"><p class="text-small">Update Password</p></button>
		<button type="reset" class="grey xlarge"><p class="text-small">Clear Form</p></button>
		
		<div class="back"><a href="<?php echo base_url(); ?>preferences" rel="ajax">Go back</a></div>
	</div>
</form>