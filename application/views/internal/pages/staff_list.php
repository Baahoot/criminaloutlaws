<h3 class="stylish">Staff List</h3>
<p>These people help with the day-to-day operations of Criminal Outlaws.</p>
<br />
<div class="center">

	<table width="100%" class="table">
	
		<tr class="heading">
			<th width="30%">Username</th>
			<th width="20%">Duties</th>
			<th width="10%">Level</th>
			<th width="15%">Money</th>
			<th width="20%">Badges</th>
		</tr>
		
		<?php foreach($this->co->userlevels as $i => $staff): 
			if( ! isset($this->co->storage['staff_count'][$staff['ul_userlevel']]) ): continue; endif;
			$force_refresh = 1;
		?>
		<tr class="itmhead">
			<th colspan="5">
				<?php echo $staff['ul_name']; ?>
				<font style='color:#999; font-size:12px; float:right;'><?php echo $staff['ul_desc']; ?></font>
			</th>
		</tr>
		
			<?php foreach($this->co->storage['staff_list'] as $i => $r): ?>
				<?php if($r['user_level'] == $staff['ul_userlevel']):
					$i = ($force_refresh) ? 1 : $i; $force_refresh = 0; ?>
					<tr class="row<?php echo (isset($this->co->storage['staff_count'][$staff['ul_userlevel']]) && $i == $this->co->storage['staff_count'][$staff['ul_userlevel']] ? ' row-end' : ''); ?>">
						<td class="row-left"><?php echo $this->co->username_format($r, 0); ?></td>
						<td><?php echo $r['user_duties']; ?></td>
						<td><?php echo number_format($r['level']); ?></td>
						<td><?php echo '$' . number_format($r['money'], 2); ?></td>
						<td class="row-right"><?php echo $this->co->get_badges($r); ?></td>
					</tr>
					<?php echo (isset($this->co->storage['staff_count'][$staff['ul_userlevel']]) && $i == $this->co->storage['staff_count'][$staff['ul_userlevel']] ? "<tr class='row-spacer'><td colspan='5'></td></tr>" : ''); ?>
				<?php endif; ?>
			<?php endforeach; ?>
			
			<?php if( ! isset($this->co->storage['staff_count'][$staff['ul_userlevel']]) ): ?>
				<tr class='row row-end'><td colspan="5" class="row-left row-right center" style='color:#999;'>There are currently <b>no</b> <?php echo strtolower($staff['ul_name']); ?> available on Criminal Outlaws.</td></tr>
				<tr class='row-spacer'><td colspan='5'></td></tr>
			<?php $force_refresh = 1; else: echo ""; endif; ?>
		
		<?php endforeach; ?>
	
	</table>

</div>