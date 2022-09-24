<?php 

	class File_m extends CI_Model
	{
		public function insert_data($data)
		{
			$this->db->insert('file', $data);
			if($this->db->affected_rows() > 0)
			{
				return true;
			}else{
				return false;
			}
		}

		public function getAll()
		{
			return $this->db->get("file")->result();
		}

		public function getById($id)
		{
			return $this->db->get_where("file", array("id"=>$id))->row();
		}

		public function getLastId()
		{
			return $this->db->select('*')->order_by('id',"desc")->limit(1)->get('file')->row();
		}

		public function get_where_data($id)
		{
			return $this->db->get_where("file", array('id' => $id))->row();
		}

		public function update_data($dataupdate, $datawhere)
		{
			$this->db->update('file', $dataupdate, $datawhere);
		}

		public function delete_data($datawhere)
		{
			$this->db->delete('file', $datawhere);
		}
	}