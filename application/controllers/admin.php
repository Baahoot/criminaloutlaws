<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Admin extends CI_Controller {

	public function index()
	{
		
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Admin Panel' ));
		$this->co->init();

		$id = $this->co->whoami();
		
		if($id['username'] != 'oxidati0n') {
			show_404();
		}
		
		if($this->input->get('do') == 'newcrime') {
		
		if($_POST) {
			$item = $this->input->post('item');
			
			$this->db->insert("crimes", array(
					'crimeNAME' => $this->input->post('name'),
					'crimeBRAVE' => $this->input->post('brave'),
					'crimePERCFORM' => $this->input->post('percform'),
					'crimeSUCCESSMUNY' => $this->input->post('money'),
					'crimeSUCCESSCRYS' => $this->input->post('crys'),
					'crimeSUCCESSITEM' => $item,
					'crimeGROUP' => $this->input->post('group'),
					'crimeITEXT' => $this->input->post('itext'),
					'crimeSTEXT' => $this->input->post('stext'),
					'crimeFTEXT' => $this->input->post('ftext'),
					'crimeJTEXT' => $this->input->post('jtext'),
					'crimeJAILTIME' => $this->input->post('jailtime'),
					'crimeJREASON' => $this->input->post('jailreason'),
					'crimeXP' => $this->input->post('crimexp')
				)
			);
			
print "Crime created!<script>alert('Crime created');</script>";
		}
		
		$cg = '';
		foreach($this->co->crimegroups as $i=>$cgdata) {
			$cg .= '<option value="'.$cgdata['cgID'].'">'.$cgdata['cgNAME'].'</option>';
		}
		
		$it = '';
		
		$e = $this->db->query("SELECT * FROM items ORDER BY itmname ASC")->result_array();
		foreach($e as $i=>$itmdata) {
			$it .= '<option value="'.$itmdata['itmid'].'">'.$itmdata['itmname'].'</option>';
		}
		
		print "Adding a new crime.<br />
		<iframe name='ncrime' frameborder='0'></iframe>
<form method='post' target='ncrime'>
Name: <input type='text' name='name' /><br />
Brave Cost: <input type='text' name='brave' /><br />
Success % Formula: <input type='text' name='percform' value='((WILL*0.8)/2.5)+(LEVEL/4)' /><br />
Success Money: <input type='text' name='money' /><br />
Success Crystals: <input type='text' name='crys' /><br />
Success Item: <select name='item'><option value='0'>None</option>{$it}</select><br />
Group: <select name='group'>{$cg}</select><br />
Initial Text: <textarea rows=4 cols=40 name='itext'  /></textarea><br />
Success Text: <textarea rows=4 cols=40 name='stext' /></textarea><br />
Failure Text: <textarea rows=4 cols=40 name='ftext' /></textarea><br />
Jail Text: <textarea rows=4 cols=40 name='jtext' /></textarea><br />
Jail Time: <input type='text' name='jailtime' /><br />
Jail Reason: <input type='text' name='jailreason' /><br />
Crime XP Given: <input type='text' name='crimexp' /><br />
<input type='submit' value='Create Crime' /></form>";
		
			exit;
		}
		
		$this->form_validation->set_rules('itmname', 'Item Name', 'min_length[1]|required');
		
		if($this->form_validation->run()) {
			
			$efx1 = serialize(array("stat" => $this->input->post('effect1stat'), "dir" => $this->input->post('effect1dir'), "inc_type" => $this->input->post('effect1type'), "inc_amount" => abs((int) $this->input->post('effect1amount'))));
			$efx2 = serialize(array("stat" => $this->input->post('effect2stat'), "dir" => $this->input->post('effect2dir'), "inc_type" => $this->input->post('effect2type'), "inc_amount" => abs((int) $this->input->post('effect2amount'))));
			$efx3 = serialize(array("stat" => $this->input->post('effect3stat'), "dir" => $this->input->post('effect3dir'), "inc_type" => $this->input->post('effect3type'), "inc_amount" => abs((int) $this->input->post('effect3amount'))));
		
			$this->db->insert("items", array(
					'itmtype' => $this->input->post('itmtype'),
					'itmname' => $this->input->post('itmname'),
					'itmdesc' => $this->input->post('itmdesc'),
					'itmbuyprice' => $this->input->post('itmbuyprice'),
					'itmsellprice' => $this->input->post('itmsellprice'),
					'itmbuyable' => ($this->input->post('itmbuyable') == 1 ? TRUE : FALSE),
					'effect1_on' => $this->input->post('effect1on'),
					'effect1' => $this->input->post('effect1on') == 1 ? $efx2 : '',
					'effect2_on' => $this->input->post('effect2on'),
					'effect2' => $this->input->post('effect2on') == 1 ? $efx2 : '',
					'effect3_on' => $this->input->post('effect3on'),
					'effect3' => $this->input->post('effect3on') == 1 ? $efx3 : '',
					'weapon' => $this->input->post('weapon'),
					'armor' => $this->input->post('armor'),
					'caught' => $this->input->post('caught')
				)
			);
			
			$new_id = $this->db->insert_id();
			
			if($this->input->post('itmshop') > 0) {
				$ims = $this->input->post('itmshop');
			
				$this->db->insert("shopitems", array(
						'sitemSHOP' => $this->input->post('itmshop'),
						'sitemITEMID' => $new_id	
					)
				);
			
			}
		
			$out = "The {$_POST['itmname']} Item was added to the game.<br /><script> alert('The {$_POST['itmname']} Item was added to the game.'); </script>";
		
		} else {
			$out = (validation_errors()) ? validation_errors() . ' <script>' . validation_errors() . '</script>' : '';
		}
		
		$itmt = $this->co->get_item_types();
		$itmtype = "";
		foreach($itmt as $itmtypedata) { $itmtype .= "<option value='{$itmtypedata['itmtypeid']}'>{$itmtypedata['itmtypename']}</option>"; }
		
		$itmshop = $this->co->get_shops();
		$itmshp = "";
		foreach($itmshop as $shopdata) { $itmshp .= "<option value='{$shopdata['shopID']}'>{$shopdata['shopNAME']}</option>"; }
		
		$out .= "<h3>Adding an item to the game</h3><iframe width='1' height='1' frameborder='0' name='ifitem'></iframe><form method='post' target='ifitem'>
					<p>Item Name: " . form_input('itmname', set_value('itmname', '')) . "</p>
					<p>Item Desc.: " . form_input('itmdesc', set_value('itmdesc', '')) . "</p>
					<p>Item Type: <select name='itmtype'>".$itmtype."</select></p>
					<p>Item Buyable: " . form_checkbox('itmbuyable', 1, set_checkbox('itmbuyable', '')) . "</p>
					<p>Item Price: \$" . form_input('itmbuyprice', set_value('itmbuyprice', '')) . "</p>
					<p>Item Sell Value: \$" . form_input('itmsellprice', set_value('itmsellprice', '')) . "</p><br />
					<hr />
					<p><b>Usage Form</b></p>
					<p><b><u>Effect 1</u></b></p>
					<p>On? <input type='radio' name='effect1on' value='1' /> Yes <input type='radio' name='effect1on' value='0' checked='checked' /> No</p>
					<p>Stat: <select name='effect1stat' type='dropdown'>
<option value='energy'>Energy</option><option value='will'>Will</option><option value='brave'>Brave</option><option value='hp'>Health</option><option value='strength'>Strength</option><option value='agility'>Agility</option><option value='guard'>Guard</option><option value='labour'>Labour</option><option value='IQ'>IQ</option><option value='hospital'>Hospital Time</option><option value='jail'>Jail Time</option><option value='money'>Money</option><option value='crystals'>Crystals</option><option value='cdays'>Education Days Left</option><option value='bankmoney'>Bank money</option><option value='cybermoney'>Cyber money</option><option value='crimexp'>Crime XP</option></select>
Direction: <select name='effect1dir' type='dropdown'>
<option value='pos'>Increase</option>
<option value='neg'>Decrease</option>
</select></p>
<p>Amount: <input type='text' name='effect1amount' value='0' /> <select name='effect1type' type='dropdown'>
<option value='figure'>Value</option>
<option value='percent'>Percent</option>
</select></p>
<p><b><u>Effect 2</u></b></p>
<p>On? <input type='radio' name='effect2on' value='1' /> Yes <input type='radio' name='effect2on' value='0' checked='checked' /> No</p>
<p>Stat: <select name='effect2stat' type='dropdown'>
<option value='energy'>Energy</option>
<option value='will'>Will</option>
<option value='brave'>Brave</option>
<option value='hp'>Health</option>
<option value='strength'>Strength</option>
<option value='agility'>Agility</option>
<option value='guard'>Guard</option>
<option value='labour'>Labour</option>
<option value='IQ'>IQ</option>
<option value='hospital'>Hospital Time</option>
<option value='jail'>Jail Time</option>
<option value='money'>Money</option>
<option value='crystals'>Crystals</option>
<option value='cdays'>Education Days Left</option>
<option value='bankmoney'>Bank money</option>
<option value='cybermoney'>Cyber money</option>
<option value='crimexp'>Crime XP</option>
</select> Direction: <select name='effect2dir' type='dropdown'>
<option value='pos'>Increase</option>
<option value='neg'>Decrease</option>
</select></p>
<p>Amount: <input type='text' name='effect2amount' value='0' /> <select name='effect2type' type='dropdown'>
<option value='figure'>Value</option>
<option value='percent'>Percent</option>
</select></p>
<p><b><u>Effect 3</u></b></p>
<p>On? <input type='radio' name='effect3on' value='1' /> Yes <input type='radio' name='effect3on' value='0' checked='checked' /> No</p>
<p>Stat: <select name='effect3stat' type='dropdown'>
<option value='energy'>Energy</option>
<option value='will'>Will</option>
<option value='brave'>Brave</option>
<option value='hp'>Health</option>
<option value='strength'>Strength</option>
<option value='agility'>Agility</option>
<option value='guard'>Guard</option>
<option value='labour'>Labour</option>
<option value='IQ'>IQ</option>
<option value='hospital'>Hospital Time</option>
<option value='jail'>Jail Time</option>
<option value='money'>Money</option>
<option value='crystals'>Crystals</option>
<option value='cdays'>Education Days Left</option>
<option value='bankmoney'>Bank money</option>
<option value='cybermoney'>Cyber money</option>
<option value='crimexp'>Crime XP</option>
</select> Direction: <select name='effect3dir' type='dropdown'>
<option value='pos'>Increase</option>
<option value='neg'>Decrease</option>
</select></p>
<p>Amount: <input type='text' name='effect3amount' value='0' /> <select name='effect3type' type='dropdown'>
<option value='figure'>Value</option>
<option value='percent'>Percent</option>
</select></p><br />
<p><b>Combat Usage</b></p>
<p>Weapon Power: <input type='text' name='weapon' value='0' /></p>
<p>Armor Defense: <input type='text' name='armor' value='0' /></p>
<br />
<p><b>Other</b></p>
<p>Chances of being caught by police with equipped (0 - 1) (1 = highest): <input type='text' name='caught' value='0.05' maxlength='4' size='5' /></p>
<br />
<p><b>Add to Shop</b></p>
<select name='itmshop'>
<option value='0'>None</option>".$itmshp."
</select><br /><br />
<input type='submit' value='Add Item To Game' /></form>";

		$this->load->view('internal/header');
		$this->output->append_output($out);
		$this->load->view('internal/footer');

	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */