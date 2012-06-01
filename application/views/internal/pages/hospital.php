<h3 class="stylish"><img style="position:relative; top:5px;" src="<?php $this->co->base(); ?>/images/hospital.png" /> Hospital (<?php echo $this->co->config['hospital_count']; ?>)</h3>
<p>You walk into the hospital ward and see a list of people who are hospitalized.</p>
<br />
<table width="100%" border="0" class="table">
	<tr class="heading">
		<th width="20%">Username</th>
		<th width='35%'>Expected Discharge</th>
		<th width='35%'>Reason</th>
		<th width='10%'>Online</th>
	</tr>
	
	<tr class="itmhead">
		<th colspan="4">Standard Ward</th>
	</tr>
	
	<?php $last = count($this->co->storage['patients']); ?>
	<?php foreach($this->co->storage['patients'] as $i=>$r):
		$i++;
		$res = $this->co->seconds_to_mins($r['hospital']);
	?>
	<tr class="row<?php echo ($i == $last) ? ' row-end' : ''; ?>">
		<td class="row-left"><?php echo $this->co->username_format($r, 0, FALSE); ?></td>
		<td><b><span rel="time"><?php echo $res; ?></span></b> seconds left <font style='color:#999;'>(<?php echo unix_to_human($r['hospital']); ?>)</font></td>
		<td><?php echo $r['hospreason']; ?></td>
		<td class="row-right"><?php echo $this->co->username_format($r, 0, 2); ?></td>
	</tr>
	<?php endforeach; ?>
	
	<?php if($last == 0): ?>
		<tr class="row row-end">
			<td class="row-left row-right center odd" colspan="4">Nobody is currently gaining treatment from the state hospital.</td>
		</tr>
	<?php endif; ?>
	
</table>