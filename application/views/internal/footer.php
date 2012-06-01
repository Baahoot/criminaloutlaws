<br />
<?php if( $this->input->is_ajax_request() && $this->co->user['is_ajax'] == 0) { ?><script> window.location.reload(); </script><?php } ?>
<?php if( $this->input->is_ajax_request()) { /* ?>
<script> if(typeof CO_SESSION == 'undefined') { top.location = top.location.hash.replace('#!/', '<?php echo base_url(); ?>'); } </script>
<?php */ } else { ?></div>
</div>

<div class="clear"></div>

<?php /* <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="150" height="150"><param name="movie" value="<?php $this->co->base(); ?>/flash/clock/clock.swf?settings_path=<?php $this->co->base(); ?>/flash/clock/settings.xml"><param name="quality" value="high"><embed src="<?php $this->co->base(); ?>/flash/clock/clock.swf?settings_path=<?php $this->co->base(); ?>/flash/clock/settings.xml" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="150" height="150"></embed></object> */ ?>

	<?php if(@$this->co->storage['attack'] == 0): ?>
	<div class="grid_12 co_footer center alpha omega" style="width:100%;">
		<p style="float:left; padding:0 2% 7px; color:#333; margin-top:5px; font-size:11px;">
			<a href='<?php echo base_url() . 'privacy_policy'; ?>' rel='ajax' style='padding:0 5px 0 0;'>Privacy Policy</a> | 
			<a href='<?php echo base_url() . 'terms_of_service'; ?>' rel='ajax' style='padding:0 5px 0;'>Terms of Service</a> | 
			<a href='<?php echo base_url() . 'about_us'; ?>' rel='ajax' style='padding:0 5px 0;'>About Us</a> |
			<a href='<?php echo base_url() . 'contact_us'; ?>' rel='ajax' style='padding:0 5px 0;'>Contact Us</a> | 			<a href='<?php echo base_url() . 'help'; ?>' rel='ajax' style='padding:0 5px 0;'>Help</a>
		</p>
		<p style="float:right; padding:0 2% 7px; color:#555; margin-top:3px; margin-bottom:5px;"><span style='font-weight:bold;'>&copy; 2011 Criminal Outlaws</span>
		
			<?php /* <font style='color:#333;font-size:11px;display:none;'>
				<span id='__internal_major_release'><?php echo $this->config->item('major-release'); ?></span>
				<span id='__internal_minor_release'><?php echo $this->config->item('minor-release'); ?></span>
				<span id='__internal_render_time'><?php echo $this->benchmark->elapsed_time(); ?></span>
				<span id='__internal_memory_usage'><?php echo $this->benchmark->memory_usage();?></span>
				<span id='__internal_time'><?php echo unix_to_human(now()); ?></span>
			</font> */ ?>
		
		</p>
	</div>
	<?php endif; ?>
	
</div>

<div class="l" style="display:block;"><div style="display: block;"><img src="<?php $this->co->base(); ?>/images/l.gif"></div></div>

<?php }

if( !$this->input->is_ajax_request()) { ?>
<!-- JavaScript && GA -->
<script type="text/javascript" src="<?php $this->co->base(); ?>/scripts/jquery.js?0"></script>
<!-- script type="text/javascript" src="<?php $this->co->base(); ?>/scripts/modernizr.js?0"></script -->
<script type="text/javascript">
	var CO_DIR = '<?php if($_SERVER['HTTP_HOST'] == 'localhost') { echo '/RPG/'; } else { echo '/'; } ?>';
	var CO_SESSION = '<?php echo $this->co->get_session(); ?>';
	var TIMESTAMP = '<?php echo now(); ?>';
	var CO_PATH = '<?php echo $this->uri->uri_string(); ?>';
	var CO_URL = '<?php echo base_url(); ?>';
	var CO_CDN_URL = '<?php $this->co->base(); ?>';
</script>
<script type="text/javascript" src="<?php $this->co->base(); ?>/scripts/application-internal.js?0"></script>

</body>
</html><?php } ?>
<?php
	$this->db->close();
	$this->redis->__destruct();
?>