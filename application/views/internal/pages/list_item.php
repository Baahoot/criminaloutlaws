<h3 class="stylish">List on Item Market</h3>
<p>This item allows you to list your item on the <a href='<?php echo base_url(); ?>market/item' rel='ajax'>item market</a> where other players can buy items and immediately receive them. There is a 10% commission for using the Item Market to sell your items and items cannot be sold lower than 25% of its current sell value.</p>
<br />
<form action="<?php echo base_url() . 'inventory/list_item?id=' . $this->input->get('id'); ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax">
	<div class="field">
		<input type='hidden' name='post' value='1'>
		<p class="form-label"><label style="width:100px; text-align:left; height:10px;">Item</label> <?php echo form_input( array( 'disabled' => 'disabled', 'class' => 'form-field', 'name' => 'item', 'value' => $this->co->storage['list_item'][0]['itmname'], 'size' => 50) ); ?></p><br>
		<p class="form-label"><label style="width:100px; text-align:left; height:10px;">Quantity</label> <?php echo form_input( array( 'class' => 'form-field', 'name' => 'quantity', 'value' => $this->co->storage['list_item'][0]['inv_qty'], 'size' => 5 ) ); ?> &nbsp;out of <?php echo $this->co->storage['list_item'][0]['inv_qty']; ?> available to list</p><br>
		<p class="form-label"><label style="width:100px; text-align:left; height:10px;">Currency</label> <?php echo form_radio( array( 'class' => 'form-field', 'name' => 'currency', 'value' => 'money', 'size' => 8, 'checked' => TRUE ) ); ?> Money &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo form_radio( array( 'class' => 'form-field', 'name' => 'currency', 'value' => 'crystals', 'size' => 8 ) ); ?> Gold</p><br />
		<p class="form-label"><label style="width:100px; text-align:left; height:10px;">Price each</label> <?php echo form_input( array( 'class' => 'form-field', 'name' => 'price', 'value' => '50', 'size' => 15 ) ); ?> &nbsp;&nbsp;(Current Sell Value: $<?php echo number_format($this->co->storage['list_item'][0]['itmsellprice'], 2); ?>)</p><br>
		
		<p></p>

		<button type="submit" class="grey xlarge"><p class="text-small">List Item On Market</p></button>
		<div class="back"><a href="<?php echo base_url(); ?>inventory" rel="ajax">Go back to my inventory</a></div>
	</div>
</form>