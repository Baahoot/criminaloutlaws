<h3 class="stylish">Gold Market
	<span><a href="<?php echo base_url(); ?>market/gold/create" rel="ajax">Sell on the gold market</a></span>
</h3>

<br />

<table width="100%" class="table">

	<tr class="heading">
		<th width="25%">Seller</th>
		<th width="20%">Quantity</th>
		<th width="20%">Price each</th>
		<th width="20%">Price total</th>
		<th width="15%">&nbsp;</th>
	</tr>

<?php
$q = $this->db->select('crystalmarket.*, username_cache.*, (crystalmarket.cmPRICE * crystalmarket.cmQTY) AS cmTOTAL')->from('crystalmarket')->join('username_cache', 'crystalmarket.cmADDER=username_cache.userid')->get();

if(count($q->result_array()) == 0): ?>
	<tr class="row odd"><td colspan="5" class="center">Sorry, currently nobody has listed any gold for sale.</td></tr>
<?php endif;

foreach($q->result_array() as $i=>$r):
?>
	
	<tr class="row<?php echo ($i % 2 == 1 ? ' odd' : ''); ?><?php echo ($q->num_rows() == $i+1 ? ' row-end' : ''); ?>">
		<td class="row-left"><a href="<?php echo base_url(); ?>user/<?php echo $r['username']; ?>" style="font-size:13px; font-weight:normal;" rel="ajax"><?php echo $r['username']; ?> [<?php echo $r['userid']; ?>]</a></td>
		<td><?php echo number_format($r['cmQTY']); ?></td>
		<td><?php echo '$' . number_format($r['cmPRICE'], 2); ?></td>
		<td><?php echo '$' . number_format($r['cmTOTAL'], 2); ?></td>
		<td class="row-right">
		
			<?php if($r['cmADDER'] == $this->co->user['userid']): ?>
				<a href="<?php echo base_url(); ?>market/gold/remove?id=<?php echo $r['cmID']; ?>&__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="black standard">Remove</button></a>
			<?php elseif($this->co->user['money'] >= $r['cmTOTAL']): ?>
				<a href="<?php echo base_url(); ?>market/gold/buy?id=<?php echo $r['cmID']; ?>&__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="black standard">Buy gold</button></a>
			<?php else: ?>
				<button class="black standard disabled-button">Buy gold</button>
			<?php endif; ?>
			
		</td>
	</tr>
	
<?php endforeach; ?>

</table>

<div class="back"><a href="<?php echo base_url(); ?>explore" rel="ajax">Go back</a></div>