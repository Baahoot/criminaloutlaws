<h3 class="stylish">My Inbox<?php echo $this->co->storage['cnt']; ?> <span><a href="<?php echo base_url(); ?>help/faq?item=inbox" rel="ajax">Learn more about how mail works</a></span><?php if(count($this->co->storage['inbox']) > 0): ?> <span><a href="<?php echo base_url(); ?>inbox/archive"><b>Download Archive</b></a></span><?php endif; ?> <span><a href="<?php echo base_url(); ?>inbox/create" rel="ajax"><b>Create Mail</b></a></span></h3>
<br />
<table width='100%' cellspacing='1' class='table'>
<tr class='heading'><th width='25%'>Sender</th><th width='70%'>Message</th></tr>
<?php foreach($this->co->storage['inbox'] as $i=>$r): ?>
<tr class='row<?php echo ($i % 2 == 1 ? ' odd' : ''); ?><?php if($i == count($this->co->storage['inbox'])-1) { echo ' row-end'; } ?>'>
<td class="row-left" style="vertical-align:top;"><strong><?php echo ($r['mail_from'] > 0) ? $this->co->username_format($r) : 'SYSTEM'; ?></strong><br />
<?php echo $this->co->get_badges($r, 'small'); ?><br />
<p class='text-xxsmall'>Sent: <?php echo ($r['mail_time']+60*60*24 < now()) ? unix_to_human($r['mail_time']) : strtolower(timespan($r['mail_time'], now())) . ' ago'; ?></p></td>
<td class="row-right" style="vertical-align:top;">

	<div style='overflow:auto; width:750px;'>
		<strong style='margin:0px; padding:3px 10px;background:#2E2E2E;color:#eee;line-height:20px; float:left;'><?php echo $r['mail_subject']; ?></strong>
		<p class='text-xxsmall right' style='opacity:0.6;filter:alpha(opacity=60); height:15px; float:left; margin-top:-1px; padding:0 0 0 10px;'><?php if($r['mail_read'] == 0): ?><img src="<?php $this->co->base(); ?>/images/new.gif" border="0" /><?php endif; ?> <?php if($r['mail_from'] > 0): ?><a href='inbox/create?to=<?php echo $r['username']; ?>&subject=<?php echo urlencode('Re: ' . str_replace('Re: ', '', $r['mail_subject'])); ?>' style='padding:0;font-size:11px;' class='o' rel='ajax'>REPLY</a> &nbsp;|&nbsp; <?php endif; ?>
	<a href='inbox/delete?id=<?php echo $r['mail_id']; ?>&__sess__=<?php echo $this->co->get_session(); ?>' style='padding:0;font-size:11px;color:darkred;' class='o' rel='ajax-hidden'>DELETE</a></p>
		<div class="clear"></div>
		<font style="line-height:25px;"><?php echo nl2br(htmlentities(utf8_decode($r['mail_text']))); ?></font>
	</div>
	</td>
</tr>
<?php endforeach; ?>
<?php if(count($this->co->storage['inbox']) == 0): ?>
<tr class='row odd row-end'>
<td class="row-left row-right center" colspan="2">There are no mails sent to you in your inbox.</td>
</tr>
<?php endif; ?>
</table>