<h3 class="stylish">
	<a href="<?php echo base_url() . 'preferences'; ?>" rel="ajax">Preferences</a>
	 &rarr; Change Profile Picture
</h3>
<p>This will update the avatar that is respectively displayed on the right hand side of your profile page, and <b>must be a size of 150x550 pixels</b> or it will be resized by our servers. It must not also violate our terms of service, which if you are caught violating, we will indefinitely suspend your account from the gameplay.</p>
<br />
<form action="<?php echo base_url() . 'preferences/update_pic'; ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax-e" enctype="multipart/form-data">
	<div class="field">
		<input type='hidden' name='__unique__' value='<?php echo $this->co->get_session(); ?>' />
		
		<p class="form-label"><label style="width:100px; text-align:left; height:10px;">Current Picture</label> <img src="<?php if($this->co->user['display_pic']): echo $this->config->item('cdn_user_url') . $this->co->user['display_pic']; else: ?><?php $this->co->base(); ?>/images/default-profile-pic.png<?php endif; ?>" width="150" height="550" /></p><br>

		<p></p>
		
		<p class="form-label"><label style="width:100px; text-align:left; height:10px;">New Picture</label> <?php echo form_upload( array( 'class' => 'form-field', 'name' => 'userfile', 'size' => 50 ) ); ?></p><br>

		<button type="submit" class="dark-grey xlarge" rel="profile-upload"><p class="text-small">Upload New Profile Picture</p></button>
		<button type="reset" class="grey xlarge"><p class="text-small">Reset Form</p></button>

		<div class="back"><a href="<?php echo base_url(); ?>preferences" rel="ajax">Go back</a></div>
	</div>
</form>