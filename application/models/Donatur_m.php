<?php 

	class Donatur_m extends CI_Model
	{
		public function getAll()
		{
			return $this->db->get('donatur')->result();
		}

		public function changeStatus($dataupdate, $where)
		{
			$this->db->update('donatur', $dataupdate, $where);
		}

		public function changeStatusApi($dataupdate, $where)
		{
			$this->db->update('donatur', $dataupdate, $where);
			if($this->db->affected_rows() > 0)
			{
				$this->db->update('parent_donatur', $dataupdate, $where);
				return true;
			}else{
				return false;
			}
		}

		public function insert_data($datainsert)
		{
			$this->db->insert('donatur', $datainsert);
			if($this->db->affected_rows() > 0)
			{
				return true;
			}else{
				return false;
			}
		}
		public function insert_data_parent($datainsert)
		{
			$this->db->insert('parent_donatur', $datainsert);
			if($this->db->affected_rows() > 0)
			{
				return true;
			}else{
				return false;
			}
		}

		public function getDataWhere($id)
		{
			return $this->db->get_where('donatur', array('id' => $id))->row();
		}

		public function getDataFilter($from, $to, $opsi)
		{		
			return $this->db->query("SELECT * FROM parent_donatur WHERE (tanggal_donate BETWEEN '$from' AND '$to') AND status = '$opsi' ORDER BY id DESC")->result();
		}

		public function getDataParentWhere($id)
		{
			return $this->db->get_where('parent_donatur', array('id' => $id))->row();
		}

		public function enkripsiData($dataupdate, $datawhere)
		{
			$this->db->update('donatur', $dataupdate, $datawhere);
		}

		public function dekripsiData($dataupdate, $datawhere)
		{
			$this->db->update('donatur', $dataupdate, $datawhere);
		}
	}