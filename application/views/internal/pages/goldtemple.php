<h3 class="stylish">Gold Temple</h3>
<p>Here you can redeem any valuable gold you might find into some other appealing things.</p>

<br />

<ul>
	<li style='font-size:14px;'><a href='<?php echo base_url() . 'temple/order?action=iq'; ?>' rel='ajax'>Trade gold for intelligence <b>(costs 1 gold for 2 intelligence)</b></a></li>
	<li style='font-size:14px;'><a href='<?php echo base_url() . 'temple/order?action=energy'; ?>' rel='ajax'>Trade gold for power <b>(costs 1 gold for 1 power)</b></a></li>
	<li style='font-size:14px;'><a href='<?php echo base_url() . 'temple/order?action=exp&__unique__='.$this->co->get_session(); ?>' rel='ajax-hidden'>Obtain a snapshot of your EXP levels <b>(costs 100 gold)</b></a></li>
</ul>

<!-- a href='<?php echo base_url() . 'temple/order?action=health'; ?>' rel='ajax-hidden'>Increase your HP 1,000 for 24 hours (costs 500 gold)</a><br / -->