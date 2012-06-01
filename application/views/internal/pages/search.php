<h3 class="stylish">Search</h3>
<br />
<div>
	<form action="<?php echo base_url(); ?>search" method="get" rel="form-ajax-hidden">
		<input type="hidden" name="at" value="<?php echo now(); ?>" />
		<p class='left'><input type="text" name="q" value="<?php echo $this->input->get_post('q'); ?>" style='width:67%; font-size:13px; padding:4px;' autocomplete='off' />
		<button type="submit" class="grey center" style="width:30%; float:right;">Search</button></p>
	</form>
</div>
<?php if($this->input->get_post('q')): ?>
<br /><br />
<div class="clear"></div>

	<?php if($this->co->storage['count'] == 0): ?>
		<h6 class="center"><span style="padding:4px; background:#eee;">No results found with the query '<?php echo $this->input->get_post('q'); ?>'</span></h6>
	<?php else: ?>
		<table width="100%" class="table">
			<tr class="heading">
				<th>Username</th>
				<th>Badges</th>
				<th>Level</th>
				<th>Money</th>
				<th>Gender</th>
				<th>Online</th>
			</tr>
			<?php foreach($this->co->storage['users'] as $id => $r): if($this->input->get_post('q') == $r['username']) { $msg = TRUE; } ?>
				<tr class="row<?php echo ($id % 2 == 1 ? ' odd' : ''); ?><?php echo ($this->co->storage['count'] == $id+1 ? ' row-end' : ''); ?>"<?php echo ($this->input->get_post('q') == $r['username'] ? ' style="background:#A7D5FA;"' : ''); ?>>
					<td class="row-left"><?php echo $this->co->username_format($r, FALSE, 0); ?></td>
					<td><?php echo $this->co->get_badges($r); ?></td>
					<td><?php echo number_format($r['level']); ?></td>
					<td><?php echo '$' . number_format($r['money'], 2); ?></td>
					<td><?php echo $r['gender']; ?></td>
					<td class="row-right"><?php echo $this->co->username_format($r, TRUE, 2); ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
		
		<?php if(isset($msg)): ?>
			<br />
			<p class="center">Results which are coloured in <font style="padding: 2px; background:#A7D5FA;">blue</font> are exact matches.</p>
		<?php endif; ?>
	<?php endif; ?>
	
<?php /* <!-- div class="grid_2 co_static center">
Left
</div>
<div class="grid_7 co_static" style="background:#eee;">
Hello
</div --> */ ?>
<?php endif; ?>