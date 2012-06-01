<h3 class="stylish">
	<a href="<?php echo base_url() . 'preferences'; ?>" rel="ajax">Preferences</a>
	 &rarr; Change Signature
</h3>
<p>This is an area beneath your profile which contains your signature and can state anything from your bio, wants and demands. <?php if($this->co->storage['cnt'] == 0): ?><br /><B>It costs <?php echo '$' . number_format( $this->config->item('signature-cost') ); ?> to buy a signature that you can use with your profile.</B><?php endif; ?></p>
<br />
<?php if($this->co->storage['cnt'] == 0): ?>

	<form action="<?php echo base_url() . 'preferences/change_signature'; ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax">
		<div class="field">
			<input type='hidden' name='__unique__' value='<?php echo $this->co->get_session(); ?>' />
			<input type='hidden' name='__type__' value='buy' />
		
			<?php if($this->co->user['money'] >= $this->config->item('signature-cost')): ?>
				<button type="submit" class="dark-grey xlarge"><p class="text-small">Buy a signature for your profile for <?php echo '$' . number_format( $this->config->item('signature-cost') ); ?></p></button>
			<?php else: ?>
				<button type="submit" class="dark-grey xlarge disabled-button"><p class="text-small">You need <?php echo '$' . number_format( $this->config->item('signature-cost') - $this->co->user['money'], 2); ?> more to buy a signature for your profile!</p></button>
			<?php endif; ?>
		
			<div class="back"><a href="<?php echo base_url(); ?>preferences" rel="ajax">Go back</a></div>
		</div>
	</form>

<?php else: ?>

	<?php if($this->co->storage['sig']): ?>
		<h5>Current Signature</h5>
		<div class="center" style="margin:0px; background:#eee; padding:10px; font-size:12px; font-family:verdana; width:100%;">
			<?php echo $this->co->parse_bbcode($this->co->storage['sig']); ?>
		</div>
		
		<br />
	<?php endif; ?>
	
	<h5>New Signature</h5>
	<form action="<?php echo base_url() . 'preferences/change_signature'; ?>" accept-charset="utf-8" class="stn-form label-inline simple" method="post" rel="form-ajax">
		<div class="field grid_12">
			<input type='hidden' name='__unique__' value='<?php echo $this->co->get_session(); ?>' />
			
				<textarea rel='resize' name='signature' id='signature' style="font-family:'courier new', arial; font-size:15px; letter-spacing:-0.05em;"><?php echo htmlentities($this->co->storage['sig']); ?></textarea>
		
				<br />
				<br />
		
				<button type="submit" class="dark-grey xlarge"><p class="text-small">Update Signature</p></button>
				<button type="reset" class="grey xlarge"><p class="text-small">Reset Form</p></button>
				
				<br />
				<br />
				
				<h5>Signature Help</h5>
				<p class="form-tiny">The signature does not support HTML, but does support BBcode and emoticons:</p>
				<br />
				<br />
				
				<?php echo smiley_js(); ?>
				
				<table width="99%" border="0" class="table">
				
				<tr class="heading">
					<th width='50%'>BBCode</th>
					<th>Emoticons</th>
				</tr>
				
				<tr class="row">
					<td style="vertical-align:top;">
						<p style="font-size:12px;" class="form-tiny"><b>[b]</b> Text <b>[/b]</b> &mdash; This bolds the text like <b>this</b>.</p><br />
						<p style="font-size:12px;" class="form-tiny"><b>[i]</b> Text <b>[/i]</b> &mdash; This makes the text go <i>italic</i>.</p><br />
						<p style="font-size:12px;" class="form-tiny"><b>[u]</b> Text <b>[/u]</b> &mdash; This makes the text <u>underline</u>.</p><br />
						<p style="font-size:12px;" class="form-tiny"><b>[s]</b> Text <b>[/s]</b> &mdash; This puts a line through the text like <s>this</s>.</p><br />
						<p style="font-size:12px;" class="form-tiny"><b>[img]</b> URL <b>[/img]</b> &mdash; This is to put an image in your signature.</p><br />
						<br />
						<p style="font-size:12px;" class="form-tiny"><b>[left]</b> Text <b>[/left]</b> &mdash; This aligns the text to the left.</p><br />
						<p style="font-size:12px;" class="form-tiny"><b>[right]</b> Text <b>[/right]</b> &mdash; This aligns the text to the right.</p><br />
						<br />
						<p style="font-size:12px;" class="form-tiny"><b>[link = </b> URL <b>]</b> Text <b>[/link]</b> &mdash; This <a style='font-size:12px;' href='http://www.criminaloutlaws.com'>hyperlinks</a> the text with the URL.</p><br />
						<p style="font-size:12px;" class="form-tiny"><b>[color = </b>#EE0000<b>]</b> Text <b>[/color]</b> &mdash; This colors the text in any <font color='#EE0000'>color</font> you want.</p><br />
						<p style="font-size:12px;" class="form-tiny"><b>[highlight = </b>yellow<b>]</b> Text <b>[/highlight]</b> &mdash; This highlights the text like <font style='background:yellow;'>this</font>. </p><br />
					</td>
				
					<td style="vertical-align:top;"><?php
								$image_array = get_clickable_smileys( $this->co->base(true) . '/emoticons' , 'signature');
								$col_array = $this->table->make_columns($image_array, 8);
								echo $this->table->generate($col_array);
						?></td>
				</tr>
				
				</table>
				<br />
				
				<div class="back"><a href="<?php echo base_url(); ?>preferences" rel="ajax">Go back</a></div>
		
		</div>
	</form>	

<?php endif; ?>