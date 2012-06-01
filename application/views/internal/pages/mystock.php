<h3 class="stylish"><a href="<?php echo base_url() . 'stocks'; ?>" rel="ajax">Stock Market</a> &rarr; My Stocks</h3>
<p>You go to your stock broker, and ask for a status sheet for information about the stock you've purchased.</p>
<br />

<table width="100%" border="0" class="table">
	<tr class="heading">
		<th width="25%">Stock Name</th>
		<th width="20%">Your Stock</th>
		<th width="20%">Sell Price</th>
		<th width="20%">Total Sell Price</th>
		<th>&nbsp;</th>
	</tr>
	
	<?php $q = $this->db->select('*')->from('stock_holdings')->join('stock_stocks', 'stock_stocks.stockID = stock_holdings.holdingSTOCK')->where('holdingUSER', $this->co->user['userid'])->get(); ?>
	
	<?php if($q->num_rows() == 0): ?>
		<tr class="row row-end">
			<td colspan="5" class="center row-left row-right">Sorry, you don't currently hold any shares from any companies.</td>
		</tr>
	<?php endif; ?>
	
	<?php foreach($q->result_array() as $i=>$r): ?>
		<tr class="row<?php echo ($i == $q->num_rows()-1 ? ' row-end' : ''); ?>">
			<td class="row-left"><?php echo $r['stockNAME']; ?></td>
			<td><?php echo number_format($r['holdingQTY']); ?></td>
			<td>$<?php echo number_format($r['stockNPRICE'], 2); ?></td>
			<td>$<?php echo number_format($r['stockNPRICE'] * $r['holdingQTY'], 2); ?></td>
			<td class="row-right">
				<a href="<?php echo base_url() . 'stocks/sell?__unique__='.$this->co->get_session().'&id='.$r['stockID']; ?>" rel="ajax-hidden">
					<button class="dark-grey">Sell Stock</button>
				</a>
			</td>
		</tr>
	<?php endforeach; ?>

</table>

	<br />

	<div class="back"><a href="<?php echo base_url(); ?>stocks" rel="ajax">Go back to the stock market</a></div>