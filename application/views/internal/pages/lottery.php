<h3 class="stylish">Criminal Outlaws Lottery
	<span><a href="<?php echo base_url() . 'lottery/buy'; ?>" rel="ajax">Buy Lottery Tickets</a></span>
</h3>
<p>Welcome to the central lottery office, with jackpots guaranteed to be huge every week.</p>

<div class="clear"></div>
<br />


<div class="grid_12 alpha omega" style="width:100%; padding:60px 0 70px; background:#F5FFF5;">
	<h4 class="center" style="color:#222; padding-bottom:0;">This week's entire jackpot is now a whopping:</h4>
	<h4 class="center" style="color:#38E332; margin:0;padding:5px 0; font-size:50px; font-family:Helvetica Neue, Arial; font-weight:bold; letter-spacing:0px;"><span style="padding:8px 20px;">$<?php echo number_format($this->co->config['lottery_jackpot']); ?></span></h4>
</div>

<div class="clear"></div>

<!-- Last weeks' winner! -->
<div class="grid_12 alpha omega" style="width:100%; padding:5px 0; background:#CFE9FA; border-top:3px #777 solid;">
	<p class="center"><?php

if($this->co->config['lottery_winners'] == '')
{
	echo '<strong>There was no lottery last week, so we don\'t have any winners yet. Buy your ticket and you could be our first millionaire!</strong>';
} else {
	$un = unserialize($this->co->config['lottery_winners']);
	
	if(count($un['winners']) == 0)
	{
		echo '<strong>There were no winners of the $' . number_format($un['amount']) . ' jackpot last week, so it has been rolled over this week!</strong>';
	} else {
		
		$output = array();
		foreach($this->db->select('*')->from('username_cache')->where_in('userid', $un['winners'])->get()->result_array() as $this_id=>$r) {
			$output[] = '<a href="'.base_url().'user/'.$r['username'].'" rel="ajax"><strong>'.$r['username'].'</strong></a>';
		}
		
		$n = 0;
		$res = '';
		foreach($output as $val) {
			$res .= $val;
			if($n == count($output)-1) {
			}
			else if($n == count($output)-2) {
				$res .= ' and ';
			}
			else {
				$res .= ', ';
			}
		
			$n++;
		}
		
		if($n == 1) {
			echo 'Congratulations to ' . $res . ' who won last week\'s jackpot and received the entire prize fund of <strong>$'.number_format($un['amount'] / count($output), 2).'</strong>!';
		} else {
			echo 'Congratulations to ' . $res . ' who matched last week\'s jackpot numbers and each winner equally received <strong>$'.number_format($un['amount'] / count($output), 2).'</strong>!';
		}
	}
}
?></p>
</div>

<div class="clear"></div>

<!-- More boxes at the bottom! -->

<div class="grid_4 alpha omega" style="width:33%; padding:40px 0; background:#F5FFF5; border-top:3px #777 solid;">
	<p class="center"><strong>Each lottery ticket costs:</strong></p>
	<h6 class="center">$25</h6>
</div>

<div class="grid_4 alpha omega" style="width:33%; padding:40px 0; background:#F5FFF5; border-top:3px #777 solid;">
	<p class="center"><strong>The next lottery drawing is:</strong></p>
	<h6 class="center"><?php echo strtolower(timespan(now(), $this->co->config['sync_lottery'])); ?></h6>
</div>

<div class="grid_4 alpha omega" style="width:34%; padding:40px 0; background:#F5FFF5; border-top:3px #777 solid;">
	<p class="center"><strong>Tickets you've bought for this draw:</strong></p>
	<h6 class="center"><?php echo number_format($this->db->select('*')->from('lotterytickets')->where('lt_user', $this->co->user['userid'])->count_all_results()); ?></h6>
</div>