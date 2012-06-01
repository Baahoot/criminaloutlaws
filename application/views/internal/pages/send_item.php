<h3 class="stylish">Send Item</h3>
<p>Please enter the username that you would like to send your <b><?php echo $this->co->storage['send_item'][0]['itmname']; ?></b> to and how many you wish to send.</p>
<br />
<form action="<?php echo base_url() . 'inventory/send?id=' . $this->input->get('id'); ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax"><input type="hidden" name="post" value="1" />
	<div class="field">
		<p class="form-label"><label style="width:75px;">Username:</label><?php echo form_input( array( 'class' => 'form-field', 'name' => 'username', 'value' => $this->input->get('username'), 'size' => 50 ) ); ?></p>
		<div class="clear"></div>
		<p class="form-label"><label style="width:75px;">Item Name:</label><?php echo form_input( array( 'class' => 'form-field', 'name' => 'item_name', 'disabled' => 'disabled', 'value' => $this->co->storage['send_item'][0]['itmname'], 'size' => 30 ) ); ?></p>
		<div class="clear"></div>
		<p class="form-label"><label style="width:75px;">Quantity:</label><?php echo form_input( array( 'class' => 'form-field', 'name' => 'quantity', 'value' => $this->co->storage['send_item'][0]['inv_qty'], 'size' => 4, 'style' => 'width:20px;', 'maxlength' => strlen($this->co->storage['send_item'][0]['inv_qty']) ) ); ?> &nbsp;out of <?php echo $this->co->storage['send_item'][0]['inv_qty']; ?> available to send</p>
		 
		 <br />
		 <p><i><b>Note:</b> This process is irreversible so please check before you submit your request.</i></p>

		 <br />
		<button type="submit" class="grey xlarge"><p class="text-small">Send items to user</p></button>
		<div class="back"><a href="<?php echo base_url(); ?>inventory" rel="ajax">Go back to my inventory</a></div>
	</div>
</form>