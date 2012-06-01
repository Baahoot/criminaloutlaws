<?php 
	$ir = $this->co->user;
	$r = $this->co->storage['u'];
	$equips = $this->co->storage['equips'];
?>

<br />

<meta http-equiv="refresh" content="300; url=<?php echo base_url() . 'home'; ?>" />

<div class="grid_8 alpha omega" style="width:64%; margin-right:1%; height:400px;">
	<div class="grid_3  alpha omega right" style="width:48.5%;">
		<h3 class='right' style='padding:6px 5px 6px 0;'><?php echo $ir['username']; ?> [<?php echo $ir['userid']; ?>]</h3>
		<img src="<?php echo $this->co->base() . '/userbars/health.png'; ?>" width="<?php echo (($ir['hp'] / $ir['maxhp']) * 100) . '%'; ?>" height="15" /><img src="<?php echo $this->co->base() . '/userbars/red.png'; ?>" width="<?php echo 100 - (($ir['hp'] / $ir['maxhp']) * 100) . '%'; ?>" height="15" />
		<p class='text-xxsmall left'>Total damage received by opponent: <?php echo number_format( $r['atk_stats']['total_damage_received'] ); ?></p>
	</div>
	
	<div class="grid_1 alpha omega" style="width:5%; padding-top:6px;"><h3 class='center' style='padding:0;'><font style='font-family:courier new; font-size:18px; font-weight:normal; position:relative; top:-3px; background:#444; color:#ccc; padding:0px 3px;'>vs</font></h3>&nbsp;</div>
	
	<div class="grid_3  alpha omega left" style="width:46.5%;">
		<h3 class='left' style='padding:6px 0px 6px 5px;'><?php echo $r['username']; ?> [<?php echo $r['userid']; ?>]</h3>
		<img src="<?php echo $this->co->base() . '/userbars/happiness.png'; ?>" width="<?php echo ($r['hp'] / $r['maxhp']) * 100 . '%'; ?>" height="15" /><img src="<?php echo $this->co->base() . '/userbars/red.png'; ?>" width="<?php echo 100 - (($r['hp'] / $r['maxhp']) * 100) . '%'; ?>" height="15" />
		<p class='text-xxsmall right'>Total damage to opponent: <?php echo number_format( $r['atk_stats']['total_damage_given'] ); ?></p>
	</div>
	
	<div class="clear"></div>
	
	<?php if($this->co->storage['commentary'] != ''): ?>
		<br /><br /><br /><br />
	
		<div class='center'>
			<span style='font-family:arial; font-size:13px; padding:10px 15px; background:#FAF6DE;'><?php echo $this->co->storage['commentary']; ?></span>
		</div>
	<?php endif; ?>
	
	<div class="clear"></div>
	
	<div class='center' style='position:absolute; bottom:0; width:98%; padding:5px 1%; background:#aaa;'>
	
		<?php if( $this->co->storage['attack_result'] == 'won' ): ?>
			<center>
				<p class='text-xxsmall'><b>You won the fight against <?php echo $r['username']; ?>. What do you want to do?</b></p>
				<a href="<?php echo base_url() . 'attack/session?data='.$this->co->storage['id'].'&action=mug'; ?>" rel="ajax"><button onclick="$(this).addClass('disabled-button'); $('#hidden').show();" class="grey" style="font-size:12px;">Mug them</button></a>
				<a href="<?php echo base_url() . 'attack/session?data='.$this->co->storage['id'].'&action=hospitalize'; ?>" rel="ajax"><button onclick="$(this).addClass('disabled-button'); $('#hidden').show();" class="grey" style="font-size:12px;">Hospitalize them</button></a>
				<a href="<?php echo base_url() . 'attack/session?data='.$this->co->storage['id'].'&action=leave'; ?>" rel="ajax"><button onclick="$(this).addClass('disabled-button'); $('#hidden').show();" class="grey" style="font-size:12px;">Leave them</button></a>
			</center>
		<?php endif; ?>
	
		<?php if( $this->co->storage['attack_result'] == 'lost' || $this->co->storage['attack_result'] == 'complete'): ?>
			<center>
				<a href="<?php echo base_url() . 'home'; ?>" rel="ajax"><button class="grey" style="font-size:12px;">Continue</button></a>
			</center>
		<?php endif; ?>
	
		<?php if( is_array( $equips['me_primary'] ) && $this->co->storage['attack_result'] == 'null' ): ?>
			<a href="<?php echo base_url() . 'attack/session?data=' . $this->co->storage['id']. '&with=primary&step=' . (is_numeric($this->input->get('step')) ? $this->input->get('step') + 1 : 2); ?>" rel="ajax"><button onclick="$(this).addClass('disabled-button'); $('#hidden').show();" class="dark-grey" style="float:left; font-size:12px;">Attack with <?php echo $equips['me_primary']['itmname']; ?></button></a>
		<?php endif; ?>
		
		<?php if( is_array( $equips['me_secondary'] ) && $this->co->storage['attack_result'] == 'null' ): ?>
			<a href="<?php echo base_url() . 'attack/session?data=' . $this->co->storage['id'] . '&with=secondary&step=' . (is_numeric($this->input->get('step')) ? $this->input->get('step') + 1 : 2); ?>" rel="ajax"><button onclick="$(this).addClass('disabled-button'); $('#hidden').show();" class="dark-grey" style="float:left; font-size:12px;">Attack with <?php echo $equips['me_secondary']['itmname']; ?></button></a>
		<?php endif; ?>
		
		<?php if( ! is_array($equips['me_primary']) && ! is_array($equips['me_secondary']) && ! isset($this->co->storage['attack_result']) ): ?>
			<a href="<?php echo base_url() . 'attack/session?data=' . $this->co->storage['id'] . '&with=fists&step=' . (is_numeric($this->input->get('step')) ? $this->input->get('step') + 1 : 2); ?>" rel="ajax"><button onclick="$(this).addClass('disabled-button'); $('#hidden').show();" class="tan" style="float:left; font-size:12px;">Attack with fists</button></a>
		<?php endif; ?>
	
	</div>
	
</div>

<div class="grid_4 alpha omega" style="width:35%; height:400px;">
		
		<div style='background:#eee; padding:5px 10px;'>
		
			<h4 style='font-size:14px; padding:4px 0px; font-weight:bold;'>Attack History</h4>
			<div style='overflow:auto; font-family:arial; font-size:11px; color:#777; height:361px;'>
				<?php $r['atk_log'] = array_reverse($r['atk_log']); ?>
					<ul style='margin:0; padding:0;'><?php foreach($r['atk_log'] as $log): ?>
						<li style='margin:0px; padding:0; white-space:nowrap; list-style-type: upper-alpha;'><?php echo $log; ?></li>
						<?php endforeach; ?>
					</ul>
			</div>	
	
		</div>
	
</div>

<div class="clear"></div>

<br />

<p class='center'><span style='color:#444; font-size:12px; font-weight:bold; padding:3px 5px; background:#AAA;'>NB: If you refresh the page, you will automatically forfeit your fight and the opponent wins. Losing a fight will mean you lose XP which is used to help you level up.</span></p>

<div style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;" id="hidden">&nbsp;</div>