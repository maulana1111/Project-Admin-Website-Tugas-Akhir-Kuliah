<?php 

	class Admin extends BackEnd_Controller{

		public function index()
		{
			// $this->session->unset_flashdata('success')
			$data['page'] = 'pages/admin/admin';
			$data['data'] = $this->admin_m->getAll();

			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Passwrod', 'required');

			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('Failed', validation_errors());
				$this->load->view('tamplate', $data);
			}else{
				$this->admin_m->insert_data(array(
					'nama' => $_POST['nama'],
					'username' => $_POST['username'],
					'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
					'level' => $_POST['tingkat']
				));

				$this->session->set_flashdata('success', 'Data Berhasil di Masukan');
				redirect('admin');

			}
		}

		public function delete($id)
		{
			$this->admin_m->delete_data($id);
			$this->session->set_flashdata('success', 'Data DiHapus');
			redirect('admin');
		}

		public function update($id)
		{
			$data['page'] = 'pages/admin/update_admin';
			$data['data'] = $this->admin_m->getAllNotId($id);
			$data['row'] = $this->admin_m->getDetail($id);

			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required');
			// $this->form_validation->set_rules('password', 'Password', 'required'); 

			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('failed', validation_errors());
				$this->load->view('tamplate', $data);
			}else{
				if(!empty($_POST['password']))
				{
					$this->admin_m->update_data(array(
						'nama' => $_POST['nama'],
						'username' => $_POST['username'],
						'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
						'level' => $_POST['tingkat']
					), array(
						'id' => $id
					));
					$this->session->set_flashdata('success', 'Data Berhasil di Ubah');
					redirect('admin');
				}else{
					$this->admin_m->update_data(array(
						'nama' => $_POST['nama'],
						'username' => $_POST['username'],
						'level' => $_POST['tingkat']
					), array(
						'id' => $id
					));
					$this->session->set_flashdata('success', 'Data Berhasil di Ubah');
					redirect('admin');
				}

			}


		}

	}