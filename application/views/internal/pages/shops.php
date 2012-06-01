<h3 class="stylish">Shops 
	<span>
		<a href='<?php echo base_url(); ?>help/faq?item=shops' rel='ajax'>Learn more about buying items from shops</a>
	</span>
</h3>
<p>You find a host of shops which have items displayed on their windows for sale.</p>
<br />
<table width='100%' cellspacing='1' class='table'>
	<tr class='heading'><th width='30%'>Name</th><th>Description</th></tr>
	<?php foreach($this->co->storage['shops'] as $i=>$shopdata): ?>
		<tr style='height:50px;' class='row<?php echo ($i % 2 == 1 ? ' odd' : ''); ?>'><td><a href='<?php echo base_url(); ?>shops/visit?id=<?php echo $shopdata['shopID']; ?>' rel='ajax'><?php echo $shopdata['shopNAME']; ?></a></td><td><?php echo $shopdata['shopDESCRIPTION']; ?></td></tr>
	<?php endforeach; ?>

</table>
<div class="back"><a href="<?php echo base_url(); ?>explore" rel="ajax">Go back</a></div>