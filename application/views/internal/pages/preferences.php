<h3 class="stylish">Preferences</h3>
<p>This area is where you go to change certain aspects of your account.</p>
<br />

	<p class='left'>
		<span style='display:block; padding-bottom:15px;'>
			<a href='<?php echo base_url() . 'preferences/change_username'; ?>' rel='ajax'><button class="dark-grey">Change Username</button></a>
		</span>
		
		<span style='display:block; padding-bottom:15px;'>
			<a href='<?php echo base_url() . 'preferences/change_signature'; ?>' rel='ajax'><button class="dark-grey">Change Signature</button></a>
		</span>
		
		<span style='display:block; padding-bottom:15px;'>
			<a href='<?php echo base_url() . 'preferences/change_gender'; ?>' rel='ajax'><button class="dark-grey<?php echo ($this->co->user['jail'] > now() ? ' disabled-button' : ''); ?>">Change Gender</button></a>
		</span>
		
		<span style='display:block; padding-bottom:15px;'>
			<a href='<?php echo base_url() . 'preferences/change_email'; ?>' rel='ajax'><button class="dark-grey">Change Email Address</button></a>
		</span>
		
		<span style='display:block; padding-bottom:15px;'>
			<a href='<?php echo base_url() . 'preferences/update_password'; ?>' rel='ajax'><button class="dark-grey">Change Password</button></a>
		</span>
		
		<span style='display:block; padding-bottom:15px;'>
			<a href='<?php echo base_url() . 'preferences/update_pic'; ?>' rel='ajax'><button class="dark-grey">Change Profile Picture</button></a>
		</span>
		
		<span style='display:block; padding-bottom:15px;'>
			<a href='<?php echo base_url() . 'preferences/facebook_connections'; ?>'><button class="light-blue">Manage Facebook Connections</button></a><br />
		</span>
	</p>