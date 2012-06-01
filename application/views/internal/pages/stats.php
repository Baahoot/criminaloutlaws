<?php $stats = $this->co->storage['stats']; ?><h3 class="stylish">Criminal Outlaws Statistics</h3>
<p>You make a quick visit outside the Mayor's Office and see a bunch of statistics available in the statistics room.</p>
<br />

<table width="100%" border="0" class="table">

	<tr class="heading">
		<th width='50%'>Players</th>
		<th>Finance</th>
	</tr>
	
	<tr class="row odd row-end" style="line-height:30px;">
		<td valign="top" class="row-left row-end">
		<b>Total Users:</b> <?php echo number_format($stats['ttlusers']); ?><br />
		<b>Male/Female Users:</b> <?php echo number_format($stats['maleusers']); ?> male (<?php echo ($stats['m_perc']); ?>%) and <?php echo number_format($stats['femaleusers']); ?> female (<?php echo ($stats['f_perc']); ?>%)<br />
		<b>Users Online:</b> <?php echo number_format($stats['onusers']); ?><br />
		<b>Active Users:</b> <?php echo number_format($stats['activeusers']); ?><br />
		<b>Facebook Accounts Connected:</b> <?php echo number_format($stats['fbusers']); ?> (<?php echo $stats['fb_perc']; ?>%)
		</td>
		
		<td style="vertical-align:top;" class="row-right">
			<b>Avg money per user:</b> $<?php echo number_format($stats['avgmoney'][0]['avgmoney']); ?><br />
			<b>Total GDP:</b> $<?php echo number_format($stats['avgmoney'][0]['ttlmoney']); ?><br />
			<?php if($stats['avgbkmoney'][0]['cnt'] > 0): ?><b>Avg money in banks per user:</b> $<?php echo number_format($stats['avgbkmoney'][0]['avgbkmoney']); ?><br />
			<b>Users with bank accounts:</b> <?php echo number_format($stats['avgbkmoney'][0]['cnt']); ?><?php endif; ?>
		</td>
	</tr>
	
	<tr class="row-spacer"><td></td></tr>
	
	<tr class="heading">
		<th>Items</th>
		<th>Gold</th>
	</tr>
	
	<tr class="row odd row-end" style="line-height:30px;">
		<td style="vertical-align:top;" class="row-left">
			<b>Total Items in circulation:</b> <?php echo number_format($stats['ttlitems']); ?><br />
		</td>
		<td style="vertical-align:top;" class="row-right">
			<b>Avg gold per user:</b> <?php echo number_format($stats['avgmoney'][0]['avgcrystals']); ?><br />
			<b>Total gold in circulation:</b> <?php echo number_format($stats['avgmoney'][0]['ttlcrystals']); ?><br />
		</td>
	</tr>
	
	<tr class="row-spacer"><td></td></tr>
	
	<tr class="heading">
		<th>Pro Users</th>
		<th>Mail/Events</th>
	</tr>
	
	<tr class="row odd row-end" style="line-height:30px;" class="row-left">
		<td style="vertical-align:top;" class="row-left">
			<b>Total Pro users:</b> <?php echo number_format($stats['ttlpro']); ?><br />
		</td>
		<td style="vertical-align:top;" class="row-right">
			<b>Total mail stored:</b> <?php echo number_format($stats['ttlmail']); ?><br />
			<b>Total events stored:</b> <?php echo number_format($stats['ttlevents']); ?><br />
		</td>
	</tr>

</table>