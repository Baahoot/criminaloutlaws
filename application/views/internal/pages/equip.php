<h3 class="stylish">Equip Item</h3>
<p>Please select what you want to equip the <b><?php echo $this->co->storage['equip'][0]['itmname']; ?></b> as in your inventory.</p>
<br />
<form action="<?php echo base_url() . 'inventory/equip?id=' . $this->input->get('id'); ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax-hidden">
<?php if($this->co->storage['equip'][0]['weapon'] > 0): ?>
	<div class="field">
		<p class="form-label"><?php echo form_radio( array( 'class' => 'form-field', 'name' => 'as', 'value' => 'primary', 'checked' => TRUE ) ); ?>
		 Equip the "<?php echo $this->co->storage['equip'][0]['itmname']; ?>" as your primary weapon</p>
		<p class="form-label"><?php echo form_radio( array( 'class' => 'form-field', 'name' => 'as', 'value' => 'secondary' ) ); ?>
		 Equip the "<?php echo $this->co->storage['equip'][0]['itmname']; ?>" as your secondary weapon</p>
		 <p class="form-label"><?php echo form_radio( array( 'class' => 'form-field', 'name' => 'as', 'value' => 'none' ) ); ?>
		 Do not equip the "<?php echo $this->co->storage['equip'][0]['itmname']; ?>"</p>
		 <br />
		<button type="submit" class="grey xlarge"><p class="text-small">Equip weapon</p></button>
		<div class="back"><a href="<?php echo base_url(); ?>inventory" rel="ajax">Go back to my inventory</a></div>
	</div>
<?php elseif($this->co->storage['equip'][0]['armor'] > 0): ?>
	<div class="field">
		<p class="form-label"><?php echo form_radio( array( 'class' => 'form-field', 'name' => 'as', 'value' => 'armor', 'checked' => TRUE ) ); ?>
		 Equip the "<?php echo $this->co->storage['equip'][0]['itmname']; ?>" as your armor</p>
		 <p class="form-label"><?php echo form_radio( array( 'class' => 'form-field', 'name' => 'as', 'value' => 'none' ) ); ?>
		 Do not equip the "<?php echo $this->co->storage['equip'][0]['itmname']; ?>"</p>
		 <br />
		<button type="submit" class="grey xlarge"><p class="text-small">Equip armor</p></button>
		<div class="back"><a href="<?php echo base_url(); ?>inventory" rel="ajax">Go back to my inventory</a></div>
	</div>
<?php endif; ?>
</form>