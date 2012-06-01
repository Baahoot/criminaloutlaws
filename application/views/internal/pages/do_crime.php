<h3 class="stylish">Crimes: <?php echo $this->co->storage['crimes']['crimeNAME']; ?></h3>
<br />
<br />
<?php echo $this->co->storage['output']; ?>
<br /><br />
<div class="back">
	<?php if(($this->co->user['brave'] - $this->co->storage['crimes']['crimeBRAVE']) >= $this->co->storage['crimes']['crimeBRAVE']): ?><a href="<?php echo base_url(); ?>crimes/perform?__unique__=<?php echo $this->input->get('__unique__'); ?>&id=<?php echo $this->input->get('id'); ?>" rel="ajax-hidden">Try again</a><?php endif; ?>
	<a href="<?php echo base_url(); ?>crimes" rel="ajax">Go back to crimes</a>
</div>