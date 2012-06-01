<h3 class="stylish">Sell Item</h3>
<p>Please enter how many <b><?php echo $this->co->storage['sell_item'][0]['itmname']; ?></b> you wish to sell to a local exchange. You currently have a total of <?php echo $this->co->storage['sell_item'][0]['inv_qty']; ?> to sell.</p>
<br />
<form action="<?php echo base_url() . 'inventory/sell?id=' . $this->input->get('id'); ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax">
	<div class="field">
		<?php if($this->co->storage['sell_item'][0]['inv_qty'] > 1): ?>
		<p class="form-label"><label style="width:400px; text-align:left; height:10px;"><?php echo form_radio( array( 'class' => 'form-field', 'name' => 'amount', 'value' => 'all', 'checked' => TRUE ) ); ?>
		 Sell all <?php echo $this->co->storage['sell_item'][0]['inv_qty']; ?> of them for <?php echo '$' . number_format($this->co->storage['sell_item'][0]['inv_qty'] * $this->co->storage['sell_item'][0]['itmsellprice'], 2); ?></label></p><br><?php endif; ?>
		 <p class="form-label"><label style="width:400px; text-align:left; height:10px;"><?php echo form_radio( array( 'class' => 'form-field', 'name' => 'amount', 'value' => '1', 'checked' => ($this->co->storage['sell_item'][0]['inv_qty'] <= 1 ? TRUE : FALSE) ) ); ?>
		 Sell 1 of them for <?php echo '$' . number_format(1 * $this->co->storage['sell_item'][0]['itmsellprice'], 2); ?></label></p><br>
		 
		<p class="form-label"><label style="width:400px; text-align:left; height:10px;"><?php echo form_radio( array( 'class' => 'form-field', 'name' => 'amount', 'value' => 'none' ) ); ?>
		 Do not sell this item</label></p>
		 <?php if($this->co->storage['sell_item'][0]['inv_qty'] > 2): ?><br>
		 <p class="form-label"><label style="width:400px; text-align:left; height:10px;"><?php echo form_radio( array( 'class' => 'form-field', 'name' => 'amount', 'value' => 'custom' ) ); ?> Sell <?php echo form_input( array( 'class' => 'form-field', 'name' => 'custom', 'value' => $this->co->storage['sell_item'][0]['inv_qty'], 'maxlength' => strlen($this->co->storage['sell_item'][0]['inv_qty']), 'style' => 'border:0px; height:10px; font-size:11px; width:15px;' ) ); ?> out of the <?php echo $this->co->storage['sell_item'][0]['inv_qty']; ?> I have at <?php echo '$' . number_format(1 * $this->co->storage['sell_item'][0]['itmsellprice'], 2); ?> each</label></p>
		 
		 <?php endif; ?>
		 
		 <br />
		 <br />
		 <p class='custom-small'><b>Note before selling items:</b> These items will be sold to a local exchange buying your items at a reduced amount from what was paid for the item (if paid). Once sold, the action cannot be reversed and you will need to go back wherever the item can be found and purchase/obtain them again. Items which are rare or cannot be bought will be removed from circulation once sold.</p>
		 <br />
		<button type="submit" class="grey xlarge"><p class="text-small">Sell Items To The Local Exchange</p></button>
		<div class="back"><a href="<?php echo base_url(); ?>inventory" rel="ajax">Go back to my inventory</a></div>
	</div>
</form>