<div class="clear"></div>
	<div class="grid_12 co_footer" style="position:relative;">
		<!-- p>&copy; 2011 Criminal Outlaws</p -->
	</div>
	
</div>

<!-- JavaScript && GA -->
<?php /* <script type="text/javascript" src="<?php $this->co->base(); ?>/scripts/jquery.js?0"></script>
<!-- script type="text/javascript" src="<?php $this->co->base(); ?>/scripts/modernizr.js?0"></script -->
<script type="text/javascript" src="<?php $this->co->base(); ?>/scripts/application.js?0"></script>
<script type="text/javascript">if(typeof CO_SESSION != 'undefined') { alert('The system or a member of staff has forced you to logout of your account.'); window.location.reload(); } </script>
<script type="text/javascript">var CO_PATH = '<?php echo $this->uri->uri_string(); ?>'; var CO_URL = '<?php echo base_url(); ?>';  var CO_CDN_URL = '<?php $this->co->base(); ?>'; var ADAPT_CONFIG = { path: CO_CDN_URL + '/styles/formats/', dynamic: false, range: [ '0px  to 1280px = 960.min.css', '1280px = 1200.min.css' ], callback: function(i, width){ $("*[adapt-0], *[adapt-1], *[adapt-2]").each(function(){ $(this).attr('style', ''); }); $("*[adapt-"+i+"]").each(function(){ $(this).attr('style', $(this).attr('adapt-'+i)); }); } }; </script>
<script type="text/javascript" id="adapt-js" src="<?php $this->co->base(); ?>/scripts/adapt.min.js?0"></script> */ ?>

<div id="fb-root"></div>
<script> window.fbAsyncInit = function() { FB.init({appId: '<?php echo $this->config->item('facebook_app_id'); ?>', status: true, cookie: true, xfbml: true, oauth: true}); /**/ };

(function (d) {var js, id = 'facebook-jssdk';if (d.getElementById(id)) {return;}js = d.createElement('script');js.id = id;js.async = true;js.src = "//connect.facebook.net/en_US/all.js";d.getElementsByTagName('head')[0].appendChild(js);}(document));

$("[rel=fb-login]").click(function(){
    FB.login(function(response) {
      if (response.session && response.perms) {
        FB.api('/me',
          function(response) {
            window.location = '<?php echo base_url(); ?>/login/facebook#getJSWrapper';
          }
        );
      }
    } , {perms:'publish_stream, email, offline_access'}); 
});</script>

</body>
</html>