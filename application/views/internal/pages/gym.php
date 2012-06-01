<h3 class="stylish"><?php if($this->co->user['jail'] > now()) { echo 'Jail '; } ?>Gym
	<span><a href="<?php echo base_url(); ?>help/faq?item=gym" rel="ajax">Learn more about the gym</a></span>
</h3>
<?php $i = $this->co->__compare_all_stats(); ?>

<?php if($this->co->user['jail'] > now()) : ?>
	<p>You see an area in the jail which states that you can use it for training but the equipment appears to be very rusty and old.</p>
<?php else: ?>
	<p>You walk into your local gym and look to improve your personal stats. You see options below as to what you can work out on.</p>
<?php endif; ?>
<br />
<?php echo form_open( base_url() . 'gym', array( 'rel' => 'form-ajax-hidden', 'id' => 'gym' )) ?>
<?php echo form_hidden('__unique__', $this->co->get_session()); ?>
<div class="prefix_1 grid_2 omega" style="border-top:2px #AAA solid; border-bottom:2px #AAA solid; width:22%; margin:5px 0; height:45px; padding-top:0px;<?php if($this->co->user['energy'] < 10): ?>opacity:0.2;filter:alpha(opacity=20);<?php endif; ?>">
<h2 style='font-size:26px;'>
<label><?php echo form_radio(array_merge( array( 'rel' => ($this->co->user['is_ajax'] ? 'gym-workout' : ''), 'name' => 'on', 'value' => 'strength', 'checked' => ($this->co->storage['radio'] == 'strength' && $this->co->user['energy'] > 9 ? TRUE : FALSE) ), ( $this->co->user['energy'] < 10 ? array('disabled' => TRUE) : array() ))); ?>
 <span style='font-family:arimo,arial; font-size:20px;'>FORCE</span></label></h2>
</div>
<div class="suffix_1 grid_7 alpha" style="border-top:2px #AAA solid; border-bottom:2px #AAA solid; width:57%; margin:5px 0; height:45px;<?php if($this->co->user['energy'] < 10): ?>opacity:0.2;filter:alpha(opacity=20);<?php endif; ?>">
<p style='height:35px;'>
<span style='float:left; padding:10px 0 0 10px;'>Current: <?php echo number_format($this->co->user['strength'], 4); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sp">Ranked #<?php echo number_format((double) $i['strength']); ?></span></span>
<span style='float:right; padding:10px 10px 0 0;'>One workout uses: <b>10 power</b> <font style='color:#777;'>(<?php echo round((10/$this->co->user['maxenergy'])*100) . '%'; ?>)</font></span>
</p>
</div>

<br />
<br />
<div class="clear"></div>

<div class="prefix_1 grid_2 omega" style="border-bottom:2px #AAA solid; width:22%; margin:5px 0; height:45px; padding-top:0px;<?php if($this->co->user['energy'] < 6): ?>opacity:0.2;filter:alpha(opacity=20);<?php endif; ?>">
<h2 style='font-size:26px;'>
<label><?php echo form_radio(array_merge( array( 'rel' => ($this->co->user['is_ajax'] ? 'gym-workout' : ''), 'name' => 'on', 'value' => 'agility', 'checked' => ($this->co->storage['radio'] == 'agility' ? TRUE : FALSE) ), ( $this->co->user['energy'] < 6 ? array('disabled' => TRUE) : array() ))); ?>
 <span style='font-family:arimo,arial; font-size:20px;'>SPEED</span></label></h2>
</div>
<div class="suffix_1 grid_7 alpha" style="border-bottom:2px #AAA solid; width:57%; margin:5px 0; height:45px;<?php if($this->co->user['energy'] < 6): ?>opacity:0.2;filter:alpha(opacity=20);<?php endif; ?>">
<p style='height:35px;'>
<span style='float:left; padding:10px 0 0 10px;'>Current: <?php echo number_format($this->co->user['agility'], 4); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sp">Ranked #<?php echo number_format((double) $i['agility']); ?></span></span>
<span style='float:right; padding:10px 10px 0 0;'>One workout uses: <b>6 power</b> <font style='color:#777;'>(<?php echo round((6/$this->co->user['maxenergy'])*100) . '%'; ?>)</font></span>
</p>
</div>

<br />
<br />
<div class="clear"></div>

<div class="prefix_1 grid_2 omega" style="border-bottom:2px #AAA solid; width:22%; margin:5px 0; height:45px; padding-top:0px;<?php if($this->co->user['energy'] < 5): ?>opacity:0.2;filter:alpha(opacity=20);<?php endif; ?>">
<h2 style='font-size:26px;'>
<label><?php echo form_radio(array_merge( array( 'rel' => ($this->co->user['is_ajax'] ? 'gym-workout' : ''), 'name' => 'on', 'value' => 'guard', 'checked' => ($this->co->storage['radio'] == 'guard' ? TRUE : FALSE) ), ( $this->co->user['energy'] < 5 ? array('disabled' => TRUE) : array() ))); ?>
 <span style='font-family:arimo,arial; font-size:20px;'>DEFENCE</span></label></h2>
</div>
<div class="suffix_1 grid_7 alpha" style="border-bottom:2px #AAA solid; width:57%; margin:5px 0; height:45px;<?php if($this->co->user['energy'] < 5): ?>opacity:0.2;filter:alpha(opacity=20);<?php endif; ?>">
<p style='height:35px;'>
<span style='float:left; padding:10px 0 0 10px;'>Current: <?php echo number_format($this->co->user['guard'], 4); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sp">Ranked #<?php echo number_format((double) $i['guard']); ?></span></span>
<span style='float:right; padding:10px 10px 0 0;'>One workout uses: <b>5 power</b> <font style='color:#777;'>(<?php echo round((5/$this->co->user['maxenergy'])*100) . '%'; ?>)</font></span>
</p>
</div>

<br />
<br />
<div class="clear"></div>


<div class="prefix_1 grid_2 omega" style="border-bottom:2px #AAA solid; width:22%; margin:5px 0; height:45px; padding-top:0px;<?php if($this->co->user['energy'] < 3): ?>opacity:0.2;filter:alpha(opacity=20);<?php endif; ?>">
<h2 style='font-size:26px;'>
<label><?php echo form_radio(array_merge( array( 'rel' => ($this->co->user['is_ajax'] ? 'gym-workout' : ''), 'name' => 'on', 'value' => 'labour', 'checked' => ($this->co->storage['radio'] == 'labour' ? TRUE : FALSE) ), ( $this->co->user['energy'] < 3 ? array('disabled' => TRUE) : array() ))); ?>
 <span style='font-family:arimo,arial; font-size:20px;'>LABOUR</span></label></h2>
</div>
<div class="suffix_1 grid_7 alpha" style="border-bottom:2px #AAA solid; width:57%; margin:5px 0; height:45px;<?php if($this->co->user['energy'] < 3): ?>opacity:0.2;filter:alpha(opacity=20);<?php endif; ?>">
	<p style='height:35px;'>
		<span style='float:left; padding:10px 0 0 10px;'>Current: <?php echo number_format($this->co->user['labour'], 4); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sp">Ranked #<?php echo number_format((double) $i['labour']); ?></span></span>
		<span style='float:right; padding:10px 10px 0 0;'>One workout uses: <b>3 power</b> <font style='color:#777;'>(<?php echo round((3/$this->co->user['maxenergy'])*100) . '%'; ?>)</font></span>
	</p>
</div>

<div class="clear"></div>
<br />

<?php if($this->co->user['energy'] < 3): ?>
	<?php echo ($this->co->user['is_ajax'] ? '<noscript>' : ''); ?>
		<p class='text-xsmall center'><b>Sorry, you do not have enough power to do any workouts.</b></p>
	<?php echo ($this->co->user['is_ajax'] ? '</noscript>' : ''); ?>
<?php else: ?>
	<?php echo ($this->co->user['is_ajax'] ? '<noscript>' : ''); ?>
		<div class="center">
			<p>
				<button type="submit" class="dark-grey medium"><span>Work out at the gym!</span></button>
			</p>
		</div>
	<?php echo ($this->co->user['is_ajax'] ? '</noscript>' : ''); ?>
</form>

<?php endif; ?>