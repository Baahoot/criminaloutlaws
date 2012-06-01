<h3 class="stylish">User List</h3>

<br />
<div class="center">
	<table width="100%" id="users" class="table">
	
		<?php if(($this->co->storage['end_at'] != $this->co->storage['users_count']) || ($this->co->storage['start_from'] > 0 && $this->input->get('page') > 0)): ?>
			<tr class="row" id="load-more">
				<td colspan="1" valign="top" class="center">&nbsp;
					<p>
						<?php if($this->co->storage['start_from'] > 0 && $this->input->get('page') > 0): ?>
							<a style="float:left;" href="<?php echo base_url(); ?>users?page=<?php echo ($this->input->get('page') ? $this->input->get('page')-1 : 2); echo ($this->input->get('sort') ? '&sort=' . $this->input->get('sort') : ''); echo ($this->input->get('order') ? '&order=' . $this->input->get('order') : ''); ?>" rel="ajax-users-load-more"><button class="black">Previous <?php echo $this->co->storage['per_page']; ?> Users</button></a>
						<?php endif; ?></p>
				</td>
				<td colspan="3" class="center" valign="top">&nbsp;
						<p><?php if($this->co->storage['users_count'] > $this->co->storage['per_page']): ?>
							Pages: <?php echo $this->co->storage['pagination']; ?>
						<?php endif; ?></p>
				</td>
				<td colspan="2" valign="top" class="center">&nbsp;
						<p><?php if($this->co->storage['end_at'] != $this->co->storage['users_count']): ?>
							<a style="float:right;" href="<?php echo base_url(); ?>users?page=<?php echo ($this->input->get('page') ? $this->input->get('page')+1 : 2); echo ($this->input->get('sort') ? '&sort=' . $this->input->get('sort') : ''); echo ($this->input->get('order') ? '&order=' . $this->input->get('order') : ''); ?>" rel="ajax-users-load-more"><button class="black">Next  <?php echo $this->co->storage['per_page']; ?> Users</button></a>
						<?php endif; ?>
					</p><br /><br />
				</td>
			</tr>
		<?php endif; ?>
	
		<tr class="heading">
			<th width="20%"><a href="<?php echo base_url(); ?>users?sort=username<?php if($this->input->get('sort') == 'username' && $this->input->get('order') == 'DESC') { echo '&order=ASC'; } else if($this->input->get('sort') == 'username') { echo '&order=DESC'; } echo ($this->input->get('page') ? '&page=' . $this->input->get('page') : ''); ?>" rel="ajax">Username <?php if($this->input->get('sort') == 'username' && $this->input->get('order') == 'DESC') { echo ' <img src="'.$this->co->base(true).'/images/up.gif" style="position:relative;top:4px;background:transparent;" border="0" title="Sort the username in descending order" />'; } else if($this->input->get('sort') == 'username') { echo ' <img src="'.$this->co->base(true).'/images/down.gif" style="position:relative;top:3px;background:transparent;" border="0" title="Sort the username in ascending order" />'; } ?></a></th>
			<th width="30%">Badges</th>
			<th width="10%"><a href="<?php echo base_url(); ?>users?sort=level<?php if($this->input->get('sort') == 'level' && $this->input->get('order') == 'DESC') { echo '&order=ASC'; } else if($this->input->get('sort') == 'level') { echo '&order=DESC'; } echo ($this->input->get('page') ? '&page=' . $this->input->get('page') : ''); ?>" rel="ajax">Level <?php if($this->input->get('sort') == 'level' && $this->input->get('order') == 'DESC') { echo ' <img src="'.$this->co->base(true).'/images/up.gif" style="position:relative;top:4px;background:transparent;" border="0" title="Sort the level in descending order" />'; } else if($this->input->get('sort') == 'level') { echo ' <img src="'.$this->co->base(true).'/images/down.gif" style="position:relative;top:3px;background:transparent;" border="0" title="Sort the level in ascending order" />'; } ?></a></th>
			<th width="10%"><a href="<?php echo base_url(); ?>users?sort=money<?php if($this->input->get('sort') == 'money' && $this->input->get('order') == 'DESC') { echo '&order=ASC'; } else if($this->input->get('sort') == 'money') { echo '&order=DESC'; } echo ($this->input->get('page') ? '&page=' . $this->input->get('page') : ''); ?>" rel="ajax">Money <?php if($this->input->get('sort') == 'money' && $this->input->get('order') == 'DESC') { echo ' <img src="'.$this->co->base(true).'/images/up.gif" style="position:relative;top:4px;background:transparent;" border="0" title="Sort the money in descending order" />'; } else if($this->input->get('sort') == 'money') { echo ' <img src="'.$this->co->base(true).'/images/down.gif" style="position:relative;top:3px;background:transparent;" border="0" title="Sort the money in ascending order" />'; } ?></a></th>
			<th width="10%"><a href="<?php echo base_url(); ?>users?sort=gold<?php if($this->input->get('sort') == 'gold' && $this->input->get('order') == 'DESC') { echo '&order=ASC'; } else if($this->input->get('sort') == 'gold') { echo '&order=DESC'; } echo ($this->input->get('page') ? '&page=' . $this->input->get('page') : ''); ?>" rel="ajax">Gold <?php if($this->input->get('sort') == 'gold' && $this->input->get('order') == 'DESC') { echo ' <img src="'.$this->co->base(true).'/images/up.gif" style="position:relative;top:4px;background:transparent;" border="0" title="Sort the gold in descending order" />'; } else if($this->input->get('sort') == 'gold') { echo ' <img src="'.$this->co->base(true).'/images/down.gif" style="position:relative;top:3px;background:transparent;" border="0" title="Sort the gold in ascending order" />'; } ?></a></th>
			<th width="10%"><a href="<?php echo base_url(); ?>users?sort=gender<?php if($this->input->get('sort') == 'gender' && $this->input->get('order') == 'DESC') { echo '&order=ASC'; } else if($this->input->get('sort') == 'gender') { echo '&order=DESC'; } echo ($this->input->get('page') ? '&page=' . $this->input->get('page') : ''); ?>" rel="ajax">Gender <?php if($this->input->get('sort') == 'gender' && $this->input->get('order') == 'DESC') { echo ' <img src="'.$this->co->base(true).'/images/up.gif" style="position:relative;top:4px;background:transparent;" border="0" title="Sort the gender in descending order" />'; } else if($this->input->get('sort') == 'gender') { echo ' <img src="'.$this->co->base(true).'/images/down.gif" style="position:relative;top:3px;background:transparent;" border="0" title="Sort the gender in ascending order" />'; } ?></a></th>
			<th width="10%">Online</th>
		</tr>
		
		<?php $users = $this->co->storage['users'];?>
		<?php
			$ids = array();
			$is_online = array();
			foreach($users->result_array() as $i => $r):
				$ids[] = $r['userid'];
			endforeach;
			
			$online = $this->db->select('*')->from('online')->where_in('userid', $ids)->get();
			foreach($online->result_array() as $i => $k) {
				$is_online[$k['userid']] = $k['laston'];
			}
		?>
		
			<tr class="itmhead">
				<th colspan="7" style='font-size:12px; color:#777;'>
				Showing users <?php echo $this->co->storage['start_from']+1; ?> - <?php echo ($this->co->storage['end_at']+1 > $this->co->storage['users_count'] ? $this->co->storage['users_count'] : $this->co->storage['end_at']+1); ?> out of <?php echo number_format($this->co->storage['users_count']); ?> users in total
				</th>
			</tr>
		
		<?php foreach($users->result_array() as $i => $r):
				$r['laston'] = (isset($is_online[$r['userid']]) ? $is_online[$r['userid']] : '0'); ?>
	
			<tr class="row<?php echo ($i % 2 == 1) ? ' odd' : ''; ?><?php echo ($i+1 == $users->num_rows() ? ' row-end' : ''); ?>">
				<td class="row-left"><?php echo $this->co->username_format($r, 0, 0); ?></td>
				<td><?php echo $this->co->get_badges($r); ?></td>
				<td><?php echo number_format($r['level']); ?></td>
				<td><?php echo '$' . number_format($r['money'], 2); ?></td>
				<td><?php echo number_format($r['crystals']); ?></td>
				<td><?php echo ucfirst($r['gender']); ?></td>
				<td class="row-right"><?php echo $this->co->username_format($r, 0, 2); ?></td>
			</tr>
		<?php endforeach; ?>
		
		<?php /* if(($this->co->storage['end_at'] != $this->co->storage['users_count']) || ($this->co->storage['start_from'] > 0 && $this->input->get('page') > 0)): ?>
			<tr class="row" id="load-more">
				<td colspan="6" class="center">
					<br />
					<p>
						<?php if($this->co->storage['start_from'] > 0 && $this->input->get('page') > 0): ?>
							<a style="float:left;" href="<?php echo base_url(); ?>users?page=<?php echo ($this->input->get('page') ? $this->input->get('page')-1 : 2); echo ($this->input->get('sort') ? '&sort=' . $this->input->get('sort') : ''); echo ($this->input->get('order') ? '&order=' . $this->input->get('order') : ''); ?>" rel="ajax-users-load-more"><button class="black">Previous <?php echo $this->co->storage['per_page']; ?> Users</button></a>
						<?php endif; ?>
						<?php if($this->co->storage['end_at'] != $this->co->storage['users_count']): ?>
							<a style="float:right;" href="<?php echo base_url(); ?>users?page=<?php echo ($this->input->get('page') ? $this->input->get('page')+1 : 2); echo ($this->input->get('sort') ? '&sort=' . $this->input->get('sort') : ''); echo ($this->input->get('order') ? '&order=' . $this->input->get('order') : ''); ?>" rel="ajax-users-load-more"><button class="black">Next  <?php echo $this->co->storage['per_page']; ?> Users</button></a>
						<?php endif; ?>
					</p>
				</td>
			</tr>
		<?php endif; */ ?>
	</table>
</div>