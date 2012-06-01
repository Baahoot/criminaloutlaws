<h3 class="stylish">
	<a href="<?php echo base_url() . 'preferences'; ?>" rel="ajax">Preferences</a>
	 &rarr; Change Gender
</h3>
<p>To change your gender, you will need to undergo an operation which costs $<?php echo number_format($this->config->item('gender-change')); ?> and might hospitalize you for a short period of time if it goes wrong.</p>
<br />
<form action="<?php echo base_url() . 'preferences/change_gender'; ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax">
	<div class="field">
		<input type='hidden' name='__unique__' value='<?php echo $this->co->get_session(); ?>' />
		
		<p class="form-label"><label style="width:100px; text-align:left; height:10px;">Current Gender</label> <?php echo form_input( array( 'class' => 'form-field', 'name' => 'new_username', 'value' => set_value('new_username', $this->co->user['gender']), 'size' => 10, 'disabled' => 'disabled' ) ); ?></p><br>

		<p></p>

		<?php if($this->co->user['money'] >= $this->config->item('gender-change')): ?>
		
			<?php if($this->co->user['gender'] == 'Male'): ?>
				<button type="submit" class="dark-grey xlarge"><p class="text-small">Change your gender to Female for $<?php echo number_format($this->config->item('gender-change')); ?></p></button>
			<?php else: ?>
				<button type="submit" class="dark-grey xlarge"><p class="text-small">Change your gender to Male for $<?php echo number_format($this->config->item('gender-change')); ?></p></button>
			<?php endif; ?>
		
		<?php else: ?>
			<button type="submit" class="grey xlarge disabled-button"><p class="text-small">You need $<?php echo number_format($this->config->item('gender-change') - $this->co->user['money'], 2); ?> more to change your gender!</p></button>
		<?php endif; ?>

		<div class="back"><a href="<?php echo base_url(); ?>preferences" rel="ajax">Go back</a></div>
	</div>
</form>