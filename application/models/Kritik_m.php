<?php 

	class Kritik_m extends CI_Model{

		public function getAll(){
			return $this->db->get('kritik_saran')->result();
		}

		public function delete($id)
		{
			$this->db->delete('kritik_saran', array('id' => $id));
		}

	}