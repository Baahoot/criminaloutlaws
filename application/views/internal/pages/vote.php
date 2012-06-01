<h3 class="stylish">Vote for Us</h3>
<p>Here you can earn various rewards for voting for Criminal Outlaws.</p>
<br />

<?php
	$ids = array(
		'btg'
	);
	
	$q = $this->db->select('*')->from('votes')->where('userid', $this->co->user['userid'])->where_in('list', $ids)->get()->result_array();
	$results = array();
	foreach($q as $i=>$r) {
		$results[] = $r['list'];
	}
?>

<table width="100%" border="0" class="table">

	<tr class="heading">
		<th width='45%'>Voting Site</th>
		<th width='25%'>Reward</th>
		<th width='15%'>Votes Today</th>
		<th width='15%'>Total Votes</th>
	</tr>
	
	<?php $id = 'btg'; ?>
	<?php $q3 = $this->db->select('*')->from('totalvotes')->where('list', $id)->get()->result_array(); ?>
	<tr class="row odd"<?php if( in_array($id, $results)) { echo ' style="opacity:0.5;"'; } ?>>
		<td><a <?php if( in_array($id, $results)) { echo 'x'; } ?>href="http://www.besttextgames.com/vote.php?game=31&user=<?php echo $this->co->user['userid']; ?>" target="_blank">Vote on "Best Text Games"</a></td>
		<td>1 Gold</td>
		<td><?php echo number_format( $this->db->select('*')->from('votes')->where('list', $id)->count_all_results() ); ?></td>
		<td><?php echo number_format( $q3[0]['votes'] ); ?></td>
	</tr>

</table>