<?php 

	class Berita_m extends CI_Model{

		public function getAll()
		{
			$this->db->select('berita.*, admin.nama');
			$this->db->from('berita');
			$this->db->join('admin', 'berita.penulis = admin.id');
			return $this->db->get()->result();
		}

		public function insert_data($data)
		{
			$this->db->insert('berita', $data);
		}

		public function getDetail($id){
			$this->db->select('berita.*, admin.nama');
			$this->db->from('berita');
			$this->db->join('admin', 'berita.penulis = admin.id');
			$this->db->where('berita.id', $id);
			return $this->db->get()->row();
		}

		public function delete_data($data, $id_gambar)
		{
			unlink("uploads/berita/".$id_gambar);
			$this->db->delete('berita', array('id' => $data));
		}

		public function getAllNotId($id)
		{
			$this->db->select('berita.*, admin.nama');
			$this->db->from('berita');
			$this->db->join('admin', 'berita.penulis = admin.id');
			$this->db->where('berita.id !=', $id);
			return $this->db->get()->result();
		}

		public function update_data($data, $where, $id_gambar){
			unlink("uploads/berita/".$id_gambar);
			$this->db->update('berita', $data, $where);
		}

		public function updateDataWithoutImg($data, $where){
			$this->db->update('berita', $data, $where);
		}

	}