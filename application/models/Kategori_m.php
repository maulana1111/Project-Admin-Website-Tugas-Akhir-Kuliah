<?php 

	class Kategori_m extends CI_Model{

		public function getAll()
		{
			return $this->db->get('kategori')->result();
		}

		public function insert_data($data)
		{
			$this->db->insert('kategori', $data);
		}

		public function delete_data($id){
			$this->db->delete('kategori', array('id' => $id));
		}

		public function getAllNotId($id)
		{
			return $this->db->get_where('kategori', array('id !=' => $id))->result();
		}

		public function getDetail($id)
		{
			return $this->db->get_where('kategori', array('id' => $id))->row();
		}

		public function update_data($data, $where)
		{
			$this->db->update('kategori', $data, $where);
		}

	}