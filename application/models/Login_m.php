<?php 

	class Login_m extends CI_Model{

		public function get_admin_by_username($username)
		{
			return $this->db->get_where('admin', array('username' => $username))->row();
		}

	}