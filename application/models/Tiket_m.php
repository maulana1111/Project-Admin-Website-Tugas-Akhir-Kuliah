<?php 

	class Tiket_m extends CI_Model
	{

		public function getAll()
		{
			return $this->db->query('SELECT * FROM tiket WHERE tanggal >= now() + INTERVAL 1 DAY AND status = "belum_berkunjung"')->result();
		}

		public function getAllWhere($data)
		{
			return $this->db->query('SELECT * FROM tiket WHERE tanggal >= now() + INTERVAL 1 DAY AND status = "belum_berkunjung" AND nama LIKE "'.$data.'%" ORDER BY tanggal DESC')->result();
		}

		public function changeStatus($dataupdate, $datawhere)
		{
			$this->db->update("tiket", $dataupdate, $datawhere);
		}


	}