<?php
	$ir = $this->co->user;
	$stock = $this->co->storage['stock'];
?>
<h3 class="stylish"><a href="<?php echo base_url() . 'stocks'; ?>" rel="ajax">Stock Market</a> &rarr; Buy <?php echo $stock['stockNAME']; ?> Stock
</h3>
<p>You take an interest in a specific company, <?php echo $stock['stockNAME']; ?> and decide to purchase some shares from the stock broker.</p>

<br />

<?php
        $class = ($stock['stockUD'] == 1) ? '#109C19' : '#9C1020';
        $blip = ($stock['stockUD'] == 1) ? '+' : '-';
        $clor = ($stock['stockOPRICE'] < $stock['stockNPRICE']) ? 'green' : 'red';

		/* Popularity of the houses */
		$key = "stock-".$stock['stockID'];
		if($this->redis->get($key)) {
			echo $key;
		} else {
			$total_users_q = (!isset($total_users_q)) ? $this->db->select('SUM(holdingQTY)')->from('stock_holdings')->get()->result_array() : $total_users_q;
			$total_users = (!isset($total_users)) ? $total_users_q[0]['SUM(holdingQTY)'] : $total_users;
			$popularity_query = $this->db->select('SUM(holdingQTY)')->from('stock_holdings')->where('holdingID', $stock['stockID'])->get()->result_array();
			$popularity_query = $popularity_query[0]['SUM(holdingQTY)'];
			$formula = floor(((($popularity_query / $total_users) * 100) / 100) * 30);
			$popularity = '';
			foreach(range(0, $formula) as $null) { $popularity .= '|'; }
			$this->redis->set($key, $popularity, 60*60*24*7);
		}
		
		$own = $this->db->select('holdingQTY')->from('stock_holdings')->where('holdingUSER', $ir['userid'])->where('holdingSTOCK', $stock['stockID'])->get()->result_array();
        $stocks_own = 'No shares bought';
        if(count($own) > 0) {
	        $stocks_own = number_format($own[0]['holdingQTY']) . ' shares ('. round(($own[0]['holdingQTY'] / $total_users) * 100, 1).'% of total stock)';
	    }
	    
	    $majority = 'No majority shareholder';
	    if($total_users > 0) {
	    	$q = $this->db->query("SELECT stock_holdings.*, username_cache.* FROM stock_holdings LEFT JOIN username_cache ON username_cache.userid = stock_holdings.holdingUSER WHERE holdingSTOCK = ? ORDER BY holdingQTY DESC LIMIT 1", array( $stock['stockID'] ))->result_array();
	    	if(count($q) > 0) {
	    		$q = $q[0];
	    		$majority = "<a href='".base_url()."user/{$q['username']}' rel='ajax' style='font-size:13px; font-weight:normal;'>" . $q['username'] . "</a> [{$q['userid']}]";
	    	}
	    }
?>
 
        <table border="0" cellspacing="0" style="margin-left:17%;" width="66%" class="table">
            <tr class="row odd">
                <td class="left"><strong>Your Stock</strong></td>
                <td><?php echo ($stocks_own); ?></td>
            </tr>
            <tr class="row">
                <td class="left" width="50%"><strong>Stock Name</strong></td>
                <td width="50%"><?php echo $stock['stockNAME']; ?></td>
            </tr>
            <tr class="row">
                <td class="left"><strong>Majority Shareholder</strong></td>
                <td><?php echo ($majority); ?></td>
            </tr>
            <tr class="row">
                <td class="left"><strong>Stock Price Change</strong></td>
                <td><span style="color:<?php echo $class; ?>;"><?php echo $blip.' $'.number_format($stock['stockCHANGE'], 2); ?></span></td>
            </tr>
            <tr class="row">
                <td class="left"><strong>Initial Price</strong></td>
                <td>$<?php echo number_format($stock['stockOPRICE'], 2); ?></td>
            </tr>
            <tr class="row">
                <td class="left"><strong>Current Price</strong></td>
                <td><?php
        			if($stock['stockOPRICE'] < $stock['stockNPRICE']) { echo '<span style="color:#5C6949; padding:5px 10px; background:#F5FFE6;">$'.number_format($stock['stockNPRICE'], 2).'</span>'; } 
        			else if($stock['stockOPRICE'] >= $stock['stockNPRICE']) { echo '<span style="color:#453232; padding:5px 10px; background:#FFE0E0;">$'.number_format($stock['stockNPRICE'], 2).'</span>'; }
        		?></td>
            </tr>
            <tr class="row">
                <td class="left"><strong>Popularity</strong></td>
            	<td><?php echo $popularity; ?></td>
            </tr>
            <tr class="row">
                <td colspan="2" class="center">
                    <?php if($ir['money'] >= $stock['stockNPRICE']): ?>
                    <form action="<?php echo base_url() . 'stocks/buy?id=' . $stock['stockID']; ?>" rel="form-ajax-hidden" method="post">
                    	<input type="hidden" name="__unique__" value="<?php echo $this->co->get_session(); ?>" />
                        <label><strong>Buy Stock</strong> &rarr; <input type="text" size="10" style="font-size:13px;" name="amount" value="1" /></label>
                        <input type="submit" value="Buy" name="buy" />
                    </form>
                    <?php else: ?>
                    <br /><p class='center'><strong>Sorry, you don't have enough money to buy shares in this company.</strong></p>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        
        <br />
        
		<div class="back"><a href="<?php echo base_url(); ?>stocks" rel="ajax">Go back to the stock market</a></div>