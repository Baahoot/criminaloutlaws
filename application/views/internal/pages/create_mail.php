<h3 class="stylish">Compose Mail</h3>
<br />
<form action="<?php echo base_url() . 'inbox/create'; ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax">
	<input type='hidden' name='__unique__' value='<?php echo $this->co->get_session(); ?>'>
	<div class="field">

		<p class="form-label"><label style="width:200px; text-align:left; height:10px;">Username</label>
		 <?php echo form_input( array( 'class' => 'form-field', 'name' => 'username', 'value' => set_value('username', $this->input->get_post('to')), 'size' => 30, 'maxlength' => 16 ) ); ?>
		 
		 <?php if(count($this->co->storage['contactlist']) > 0 && !$this->input->get_post('to')): ?>
			 <b>OR</b> 
			<select name='contact' type='dropdown' style='width: 269px;'>
				<option value='0'>-- Select From Contact List --</option>
			<?php foreach($this->co->storage['contactlist'] as $r): ?>
				<option value='<?php echo $r['username']; ?>'><?php echo $r['username']; ?> [<?php echo $r['cl_ADDED']; ?>]</option>
			<?php endforeach; ?>
			</select>
		<?php endif; ?>
		
		</p>
		 
		 <p class="form-label" style="padding-top:10px;"><label style="width:200px; text-align:left; height:10px;">Subject</label>
		 <?php echo form_input( array( 'class' => 'form-field', 'name' => 'subject', 'maxlength' => 255, 'value' => set_value('subject', ($this->input->get_post('subject') ? $this->input->get_post('subject') : 'Untitled')), 'size' => 75, 'style' => 'background:#E0F3FF; width:75%;' ) ); ?></p>
		 <br />
		 
		 <p class="form-label"> <?php echo form_textarea( array( 'class' => 'form-field', 'name' => 'message', 'value' => set_value('message', $this->input->post('message')), 'style' => 'width:95%;border:0px;margin:0px;height:300px;padding:10px 15px;letter-spacing:0em;font-size:14px;' ) ); ?></p>
		
		<br />
		
		<div class="left">
			<button type="submit" class="dark-grey medium"><span>Send Message</span></button>
			<button type="reset" class="grey medium"><span>Reset Form</span></button>
		</div>
		
		<div class="back"><a href="<?php echo base_url(); ?>inbox" rel="ajax">Go back to my inbox</a></div>
		
		<?php if($this->input->get_post('to') && count($this->co->storage['create_mail']) > 0): ?>
		<br /><br /><table width='100%' cellspacing='1' class='table'>
		<tr class='heading'><th colspan='2' class='center'>Your last 5 mails sent to/from <?php echo $this->input->get_post('to'); ?></th></tr>
			<?php foreach($this->co->storage['create_mail'] as $i=>$r): ?>
			<tr class='row<?php if($i % 2 == 1) { echo ' odd'; } ?>'>
				<td width='30%'><b>Sent:</b> <?php echo ($r['mail_time']+60*60*24 > now() ? strtolower(timespan($r['mail_time'], now())) . ' ago' : unix_to_human($r['mail_time'])); ?></td>
				<td>
					<b><?php echo ($r['mail_from'] == $this->co->user['userid'] ? $this->co->user['username'] : $this->input->get_post('to') ); ?> wrote:</b><br />
					<div style='overflow:auto; width:750px; font-size:11px;'>
						<?php echo nl2br(htmlentities(utf8_decode($r['mail_text']))); ?>	
					</div>
					
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php endif; ?>
	</div>
</form>