<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php if($this->input->server('HTTP_HOST') != 'game.ssl.dotcloud.com'): ?>
		      xmlns:fb="http://www.facebook.com/2008/fbml"<?php endif; ?>>
<head>
		<title><?php $this->co->get('title'); ?></title>
		
		<!-- Styles -->
		<style type="text/css">
			@import "<?php $this->co->base(); ?>/styles/core.css?0";
			@import "<?php $this->co->base(); ?>/styles/central.css?0";
			@import "<?php $this->co->base(); ?>/styles/formats/960.min.css";
			@import "http<?php echo ($this->input->server('HTTP_HOST') == 'game.ssl.dotcloud.com' ? 's' : ''); ?>://fonts.googleapis.com/css?family=Questrial";
		</style>
		<?php /* <noscript><link rel="stylesheet" type="text/css" href="<?php $this->co->base(); ?>/styles/formats/960.min.css?0" /></noscript> */ ?>
		
		<!--[if IE]> <style>	div.captcha-box a { position:relative; top:-50px; left:100px; } </style> <![endif]-->

</head>
<body>

<?php $n = $this->co->get_notice(); if(isset($n) && $n != ""): ?>
	<div class="app-notice">
		<span><?php echo $n; ?></span>
	</div>
	<noscript>
		<div class="app-notice" style="display:block;">
		 	<span><?php echo $n; ?> <a href='' style='font-size:10px;'>Close</a></span>
		</div>
	</noscript>
<?php endif; ?>

<div class="container_12 standard_theme">

	<!-- div class="grid_12 co_static">
		<div class="response notice center" id="bbv" adapt-0="display:block;">We recommend you play <b>Criminal Outlaws</b> on at least a 1280x720 screen resolution</div>
	</div -->
	
	<div class="clear"></div>

	<div class="grid_12 co_app_logo_background"></div>

	<div class="grid_12 co_app_logo">
		<a href="<?php echo base_url(); ?>" rel="link-login"><h1 class="white-logo-new"><span>Criminal Outlaws</span></h1></a>
	</div>