<?php
	$ir = $this->co->user;
	$r = $this->co->storage['profile'];
	
	$referrals = $this->db->select('*')->from('referrals')->where('ref_referer', $r['userid'])->count_all_results();
	
	$username = $r['username'];
	if($r['user_level'] > 1) {
		$uldata = array();
		foreach($this->co->userlevels as $i => $m) { if($m['ul_userlevel'] == $r['user_level']) { $uldata = $m; break; } }
		$username = '<font style="color:#'.$uldata['ul_color'].';	">' . $username . '</font>';
	}
	
	if($r['hospital'] >= now()) {
		$mins = round(abs($r['hospital'] - now()) / 60); 
		$status = "<font color='#103440' style='background:#BDE3F0;'>Hospitalized for {$mins} minutes</font>";
	} else if($r['jail'] >= now()) {
		$mins = round(abs($r['jail'] - now()) / 60); 
		$status = "<font color='#1F1404' style='background:#F0DBBD;'>Jailed for {$mins} minutes</font>";
	} else {
		$status = "Normal";
	}
	
	$added_to_cl = FALSE;
	if($this->db->select('*')->from('contactlist')->where('cl_ADDER', $ir['userid'])->where('cl_ADDED', $r['userid'])->limit(1)->count_all_results() > 0) {
		$added_to_cl = TRUE;
	}
	
	//$username .= ' ['.$r['userid'].']';
?>
<div class="grid_10 alpha omega">

	<div style="width:75px; text-align:right; float:right;">
		<img src="<?php if($r['display_pic']): echo $this->config->item('cdn_user_url') . $r['display_pic']; else: ?><?php $this->co->base(); ?>/images/default-profile-pic.png<?php endif; ?>" width="150" height="550" style="max-width:75px; max-height:75px;" />
	</div>

	<div style='height:400px;'>
		<div style='float:left; padding-top:2px; padding-right:20px; position:relative; top:5px;'><?php echo $this->co->username_format($r, TRUE, 2); ?></div>
			<div style="margin-left:10px; height:40px;">
	
				<h3 class="stylish" style='display:inline; text-shadow:none;'>
					<font style='float:right; padding-right:20px;'><?php echo $this->co->get_badges($r); ?></font>
					<span style='float:left;'><?php echo $username; ?></span>
					<?php if($r['donator'] >= now()): ?><span class="pro" style="float:left; position:relative;top:6px; margin-left:5px; padding:4px 10px; font-size:12px;" title="<?php echo $r['username']; ?> currently has a PRO Outlaw membership">PRO</span><?php endif; ?>
				</h3>

			</div>
	
		<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td width="45%" valign="top">
				
					<div class="grid_4" style="width:99%; margin-top:25px;">
						<table width='100%' border='0' class='table'><tr class='heading'><th>Account Information</th></tr></table>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Age:</b> <?php echo number_format($this->co->days_elapsed($r['signedup'])); ?> days</p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Status:</b> <?php echo $status; ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Member Type:</b> <?php if($r['user_level'] > 1) { echo '<font style="color:#'.$uldata['ul_color'].';	">' . $uldata['ul_single'] . '</font>'; } else { echo 'Player'; } ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Duties:</b> <?php echo ($r['user_duties'] ? $r['user_duties'] : 'N/A'); ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Gender:</b> <?php echo ($r['gender']); ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Health:</b> <?php echo round(($r['hp'] / $r['maxhp']) * 100, 2) . '%'; ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Last Seen:</b> <?php if($r['laston'] <= now()-60*60*24): echo unix_to_human($r['laston']); elseif($r['laston']): echo strtolower(timespan($r['laston'], now())) . ' ago'; else: ?>N/A<?php endif; ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Last Session:</b> <?php echo ($r['last_login'] > 0 ? strtolower(timespan(now() - $r['laston'], now() - $r['last_login'])) : 'N/A'); ?></p>
					</div>
		
		</td>		<td width="44%" valign="top">
	
					<div class="grid_3" style="width:99%; margin-top:25px;">
						<table width='100%' border='0' cellpadding='0' cellspacing='0' class='table'><tr class='heading'><th>Player Stats</th></tr></table>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Level:</b> <?php echo number_format($r['level']); ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Money:</b> <?php echo '$' . number_format($r['money'], 2); ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Gold:</b> <?php echo number_format($r['crystals']); ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Property:</b> <?php echo ($r['hNAME']); ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Location:</b> <?php echo ($r['cityname']); ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Referrals:</b> <?php echo number_format($referrals); ?></p>
							<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Employment:</b> <?php echo ($r['jobrank'] > 0 ? $r['rank_name'] . ' (at '.$r['job_name'].')' : 'Unemployed' ); ?></p>
						<p style="line-height:28px; padding:1px 0 1px 10px;"><b>Gang:</b> None</p>
					</div>
		
				</td>
			</tr>
		</table>

	</div>

	</div>
	
	
	<?php if($r['userid'] != $ir['userid']): ?>
	
	<div class="grid_10">
	
		<div class="center" style="position:relative; padding:10px; background:#BBB; height:31px;">
		
			<a style="float:left;" <?php echo ($ir['money'] < 1 || $r['jail'] >= now() || $r['hospital'] >= now() || $ir['hospital'] >= now() || $ir['jail'] >= now() ? 'x' : ''); ?>href="<?php echo base_url(); ?>send/money?username=<?php echo $r['username']; ?>" rel="ajax"><button class="grey xsmall<?php echo ($ir['money'] < 1 || $r['jail'] >= now() || $r['hospital'] >= now() || $ir['hospital'] >= now() || $ir['jail'] >= now() ? ' disabled-button' : ''); ?>" style="padding-right:5px;">Send Money</button></a>
	
			<a style="float:left;" <?php echo ($ir['crystals'] < 1 || $r['jail'] >= now() || $r['hospital'] >= now() || $ir['hospital'] >= now() || $ir['jail'] >= now() ? 'x' : ''); ?>href="<?php echo base_url(); ?>send/gold?username=<?php echo $r['username']; ?>" rel="ajax"><button class="grey xsmall<?php echo ($ir['crystals'] < 1 || $r['jail'] >= now() || $r['hospital'] >= now() || $ir['hospital'] >= now() || $ir['jail'] >= now() ? ' disabled-button' : ''); ?>" style="padding-right:5px;">Send Gold</button></a>
	
			<a style="float:right;" <?php echo ($r['location'] != $ir['location'] || $r['jail'] >= now() || $r['hospital'] >= now() || $ir['hospital'] >= now() || $ir['jail'] >= now() ? 'x' : ''); ?>href="<?php echo base_url(); ?>attack/begin?username=<?php echo $r['username']; ?>&__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="dark-grey xsmall<?php echo ($r['location'] != $ir['location'] || $r['jail'] >= now() || $r['hospital'] >= now() || $ir['hospital'] >= now() || $ir['jail'] >= now() ? ' disabled-button' : ''); ?>" style="padding-right:5px;">Attack <?php echo $r['username']; ?></button></a>
	
			<a style="float:left; " href="<?php echo base_url(); ?>inbox/create?to=<?php echo $r['username']; ?>" rel="ajax"><button class="grey xsmall" style="padding-right:5px;">Send Message</button></a>
	
			<?php if($ir['jail'] < now() && $ir['hospital'] < now() && $ir['donator'] >= now()): ?><a style="float:left;" href="<?php echo base_url(); ?>contacts/<?php echo (!$added_to_cl ? 'create' : 'remove'); ?>?user=<?php echo $r['username']; ?>&__unique__=<?php echo $this->co->get_session(); ?><?php echo ($added_to_cl ? '&profile=1' : ''); ?>" rel="manage-contact"><button class="grey xsmall"><?php echo ($added_to_cl ? 'Remove' : 'Add'); ?> Contact</button></a><?php endif; ?>

		</div>
	
	</div>

	<?php endif; ?>

	<div class="clear"></div>

	<?php if($r['signature']): ?><br />

	<div class="grid_10">
		<table width='100%' class='table'>
			<tr class='heading'><th>Signature</th></tr>
	
			<tr class='row'>
				<td style='padding:0;'>
					<div class="center" style="margin:0px; background:#ccc; padding:10px; font-size:12px; font-family:verdana;">
						<?php echo $this->co->parse_bbcode( $r['signature'] ); ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
	
	<br /><br />
	
	<?php endif; ?>