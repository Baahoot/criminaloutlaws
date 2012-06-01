<h3 class="stylish">
	<a href="<?php echo base_url() . 'preferences'; ?>" rel="ajax">Preferences</a>
	 &rarr; Change Username
</h3>
<p>If you have already gained a bad reputation, or simply don't like the way the streets recognize you, then you can attempt to change your username by frauding your way into gaining a blank passport from Area 51 and using another $100,000 to pay an insider within the government to hide any possible evidence.</p>
<br />
<form action="<?php echo base_url() . 'preferences/change_username'; ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax">
	<div class="field">
		<input type='hidden' name='__unique__' value='<?php echo $this->co->get_session(); ?>' />
		
		<p class="form-label"><label style="width:100px; text-align:left; height:10px;">New Username</label> <?php echo form_input( array( 'class' => 'form-field', 'name' => 'new_username', 'value' => set_value('new_username', $this->co->user['username']), 'size' => 60, 'disabled' => 'disabled' ) ); ?></p><br>

		<p></p>

		<button type="submit" class="grey xlarge disabled-button"><p class="text-small">You do not have a blank passport and $100,000 to change your username</p></button>

		<div class="back"><a href="<?php echo base_url(); ?>preferences" rel="ajax">Go back</a></div>
	</div>
</form>