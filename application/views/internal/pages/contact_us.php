<h3 class="stylish">Contact Us</h3>

<div class="grid_9 alpha">
	<!-- Contact Form -->
	<p class="medium stylish">As we are currently experiencing a huge growth in requests, we cannot guarantee everyone will receive a reply and when reporting users or content, neither can we guarantee that the reported material will be removed from the site.</p>
	<br />
	
	<form action="<?php echo base_url() . 'contact_us'; ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax-hidden">
	<input type='hidden' name='__unique__' value='<?php echo $this->co->get_session(); ?>' />
	<div class="field">
	
		<p class="form-label"><label style="width:75px; text-align:left; height:10px;">E-mail</label>
		 <?php echo form_input( array( 'class' => 'form-field', 'name' => 'email', 'maxlength' => 150, 'value' => $this->co->user['email'], 'size' => strlen($this->co->user['email']) * 1.3, 'disabled' => 'disabled' ) ); ?></p>
		 <br />
		 
		 <p class="form-label"><label style="width:75px; text-align:left; height:10px;">Subject</label>
		 <?php echo form_input( array( 'class' => 'form-field', 'name' => 'subject', 'maxlength' => 150, 'value' => set_value('subject', $this->input->post('subject')), 'size' => 92 ) ); ?></p>
		 <br />
		 
		 <p class="form-label"> <?php echo form_textarea( array( 'class' => 'form-field', 'name' => 'message', 'value' => set_value('message', $this->input->post('message')), 'style' => 'width:95%;border:0px;margin:0px;height:300px;padding:10px 15px;letter-spacing:0em;font-size:14px;' ) ); ?></p>
		
		<br />
		
		<div class="right">
			<button type="submit" class="dark-grey medium"><span>Open Ticket</span></button>
			<button type="reset" class="grey medium"><span>Reset Form</span></button>
		</div>
		
	</div>
</form>
	
</div>
<div class="grid_3 omega">
	<p class="o"><b>Notice</b></p>
	<p class="tiny o">You will receive your reply at <b><?php echo $this->co->user['email']; ?></b> so make sure that it is correct and you are able to receive the reply from us because it might be important. If your email needs updating, click <a href='<?php echo base_url() . 'preferences/change_email'; ?>' rel="ajax">here to update it.</a></p>
	<br />
	<!-- Information -->
	<p class="o"><b>Office Times:</b></p>
	<p class="tiny o">Mon: 1PM - 5PM</p>
	<p class="tiny o">Tue: 1PM - 5PM</p>
	<p class="tiny o">Wed: 2PM - 5.30PM</p>
	<p class="tiny o">Thu: 2PM - 5.30PM</p>
	<p class="tiny o">Fri: 1PM - 4PM</p>
	<p class="tiny o">Sat/Sun: <b>CLOSED</b></p>
	<p class="tiny o">Bank Hol: <b>CLOSED</b></p>
</div>