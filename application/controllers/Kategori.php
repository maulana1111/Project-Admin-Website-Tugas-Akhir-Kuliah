<?php 

	class Kategori extends BackEnd_Controller{

		public function index()
		{
			$data['page'] = 'pages/kategori/kategori';
			$data['data'] = $this->kategori_m->getAll();

			$this->form_validation->set_rules('judul', 'Judul', 'required');

			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('failed', validation_errors());
				$this->load->view('tamplate', $data);
			}else{
				$this->kategori_m->insert_data(array(
					'title' => $_POST['judul']
				));

				$this->session->set_flashdata('success', 'Data Berhasil di Masukan');
				redirect('kategori');
			}
		}

		public function delete($id)
		{
			$this->kategori_m->delete_data($id);
			$this->session->set_flashdata('success', 'Data Berhasil di Hapus');
			redirect('kategori');
		}

		public function update($id)
		{
			$data['page'] = 'pages/kategori/kategori_update';
			$data['data'] = $this->kategori_m->getAllNotId($id);
			$data['row'] = $this->kategori_m->getDetail($id);

			$this->form_validation->set_rules('judul', 'Judul', 'required');

			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('Failed', validation_errors());
				$this->load->view('tamplate', $data);
			}else{
				$this->kategori_m->update_data(array(
					'title' => $_POST['judul']
				), array(
					'id' => $id
				));

				$this->session->set_flashdata('success', 'Data Berhasil di Update');
				redirect('kategori');
			}
		}

	}