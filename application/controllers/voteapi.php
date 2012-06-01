<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Voteapi extends CI_Controller {

	public function btg()
	{
		$this->co->init();
		
		$user = $this->input->get('user');
		$id = 'btg';
		$message = 'Thanks for your vote at Best Text Games, we have credited you with 1 gold.';
		
		if(! $user) {
			echo 'This address does not have not sufficient parameters. Detected fraudulent request.';
			return false;
		}
		
		if($this->co->is_logged_in() == TRUE) {
			echo 'Sorry, we do not accept requests using this port. You need to use the selected portal to make your request.';
			return false;
		}
		
		if($this->db->select('userid')->from('username_cache')->where('userid', $user)->count_all_results() == 0) {
			echo 'No user has been found.';
			return false;
		}
		
		$q = $this->db->select('*')->from('votes')->where('userid', $user)->where('list', $id)->count_all_results();
		
		if($q > 0) {
			echo 'Vote has already been stored in memory. No longer accepting pings at this resolved address until next 24 hours.';
			return false;
		}
		
		$this->db->insert('votes', array(
				'userid' => $user,
				'list' => $id
			)
		);
		
		if($this->db->select('*')->from('totalvotes')->where('list', $id)->count_all_results() == 0) {
			$this->db->insert("totalvotes", array(
					'votes' => 1,
					'list' => $id
				)
			);
		} else {
			$this->db->query("UPDATE totalvotes SET votes = votes + 1 WHERE list = ? LIMIT 1", array( $id ));
		}
		
		/* Reward crystals */
		$this->co->statistics_up('total_votes_made');
		$this->db->query("UPDATE users SET crystals = crystals + 1 WHERE userid = ? LIMIT 1;", array( $user ));
		$this->co->event_add($user, $message, TRUE);
		
		echo 'Vote has been pinged. Thanks.';
	}
}