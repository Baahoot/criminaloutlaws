<h3 class="stylish">Jail (<?php echo $this->co->config['jail_count']; ?>)</h3>
<p>You look outside the state jail to see who is currently sentenced to prison.</p>
<br />
<table width="100%" border="0" class="table">
	<tr class="heading">
		<th width="25%">Username</th>
		<th>Jail Time</th>
		<th width='30%'>Jail Reason</th>
		<th width='10%'>Online</th>
	</tr>
	
	<?php $last = count($this->co->storage['prisoners']); ?>
	<?php foreach($this->co->storage['prisoners'] as $i=>$r):
		$i++;
		$res = $this->co->seconds_to_mins($r['jail']);
	?>
	<tr class="row<?php echo ($i == $last) ? ' row-end' : ''; ?>">
		<td class="row-left"><?php echo $this->co->username_format($r, 0, FALSE); ?></td>
		<td><span rel="time" style="font-weight:bold;"><?php echo $res; ?></span> seconds left <font style='color:#999;'>(<?php echo unix_to_human($r['jail']); ?>)</font></td>
		<td><?php echo $r['jail_reason']; ?>.</td>
		<td class="row-right"><?php echo $this->co->username_format($r, TRUE, 2); ?></td>
	</tr>
	<?php endforeach; ?>
	
	<?php if($last == 0): ?>
		<tr class="row row-end">
			<td class="row-left row-right center odd" colspan="4">Nobody is serving any prison time at the moment.</td>
		</tr>
	<?php endif; ?>
	
</table>