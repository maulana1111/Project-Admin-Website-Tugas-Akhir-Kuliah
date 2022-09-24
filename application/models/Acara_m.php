<?php 

	class Acara_m extends CI_Model{

		public function getAll()
		{	
			$this->db->select('acara.*, kategori.title');
			$this->db->from('acara');
			$this->db->join('kategori', 'acara.kategori_id = kategori.id');
			return $this->db->get()->result();
		}

		public function insertData($datainsert)
		{
			$this->db->insert('acara', $datainsert);
		}

		public function delete_acara($id)
		{
			unlink("uploads/acara/".$id_gambar);
			$this->db->delete('acara', array('id' => $id));
		}

		public function get_detail_acara($id)
		{
			$this->db->select('acara.*, kategori.title');
			$this->db->from('acara');
			$this->db->join('kategori', 'acara.kategori_id = kategori.id');
			$this->db->where('acara.id', $id);
			return $this->db->get()->row();
		}

		public function getAllNotId($id)
		{
			return $this->db->get_where('acara', array('id !=' =>  $id))->result();
		}

		public function updateData($dataupdate, $where, $id_gambar)
		{
			unlink("uploads/acara/".$id_gambar);
			$this->db->update('acara', $dataupdate, $where);
		}

		public function updateDataWithoutImg($dataupdate, $where)
		{
			$this->db->update('acara', $dataupdate, $where);
		}

	}