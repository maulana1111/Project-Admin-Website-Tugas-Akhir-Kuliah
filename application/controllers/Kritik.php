<?php 

	class Kritik extends BackEnd_Controller{

		public function index()
		{
			$data['page'] = 'pages/kritik/kritik';
			$data['data'] = $this->kritik_m->getAll();
			$this->load->view('tamplate', $data);
		}

		public function delete($id)
		{
			$this->kritik_m->delete($id);	
			$this->session->set_flashdata('success', 'Data Berhasil di Hapus');
			redirect('kritik');
		}

	}