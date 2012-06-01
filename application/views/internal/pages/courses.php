<?php
$ir = $this->co->user;
$query = $this->co->courses;
?>
<h3 class="stylish">Courses
	<span><a href="<?php echo base_url(); ?>help/faq?item=courses" rel="ajax">Learn more about courses</a></span>
</h3>
<?php if($ir['course'] == 0): ?><p>You go to a local education centre to see what you can learn and improve your character on.</p><?php endif; ?>
<br />
<?php if($ir['course_expires'] <= now() && $ir['course'] > 0): ?>
<div class="center">

	<table width="100%" class="table" style="padding-left:10%; width:90%;">
		<tr class="itmhead">
			<th colspan="2" class="center">
			Congratulations! You've just completed your <b><?php echo $this->co->courses[$ir['course']]['crNAME']; ?></b>!
			</th>
		</tr>
		<tr class="row row-end">
			<td class="row-left center row-right" width="50%">
			Criminal Outlaws is currently processing your request for your completed course.<br />
			You will be able to select a new course in approximately <span rel="time"><?php echo $this->co->seconds_to_mins($this->co->config['next_update']) . '</span> minutes'; ?>.</td>
		</tr>
	</table>
	
</div>
<?php elseif($ir['course_expires'] > now() && $ir['course'] > 0): ?>
<div class="center">

	<table width="100%" class="table" style="padding-left:10%; width:90%;">
		<tr class="itmhead">
			<th colspan="2">
			Course Information
			</th>
		</tr>
		<tr class="row">
			<td class="row-left" width="40%"><b>Course Name</b></td>
			<td class="row-right"><?php echo $this->co->courses[$ir['course']]['crNAME']; ?></td>
		</tr>
		<tr class="row">
			<td class="row-left" width="40%"><b>Course Description</b></td>
			<td class="row-right"><?php echo $this->co->courses[$ir['course']]['crDESC']; ?></td>
		</tr>
		<tr class="row">
			<td class="row-left" width="40%"><b>Course Cost</b></td>
			<td class="row-right"><?php echo '$' . number_format($this->co->courses[$ir['course']]['crCOST'], 2); ?></td>
		</tr>
		<tr class="row">
			<td class="row-left" width="40%"><b>Time left until completion</b></td>
			<td class="row-right"><?php echo strtolower(timespan(now(), $ir['course_expires'])); floor((now() - $ir['course_expires'])/60); ?> <font style='color:#999;'>(<?php echo unix_to_human($ir['course_expires']); ?>)</font></td>
		</tr>
		<tr class="row">
			<td colspan="2" class="center row-left row-right" style="padding-top:20px;"><a href="<?php echo base_url(); ?>courses/cancel?__unique__=<?php echo $this->co->get_session(); ?>" rel="ajax-hidden"><button class="dark-grey">Cancel Course</button></a>
		</tr>
		<tr class="row row-end">
			<td colspan="2" class="row-left row-right">
				<p class="smallprint left">Note: By cancelling your course, you solely agree that your <b>course fee</b> will not be refunded by the local education center at all and you will not be able to resume this course at this position. To go on this course again, you will need to pay the full course fee again and start it for the original length of the course.</p></td>
			</td>
		</tr>
	</table>
	
</div>
<?php else: ?>
<?php
$completed = $this->db->select('*')->from('coursesdone')->where('userid', $ir['userid'])->get();
$coursesdone = array();
foreach($completed->result_array() as $i => $r) {
	$coursesdone[] = $r['courseid'];
}
?>

<table width="100%" class="table">

	<tr class="heading">
		<th width="22%">Course Name</th>
		<th width="45%">Description</th>
		<th width="10%">Popularity</th>
		<th width="8%">Cost</th>
		<th width="10%">&nbsp;</th>
	</tr>
	
	<tr class="itmhead">
		<th colspan="5">Standard Courses</th>
	</tr>

<?php foreach($query as $i => $r): ?>
	<tr class="row<?php if($i % 2 == 0) { echo ' odd'; } ?><?php if(count($query) == $i): echo ' row-end'; endif; ?>">
		<td class="row-left"><?php echo $r['crNAME']; ?></td>
		<td style='color:#666;'><?php echo $r['crDESC']; ?> <font style='color:#999;'>(<?php echo $r['crDAYS']; ?> days)</font></td>
		<td><font class='popularity'><?php
			/* Popularity of the courses */
			$key = "course-".$r['crID'];
			if($this->redis->get($key)) {
				echo $key;
			} else {
				$total_users = (!isset($total_users)) ? $this->db->count_all_results('users') : $total_users;
				$popularity_query = $this->db->select('*')->from('coursesdone')->where('courseid', $r['crID'])->count_all_results();
				$formula = floor(((($popularity_query / $total_users) * 100) / 100) * 30);
				$popularity = '';
				foreach(range(0, $formula) as $null) { $popularity .= '|'; }
				echo $popularity;
				$this->redis->set($key, $popularity, 60*60*24*7);
			}
		?></font></td>
		<td>$<?php echo number_format($r['crCOST'], 2); ?></td>
		<td class="row-right">
			<?php if( in_array($r['crID'], $coursesdone) ): ?>
				<button class="black disabled-button"><i>Completed</i></button>
			<?php else: ?>
				<?php if($r['crCOST'] > $ir['money']): ?>
					<a href="<?php echo base_url(); ?>courses/do_course?__unique__=<?php echo $this->co->get_session(); ?>&id=<?php echo $r['crID']; ?>" rel="ajax-hidden"><button class="black disabled-button">Do</button></a>
				<?php else: ?>
					<a href="<?php echo base_url(); ?>courses/do_course?__unique__=<?php echo $this->co->get_session(); ?>&id=<?php echo $r['crID']; ?>" rel="ajax-hidden"><button class="black">Do</button></a>
				<?php endif; ?>
			<?php endif; ?>
		</td>
	</tr>
	
<?php endforeach; ?>
</table>
<?php endif; ?>