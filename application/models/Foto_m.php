<?php 

	class Foto_m extends CI_Model{

		public function getAll()
		{	
			$this->db->select('foto.*, kategori.title');
			$this->db->from('foto');
			$this->db->join('kategori', 'foto.category_id = kategori.id');
			return $this->db->get()->result();
		}

		public function insert_data($data)
		{
			$this->db->insert('foto', $data);
		}

		public function getDetail($id){
			return $this->db->get_where('foto', array('id' => $id))->row();
		}

		public function delete_data($id, $id_gambar)
		{
			unlink("uploads/foto/".$id_gambar);
			$this->db->delete('foto', array('id' => $id));
		}


	}