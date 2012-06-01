<?php $ir = $this->co->__internal_user(); ?>
<center><p><b>You begin to roam the <?php echo $this->co->user['cityname']; ?> streets, and see a host of areas to explore.</b></p></center>

<div class="grid_3 left" style="padding-top:10px; width:31%; height:150px;">
<p><b style='padding:0 15px;background:#555; color:#eee;'>Marketplace</b></p>
<p><a href='<?php echo base_url(); ?>shops' rel='ajax'>Shops</a></p>
<p><a href='<?php echo base_url(); ?>market/item' rel='ajax'>Item Market</a></p>
<p><a href='<?php echo base_url(); ?>market/gold' rel='ajax'>Gold Market</a></p>
</div>
<div class="grid_3 center" style="padding-top:10px; width:31%; height:150px;">
<p><b style='padding:0 15px;background:#555; color:#eee;'>Big Money</b></p>
<p><a href='<?php echo base_url(); ?>airport' rel='ajax'>Airport</a></p>
<p><a href='<?php echo base_url(); ?>estate' rel='ajax'>Real Estates</a></p>
<p><a href='<?php echo base_url(); ?>bank/home' rel='ajax'>Local Bank</a></p>
<p><a href='<?php echo base_url(); ?>stocks' rel='ajax'>Stock Market <b style='color:#336699;'>[fixed]</b></a></p>
</div>
<div class="grid_3 right" style="padding-top:10px; width:31%; height:150px;">
<p><b style='padding:0 15px;background:#555; color:#eee;'>Black Market</b></p>
<p><a href='<?php echo base_url(); ?>bases/all' rel='ajax'>View All Gangs (coming soon)</a></p>
<p><a href='<?php echo base_url(); ?>bases/create' rel='ajax'>Create a Gang (coming soon)</a></p>
<p><a href='<?php echo base_url(); ?>lottery' rel='ajax'>Lottery</a></p>
</div>

<div class="grid_3 left" style="padding-top:30px; width:31%;">
<p><b style='padding:0 15px;background:#555; color:#eee;'>City</b></p>
<p><a href='<?php echo base_url(); ?>hospital' id='__internal_hospital' rel='ajax'>Hospital (<?php echo $ir['hospital_count']; ?>)</a></p>
<p><a href='<?php echo base_url(); ?>jail' id='__internal_jail' rel='ajax'>Jail (<?php echo $ir['jail_count']; ?>)</a></p>
<p><a href='<?php echo base_url(); ?>courses' rel='ajax'>Courses</a></p>
<p><a href='<?php echo base_url(); ?>job' rel='ajax'><?php echo ($this->co->user['jobrank'] > 0) ? 'Your Job' : 'Job Centre'; ?></a></p>
</div>
<div class="grid_3 center" style="padding-top:30px; width:31%;">
<p><b style='padding:0 15px;background:#555; color:#eee;'>Mayor's Office</b></p>
<p><a href='<?php echo base_url(); ?>users' rel='ajax'>User List</a></p>
<p><a href='<?php echo base_url(); ?>staff_list' rel='ajax'>Staff List</a></p>
<p><a href='<?php echo base_url(); ?>statistics' rel='ajax'>Criminal Outlaws Stats</a></p>
<p><a href='<?php echo base_url(); ?>online' rel='ajax'>Users Online (<?php echo number_format($this->co->storage['online']); ?>)</a></p>
</div>
<div class="grid_3 right" style="padding-top:30px; width:31%;">
<p><b style='padding:0 15px;background:#555; color:#eee;'>Redemption</b></p>
<p><a href='<?php echo base_url(); ?>temple' rel='ajax'>Gold Temple</a></p>
</div>
<div class="grid_9 center"><div class="hr"></div></div>
<div class="grid_9 center" style="width:100%;">
<p><strong>Did you know? If you refer a friend to Criminal Outlaws with the link below, they get $50 and you get $75<?php if(!in_array('refer', $this->co->user['badges'])): ?> and the <img src='<?php $this->co->base(); ?>/badges/refer.gif'> badge<?php endif; ?>!</strong></p>
<p><span><input readonly style='text-align:center; font-family:verdana; font-size:13px; padding:3px 5px;' type='text' value='http://www.criminaloutlaws.com/refer/id/<?php echo $this->co->user['username']; ?>' size='60' onclick='this.select()' /></span></p>
</div>