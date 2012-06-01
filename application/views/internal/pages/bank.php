<?php
	$ir = $this->co->user;
	$plan = 0;
	foreach($this->co->interest as $v=>$b) { if($b['interest'] == $ir['bankinterest']) { $plan = $b['interest_id']; } }
	$next = $plan + 1;
?>

<?php if($ir['bankmoney'] > 0 && $this->input->get('action') != 'changeplan'): ?><div style="padding:50px 4px 59px; margin-top:7px; float:right; background:#C3DBC6; width:30%; font-family:helvetica neue, georgia; font-size:15px; line-height:38px; color:#3A8744;" class="center">
Bank Balance<br />
<span style='color:#458A4E; font-size:32px; letter-spacing:-0.01em; font-weight:bold;'><?php echo '$'.number_format($ir['bankmoney'], 2); ?></span></div><?php elseif($ir['bankmoney'] == 0 && $this->input->get('action') != 'changeplan'): ?>
<div style="padding:50px 4px 59px; margin-top:7px; float:right; background:#DBD3C3; width:30%; font-family:helvetica neue, georgia; font-size:15px; line-height:38px; color:#6E6040;" class="center">
Bank Balance<br />
<span style='color:#946C0F; font-size:32px; letter-spacing:-0.01em; font-weight:bold;'><?php echo '$'.number_format($ir['bankmoney'], 2); ?></span></div>
<?php endif; ?>

<h3 class="stylish">Local Bank<?php if($ir['bankmoney'] > -1): ?>
	<?php if(isset($this->co->interest[$next])): ?>
	<span>
		<a href='<?php echo base_url(); ?>bank/home?action=changeplan' rel='ajax'>Upgrade Interest Plan</a>
	</span>
	<?php endif; ?>
<?php endif; ?></h3>
<?php if($ir['bankmoney'] == -1 || $this->input->get('action') == 'changeplan'): ?>
<br />
<div class="center">

	<?php if($ir['bankmoney'] == -1): ?><p>You do not appear to have an account with us. It costs <b><?php echo '$' . number_format($this->config->item('bank-cost'), 2); ?></b> to open one and store up to <?php echo '$' . number_format($this->co->interest[2]['min_money'], 2); ?>.</p><?php else: ?>
	<p>You currently have a bank account with an interest rate of <?php echo number_format($this->co->interest[$plan]['interest'], 2); ?>% and allows you to store up to <?php echo (isset($this->co->interest[$next]) ? '$' . number_format($this->co->interest[$next]['min_money'], 2) : ' <b>as much as you want</b>'); ?> in your account.</p>
	<?php endif; ?>
	<table width="100%" class="table" style="padding-left:10%; width:90%;">
		<tr class="heading">
			<th width="50%">Tier</th>
			<th width="25%">Daily Interest</th>
			<th width="25%"><?php echo ($ir['bankmoney'] > -1 ? 'Upgrade ' : ''); ?>Cost</th>
		</tr>
		<?php foreach($this->co->interest as $i=>$r): ?>
		<tr class="row"<?php echo (($r['interest'] == $ir['bankinterest'] && $ir['bankmoney'] > -1) || ($ir['bankmoney'] == -1 && $i == 1) ? ' style="font-weight:bold;background:#336699;color:#fff;"' : ''); ?><?php if($plan > $r['interest_id']) { echo ' style="opacity:0.3;"'; } ?>>
			<td><?php $n = $i+1; if($i == 1) {  echo 'store up to $' . number_format($this->co->interest[$n]['min_money'], 2); } elseif(isset($this->co->interest[$n])) { echo '<!-- $' . $r['min_money'] . ' --> store up to $' . number_format($this->co->interest[$n]['min_money'], 2); } else { echo 'store $' . number_format($r['min_money'], 2) . ' and over'; } ?></td>
			<td><?php echo number_format($r['interest'], 2) . '%'; ?></td>
			<td><?php echo '$' . number_format($r['cost'], 2); ?></td>
		</tr>
		<?php endforeach; ?>
		
		<?php if( $plan > 0 && ! is_array($this->co->interest[$plan])): ?>
			<!-- Blank -->
		<?php elseif((($ir['bankmoney'] == -1 && $ir['money'] >= $this->config->item('bank-cost')) || ($ir['bankmoney'] > -1 && $ir['money'] >= (isset($this->co->interest[$next]) ? $this->co->interest[$next]['cost'] : 0))) && isset($this->co->interest[$next])):	?>
		<tr class="row">
			<td colspan="3" class="center"><a href="<?php echo base_url(); ?>bank/plan?__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="dark-grey"><?php if($ir['bankmoney'] == -1): ?>Open a bank account for <?php echo '$' . number_format($this->config->item('bank-cost'), 2); ?><?php else: ?>Upgrade your bank account for <?php echo '$' . number_format($this->co->interest[$plan+1]['cost'], 2); ?><?php endif; ?></button></a></td>
		</tr>
		<?php else:
			$more = ($ir['bankmoney'] > -1) ? (isset($this->co->interest[$next]) ? $this->co->interest[$next]['cost'] : 0) : $this->config->item('bank-cost');
			if($more > 0): ?>
			<tr class="row">
				<td colspan="3" class="center"><button class="dark-grey disabled-button">You need <?php echo '$' . number_format($more - $ir['money'], 2); ?> more to <?php echo ($ir['bankmoney'] > -1 ? 'upgrade your bank account' : 'open an account'); ?>!</button></td>
			</tr>
			<?php endif; ?>
		<?php endif; ?>
	</table>
	
	<br />
	
	<?php if($ir['bankmoney'] > -1): ?>
		<div class="back"><a href="<?php echo base_url(); ?>bank/home" rel="ajax">Go back</a></div>
	<?php else: ?>
		<div class="back"><a href="<?php echo base_url(); ?>explore" rel="ajax">Go back</a></div>
	<?php endif; ?>
	
</div>

<?php elseif($ir['bankmoney'] > -1): ?>

	<table class="table" style="margin-top:4px; width:68%;"> <!-- 666px -->
		<tr class="row odd">
			<td width="45%" class="right"><b>Current Interest Rate</b></td>
			<td><?php echo $this->co->interest[$plan]['interest'] . '%'; ?></td>
		</tr>
		<tr class="row odd">
			<td width="45%" class="right"><b>Current Limit</b></td>
			<td><?php echo (isset($this->co->interest[$next]) ? '$' . number_format($this->co->interest[$next]['min_money'], 2) : 'Unlimited'); ?></td>
		</tr>
		<tr class="row odd">
			<td width="45%" class="right"><b>Current Daily Interest</b></td>
			<td><?php echo '$' . number_format($ir['bankmoney'] * ($this->co->interest[$plan]['interest'] / 100), 2); ?></td>
		</tr>
		<tr class="row odd">
			<td width="45%" class="right"><b>Next interest payout</b></td>
			<td><?php echo unix_to_human($this->co->config['sync_day']); ?></td>
		</tr>
	</table>
	

<table width="100%" border="0" class="table" style="margin-top:15px;">

	<tr class="heading">
		<th width="50%">Deposit Money</th>
		<th>Withdraw Money</th>
	</tr>
	
	<tr class="row odd row-end">
		<td class="row-left" style="vertical-align:bottom;">
		
			<p class="text-xsmall">There is a 4% fee for depositing your money in the bank which will be charged immediately from your deposit<?php if( isset($this->co->interest[$next])): ?>, and you can only deposit <?php echo '$' . number_format($this->co->interest[$next]['min_money'] - $ir['bankmoney'], 2) . ' more before you reach the maximum money you can store for your plan.'; else: echo '. You can store unlimited cash in your account.'; endif; ?></p>
			<br />
		
			<?php if($ir['money'] > 0): ?>
			<form action="<?php echo base_url(); ?>bank/deposit?__unique__=<?php echo $this->co->get_session(); ?>" method="post" rel="form-ajax-hidden">
				<p><b>Amount to deposit:</b> $<?php echo form_input(array( 'name' => 'amount', 'value' => (isset($this->co->interest[$next]) && $ir['money'] > ($this->co->interest[$next]['min_money'] - $ir['bankmoney']) ? round($this->co->interest[$next]['min_money'] - $ir['bankmoney'], 2) : $ir['money']), 'style' => 'padding:4px;', 'size' => 23 )); ?>
					&nbsp;<button type="submit" class="dark-grey">Deposit Money</button>
				</p>
			</form>
			<?php else: ?>
				<p class="center"><b>Sorry, you do not have any money to deposit.</b></p>
			<?php endif; ?>
		
		</td>
		<td class="row-right odd" style="vertical-align:bottom;">
		
			<p class="text-xsmall">Withdrawing money does not charge you at all as you have paid the fee to open your account. However, as soon as you withdraw your money, you will need to pay the 4% fee again for any money you decide to deposit again.</p>
			<br />
		
			<?php if($ir['bankmoney'] > 0): ?>
			<form action="<?php echo base_url(); ?>bank/withdraw?__unique__=<?php echo $this->co->get_session(); ?>" method="post" rel="form-ajax-hidden">
				<p><b>Amount to withdraw:</b> $<?php echo form_input(array( 'name' => 'amount', 'value' => $ir['bankmoney'], 'style' => 'padding:4px;', 'size' => 19 )); ?>
					&nbsp;<button type="submit" class="dark-grey">Withdraw Money</button>
				</p>
			</form>
			<?php else: ?>
				<p class="center"><b>Sorry, you do not have any money to withdraw.</b></p>
			<?php endif; ?>
		
		</td>
	</tr>

</table>

<?php endif; ?>