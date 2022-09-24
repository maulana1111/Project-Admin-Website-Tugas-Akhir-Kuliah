<?php 

	class Berita extends BackEnd_Controller{

		public function index()
		{
			$data['page'] = 'pages/berita/berita';
			$data['data'] = $this->berita_m->getAll();

			$this->form_validation->set_rules('judul', 'Judul', 'required');
			$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');


			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('Failed', validation_errors());
				$this->load->view('tamplate', $data);
			}else{

                //upload gambar

				$config['upload_path']		    = './uploads/berita/';
                $config['allowed_types']	    = 'gif|jpg|png|jpeg|bmp|';
                $config['overwrite']		    = TRUE;

				$this->load->library('upload', $config, 'first_upload');
                $this->first_upload->initialize($config);
                $first = $this->first_upload->do_upload('image');

                //upload gambar

				$config['upload_path']			= 'D:/xampp/htdocs/krc/image/';
                $config['allowed_types']	    = 'gif|jpg|png|jpeg|bmp|';
                $config['overwrite']		    = TRUE;

				$this->load->library('upload', $config, 'second_upload');
                $this->second_upload->initialize($config);
                $second = $this->second_upload->do_upload('image');

                if($first & $second){	

					$upload_pict = $this->first_upload->data();

					$this->berita_m->insert_data(array(
						'judul' => $_POST['judul'],
						'deskripsi' => $_POST['deskripsi'],
						// 'penulis' => $this->session->userdata('id'),
						'penulis' => $this->session->userdata('admin_id'),
						'foto' => $upload_pict['file_name'],
						'tanggal' => $_POST['tanggal']
					));

					$this->session->set_flashdata('success', 'Data Berhasil di Masukan');
					redirect('berita');
	            }else{
                    $this->session->set_flashdata('failed', 'Masukan Gambar!');
                    redirect('berita');
	            }

			}
		}

		public function delete($id){
			$data = $this->berita_m->getDetail($id);
			$id_gambar = $data->foto;
			$this->berita_m->delete_data($id, $id_gambar);
			$this->session->set_flashdata('success', 'Data Berhasil di Hapus');
			redirect('berita');
		}

		public function update($id)
		{			
			$data['row'] = $this->berita_m->getDetail($id);
			$data['data'] = $this->berita_m->getAllNotId($id);
			$data['page'] = 'pages/berita/berita_update';

			$this->form_validation->set_rules('judul', 'Judul', 'required');
			$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');


			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('Failed', validation_errors());
				$this->load->view('tamplate', $data);
			}else{

				if($_FILES['image']['error'] == 0)
				{			
					$config['upload_path']		    = './uploads/berita/';
	                $config['allowed_types']	    = 'gif|jpg|png|jpeg|bmp|';
	                $config['overwrite']		    = TRUE;

					$this->load->library('upload', $config, 'first_upload');
	                $this->first_upload->initialize($config);
	                $first = $this->first_upload->do_upload('image');

	                //upload gambar

					$config['upload_path']			= 'D:/xampp/htdocs/krc/image/';
	                $config['allowed_types']	    = 'gif|jpg|png|jpeg|bmp|';
	                $config['overwrite']		    = TRUE;

					$this->load->library('upload', $config, 'second_upload');
	                $this->second_upload->initialize($config);
	                $second = $this->second_upload->do_upload('image');

	                if($first & $second){	

						$upload_pict = $this->upload->data();

						$data = $this->berita_m->getDetail($id);
						$id_gambar = $data->foto;

						$this->berita_m->update_data(array(
							'judul' => $_POST['judul'],
							'deskripsi' => $_POST['deskripsi'],
							// 'penulis' => $this->session->userdata('id'),
							'penulis' => $this->session->userdata('admin_id'),
							'foto' => $upload_pict['file_name'],
							'tanggal' => $_POST['tanggal']
						), array(
								'id' => $id
							), $id_gambar
						);

						$this->session->set_flashdata('success', 'Data Berhasil di Update');
						redirect('berita');
		            }else{
	                    $this->session->set_flashdata('failed', 'Masukan Gambar');
	                    redirect('berita');
		            }

				}else{

					$this->berita_m->updateDataWithoutImg(array(
						'judul' => $_POST['judul'],
						'deskripsi' => $_POST['deskripsi'],
						// 'penulis' => $this->session->userdata('id'),
						'penulis' => 1,
						'tanggal' => $_POST['tanggal']
					), array(
							'id' => $id
						)
					);

					$this->session->set_flashdata('success', 'Data Berhasil di Update');
					redirect('berita');

				}

			}

		}

	}