<h3 class="stylish">List on Gold Market</h3>
<p>There is a $<?php echo number_format($this->config->item('gold-list-fee'), 2); ?> listing fee for listing your gold on the market (which is refunded if you remove your gold from the market) and if it sells to another player, there will be an additional <b>25% final sale fee</b> which will be deducted from the money paid by the buyer.</p>
<br />
<form action="<?php echo base_url() . 'market/gold/create'; ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax-hidden">
	<div class="field">
		<input type='hidden' name='post' value='1'>
		<p class="form-label"><label style="width:100px; text-align:left; height:10px;">Quantity</label> <?php echo form_input( array( 'class' => 'form-field', 'name' => 'quantity', 'value' => set_value('quantity', $this->co->user['crystals']), 'size' => 5 ) ); ?> &nbsp;out of <?php echo $this->co->user['crystals']; ?> available to list</p><br>
		<p class="form-label"><label style="width:100px; text-align:left; height:10px;">Price each</label> $<?php echo form_input( array( 'class' => 'form-field', 'name' => 'price_each', 'value' => set_value('price_each', '10.00'), 'size' => 25 ) ); ?></p><br>

		<p></p>

		<?php if($this->co->user['money'] < $this->config->item('gold-list-fee')): ?>
			<button disabled="disabled" class="grey xlarge disabled-button"><p class="text-small">You do not have the $<?php echo number_format($this->config->item('gold-list-fee'), 2); ?> listing fee required to sell gold on the market.</p></button>
		<?php else: ?>
			<button type="submit" class="grey xlarge"><p class="text-small">List Gold On Market</p></button>
		<?php endif; ?>
		
		<div class="back"><a href="<?php echo base_url(); ?>market/gold" rel="ajax">Go back</a></div>
	</div>
</form>