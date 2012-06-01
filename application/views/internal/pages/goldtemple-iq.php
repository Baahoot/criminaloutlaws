<?php $ir = $this->co->user; ?>
<h3 class="stylish"><a href='<?php echo base_url() . 'temple'; ?>' rel='ajax'>Gold Temple</a> &rarr; Trade for intelligence</h3>
<p>Please enter how many gold you want to trade for your intelligence stat. For every gold you trade, you will gain 2 intelligence.</p>
<br />

<?php if($ir['crystals'] == 0): ?>
	<p class='center'>
		<b>Sorry, you do not have any gold to trade for intelligence.</b>
	</p>
<?php else: ?>
	<form action="<?php echo base_url() . 'temple/order?action=iq'; ?>" method="post" rel="form-ajax">
	<input type="hidden" name="__unique__" value="<?php echo $this->co->get_session(); ?>" />
	
		<p>Gold: <input type="text" name="gold" value="<?php echo $ir['crystals']; ?>" style="padding:5px; font-size:14px; font-family:arial;">
		<button type="submit" class="dark-grey">Trade gold for intelligence</button></p>
	</form>
<?php endif; ?>

<div class="back"><a href="<?php echo base_url(); ?>temple" rel="ajax">Go back</a></div>