<?php 

	class Tiket extends BackEnd_Controller
	{
		public function index()
		{
			$data['page'] = 'pages/tiket/index';
			$data['data'] = $this->tiket_m->getAll();
			$this->load->view('tamplate', $data);
		}
		public function like()
		{
			$data['page'] = 'pages/tiket/getLike';
			$data['data'] = $this->tiket_m->getAllWhere($_POST['search']);
			$this->load->view('tamplate', $data);
		}
		public function changeStatusTrue($id)
		{
			$this->tiket_m->changeStatus(array('status' => "berkunjung"), array('id' => $id));
			$this->session->set_flashdata('success', 'Data Berhasil di ubah');
			redirect('tiket');
		}
		public function changeStatusFalse($id)
		{
			$this->tiket_m->changeStatus(array('status' => "batal"), array('id' => $id));
			$this->session->set_flashdata('success', 'Data Berhasil di ubah');
			redirect('tiket');
		}
	}