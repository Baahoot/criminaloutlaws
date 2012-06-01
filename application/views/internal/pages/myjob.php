<?php
	$r = $this->co->storage['jobdata'];
	$ir = $this->co->user;

	foreach($this->co->storage['jobranks'] as $i=>$d) {
		if($ir['jobrank'] < $d['rank_id'] && ($d['rank_strengthneed'] - $ir['strength'] < 1) && ($d['rank_labourneed'] - $ir['labour'] < 1) && ($d['rank_iqneed'] - $ir['IQ'] < 1)) {
			$can_upgrade = $d;
		}
	}
?>
<?php if($ir['jobwage'] > 0): ?><div style="padding:50px 4px 59px; margin-top:7px; float:right; background:#C3DBC6; width:24%; font-family:helvetica neue, georgia; font-size:15px; line-height:38px; color:#3A8744;" class="center">
Owed Wages<br />
<span style='color:#458A4E; font-size:32px; letter-spacing:-0.01em; font-weight:bold;'><?php echo '+$'.number_format($ir['jobwage'], 2); ?></span></div><?php else: ?>
<div style="padding:50px 4px 59px; margin-top:7px; float:right; background:#DBD3C3; width:24%; font-family:helvetica neue, georgia; font-size:15px; line-height:38px; color:#6E6040;" class="center">
Owed Wages<br />
<span style='color:#946C0F; font-size:32px; letter-spacing:-0.01em; font-weight:bold;'><?php echo '$'.number_format($ir['jobwage'], 2); ?></span></div>
<?php endif; ?>

<h3 class="stylish">My Job
	<span><a href="<?php echo base_url(); ?>job/leave?__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><b>Leave Job</b></a></span>
	<?php if(isset($can_upgrade)): ?><span><a href="<?php echo base_url(); ?>job/promote?__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><b>Promote to <?php echo $can_upgrade['rank_name']; ?></b></a></span><?php endif; ?>
	<?php if($this->co->storage['next_shift'] < now()): ?><span><a style='background:#eee; text-shadow:none;' href="<?php echo base_url(); ?>job/work?__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><b style='color:#111;'>Work</b></a></span><?php endif; ?>
	<?php if($ir['jobwage'] > 0): ?><span><a href="<?php echo base_url(); ?>job/earlypay?__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><b>Receive Early Pay</b></a></span><?php endif; ?>
</h3>

	<table class="table" style="margin-top:4px; width:74.5%;"> <!-- 666px -->
		<tr class="row odd">
			<td width="45%" class="right"><b>Current Title</b></td>
			<td><?php echo $r['rank_name']; ?> (at <?php echo $r['job_name']; ?>)</td>
		</tr>
		<tr class="row odd">
			<td width="45%" class="right"><b>Current Wage</b></td>
			<td>$<?php echo number_format($r['rank_wage'], 2); ?> per hour</td>
		</tr>
		<tr class="row odd">
			<td width="45%" class="right"><b>Next Shift</b></td>
			<td><?php echo ($this->co->storage['next_shift'] < now() ? 'Now' : 'in ' . strtolower(timespan(now(), $this->co->storage['next_shift']))); ?></td>
		</tr>
		<tr class="row odd">
			<td width="45%" class="right"><b>Next Payday</b></td>
			<td>in <?php echo strtolower(timespan(now(), strtotime("next friday"))); ?></td>
		</tr>
	</table>

<br />
<h4>Job Ranks</h4>
<table width="100%" class="table">

	<tr class="heading">
		<th width="20%">Job Title</th>
		<th width="15%">Job Wage</th>
		<th width="15%">Hours Per Week</th>
		<th width="15%">Force Needed</th>
		<th width="15%">Labour Needed</th>
		<th width="20%">Intelligence Needed</th>
	</tr>
	
	<?php foreach($this->co->storage['jobranks'] as $i=>$d): ?>
		<tr style="height:50px;<?php if($ir['jobrank'] >= $d['rank_id']) { echo 'opacity:0.1; filter:alpha(opacity=10);'; } ?>" class="row<?php echo ($i % 2 == 1 ? ' odd' : ''); ?><?php echo (count($this->co->storage['jobranks']) == $i+1 ? ' row-end' : ''); ?>">
			<td class="row-left"><?php echo $d['rank_name']; ?></td>
			<td><?php echo '$' . number_format($d['rank_wage'], 2); ?> per hour</td>
			<td><?php echo $d['rank_maxhours']; ?> hours</td>
			<td><?php echo (($d['rank_strengthneed'] - $ir['strength']) < 1 ? '<b>Qualified</b>' : round($d['rank_strengthneed'] - $ir['strength'], 4) . ' more force'); ?></td>
			<td><?php echo (($d['rank_labourneed'] - $ir['labour']) < 1 ? '<b>Qualified</b>' : round($d['rank_labourneed'] - $ir['labour'], 4) . ' more labour'); ?></td>
			<td class="row-right"><?php echo (($d['rank_iqneed'] - $ir['IQ']) < 1 ? '<b>Qualified</b>' : number_format($d['rank_iqneed'] - $ir['IQ'], 4) . ' more intelligence'); ?></td>
		</tr>
	<?php endforeach; ?>

</table>