<h3 class="stylish">Events<?php echo $this->co->storage['cnt']; ?> <span><a href="<?php echo base_url(); ?>help/faq?item=events" rel="ajax">Learn more about how events work</a></span></h3>
<br />
<table width='100%' cellspacing='1' class='table'>
	<tr class='heading'><th width='20%'>Time</th><th width='67%'>Event</th><th>&nbsp;</th></tr>
	<?php foreach($this->co->storage['events'] as $i=>$eventdata): ?>
		<tr class='row<?php echo ($i % 2 == 1 ? ' odd' : ''); ?> <?php if($i == count($this->co->storage['events'])-1) { echo ' row-end'; } ?>'><td class='row-left'> <?php if($eventdata['evREAD'] == 0): ?><img src="<?php $this->co->base(); ?>/images/new.gif" border="0" /><?php endif; ?><?php echo ($eventdata['evTIME']+60*60*24 < now()) ? unix_to_human($eventdata['evTIME']) : strtolower(timespan($eventdata['evTIME'])) . ' ago'; ?></td><td><?php echo $eventdata['evTEXT']; ?></td><td class='row-right'><a href='<?php echo base_url(); ?>events/delete?id=<?php echo $eventdata['evID']; ?>&__sess__=<?php echo $this->co->get_session(); ?>' rel='event-delete'><span style='padding:5px 30px;opacity:0.9; filter:alpha(opacity=90);background:#CF3838;color:#F5E6E6;font-size:12px;'>Delete</span></a></td></tr>
		<?php if($i == count($this->co->storage['events'])-1): ?><tr class='row-spacer'><td colspan='3'></td></tr><?php endif; ?>
	<?php endforeach; ?>
	<?php if(count($this->co->storage['events']) == 0): ?>
		<tr class='row row-end odd'><td colspan='3' class='row-left row-right center'>Sorry, you don't have any events right now.</td></tr>
		<tr class='row-spacer'><td colspan='3'></td></tr>
	<?php endif; ?>

</table>