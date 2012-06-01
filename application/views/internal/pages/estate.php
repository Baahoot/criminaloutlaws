<h3 class="stylish">Real Estates
	<span><a href="<?php echo base_url(); ?>help/faq?item=houses" rel="ajax">Learn more about houses</a></span>
</h3>
<p>You go down to the big money area, and see a shop which sells properties that are available in the market.</p>
<br />
<?php
$ir = $this->co->user;
?>
<div class="center">

	<table width="100%" class="table" style="padding-left:25%; width:75%;">
		<tr class="row odd">
			<td><b>Current Property</b></td>
			<td><?php echo $ir['hNAME']; ?></td>
		</tr>
		<tr class="row odd">
			<td><b>Property Happiness</b></td>
			<td><?php echo number_format($ir['hWILL']); ?></td>
		</tr>
		<tr class="row odd">
			<td><b>Property Value</b></td>
			<td>+$<?php echo number_format($ir['hPRICE'], 2); ?></td>
		</tr>
		<?php if($ir['maxwill'] > 100): ?>
		<tr class="row odd">
			<td colspan="2" class="center"><a href="<?php echo base_url(); ?>estate/sell?__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax"><button class="dark-grey">Sell Property</button></a></td>
		</tr>
		<?php endif; ?>
	</table>
	
	<br />
	
	<table width="100%" class="table" style="padding-left:10%; width:90%;">
	<tr class="heading">
		<th width="30%">House Name</th>
		<th width="20%">Popularity</th>
		<th width="10%">Happiness</th>
		<th width="20%">Cost</th>
		<th width="20%">&nbsp;</th>
	</tr>
	<?php foreach($this->co->get_houses() as $i => $r): ?>
		<tr style="height:45px;" class="row<?php if($i % 2 == 0) { echo ' odd'; } ?><?php echo (count($this->co->get_houses()) == $i ? ' row-end' : ''); ?>">
			<td class="row-left">
				<?php echo $r['hNAME']; ?>
			</td>
			<td valign="middle">
				<font class='popularity'><?php
					/* Popularity of the houses */
					$key = "house-".$r['hID'];
					if($this->redis->get($key)) {
						echo $key;
					} else {
						$total_users = (!isset($total_users)) ? $this->db->count_all_results('users') : $total_users;
						$popularity_query = $this->db->select('*')->from('users')->where('maxwill', $r['hWILL'])->count_all_results();
						$formula = floor(((($popularity_query / $total_users) * 100) / 100) * 30);
						$popularity = '';
						foreach(range(0, $formula) as $null) { $popularity .= '|'; }
						echo $popularity;
						$this->redis->set($key, $popularity, 60*60*24*7);
					}
				?></font>
			</td>
			<td><?php echo $r['hWILL']; ?></td>
			<td><?php echo ($r['hPRICE'] > 0) ? '$'.number_format($r['hPRICE'], 2) : '<B>FREE</B>'; ?></td>
			<td class="row-right">
				<?php if($ir['maxwill'] == 100 && $r['hWILL'] == 100): ?>
				&nbsp;
				<?php elseif($ir['hPRICE'] + $ir['money'] < $r['hPRICE']): ?>
					<a href="<?php echo base_url(); ?>estate/buy?id=<?php echo $r['hID']; ?>&__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="black disabled-button">Upgrade</button></a>
				<?php elseif($ir['maxwill'] == $r['hWILL']): ?>
					<a href="<?php echo base_url(); ?>estate/sell?__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="dark-grey">Sell Property</button></a>
				<?php else: ?>
					<a href="<?php echo base_url(); ?>estate/buy?id=<?php echo $r['hID']; ?>&__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="black"><?php echo ($ir['maxwill'] > $r['hWILL']) ? 'Downgrade' : 'Upgrade'; ?></button></a>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>

</div>