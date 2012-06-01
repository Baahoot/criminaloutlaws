<?php $ir = $this->co->user; $user = $this->input->get('username'); ?>
<h3 class="stylish">Send Money to <a href='<?php echo base_url() . 'user/' . $user; ?>' rel='ajax'><?php echo $user; ?></a></h3>

<form method="post" action="<?php echo base_url() . 'send/money?username=' . $user; ?>" rel="form-ajax">
	<input type="hidden" name="__unique__" value="<?php echo $this->co->get_session(); ?>">
	<?php if($ir['money'] > 0): ?>
		<p>Please enter below how much of your <b>$<?php echo number_format($ir['money'], 2); ?></b> you wish to send to <b><?php echo $user; ?></b> below.</p>
		<br />
		<p style='font-size:19px; padding:0 15px 0 5px;'> $ <input autocomplete="off" rel="send-money" name="money" value="<?php echo $ir['money']; ?>" transfer-limit="<?php echo $ir['money']; ?>" style="font-size:19px; padding:10px;" /> </p>
		<br />
		<button type="submit" class="dark-grey medium">Send Money to <?php echo $user; ?></button> <small>OR</small> <a href="<?php echo base_url() . 'user/' . $user; ?>" rel="ajax"><button class="grey medium">Go back to profile</button></a>
	<?php else: ?>
		<br />
		<p class='center'><b>Sorry, you do not have any money to send to <?php echo $user; ?>.</b></p>
		<center><a href="<?php echo base_url() . 'user/' . $user; ?>" rel="ajax"><button class="grey medium">Go back to profile</button></a></center>
	<?php endif; ?>
</form>