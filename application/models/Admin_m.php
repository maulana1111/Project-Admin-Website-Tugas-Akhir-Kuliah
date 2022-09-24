<?php 

	class Admin_m extends CI_Model{

		public function getAll()
		{
			return $this->db->get('admin')->result();
		}

		public function insert_data($data)
		{
			$this->db->insert('admin', $data);
		}

		public function delete_data($id)
		{
			$this->db->delete('admin', array('id' => $id));
		}

		public function getLastId()
		{
			return $this->db->select('*')->order_by('id', "desc")->limit(1)->get('admin')->row();
		}

		public function update_data($data, $where)
		{
			$this->db->update('admin', $data, $where);
			if($this->db->affected_rows() > 0)
			{
				return true;
			}else{
				return false;
			}

		}

		public function getDetail($id)
		{
			return $this->db->get_where('admin', array('id' => $id))->row();
		}

		public function getAllNotId($id)
		{
			return $this->db->get_where('admin', array('id !=' => $id))->result();
		}
		
	}