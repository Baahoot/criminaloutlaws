<h3 class="stylish">Unlockables</h3>
<p>You take a quick peek at the Unlocks board and take a pick as to what you can unlock for your account.</p>

<br />

<div class="grid_10">

<?php foreach($this->co->storage['un'] as $i=>$r): ?>
	<div class="grid_6 alpha omega unlockables<?php echo ($r['completed'] == 1 ? ' completed' : ''); ?>" style="position:relative;">
		<h1 class="center"><?php echo $r['title']; ?></h1>
		<p class="center unlock-desc"><?php echo $r['desc']; ?></p>
		
		<div class="unlock-image" style="text-align:center;">
			<img src="<?php $this->co->base(); echo $r['image']; ?>" style="max-height:95px;">
		</div>
		
		<p class="left unlock-progress">Progress: <?php echo $r['true_value']; ?>/<?php echo $r['value']; ?> (<?php echo $r['perc']; ?>%)</p>
		<p class="unlock-progress-bar">
			<img src="<?php $this->co->base(); ?>/userbars/force.png" width="<?php echo ceil($r['perc'] * 0.79); ?>%" height="7" style="border-radius:5px 0 0 5px;" /><img src="<?php $this->co->base(); ?>/userbars/red.png" width="<?php echo 79 - ceil($r['perc'] * 0.79); ?>%" height="7" style="border-radius:0 5px 5px 0;" />
		</p>
		
		<center>
			<?php if($r['perc'] == 100 && $r['completed'] == 0): ?>
				<p><a href="<?php echo base_url() . 'unlocks/complete?id=' . $r['id'] . '&__unique__=' . $this->co->get_session(); ?>" rel="ajax"><button class="dark-grey">Unlock</button></a></p>
			<?php else: ?>
				<p><button class="dark-grey disabled-button">Unlock</button></p>
			<?php endif; ?>
		</center>
		
		<div class="completed-layer"><img src="<?php echo $this->co->base(); ?>/images/completed.png" /></div>
	</div>
<?php endforeach; ?>

</div>