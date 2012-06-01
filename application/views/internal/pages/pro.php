<span class="pro" style="float:right; padding:30px 90px; font-size:80px; border-radius:15px; color:#fff;">PRO</span>
<!-- text-shadow:1px 1px #777;  -webkit-box-shadow:0 0 15px #bbb; -moz-box-shadow: 0 0 15px #bbb; box-shadow:0 0 15px #bbb; background:#aaa; color:#333; -->

	<div class="grid_6" style="width:550px; padding:4px;">
		<h3 class="stylish">Join the Pro outlaw family for only $2.99.</h3>
		<h4 style='line-height:35px; font-family:questrial, helvetica neue, arial; font-size:17px;'>Becoming pro allows you to take full advantage of Criminal Outlaws. And it only costs $2.99 for a one month subscription. And you can also now pay by mobile in a weekly subscription at &pound;1 (UK only).</h4>
	</div>

<div class="clear"></div>

<!-- div class="center">
	<br />
	<p class="medium"><b>Sorry, PRO membership is not yet available.</b></p>
	
	<br /><br />
</div -->

<br />

<div class="grid_6" style="width:550px;">

	<div style='padding:10px 15px; background:#444; color:#eee; border-radius:10px;'>
		<p><b>What you get as a PRO member:</b></p>
		
		<ul>
			<li>Power grows 2x faster than normal users</li>
			<li>Early pay fee for jobs only 10% instead of 50%</li>
			<li>Get the <span class='pro'>PRO</span> badge next to your name</li>
			<li>Access to a contact list which holds up to 60 people</li>
			<li>The ability to set a custom background on every page</li>
			
			<!-- li>Power grows 2x faster than normal users</li>
			<li>Early pay fee for jobs only 20% instead of 50%</li>
			<li>Get the <span class='pro'>PRO</span> badge next to your name</li>
			<li>Access to a contact list which holds up to 60 people</li>
			<li>The ability to set a custom background on the website</li>
			
			<li>Power grows 2x faster than normal users</li>
			<li>Early pay fee for jobs only 20% instead of 50%</li>
			<li>Get the <span class='pro'>PRO</span> badge next to your name</li>
			<li>Access to a contact list which holds up to 60 people</li>
			<li>The ability to set a custom background on the website</li>
			
			<li>Power grows 2x faster than normal users</li>
			<li>Early pay fee for jobs only 20% instead of 50%</li -->
		</ul>
		
	</div>
	
	<br />
	
	<div class="grid_2 center alpha omega" style="width:50%;">
	<form action="http://uk.impulsepay.com/payforit" method="post">
	
	<input type="image" name="submit" border="0"src="<?php $this->co->base(); ?>/images/paybymobile.png" alt="Pay by mobile securely">
	<input name="RouteID" type="hidden" value="3012" />
	<input name="Note" type="hidden" value="<?php echo $this->co->user['userid']; ?>" /> <!-- optional -->
	
	</form>
	</div>
	<div class="grid_3 center" style="width:45%;">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	
	<!-- Identify your business so that you can collect the payments. -->
	<input type="hidden" name="business" value="<?php echo $this->config->item('paypal'); ?>">
	
	<!-- Specify a Subscribe button. -->
	<input type="hidden" name="cmd" value="_xclick-subscriptions">
	
	<!-- Identify the subscription. -->
	<input type="hidden" name="item_name" value="<?php echo $this->config->item('paypal-item-name'); ?>">
	<input type="hidden" name="return" value="<?php echo base_url() . 'pro/success'; ?>">
	<input type="hidden" name="cancel_return" value="<?php echo base_url() . 'pro/cancel'; ?>">
	<input type="hidden" name="custom" value="<?php echo $this->co->user['userid']; ?>">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="tax" value="0">
	<input type="hidden" name="notify_url" value="<?php echo base_url(); ?>pro/ipn?user=<?php echo $this->co->user['userid']; ?>">
	
	<!-- Set the terms of the regular subscription. -->
	<input type="hidden" name="currency_code" value="<?php echo $this->config->item('paypal-currency'); ?>">
	<input type="hidden" name="a3" value="<?php echo $this->config->item('paypal-monthly-fee'); ?>">
	<input type="hidden" name="p3" value="1">
	<input type="hidden" name="t3" value="M">
	
	<!-- Display the payment button. -->
	<input type="image" name="submit" border="0"src="https://www.paypalobjects.com/en_US/i/btn/btn_xpressCheckout.gif" alt="PayPal - The safer, easier way to pay online"> <img alt="" border="0" width="1" height="1"src="https://www.paypal.com/en_US/i/scr/pixel.gif" >
	
	</form>
	</div>
	
</div>
<div class="alpha omega" style="float:right; width:350px; padding-top:2px;">

	<h5>What is PRO?</h5>
	<p>It is a <b>paid monthly</b> membership that gives you more features and benefits to enhance your gameplay on Criminal Outlaws.</p>
	<br />
	
	<h5>How can I pay for PRO?</h5>
	<p>You can either pay by an automatic monthly subscription using PayPal ($<?php echo $this->config->item('paypal-monthly-fee'); ?>/month) or by your mobile (&pound;1/week - UK only). You'll get your membership immediately after payment.</p>
	<br />
	
	<h5>Can I cancel anytime?</h5>
	<p>Yes you can. Subscriptions can be cancelled directly on PayPal. There is no obligation and you pay on a monthly basis as and when you feel like it.</p>
</div>

<div class="clear"></div>