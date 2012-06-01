</div><?php if($this->uri->uri_string == "register/facebook" && defined('FACEBOOK')) { ?>
	<div class="grid_6 co_static hp_left">			
			<div class="mchild">
				<p class="hp_title">Hey there, <?php echo FACEBOOK_NAME; ?>!</p>
				<p class="hp_desc">Now that you've connected your Facebook account with us, we need you to signup so we can link it to your Facebook so that in the future you can sign in to your Criminal Outlaws account simply using your Facebook. Though, for complete availability, we'll still ask you to make a password in case any problems occur.</p>
				<p class="hp_desc">We won't abuse your information in any way, and the reason why we're asking for more information than we need is because we plan to implement more "social friendly" features in the future and it will be more seamless for you. However, if you don't wish to participate in this, simply go to your Facebook Settings and revoke access from our application, but if you wish to sign in using Facebook in the future, you'll need to re-authenticate.</p>
				<p class="hp_desc">Aside the boring stuff, just signup to the left and you'll be ready to go!</p>
			 </div>
	</div>
<?php

} elseif($this->uri->uri_string == "register") { ?>
	<div class="grid_6 co_static hp_left">			
			<div class="mchild">
				<p class="hp_title">Just before you sign up:</p>
				<p class="hp_desc">In order to make the game fair and responsible, we've set down some rules which you will need to comply with in order to play.</p><br />

				<ul>
					<li>Each user is <b>only allowed one account</b>. No exceptions.</li>
					<li>You can cancel your account any time you wish unconditionally.</li>
					<li>You authorize us to send you e-mails which are of importance.</li>
					<li>You will not attempt to obtain access to areas which are prohibited.</li>
					<li>We hold no responsibility over any downtime that might occur.</li>
					<li>Purchases are <b>final</b> which means no refunds are given.</li>
					<li>You are not permitted to access an account which you don't own.</li>
					<li>You must not post any irrelevant, offensive, questionable, racist, inappropriate or violent material at any time on the website.</li>
					<li>You hold <b>full and sole responsibility</b> over your actions.</li>
					<li>Game money are a virtual currency and is not real money.</li>
					<li>Accounts, money or items <b>cannot</b> be sold outside of the website.</li>
					<li>You agree to any amendments made to our terms and policies.</li>
				</ul>
			 </div>
	</div>
<?php } if( ! $this->input->is_ajax_request()) { ?></div><?php } ?>