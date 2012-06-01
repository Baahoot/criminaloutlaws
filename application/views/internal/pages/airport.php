<h3 class="stylish">Airport
	<span><a href="<?php echo base_url(); ?>help/faq?item=airport" rel="ajax">Learn more about travel</a></span>
</h3>
<p>You visit the local airport and see where you can go with your money.</p>

<br />

<table width="100%" border="0" class="table">

	<tr class="heading">
		<th width="15%">Location</th>
		<th width="50%">Description</th>
		<th width="10%">Popularity</th>
		<th width="10%">Cost</th>
		<th width="10%">Min Level</th>
		<th width="5%">&nbsp;</th>
	</tr>
	
	<?php foreach($this->co->cities as $i=>$r): ?>
		<tr class="row<?php echo ($i % 2 == 0 ? ' odd' : ''); ?><?php echo (count($this->co->cities) == $i ? ' row-end' : ''); ?>" style="height:50px;<?php echo ($r['cityid'] != $this->co->user['location'] && ($r['cityminlevel'] > $this->co->user['level'] || $r['citycost'] > $this->co->user['money'])) ? ' opacity:0.4;' : ''; ?>">
			<td class="row-left"><?php echo $r['cityname']; ?></td>
			<td><p class='text-xxsmall'><?php echo $r['citydesc']; ?>.</p></td>
			<td><font class='popularity'><?php
					/* Popularity of the cities */
					$key = "city-".$r['cityid'];
					if($this->redis->get($key)) {
						echo $key;
					} else {
						$total_users = (!isset($total_users)) ? $this->db->count_all_results('users') : $total_users;
						$popularity_query = $this->db->select('*')->from('users')->where('location', $r['cityid'])->count_all_results();
						$formula = floor(((($popularity_query / $total_users) * 100) / 100) * 30);
						$popularity = '';
						foreach(range(0, $formula) as $null) { $popularity .= '|'; }
						echo $popularity;
						$this->redis->set($key, $popularity, 60*60*24*7);
					}
				?></font></td>
			<td>$<?php echo number_format($r['citycost'], 2); ?></td>
			<td><?php echo $r['cityminlevel']; ?></td>
			<td><?php if($r['cityid'] == $this->co->user['location']): ?>&nbsp;<?php elseif($r['cityminlevel'] > $this->co->user['level'] || $r['citycost'] > $this->co->user['money']): ?><button class="black disabled-button">Go</button><?php else: ?><a href="<?php echo base_url(); ?>airport/visit?city=<?php echo $r['cityid']; ?>&__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="black">Go</button></a><?php endif; ?></td>
		</tr>
	<?php endforeach; ?>

</table>