<?php $job = $this->co->storage['job']; $ir = $this->co->user; ?>
<h3 class="stylish">Apply for <?php echo $job['job_name']; ?></h3>
<p>You walk into the <?php echo $job['job_name']; ?> manager's office and begin your interview.</p>
<br />
<br />
<p class="left crime-sub"><span><?php echo $job['job_owner']; ?>: Hello <?php echo $ir['username']; ?>! We heard you are interested in a job for <?php echo $job['job_name']; ?>?</span></p>
<br /><p class="left crime-sub"><span style="background:transparent;border:0;">You: Yes I am.</span></p>

<br /><p class="left crime-sub"><span><?php echo $job['job_owner']; ?>: What skills can you offer us?</span></p>
<br /><p class="left crime-sub"><span style="background:transparent;border:0;">You: I have <?php echo $ir['strength']; ?> force, <?php echo $ir['labour']; ?> labour and <?php echo $ir['IQ']; ?> intelligence!</span></p>

<br /><p class="left crime-sub"><span><?php echo $job['job_owner']; ?>: <?php echo $this->co->storage['job_result']; ?></span></p>
<br /><p class="left crime-sub"><span style="background:transparent;border:0;">You: <?php echo $this->co->storage['job_me']; ?></span></p>

<br />
<?php echo $this->co->storage['result']; ?>
<div class="back"><a href="<?php echo base_url(); ?>job" rel="ajax">Go back</a></div>