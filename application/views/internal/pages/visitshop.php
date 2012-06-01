<h3 class="stylish">Browse "<?php echo $this->co->storage['shopdata']['shopNAME']; ?>" Shop</h3>
<p>You begin browsing the <?php echo $this->co->storage['shopdata']['shopNAME']; ?> shop curiously and see a range of items for sale.</p>
<br />
<table width='100%' cellspacing='0' cellpadding='0' class='table'>
	<tr class='heading'><th width='22%'>Item Name</th><th width='40%'>Description</th><th width='13%'>Buy Price</th><th width='5%'>Resale Value</th><th></th></tr>
	<?php foreach($this->co->storage['shopitems'] as $i=>$shopi): ?>
	<?php $list = count($shopi); ?>
		<tr class='itmhead'><th colspan='5'><?php echo $i; ?></th></tr>
		<?php foreach($shopi as $i=>$shopitems): ?>
			<tr class='row<?php echo ($i % 2 == 1 ? ' odd' : ''); ?><?php if($i+1 == $list) { echo ' row-end'; } ?>'><td class="row-left"><?php echo $shopitems['itmname']; ?></td><td class="desc"><?php echo $shopitems['itmdesc']; ?></td><td>$<?php echo number_format($shopitems['itmbuyprice'], 2); ?></td><td>$<?php echo number_format($shopitems['itmsellprice'], 2); ?></td><td class="row-right"><a href="<?php echo base_url(); ?>shops/buyitem?id=<?php echo $this->co->storage['shopdata']['shopID']; ?>&item=<?php echo $shopitems['itmid']; ?>&__unique=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="dark-grey standard<?php if($this->co->user['money'] > $shopitems['itmbuyprice']) { echo '">Buy'; } else { echo ' disabled-button">Buy'; } ?></button></a></td></tr>
			<?php if($i+1 == $list): ?>
			<tr class='row-spacer'><td colspan='5'></td></tr>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endforeach; ?>
</table>
<div class="back"><a href="<?php echo base_url(); ?>shops" rel="ajax">Go back</a></div>