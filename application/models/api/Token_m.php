<?php 

	class Token_m extends CI_Model
	{
		public function getAllTokens()
		{
			return $this->db->get("user_tokens")->result();
		}

		public function insert_data($data)
		{
			$this->db->insert("user_tokens", $data);
			if($this->db->affected_rows() > 0)
			{
				return true;
			}else{
				return false;
			}

		}

		public function update_data($data, $where)
		{
			$this->db->update('user_tokens', $data, $where);			
		}

		public function delete_data($id)
		{
			$this->db->delete('user_tokens', array('id_admin' => $id));
			if($this->db->affected_rows() > 0)
			{
				return true;
			}else{
				return false;
			}
		}

		public function get_token_by_id_admin($id)
		{
			return $this->db->get_where('user_tokens', array('id_admin'))->row();
		}
	}