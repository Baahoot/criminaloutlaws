<?php
if(!$this->input->is_ajax_request() || !$this->input->post('action')) {
	$ir = $this->co->__internal_user();
?><h3 class="stylish"><?php echo $this->co->user['username']; ?>'s Home</h3>
<br />
<div class="grid_6 alpha omega" style="width:50%;">
	<h5>General Info</h5>
	
	<p style='padding:1px 0 1px 10px;'><b>Username: </b> <?php echo $this->co->user['username']; ?></p>
	<p style='padding:1px 0 1px 10px;'><b>Type: </b> <?php echo $ir['type']; ?></p>
	<p style='padding:1px 0 1px 10px;'><b>Gold: </b> <?php echo $ir['crystals']; ?></p>
	<p style='padding:1px 0 1px 10px;'><b>Level: </b> <?php echo $ir['level']; ?></p>
	<p style='padding:1px 0 1px 10px;'><b>Money: </b> <?php echo $ir['money']; ?></p>
	<p style='padding:1px 0 1px 10px;'><b>HP: </b> <?php echo round(($this->co->user['hp']/$this->co->user['maxhp'])*100, 2) . '%'; ?></p>
	<p style='padding:1px 0 1px 10px;'><b>Current Property: </b> <?php echo $this->co->user['hNAME']; ?> (Cost: <?php echo '$' . number_format($this->co->user['hPRICE']); ?>)</p>
	<p style='padding:1px 0 1px 10px;'><b>Location: </b> <?php echo $this->co->user['cityname']; ?></p>
</div>

<?php $i = $this->co->__compare_all_stats(); ?>

<div class="grid_6 alpha omega" style="width:50%;">
	<h5>Stats Info <!-- span><a href='<?php echo base_url(); ?>help/faq?item=statistics' rel='ajax'>Learn more</a></span --></h5>
	<p style='padding:3px 0 3px 10px;'><b>Force: </b> <?php echo number_format($this->co->user['strength'], 4); ?> <span class="sp">Ranked #<?php echo number_format((double) $i['strength']); ?></span></p>
	<p style='padding:3px 0 3px 10px;'><b>Speed: </b> <?php echo number_format($this->co->user['agility'], 4); ?> <span class="sp">Ranked #<?php echo number_format((double) $i['agility']); ?></span></p>
	<p style='padding:3px 0 3px 10px;'><b>Defence: </b> <?php echo number_format($this->co->user['guard'], 4); ?> <span class="sp">Ranked #<?php echo number_format((double) $i['guard']); ?></span></p>
	<p style='padding:3px 0 3px 10px;'><b>Labour: </b> <?php echo number_format($this->co->user['labour'], 4); ?> <span class="sp">Ranked #<?php echo number_format((double) $i['labour']); ?></span></p>
	<p style='padding:3px 0 3px 10px;'><b>Intelligence: </b> <?php echo number_format($this->co->user['IQ'], 4); ?> <span class="sp">Ranked #<?php echo number_format((double) $i['IQ']); ?></span></p>
	<p style='padding:3px 0 3px 10px;'><b>Total Stats: </b> <?php echo number_format($this->co->user['strength'] + $this->co->user['agility'] + $this->co->user['guard'] + $this->co->user['labour'] + $this->co->user['IQ'], 4); ?> <span class="sp">Ranked #<?php echo number_format((double) $i['total']); ?></span></p>
</div>

<div class="clear"></div>

<div class="prefix_1 grid_6 alpha omega hr" id="user-notepad-html" style="width:75%;"> <?php } ?><br />
	<h5>Your Notepad</h5>
		<?php
		if($this->co->storage['notepad_purchased'] == 0) {
			
			if($this->co->user['money'] > $this->co->storage['notepad_cost']) { ?>
				<p class="center">To use the notepad feature, you need to first buy a notepad at a one-time cost of $<?php echo $this->co->storage['notepad_cost']; ?>.<br />
				<a href='<?php echo base_url(); ?>home?buy=notepad' rel='ajax' class='link'><button class="dark-grey">Click here to buy a notepad for $<?php echo $this->co->storage['notepad_cost']; ?></button>.</a></p>
			<?php } else { ?>
			<p class="center">You need to buy a notepad to use this feature. You'll need $<?php echo number_format($this->co->storage['notepad_cost'] - $this->co->user['money'], 2); ?> more to buy one!</p>
			<?php } ?>
			
		<?php } else { ?>
		
		<?php echo form_open( base_url() . 'home', array( 'rel' => 'user-notepad' )) ?>
			<?php echo form_hidden('action', $this->co->get_session()); ?>
			<!-- DISABLE_ONCE -->
			<textarea rel='resize' name='notepad'><?php echo $this->co->storage['notepad']; ?></textarea>
			<div class="right">
				<span class="small"><?php echo $this->co->storage['updated']; ?></span><button type="submit" class="grey medium" rel="notepad-update"><span>Save Notepad</span></button>
			</div>
		</form> <?php } if(!$this->input->is_ajax_request() || !$this->input->post('action')) { ?>
	</div>
	
	<?php } ?>