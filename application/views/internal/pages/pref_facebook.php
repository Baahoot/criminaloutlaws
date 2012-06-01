<h3 class="stylish">
	<a href="<?php echo base_url() . 'preferences'; ?>" rel="ajax">Preferences</a>
	 &rarr; <font style='color:#336699;'>Manage Facebook Connections</font>
</h3>
<p>You can connect your Criminal Outlaws account to your Facebook account and take advantage of several privileges which includes the ability to login at one button whenever you're logged into Facebook, and another being that you will have access to the <img src="<?php $this->co->base(); ?>/badges/facebook.gif"> badge!</p>
<br />

	<?php if($this->co->storage['facebook_cnt'] == 0): ?>
		<fb:login-button size="large" perms="publish_stream, email, offline_access" onlogin="top.location = CO_DIR + 'preferences/facebook_connections?status=connected';">Connect your Criminal Outlaws account to Facebook</fb:login-button><!-- Facebook -->
		<div id="fb-root"></div>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script> FB.init({appId: '<?php echo $this->config->item('facebook_app_id'); ?>', status: true, cookie: true, xfbml: true}); </script>
	<?php else: ?>
		<form action="<?php echo base_url() . 'preferences/facebook_connections'; ?>" accept-charset="utf-8" class="stn-form label-inline simple"  method="post" rel="form-ajax">
			<input type='hidden' name='__unique__' value='<?php echo $this->co->get_session(); ?>' />
			<div class="center"><button type="submit" class="light-blue xlarge"><p class="text-small">Disconnect your <font color='#CAE9FC'>Facebook</font> account!</p></button> <small style="font-family:arial; font-size:12px; padding-left:15px;">By doing this, you will immediately lose your <img src="<?php $this->co->base(); ?>/badges/facebook.gif"> badge!</small></div>
		</form>
	<?php endif; ?>

		<div class="back"><a href="<?php echo base_url(); ?>preferences" rel="ajax">Go back</a></div>