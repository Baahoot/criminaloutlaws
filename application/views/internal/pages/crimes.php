<h3 class="stylish">Crimes <span><a href="<?php echo base_url(); ?>help/faq?item=crimes" rel="ajax">Learn more about how crimes work</a></span></h3>
<p>You look around and try to see any opportunities to earn money through crimes.</p>
<br />
<?php
$q2 = $this->db->select('*')->from('crimes')->order_by('crimeBRAVE', 'ASC')->get()->result_array();
$count = array();
foreach($q2 as $i=>$r2) {
	$crimes[$r2['crimeID']] = $r2;
	@$count[$r2['crimeGROUP']]++;
}

?>
<table width='100%' class='table'>
<tr class='heading'>
	<th width='60%'>Crime</th>
	<th width='25%'>Nerve Level</th>
	<th>&nbsp;</th>
</tr>
<?php
foreach($this->co->crimegroups as $crimegid => $crimegdata)
{
	$append = ''; $i = 0; $disabled = 0;
	if($crimegdata['cgMINLEVEL'] > $this->co->user['level']) { $disabled = 1; $append = ' style="opacity:0.2; filter:alpha(opacity=20);"'; }
	
	echo "<tr class='itmhead'".$append."><th colspan='4'>{$crimegdata['cgNAME']}</th></tr>";
	foreach($crimes as $crimedata)
	{
		if($crimedata['crimeGROUP'] == $crimegdata['cgID']): $i++; ?>
		<tr<?php echo $append; ?> class="row<?php /* if($i % 2 == 0): echo ' odd'; endif; */ ?><?php if($count[$crimedata['crimeGROUP']] == $i): echo ' row-end'; endif; ?>" style="height:30px;<?php if($crimedata['crimeBRAVE'] > $this->co->user['brave']): ?> opacity:0.5;<?php endif; ?>">
			<td class="row-left"><?php echo $crimedata['crimeNAME']; ?></td>
			<td><?php echo $crimedata['crimeBRAVE']; ?> Nerve <font style='color:#999;'>(<?php echo round(($crimedata['crimeBRAVE']/$this->co->user['maxbrave'])*100) . '%'; ?>)</font></td>
			<td class="row-right"><?php if($crimedata['crimeBRAVE'] > $this->co->user['brave']): ?><b>Not enough nerve</b><?php elseif($disabled): ?><b>Cannot perform crime</b><?php else: ?><a href="<?php echo base_url(); ?>crimes/perform?__unique__=<?php echo $this->co->get_session(); ?>&id=<?php echo $crimedata['crimeID']; ?>" rel="ajax-hidden"><button class="black">Do this crime</button></a><?php endif; ?></td>
		</tr>
		<?php if($count[$crimedata['crimeGROUP']] == $i):?><tr class="row-spacer"><td colspan="3"></td></tr><?php endif; ?>
		<?php unset($crimes[$crimedata['crimeID']]); endif;
	}
}
print "</table>";
?>