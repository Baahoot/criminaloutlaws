<h3 class="stylish">Notifications (<?php echo $this->co->storage['notifications_count']; ?>)</h3>
<br />

<?php

	$notifications = array(
		array(
			'name' => 'Inbox',
			'message' => 'You\'ve got % unread messages',
			'count' => $this->co->user['new_mail'],
			'link' => 'inbox'
		),
		array(
			'name' => 'Events',
			'message' => 'You\'ve got % new events',
			'count' => $this->co->user['new_events'],
			'link' => 'events'
		)
	);

?>


<?php foreach($notifications as $array): ?>
	<?php if($array['count'] > 0): ?>
		<a href="<?php echo base_url() . $array['link']; ?>" rel="ajax">
			<div style="background:#AABDB3; padding:10px; width:45%; margin:0 0 0 2%; border:1px solid #95BAA7; float:left;">
				<h6 style='color:#0B6336; font-size:18px;' class='center'><?php echo str_replace('%', $array['count'], $array['message']); ?></h6>
				
			</div>
		</a>
	<?php endif; ?>
<?php endforeach; ?>