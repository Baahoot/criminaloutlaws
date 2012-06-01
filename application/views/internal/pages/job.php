<h3 class="stylish"><?php echo ($this->co->user['jobrank'] > 0 ? 'Your Job' : 'Job Centre'); ?>
	<span><a href="<?php echo base_url(); ?>help/faq?item=jobs" rel="ajax">Learn more about how jobs work</a></span>
</h3>
<p>You go to the local job centre and see a board full of jobs which are currently looking for staff.</p>
<br />

<table width="100%" border="0" class="table">

	<tr class="heading">
		<th width="20%">Job Name</th>
		<th width="50%">Job Description</th>
		<th>Starting Wage</th>
		<th>&nbsp;</th>
	</tr>
<?php
$q = $this->db->select('*')->from('jobs')->order_by('job_wage', 'ASC')->get();
foreach($q->result_array() as $i=>$r): ?>
	<tr style="height:75px;" class="row<?php echo ($q->num_rows() == $i+1 ? ' row-end' : ''); ?><?php echo ($i % 2 == 1 ? ' odd' : ''); ?>">
		<td class="row-left"><?php echo $r['job_name']; ?></td>
		<td><?php echo $r['job_description']; ?>.</td>
		<td>$<?php echo number_format($r['job_wage'], 2); ?>/hour</td>
		<td class="row-right"><?php echo '<a href="'.base_url().'job/apply?__unique__='.$this->co->get_session().'&id='.$r['job_id'].'" rel="ajax"><button class="black">Apply for this job</button></a>'; ?></td>
	</tr>
<?php endforeach; ?>
</table>