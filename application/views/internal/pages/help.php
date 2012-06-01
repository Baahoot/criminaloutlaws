<h3 class="stylish">Criminal Outlaws Help</h3>
<p>This page is a tutorial which helps you to understand how to play Criminal Outlaws and what everything in the game means for your player.</p>
<br />
<h5>You</h5>
<p>In Criminal Outlaws, you are defined as a player who is very poor and could not afford many important lessons for a person with one of them being state education. You are living in downtown New York, which has a high poverty rate and as a result you have to deal with the high rate of criminal activity in the area. As you have no other choice but to enter the streets, you want to find the best way to get rich and afford the lavish lifestyle you've always wanted but there's so many people and not so much money, so you have to make difficult choices but you get the choice of where you go and what you do.</p>
<br />
<br />
<h5>Area Guides</h5>
<p>Each box below describes more about each area so you can learn about them.</p>
<br />
<?php $i = $this->config->item('help'); ?>

<?php foreach($i as $k=>$v): ?>
	<a href="<?php echo base_url() . 'help/faq?item=' . $k; ?>" rel="ajax">
		<div class="grid_1 omega alpha" style="width:19%; margin-right:1%; background:#eee; border:1px #bbb solid; padding:5px 0;">
			<p style='font-size:16px; font-weight:bold;' class="center"><?php echo $v['title']; ?></p>
		</div>
	</a>
<?php endforeach; ?>
<div class="clear"></div>
<br />
<br />
<h5>Menu</h5>
<p>At the left of every page contains a menu which you use to navigate around each area of the site quickly, and below we'll describe exactly what each links allows you to do.</p>
<br />
<p><b>My Inventory:</b> This is where the items you currently have bought, earnt or received are managed and equipped.</p>
<p><b>Explore:</b> This brings up a list of possible things you can do in your current city.</p>
<p><b>Events:</b> These are notifications which are sent to you based on your actions and other people's actions which affect you.</p>
<p><b>Inbox:</b> This is your personal inbox and allows you to see messages you've received and the ability to send messages.</p>
<p><b>Gym:</b> This allows you to train your personal stats, including your Force, Speed, Defence and Labour.</p>
<p><b>Crimes:</b> This is where you go to commit crimes in attempt to earn money, gold and other possible things.</p>
<p><b>Search:</b> This is where you can search for other players in the game more easily.</p>
<p><b>Courses:</b> This allows you to improve your stats by completing a variety of courses.</p>
<p><b>Job:</b> This allows you to either apply for a job, or do your work shifts in the job you currently have.</p>
<p><b>Hospital:</b> This is a local hospital where people who have been hospitalized go to recover.</p>
<p><b>Jail:</b> This is where people who have committed a 'crime against the state' will go to complete their jail time.</p>
<br />
<p><b>Preferences:</b> This is where you go to change your personal settings for your account.</p>
<p><b>Help:</b> You are looking at it right now, it's this page which helps you learn more about the game.</p>
<p><b>My Profile:</b> This allows you to view your profile and see how others can see you.</p>
<p><b>Logout:</b> This allows you to securely log out of your account.</p>
<br />
<br />

<!-- h5>Explore</h5>
<p>This allows you to explore the city and be able to do a variety of things as you will be able to see below.</p>
<br />
<p><b>:</b> </p>
<br / -->