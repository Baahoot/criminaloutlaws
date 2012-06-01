<h3 class="stylish">Stock Market
	<span>
		<a href="<?php echo base_url(); ?>stocks/view" rel="ajax">Your Stocks</a>
		<a href="<?php echo base_url(); ?>help/faq?item=stocks" rel="ajax">Learn more about stocks</a>
	</span>
</h3>
<p>You briefly view the market prices on the CODAQ stock exchange and decide to invest in some company shares.</p>

<br />

<table width="100%" border="0" class="table">

	<tr class="heading">
		<th width="30%">Stock Name</th>
		<th width="15%">Initial Price</th>
		<th width="15%">Current Price</th>
		<th width="8%">Change</th>
		<th width="20%">Popularity</th>
		<th width="22%">&nbsp;</th>
	</tr>
	
	<?php $q = $this->db->select('stockID, stockNAME, stockOPRICE, stockNPRICE, stockCHANGE, stockUD')->from('stock_stocks')->order_by('stockNPRICE', 'ASC')->get(); ?>
	
	<?php if($q->num_rows() == 0): ?>
		<tr class="row odd row-end">
			<td colspan="6" class="center row-left row-right">There are currently no companies listed on the CODAQ stock market.</td>
		</tr>
	<?php endif; ?>
	
	<?php foreach($q->result_array() as $i=>$soc): ?>
        <tr class="row<?php echo ($i % 2 == 1 ? ' odd' : ''); ?><?php echo ($q->num_rows() == $i+1 ? ' row-end' : ''); ?>">
        	<td class="row-left"><?php echo $soc['stockNAME']; ?></td>
        	<td>$<?php echo number_format($soc['stockOPRICE'], 2); ?></td>
        	<td>
        		<?php
        			if($soc['stockOPRICE'] < $soc['stockNPRICE']) { echo '<span style="color:#5C6949; padding:5px 10px; background:#F5FFE6;">$'.number_format($soc['stockNPRICE'], 2).'</span>'; } 
        			else if($soc['stockOPRICE'] >= $soc['stockNPRICE']) { echo '<span style="color:#453232; padding:5px 10px; background:#FFE0E0;">$'.number_format($soc['stockNPRICE'], 2).'</span>'; }
        		?>
        	</td>
        	<td><?php
        				if($soc['stockUD'] == 1) { echo '<span style="color:#109C19;">+$'.number_format($soc['stockCHANGE'], 2).'</span>'; } 
        				else if($soc['stockUD'] == 0) { echo '<span style="color:#9C1020;">-$'.number_format($soc['stockCHANGE'], 2).'</span>'; }
        			?></td>
        	<td><?php
		$key = "stock-".$soc['stockID'];
		if($this->redis->get($key)) {
			echo $key;
		} else {
			$total_users_q = (!isset($total_users_q)) ? $this->db->select('SUM(holdingQTY)')->from('stock_holdings')->get()->result_array() : $total_users_q;
			$total_users = $total_users_q[0]['SUM(holdingQTY)'];
			$popularity_query = 0;
			$popularity_query = $this->db->select('SUM(holdingQTY)')->from('stock_holdings')->where('holdingID', $soc['stockID'])->get()->result_array();
			$popularity_query = $popularity_query[0]['SUM(holdingQTY)'];
			$formula = floor(((($popularity_query / $total_users) * 100) / 100) * 30);
			$popularity = '';
			foreach(range(0, $formula) as $null) { $popularity .= '|'; }
			echo $popularity;
			$this->redis->set($key, $popularity, 60*60*24*7);
		}
				?></td>
        	<td class="row-right center">
        		<a href="<?php echo base_url() . 'stocks/buy?id=' . $soc['stockID']; ?>" rel="ajax"><button class="dark-grey<?php echo ($this->co->user['money'] <= $soc['stockNPRICE'] ? ' disabled-button' : ''); ?>">Buy stock</button></a>
        	</td>
        </tr>
	<?php endforeach; ?>
	
</table>

<br />
<p class="center">The next stock market update is in <b><span rel="time"><?php echo $this->co->seconds_to_mins($this->co->config['sync_stock']); ?></b> minutes!</span></p>