<h3 class="stylish">Item Market
	<span><a href="<?php echo base_url(); ?>inventory" rel="ajax">List an item for sale</a></span>
</h3>

<br />

<table width="100%" class="table">

	<tr class="heading">
		<th width="50%">Item Name</th>
		<th width="20%">Seller</th>
		<th width="15%">Asking Price</th>
		<th width="15%">&nbsp;</th>
	</tr>

<?php
$q = $this->db->select('itemmarket.*, items.itmid, items.itmname, items.itmtype, username_cache.*')->from('itemmarket')->join('items', 'itemmarket.imITEM=items.itmid')->join('username_cache', 'itemmarket.imADDER=username_cache.userid')->order_by('items.itmtype', 'ASC')->order_by('items.itmname', 'ASC')->get();

$array = array( 'last' => 0 );
foreach($q->result_array() as $i=>$r) {
	$array['count'][$r['itmtype']] = (isset($array['count'][$r['itmtype']]) ? $array['count'][$r['itmtype']] + 1 : 1);
}

$list = 0;

if(count($q->result_array()) == 0): ?>
	<tr class="row odd"><td colspan="4" class="center">Sorry, currently nobody has listed any items for sale.</td></tr>
<?php endif;

foreach($q->result_array() as $i=>$r):
$list++;
$r = array_merge($r, $this->co->itemtypes[$r['itmtype']]); ?>

	<?php if($array['last'] != $r['itmtype']): ?>
		<tr class="itmhead">
			<th colspan="4"><?php echo $r['itmtypename']; ?></th>
		</tr>
	<?php $array['last'] = $r['itmtype']; endif; ?>
	
	<tr class="row<?php echo ($i % 2 == 1 ? ' odd' : ''); ?><?php echo ($array['count'][$r['itmtype']] == $list ? ' row-end' : ''); ?>">
		<td class="row-left"><?php echo $r['itmname']; ?></td>
		<td><a href="<?php echo base_url(); ?>user/<?php echo $r['username']; ?>" style="font-size:13px; font-weight:normal;" rel="ajax"><?php echo $r['username']; ?> [<?php echo $r['userid']; ?>]</a></td>
		<td><?php echo ($r['imCURRENCY'] == 'money' ? '$' : '') . number_format($r['imPRICE'], ($r['imCURRENCY'] == 'money' ? 2 : 0)) . ($r['imCURRENCY'] == 'money' ? '' : ' gold'); ?></td>
		<td class="row-right">
		
			<?php if($r['imADDER'] == $this->co->user['userid']): ?>
				<a href="<?php echo base_url(); ?>market/item/remove?id=<?php echo $r['imID']; ?>&__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="black standard">Remove</button></a>
			<?php elseif(($r['imCURRENCY'] == 'money' && $this->co->user['money'] >= $r['imPRICE']) || ($r['imCURRENCY'] == 'crystals' && $this->co->user['crystals'] >= $r['imPRICE'])): ?>
				<a href="<?php echo base_url(); ?>market/item/buy?id=<?php echo $r['imID']; ?>&__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="black standard">Buy item</button></a>
			<?php else: ?>
				<button class="black standard disabled-button">Buy item</button>
			<?php endif; ?>
			
		</td>
	</tr>
	
	<?php if($array['count'][$r['itmtype']] == $list): $list = 0; ?><tr class="row-spacer" colspan="4"><td></td></tr><?php endif; ?>
	
<?php endforeach; ?>

</table>

<div class="back"><a href="<?php echo base_url(); ?>explore" rel="ajax">Go back</a></div>