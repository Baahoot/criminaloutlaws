<?php $ir = $this->co->__internal_user(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php if($this->input->server('HTTP_HOST') != 'game.ssl.dotcloud.com'): ?>
      xmlns:fb="http://www.facebook.com/2008/fbml"<?php endif; ?>>
<head>
		<title><?php $this->co->get('title'); ?></title>
		
		<?php /* <!-- CO_API: NEXT_UPDATE: <?php echo 'in ' . $this->co->config['next_update'] . ' seconds'; ?> --> */ ?>
		
		<!-- Styles -->
		<style type="text/css">
			@import "<?php $this->co->base(); ?>/styles/core.css?0";
			@import "<?php $this->co->base(); ?>/styles/central.css?0";
			@import "<?php $this->co->base(); ?>/styles/formats/1200.min.css?0";
			@import "http://fonts.googleapis.com/css?family=Questrial|Arimo";
		</style>

</head>
<body style="<?php if($this->co->user['hospital'] > now()): ?>background:#B3C2C9;<?php elseif($this->co->user['jail'] > now()): ?>background:#CFCDBA; <?php else: ?>background:#EEE;<?php endif; ?>">

<?php $n = $this->co->get_notice(); if(isset($n) && $n != ""): ?>
	<div class="app-notice">
		<span><?php echo $n; ?></span>
	</div>
	<noscript>
		<div class="app-notice" style="display:block;">
		 	<span><?php echo $n; ?> <a href='' style='font-size:10px;'>Close</a></span>
		</div>
	</noscript>
<?php endif; ?>

<!-- Entire layer -->
<div class="container_12">

	<?php if($this->co->user['hospital'] > now()): ?>
	
	<div class="grid_12 alpha omega header" style="width:100%; background:url(<?php echo $this->co->base() . '/backgrounds/hospital.jpg'; ?>) center center;">

			<div class="right">
				<a href="<?php echo base_url(); ?>home" rel="ajax"><h1 id="white-in-logo" style="width:100%; background-position:center center;"><span>Criminal Outlaws</span></h1></a>
			</div>
			
	</div>
	
	<?php elseif($this->co->user['jail'] > now()): ?>
	
	<div class="grid_12 alpha omega header" style="width:100%; background:url(<?php echo $this->co->base() . '/backgrounds/jail.png'; ?>) top center;">

			<div class="right">
				<a href="<?php echo base_url(); ?>home" rel="ajax"><h1 id="white-in-logo" style="width:100%; background-position:center center;"><span>Criminal Outlaws</span></h1></a>
			</div>
			
	</div> <?php else: ?>
	
	<div class="grid_12 alpha omega header" style="width:100%; margin:0; height:75px; border-bottom:1px solid #ddd; background:#eee;">
	
			<div style="width:275px; margin-top:-5px;">
				<a <?php echo (@$this->co->storage['attack'] == 0 ? '' : 'x'); ?>href="<?php echo base_url(); ?>home" rel="ajax"><h1 id="black-in-logo"><span>Criminal Outlaws</span></h1></a>
			</div>
		
	</div>
	
	<div class="grid_12 alpha omega header" style="width:50%; background:transparent; height:10px; position:relative; margin-top:-20px; top:-60px; padding:4px 0 4px 50%; text-align:right;">
		<?php
			/* $list = array();
			
			if($ir['donatordays'] > 0) {
				$list[] = '<p class="text-xsmall right" style="font-family:arial; color:#DDD; padding:0 10px;"><a href="' . base_url() . 'vote" rel="ajax">Vote for Criminal Outlaws &mdash; and earn some nice free prizes!</a></p>';
			}
			
			$list[] = '<p class="text-xsmall right" style="font-family:arial; color:#DDD; padding:0 10px;"><a href="' . base_url() . 'pro" rel="ajax">Become a Pro Outlaw and gain additional benefits from the game!</a></p>';
			
			echo $list[ array_rand($list) ]; */
		?>
		
		<?php if(@$this->co->storage['attack'] == 0): ?>
		
		<!-- div><form action='<?php echo base_url() . 'search'; ?>' rel='form-ajax'><input type='text' name='q' id='query' value='' autocomplete='off' rel='search' style='font-family: arial; font-size:12px; opacity:0.5; filter:alpha(opacity=50); color:#111;' /><input type='submit' value='Search' style='margin:0 10px; font-family:12px; font-family:arial; padding:2px 4px; background:#888; border:1px #555 solid; color:#fff; position:relative; top:-1px;' /></form></div -->
		
		<!-- p class="text-xsmall right" style="font-family:arial; color:#DDD; padding:5px 13px 0; color:#333; font-size:12px !important;"><a href="<?php echo base_url() . 'vote'; ?>" rel="ajax">Vote for Criminal Outlaws</a> <font style='color:#999;'>//</font> <a href="<?php echo  base_url() . 'pro'; ?>" rel="ajax">Become a Pro Outlaw</a></p -->
		
			<!-- div class="grid_1 alpha">
				<a href="<?php echo base_url() . 'events'; ?>" rel="ajax"><img src="<?php echo $this->co->base(1) . '/images/Calendar.png'; ?>" style="max-width:75px;" />
				<p style="margin:0;padding:0;font-size:12px; position:relative; top:-80px; left:4px; font-family:arial; text-align:center;"><span class="notificat" id="event_count" style="background:#394813; color:white; font-size:11px;<?php echo ($this->co->user['new_events'] > 0 ? '' : ' display:none;'); ?>"><?php echo $this->co->user['new_events']; ?></span></p></a>
			</div>
			
			<div class="grid_1">
				<a href="<?php echo base_url() . 'inbox'; ?>" rel="ajax"><img src="<?php echo $this->co->base(1) . '/images/Mail.png'; ?>" style="max-width:75px;" />
				<p style="margin:0;padding:0;font-size:12px; position:relative; top:-80px; left:2px; font-family:arial; text-align:center;"><span class="notificat" id="mail_count" style="background:#394813; color:white; font-size:11px;<?php echo ($this->co->user['new_mail'] > 0 ? '' : ' display:none;'); ?>"><?php echo $this->co->user['new_mail']; ?></span></p></a>
			</div -->
			
			<div class="prefix_4 grid_1 alpha" style="width:17.5%; line-height:12px;">
				&nbsp;
				<font style="display:block; text-align:right; font-family:verdana, arial; letter-spacing:-1px; font-size:19px; color:#555;"><?php echo $ir['username']; ?></font><br />
				<font id='__internal_gold' style="text-transform:uppercase; line-height:10px; display:block; text-align:right; font-family:Courier New, arial; font-size:11px; color:#111;">LEVEL: <?php echo $ir['level']; ?></font>
				<font id='__internal_money' style="text-transform:uppercase; line-height:0px; text-align:right; font-family:Courier New, arial; font-size:11px; color:#111;">MONEY: <?php echo $ir['money']; ?></font><br />
				<font id='__internal_crystals' style="text-transform:uppercase; line-height:0px; text-align:right; font-family:Courier New, arial; font-size:11px; color:#111;">GOLD: <?php echo $ir['crystals']; ?></font><br />
			</div>
			
			<div class="grid_1 omega alpha" style="background:#fff; width:75px; height:75px; border-radius:2px;">
				<center>
					<a href="<?php echo base_url() . 'user/' . $this->co->user['username']; ?>" rel="ajax">
						<img src="<?php echo $this->config->item('cdn_user_url') . $this->co->user['display_pic']; ?>" style="border-radius:2px; max-width:75px; max-height:75px;" />
					</a>
				</center>
			</div>
	
	</div><?php endif; ?>
	
	<?php endif; ?>
	
	<!-- Left column -->
	
		<div class="box" style="<?php echo ($this->config->item('xp') > 1 ? 'margin:5px 10px 0;' : 'margin:0 10px;'); ?> padding:0;">
			<p class="ui-title" style="background:#222; padding:3px 8px; color:#FFF; font-family:Helvetica Neue, arial; font-size:12px; font-weight:bold;">Status Bars</p>
			<div style="padding:2px 5px; background:#EFEFEF; text-shadow:1px 1px #FAFAFA;">
				
				<p class='ui small-p' style='padding:10px 3px 5px; line-height:11px;'>
					Power: 
						<font id='__internal_power_value'><?php echo $ir['energy_value']; ?></font>	
						<span style='float:right; color:#888;' rel='time' id='__internal_power_time'><?php echo $ir['energy_time']; ?></span>
						
					<br />
					
					<img src="<?php echo $this->co->base() . '/userbars/force.png'; ?>" id="__internal_power_left" width="<?php echo $ir['energy_perc'] . '%'; ?>" height="7" /><img src="<?php echo $this->co->base() . '/userbars/red.png'; ?>" id="__internal_power_right" width="<?php echo 100 - $ir['energy_perc'] . '%'; ?>" height="7" /></span>
				</p>
				
				<p class='ui small-p' style='padding:0px 3px 5px; line-height:11px;'>
					Happy:
						<font id='__internal_happiness_value'><?php echo $ir['will_value']; ?></font>	
						<span style='float:right; color:#888;' rel='time' id='__internal_happiness_time'><?php echo $ir['will_time']; ?></span>
						
					<br />
					
					<img src="<?php echo $this->co->base() . '/userbars/happiness.png'; ?>" id="__internal_happiness_left" width="<?php echo $ir['will_perc'] . '%'; ?>" height="7" /><img src="<?php echo $this->co->base() . '/userbars/red.png'; ?>" id="__internal_happiness_right" width="<?php echo 100 - $ir['will_perc'] . '%'; ?>" height="7" />
				</p>
				
				<p class='ui small-p' style='padding:0px 3px 5px; line-height:11px;'>
					Nerve: 
						<font id='__internal_nerve_value'><?php echo $ir['brave_value']; ?></font>	
						<span style='float:right; color:#888;' rel='time' id='__internal_nerve_time'><?php echo $ir['brave_time']; ?></span>
						
					<br />
					
					<img src="<?php echo $this->co->base() . '/userbars/nerve.png'; ?>" id="__internal_nerve_left" width="<?php echo $ir['brave_perc'] . '%'; ?>" height="7" /><img src="<?php echo $this->co->base() . '/userbars/red.png'; ?>" id="__internal_nerve_right" width="<?php echo 100 - $ir['brave_perc'] . '%'; ?>" height="7" />
				</p>
				
				<p class='ui small-p' style='padding:0px 3px 5px; line-height:11px;'>
					Health: 
						<font id='__internal_health_value'><?php echo $ir['hp_value']; ?></font>	
						<span style='float:right; color:#888;' rel='time' id='__internal_health_time'><?php echo $ir['hp_time']; ?></span>
						
					<br />
					
					<img src="<?php echo $this->co->base() . '/userbars/health.png'; ?>" id="__internal_health_left" width="<?php echo $ir['hp_perc'] . '%'; ?>" height="7" /><img src="<?php echo $this->co->base() . '/userbars/red.png'; ?>" id="__internal_health_right" width="<?php echo 100 - $ir['hp_perc'] . '%'; ?>" height="7" />
				</p>
				
				<div class="left" id='__internal_badges' style='padding:10px 4px 0;'><?php echo $ir['badges']; ?></div>
			</div>
		</div>
		
		<div class="clear"></div>
		
		<div class="menu" style="margin:10px 10px 0; padding:0;">
			<p class="ui-title" style="background:#222; padding:3px 8px; color:#FFF; font-family:Helvetica Neue, arial; font-size:12px; font-weight:bold;">Account</p>
			<div style="position:relative; z-index:10; padding-top:1px;">
			
				<ul>
					<?php if($this->co->user['hospital'] < now() && $this->co->user['jail'] < now()): ?>
						<a href='<?php echo base_url(); ?>unlocks' rel='ajax'><li>Unlocks</li></a>
					<?php endif; ?>
					
					<a href='<?php echo base_url(); ?>events' rel='ajax'><li>Events (<font id='__internal_events'><?php echo $ir['events']; ?></font>)</li></a>
					<a href='<?php echo base_url(); ?>inbox' rel='ajax'><li>Inbox (<font id='__internal_mail'><?php echo $ir['mail']; ?></font>)</li></a>
				</ul>
			
			</div>
		</div>
				
		<div class="menu" style="margin:10px 10px 0; padding:0;">
			<p class="ui-title" style="background:#222; padding:3px 8px; color:#FFF; font-family:Helvetica Neue, arial; font-size:12px; font-weight:bold;"><?php echo ($this->co->user['jail'] > now() ? 'City Jail' : 'Places'); ?></p>
			<div style="padding:1px 0px; position:relative; z-index:10; height:363px;">

				<ul>
				<?php if($this->co->user['hospital'] > now()): ?>
				<a href='<?php echo base_url(); ?>hospital' id='__internal_hospital_alt' rel='ajax'><li>Hospital (<?php echo $ir['hospital_count']; ?>)</li></a>
				<a href='<?php echo base_url(); ?>inventory' rel='ajax'><li>My Inventory</li></a>
				<a href='<?php echo base_url(); ?>search' rel='ajax'><li>Search</li></a>
				<a href='<?php echo base_url(); ?>preferences' rel='ajax'><li>Preferences</li></a>
				<a href='<?php echo base_url(); ?>user/<?php echo $this->co->user['username']; ?>' rel='ajax'><li>My Profile</li></a>
				<a href='<?php echo base_url(); ?>home/logout?__session__=<?php echo $this->co->get_session(); ?>' rel='logout'><li>Logout</li></a>				
				<?php elseif($this->co->user['jail'] > now()): ?>
				<a href='<?php echo base_url(); ?>jail' id='__internal_jail_alt' rel='ajax'><li>Jail (<?php echo $ir['jail_count']; ?>)</li></a>
				<a href='<?php echo base_url(); ?>gym' rel='ajax'><li>Jail Gym</li></a>
				<a href='<?php echo base_url(); ?>search' rel='ajax'><li>Search</li></a>
				<a href='<?php echo base_url(); ?>preferences' rel='ajax'><li>Preferences</li></a>
				<a href='<?php echo base_url(); ?>user/<?php echo $this->co->user['username']; ?>' rel='ajax'><li>My Profile</li></a>
				<a href='<?php echo base_url(); ?>home/logout?__session__=<?php echo $this->co->get_session(); ?>' rel='logout'><li>Logout</li></a>
			<?php else: ?>
				<a href='<?php echo base_url(); ?>home' rel='ajax'><li>Home</li></a>
				<a href='<?php echo base_url(); ?>inventory' rel='ajax'><li>My Inventory</li></a>
				<a href='<?php echo base_url(); ?>explore' rel='ajax'><li>Explore</li></a>
				<a href='<?php echo base_url(); ?>gym' rel='ajax'><li>Gym</li></a>
				<a href='<?php echo base_url(); ?>crimes' rel='ajax'><li>Crimes</li></a>
				<a href='<?php echo base_url(); ?>search' rel='ajax'><li>Search</li></a>
				<a href='<?php echo base_url(); ?>job' rel='ajax'><li><?php echo ($this->co->user['jobrank'] > 0) ? 'Your Job' : 'Job Centre'; ?></li></a>
				<a href='<?php echo base_url(); ?>hospital' id='__internal_hospital_alt' rel='ajax'><li>Hospital (<?php echo $ir['hospital_count']; ?>)</li></a>
				<a href='<?php echo base_url(); ?>jail' id='__internal_jail_alt' rel='ajax'><li>Jail (<?php echo $ir['jail_count']; ?>)</li></a>
				
				<?php if($this->co->user['donator'] > now()): ?><a href='<?php echo base_url(); ?>contacts' rel='ajax'><li>Contact List (<?php echo number_format($this->co->user['contact_count']); ?>)</li></a><?php endif; ?>

				<a href='<?php echo base_url(); ?>preferences' rel='ajax'><li>Preferences</li></a>
				<a href='<?php echo base_url(); ?>user/<?php echo $this->co->user['username']; ?>' rel='ajax'><li>My Profile</li></a>
				<a href='<?php echo base_url(); ?>home/logout?__session__=<?php echo $this->co->get_session(); ?>' rel='logout'><li>Logout</li></a>
				<?php endif; ?>
				</ul>
			</div>
			
	</div><?php endif; ?>
</div>
	
	<div class="grid_<?php echo ( @$this->co->storage['attack'] == 0 ? '10' : '12'); ?> alpha omega inner" style="width:<?php echo (@$this->co->storage['attack'] == 0 ? '84.5' : '100'); ?>%;">
	<div class="content">