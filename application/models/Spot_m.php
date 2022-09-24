<?php 	

	class Spot_m extends CI_Model{

		public function getAll()
		{
			return $this->db->get('spot_menarik')->result();
		}
		public function insert_data($data)
		{
			$this->db->insert('spot_menarik', $data);
		}

		public function getDetail($id)
		{
			return $this->db->get_where('spot_menarik', array('id' => $id))->row();
		}
		public function delete_data($id, $id_gambar)
		{
			unlink("uploads/spot/".$id_gambar);
			$this->db->delete('spot_menarik', array('id' => $id));
		}

		public function getAllNotId($id)
		{
			$this->db->where('id !=', $id);
			return $this->db->get('spot_menarik')->result();
		} 

		public function update_data($data, $where, $id_gambar){
			unlink("uploads/spot/".$id_gambar);
			$this->db->update('spot_menarik', $data, $where);
		}

		public function updateDataWithoutImg($data, $where){
			$this->db->update('spot_menarik', $data, $where);
		}

	}