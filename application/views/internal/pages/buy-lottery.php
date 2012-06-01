<?php $ir = $this->co->user; ?>
<h3 class="stylish"><a href="<?php echo base_url() . 'lottery'; ?>" rel="ajax">Criminal Outlaws Lottery</a> &rarr; Buy Lottery Tickets</h3>

<br />

<div class="center omega alpha grid_6" style="width:50%;">
	<h5>Buy a lucky ticket</h5>
	<p class="left">This option randomly selects numbers for your lottery ticket.</p>
	<br />
	
	<form action="<?php echo base_url() . 'lottery/buy'; ?>" method="post" rel="form-ajax">
	
		<input type="hidden" name="__unique__" value="<?php echo $this->co->get_session(); ?>">
		<input type="hidden" name="action" value="lucky">
		
		<?php if($ir['money'] < 25): ?>
			<button type="submit" class="dark-grey medium disabled-button" disabled="disabled">Sorry, you need $<?php echo number_format(25 - $ir['money'], 2); ?> more to buy a lottery ticket!</button>
		<?php else: ?>
			<button type="submit" class="dark-grey medium" onclick="$(this).addClass('disabled-button');">Buy 1 Lucky Ticket ($25)</button>
		<?php endif; ?>
	
	</form>

	<form action="<?php echo base_url() . 'lottery/massbuy'; ?>" method="post" rel="form-ajax">
	
		<input type="hidden" name="__unique__" value="<?php echo $this->co->get_session(); ?>">
		<input type="hidden" name="action" value="lucky">
		<input type="hidden" name="amount" value="50">
		
		<?php if($ir['money'] > (25 * 50)): ?>
			<small>OR</small><br />
			<button type="submit" class="dark-grey medium" onclick="$(this).addClass('disabled-button');">Buy 50x Lucky Ticket ($<?php echo number_format(25*50); ?>)</button>
		<?php endif; ?>
	
	</form>
	
	<form action="<?php echo base_url() . 'lottery/massbuy'; ?>" method="post" rel="form-ajax">
	
		<input type="hidden" name="__unique__" value="<?php echo $this->co->get_session(); ?>">
		<input type="hidden" name="action" value="lucky">
		<input type="hidden" name="amount" value="500">
		
		<?php if($ir['money'] > (25 * 500)): ?>
			<small>OR</small><br />
			<button type="submit" class="dark-grey medium" onclick="$(this).addClass('disabled-button');">Buy 500x Lucky Ticket ($<?php echo number_format(25*500); ?>)</button>
		<?php endif; ?>
	
	</form>
	
	<form action="<?php echo base_url() . 'lottery/massbuy'; ?>" method="post" rel="form-ajax">
	
		<input type="hidden" name="__unique__" value="<?php echo $this->co->get_session(); ?>">
		<input type="hidden" name="action" value="lucky">
		<input type="hidden" name="amount" value="1000">
		
		<?php if($ir['money'] > (25 * 1000)): ?>
			<small>OR</small><br />
			<button type="submit" class="dark-grey medium" onclick="$(this).addClass('disabled-button');">Buy 1000x Lucky Ticket ($<?php echo number_format(25*5000); ?>)</button>
		<?php endif; ?>
	
	</form>
</div>

<div class="center omega alpha grid_6" style="width:50%;">
	<h5>Select your lottery numbers</h5>
	<p class="left">This option allows you to select your own lottery numbers for next week's draw.</p>
	<br />
	
	<form action="<?php echo base_url() . 'lottery/buy'; ?>" method="post" rel="form-ajax">
	
		<input type="hidden" name="__unique__" value="<?php echo $this->co->get_session(); ?>">
		<input type="hidden" name="action" value="manual">
	
		<?php if($ir['money'] < 25): ?>
			<button type="submit" class="dark-grey medium disabled-button" disabled="disabled">Sorry, you need $<?php echo number_format(25 - $ir['money'], 2); ?> more to buy a lottery ticket!</button>
		<?php else: ?>
		
			<input rel="lottery-num" type="text" maxlength="2" size="1" name="lottery_1" value="1" class="center" style="width:30px; padding:4px; font-size:18px; background:#E6FCE6;" />
		
			&rarr;
		
			<input rel="lottery-num" type="text" maxlength="2" size="1" name="lottery_2" value="1" class="center" style="width:30px; padding:4px; font-size:18px; background:#E6FCE6;" />
		
			&rarr;
		
			<input rel="lottery-num" type="text" maxlength="2" size="1" name="lottery_3" value="1" class="center" style="width:30px; padding:4px; font-size:18px; background:#E6FCE6;" />
		
			&rarr;
		
			<input rel="lottery-num" type="text" maxlength="2" size="1" name="lottery_4" value="1" class="center" style="width:30px; padding:4px; font-size:18px; background:#E6FCE6;" />
		
			&rarr;
		
			<input rel="lottery-num" type="text" maxlength="2" size="1" name="lottery_5" value="1" class="center" style="width:30px; padding:4px; font-size:18px; background:#E6FCE6;" />
		
			&rarr;
			
			<button rel="lottery-subm" class="dark-grey medium" type="submit" onclick="$(this).addClass('disabled-button');">Buy Lottery Ticket ($25)</button>
		
		<?php endif; ?>

	</form>
</div>

<div class="clear"></div>

<br />
<br />

<p class="custom-small" style="background:#DDD;"><b>Note:</b> The Criminal Outlaws Lottery is designed by selecting five different numbers which must be between 1 and 10, and every week, we randomly select numbers and if you match them with your ticket then we'll pay you the entire jackpot. There are no second or third place prizes for our lottery.<br /><br />
Each ticket is only valid for one week, and you must re-purchase every week if you wish to become eligible to win. The odds of winning are 1 in 100,000. If multiple people have matched the jackpot numbers, then the prize is split equally. Tickets are non-refundable and non-exchangable.</p>

<br />

<div class="back"><a href="<?php echo base_url(); ?>lottery" rel="ajax">Go back</a></div>