<?php $ir = $this->co->user; ?>
<h3 class="stylish"><a href='<?php echo base_url() . 'temple'; ?>' rel='ajax'>Gold Temple</a> &rarr; Trade for power</h3>
<p>Please enter how many gold you want to trade. You can use a maximum of <?php echo $ir['maxenergy'] - $ir['energy']; ?> gold before you reach your full power.</p>
<br />

<?php if($ir['crystals'] == 0): ?>
	<p class='center'>
		<b>Sorry, you do not have any gold to trade for power.</b>
	</p>
<?php elseif($ir['energy'] >= $ir['maxenergy']): ?>
	<p class='center'>
		<b>Sorry, you do not need to use this as you have full power already.</b>
	</p>
<?php else: ?>
	<form action="<?php echo base_url() . 'temple/order?action=energy'; ?>" method="post" rel="form-ajax">
	<input type="hidden" name="__unique__" value="<?php echo $this->co->get_session(); ?>" />
	
		<p>Gold: <input type="text" name="gold" value="<?php echo ($ir['crystals'] > $ir['maxenergy'] - $ir['energy'] ? $ir['maxenergy'] - $ir['energy'] : $ir['crystals']); ?>" style="padding:5px; font-size:14px; font-family:arial;">
		<button type="submit" class="dark-grey">Trade gold for power</button></p>
	</form>
<?php endif; ?>

<div class="back"><a href="<?php echo base_url(); ?>temple" rel="ajax">Go back</a></div>