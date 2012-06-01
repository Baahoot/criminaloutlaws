<h3 class="stylish">My Inventory</h3>
<center>
<h4>Equipped Items</h4>
<table width='70%' cellspacing='1' class='table2'>
<tr>
<th width="50%">Primary Weapon</th>
<td><?php echo $this->co->storage['equip_primary']; ?></td>
</tr>
<tr>
<th>Secondary Weapon</th>
<td><?php echo $this->co->storage['equip_secondary']; ?></td>
</tr>
<tr>
<th>Armor</th>
<td><?php echo $this->co->storage['equip_armor']; ?></td>
</tr>
</table>
</center>
<br />
<br />
<table width='100%' cellspacing='1' class='table'>
	<tr class='heading'><th width='40%'>Item</th><th width='12%'>Resale Value</th><th width='15%'>Total Resale Value</th><th></th></tr>
	<?php $list = count($this->co->storage['items']); if($list == 0): ?>
		<tr class='row odd'><td colspan='5' class='center'><p><b>You have no items in your inventory.</b></p></td></tr>
	<?php else: ?>
		<?php foreach($this->co->storage['items'] as $itmtype=>$pidata): $list = count($pidata); ?>
			<tr class='itmhead'><th colspan='4'><?php echo $itmtype; ?></th></tr>
			<?php foreach($pidata as $i=>$itemdata): ?>
				<tr class='row<?php echo ($i % 2 == 1 ? ' odd' : ''); ?><?php if($i+1 == $list) { echo ' row-end'; } ?>'><td class="row-left"><?php echo $itemdata['itmname']; echo ($itemdata['inv_qty'] > 1 ? ' (x' . $itemdata['inv_qty'] . ')' : ''); echo ($this->co->user['equip_primary'] == $itemdata['itmid']) ? ' <b style=\'color:#999; float:right;\'>Equipped as Primary</b>' : ''; echo ($this->co->user['equip_secondary'] == $itemdata['itmid']) ? ' <b style=\'color:#999; float:right;\'>Equipped as Secondary</b>' : ''; echo ($this->co->user['equip_armor'] == $itemdata['itmid']) ? ' <b style=\'color:#999; float:right;\'>Equipped as Armor</b>' : ''; ?></td><td><?php echo '$' . number_format($itemdata['itmsellprice'], 2); ?></td><td><?php if($this->co->user['equip_primary'] == $itemdata['itmid'] || $this->co->user['equip_secondary'] == $itemdata['itmid'] || $this->co->user['equip_armor'] == $itemdata['itmid']) { $itemdata['inv_qty']--; } echo '$' . number_format(($itemdata['itmsellprice']) * $itemdata['inv_qty'], 2); ?></td><td class="row-right">
	 <?php if($itemdata['inv_qty'] > 0): ?><span class="box-link"><a href="<?php echo base_url(); ?>inventory/send?id=<?php echo $itemdata['inv_id']; ?>" rel="ajax">Send</a></span>
	 <span class="box-link"><a href="<?php echo base_url(); ?>inventory/sell?id=<?php echo $itemdata['inv_id']; ?>" rel="ajax">Sell</a></span>
	 <span class="box-link"><a href="<?php echo base_url(); ?>inventory/list_item?id=<?php echo $itemdata['inv_id']; ?>" rel="ajax">List</a></span><?php endif; ?>
	<?php if($itemdata['effect1_on'] || $itemdata['effect2_on'] || $itemdata['effect3_on']): ?> <span class="box-link"><a href="<?php echo base_url(); ?>inventory/use_item?id=<?php echo $itemdata['inv_id']; ?>" rel="ajax-hidden">Use</a></span><?php endif; ?>
	<?php if(($this->co->user['equip_primary'] != $itemdata['itmid'] && $this->co->user['equip_secondary'] != $itemdata['itmid'] && $this->co->user['equip_armor'] != $itemdata['itmid']) && ($itemdata['weapon'] > 0 || $itemdata['armor'] > 0)): ?> <span class="box-link"><a href="<?php echo base_url(); ?>inventory/equip?id=<?php echo $itemdata['inv_id']; ?>" rel="ajax">Equip</a></span><?php elseif($this->co->user['equip_primary'] == $itemdata['itmid']): ?> <span class="box-link"><a href="<?php echo base_url(); ?>inventory/unequip?val=primary&__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden">Unequip</a></span><?php elseif($this->co->user['equip_secondary'] == $itemdata['itmid']): ?> <span class="box-link"><a href="<?php echo base_url(); ?>inventory/unequip?val=secondary&__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax">Unequip</a></span><?php elseif($this->co->user['equip_armor'] == $itemdata['itmid']): ?> <span class="box-link"><a href="<?php echo base_url(); ?>inventory/unequip?val=armor&__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden">Unequip</a></span><?php endif; ?>
	 </td></tr>
			<?php endforeach; ?>
				<tr class='row-spacer'><td colspan='4'></td></tr>
		<?php endforeach; ?>
		
	<?php endif; ?>
</table>

<p class="smallprint"><b>NB:</b> Only attack items (including guns and explosives) can be used as a primary or secondary equip for combat, and only defence items (including shields and protectors) can be used as an armor to reduce damage received by foes. You can use these entirely at your choice in combat, whereas if someone was attacking you, you would have no control over your use of items which you would leave up to your stats and experience. Items which are equipped cannot be sold, sent or listed on any marketplace until they are unequipped.</p>