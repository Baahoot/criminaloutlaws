<h3 class="stylish">Users Online (<?php echo number_format($this->co->storage['online']['15mins']); ?>)</h3>

<br />

<div class="center">

	<table width="100%" class="table">
	
		<tr class="heading">
			<th width="16%">Username</th>
			<th width="20%">Badges</th>
			<th width="15%">Level</th>
			<th width="15%">Money</th>
			<th width="15%">Gold</th>
			<th width="19%">Last Action</th>
		</tr>
		
		<!-- Start 15 minutes -->
		<?php $key = "15mins"; ?>
		<?php if($this->co->storage['online'][$key] > 0): ?>
			<tr class="itmhead">
				<th colspan="6">
					Users active in the last 15 minutes
					<font style='color:#999; font-size:12px; float:right;'><?php echo number_format($this->co->storage['online'][$key]); ?> users online in this period</font>
				</th>
			</tr>
		
			<?php foreach($this->co->storage['online_list'][$key] as $i => $r): ?>
					<tr class="row<?php echo ($i % 2 == 1) ? ' odd' : ''; ?><?php echo (isset($this->co->storage['online'][$key]) && $i+1 == $this->co->storage['online'][$key] ? ' row-end' : ''); ?>">
						<td class="row-left"><?php echo $this->co->username_format($r, 0, 0); ?></td>
						<td><?php echo $this->co->get_badges($r); ?></td>
						<td><?php echo number_format($r['level']); ?></td>
						<td><?php echo '$' . number_format($r['money'], 2); ?></td>
						<td><?php echo number_format($r['crystals']); ?></td>
						<td class="row-right"><?php $r['laston'] = ($r['laston'] > now()) ? $r['laston'] - 60*60 : $r['laston']; echo (abs(now() - $r['laston']) < 4) ? 'just now' : strtolower(timespan($r['laston'], now())) . ' ago'; ?></td>
					</tr>
					<?php echo (isset($this->co->storage['online'][$key]) && $i+1 == $this->co->storage['online'][$key] ? "<tr class='row-spacer'><td colspan='6'></td></tr>" : ''); ?>
			<?php endforeach; ?>
	
		<?php endif; ?>
		
		<!-- Start one hour -->
		<?php $key = "hour"; ?>
		<?php if($this->co->storage['online'][$key] > 0): ?>
			<tr class="itmhead">
				<th colspan="6">
					Users active in the last hour
					<font style='color:#999; font-size:12px; float:right;'><?php echo number_format($this->co->storage['online'][$key]); ?> users online in this period</font>
				</th>
			</tr>
		
			<?php foreach($this->co->storage['online_list'][$key] as $i => $r): ?>
					<tr class="row<?php echo ($i % 2 == 1) ? ' odd' : ''; ?><?php echo (isset($this->co->storage['online'][$key]) && $i+1 == $this->co->storage['online'][$key] ? ' row-end' : ''); ?>">
						<td class="row-left"><?php echo $this->co->username_format($r, 0, 0); ?></td>
						<td><?php echo $this->co->get_badges($r); ?></td>
						<td><?php echo number_format($r['level']); ?></td>
						<td><?php echo '$' . number_format($r['money'], 2); ?></td>
						<td><?php echo number_format($r['crystals']); ?></td>
						<td class="row-right"><?php $r['laston'] = ($r['laston'] > now()) ? $r['laston'] - 60*60 : $r['laston']; echo (abs(now() - $r['laston']) < 4) ? 'just now' : strtolower(timespan($r['laston'], now())) . ' ago'; ?></td>
					</tr>
					<?php echo (isset($this->co->storage['online'][$key]) && $i+1 == $this->co->storage['online'][$key] ? "<tr class='row-spacer'><td colspan='6'></td></tr>" : ''); ?>
			<?php endforeach; ?>
	
		<?php endif; ?>
		
		<!-- Start 24 hours -->
		<?php $key = "day"; ?>
		<?php if($this->co->storage['online'][$key] > 0): ?>
			<tr class="itmhead">
				<th colspan="6">
					Users active in the last 24 hours
					<font style='color:#999; font-size:12px; float:right;'><?php echo number_format($this->co->storage['online'][$key]); ?> users online in this period</font>
				</th>
			</tr>
		
			<?php foreach($this->co->storage['online_list'][$key] as $i => $r): ?>
					<tr class="row<?php echo ($i % 2 == 1) ? ' odd' : ''; ?><?php echo (isset($this->co->storage['online'][$key]) && $i+1 == $this->co->storage['online'][$key] ? ' row-end' : ''); ?>">
						<td class="row-left"><?php echo $this->co->username_format($r, 0, 0); ?></td>
						<td><?php echo $this->co->get_badges($r); ?></td>
						<td><?php echo number_format($r['level']); ?></td>
						<td><?php echo '$' . number_format($r['money'], 2); ?></td>
						<td><?php echo number_format($r['crystals']); ?></td>
						<td class="row-right"><?php $r['laston'] = ($r['laston'] > now()) ? $r['laston'] - 60*60 : $r['laston']; echo (abs(now() - $r['laston']) < 4) ? 'just now' : strtolower(timespan($r['laston'], now())) . ' ago'; ?></td>
					</tr>
					<?php echo (isset($this->co->storage['online'][$key]) && $i+1 == $this->co->storage['online'][$key] ? "<tr class='row-spacer'><td colspan='6'></td></tr>" : ''); ?>
			<?php endforeach; ?>
	
		<?php endif; ?>
		
		
	</table>

</div>