<h3 class="stylish">
	<a href="<?php echo base_url() . 'preferences'; ?>" rel="ajax">Preferences</a>
	 &rarr; Change Email Address
</h3>
<p>This is critical to when you forget your password, or where you receive notifications or announcements from our system or team. If you need to update it, please do so below and make it accurate or you may not be able to retrieve your account in the future.</p>
<br />
<form action="<?php echo base_url() . 'preferences/change_email'; ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax">
	<div class="field">
		<input type='hidden' name='__unique__' value='<?php echo $this->co->get_session(); ?>' />
		
		<p class="form-label"><label style="width:150px; text-align:left; height:10px;">Current password</label> <?php echo form_password( array( 'class' => 'form-field', 'name' => 'cur_password', 'value' => '', 'size' => 50) ); ?></p><br><br>
		
		<p class="form-label"><label style="width:150px; text-align:left; height:10px;">Enter new email</label> <?php echo form_input( array( 'class' => 'form-field', 'name' => 'new_email', 'value' => '', 'size' => 50) ); ?></p><br>
		
		<p class="form-label"><label style="width:150px; text-align:left; height:10px;">Confirm new email</label> <?php echo form_input( array( 'class' => 'form-field', 'name' => 'conf_new_email', 'value' => '', 'size' => 50) ); ?></p><br>

		<p></p>

		<button type="submit" class="dark-grey xlarge"><p class="text-small">Update Email Address</p></button>
		<button type="reset" class="grey xlarge"><p class="text-small">Clear Form</p></button>
		
		<div class="back"><a href="<?php echo base_url(); ?>preferences" rel="ajax">Go back</a></div>
	</div>
</form>