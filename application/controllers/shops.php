<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Shops extends CI_Controller {

	public function index()
	{
		$this->co->must_login();
		$this->co->set(array( 'title' => 'Criminal Outlaws | Shops' ));
		$this->co->init();

		$ir = $this->co->whoami();
		$this->co->storage['shops'] = $this->co->get_shop('shopLOCATION', $ir['location'], TRUE);
		
		$this->co->page('internal/pages/shops');
	}
	
	public function buyitem()
	{
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami();
		
		$id = $this->input->get('id');
		$item = $this->input->get('item');
		$__unique = $this->input->get('__unique');
		
		if($__unique != $this->co->get_session()) {
			show_404();
		}
		
		$shop = $this->co->get_shop('shopID', $id);
		
		if(! isset($shop['shopID'])) {
			show_404();
		}
		
		$q = $this->db->query("SELECT items.itmid, items.itmbuyprice, shopitems.sitemSHOP, shopitems.sitemITEMID, items.itmbuyprice, items.itmname FROM items LEFT JOIN shopitems ON shopitems.sitemITEMID=items.itmid WHERE itmid = ? AND itmbuyable = 1 LIMIT 1;", array( $item ))->result_array();
		
		if( ! isset($q[0]['itmid'])) {
			show_404();
		}
		
		if($q[0]['sitemSHOP'] != $shop['shopID']) {
			show_404();
		}
		
		if($shop['shopLOCATION'] != $ir['location']) {
			show_404();
		}
		
		$price = $q[0]['itmbuyprice'];
		
		if($price > $ir['money'])
		{
			$how_much_short = number_format($price - $ir['money'], 2);
			$this->co->notice('Sorry, you need $'.$how_much_short.' more to buy an '.$q[0]['itmname'].'!');
		} else {
		
			$this->co->remove_money($ir['username'], $price);
			$this->co->add_inventory($item);
		
			$this->co->statistics_up('total_items_bought');
			$this->co->notice('You have bought a ' . $q[0]['itmname'] . ' for $'.number_format($q[0]['itmbuyprice'], 2).'!');
		}
		
		$uri = 'shops/visit?id=' . $id;
		
		if(!$this->input->is_ajax_request()) {
				redirect(base_url() . $uri, 'location');
			} else {
				echo '<div id="redirect">' . base_url() . ($uri) . '</div>';
				echo '<meta http-equiv="refresh" content="2; ' . base_url() . $uri . '" />';
		}
	}
	
	public function visit()
	{
		$id = $this->input->get('id');
		$this->co->must_login();
		$this->co->init();
		$ir = $this->co->whoami();
		
		if($this->co->get_shop('shopID', $id) == FALSE || ! isset($id)) {
			show_404();
		}
		
		$shopdata = $this->co->get_shop('shopID', $id);
		
		if($shopdata['shopLOCATION'] != $ir['location']) {
			show_404();
		}
		
		$this->co->set(array( 'title' => 'Criminal Outlaws | Browse ' . $shopdata['shopNAME'] . ' Shop' ));
		$this->co->storage['shopdata'] = $shopdata;
		
		$this->co->storage['shopitems'] = $this->db->query("SELECT si.*, i.itmid, i.itmtype, i.itmname, i.itmdesc, i.itmbuyprice, i.itmsellprice, i.itmbuyable FROM shopitems si LEFT JOIN items i ON si.sitemITEMID=i.itmid WHERE si.sitemSHOP = ? AND i.itmbuyable = 1 ORDER BY i.itmtype ASC, i.itmbuyprice ASC", array( $id ))->result_array();
		
		foreach($this->co->storage['shopitems'] as $i=>$idata) {
			$itmtype = $this->co->get_item_type('itmtypeid', $idata['itmtype']);
			$a[$itmtype['itmtypename']][] = $idata;
		}
		
		$this->co->storage['shopitems'] = $a;
		
		$this->co->page('internal/pages/visitshop');
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */