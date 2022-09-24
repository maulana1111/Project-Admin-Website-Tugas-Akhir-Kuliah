<?php 

	class Api_m extends CI_Model
	{
		public function getDataAdmin($username)
		{
			return $this->db->get_where("admin", array("username" => $username))->row();
		}
	}