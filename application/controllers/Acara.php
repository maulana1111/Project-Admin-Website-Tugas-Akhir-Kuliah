<?php 

	class Acara extends BackEnd_Controller{

		public function index()
		{
			$data['page'] = 'pages/acara/acara';
			$data['kategori'] = $this->kategori_m->getAll();
			$data['data'] = $this->Acara_m->getAll();


			$this->form_validation->set_rules('judul', 'Judul', 'required');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required');
			$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
			// $this->form_validation->set_rules('', '', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

			if($this->form_validation->run() == FALSE){
				$this->load->view('tamplate', $data);
                echo validation_errors();
			}else{
	                //upload gambar

					$config['upload_path']		    = './uploads/acara/';
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

		
				if($first && $second){	

					$upload_pict = $this->first_upload->data();
					$this->Acara_m->insertData(array(
						'judul' => $_POST['judul'],
						'kategori_id' => $_POST['kategori'],
						'deskripsi' => $_POST['deskripsi'],
						'tanggal' => $_POST['tanggal'],
						'foto' => $upload_pict['file_name'],
						'jam_mulai' => $_POST['jam_mulai'],
						'jam_selesai' => $_POST['jam_selesai']
					));

					$this->session->set_flashdata('success', 'Data Berhasil di Masukan');
					redirect('acara');
	            }else{
                    $this->session->set_flashdata('failed', 'Masukan Gambar');
                    redirect('acara');
	            }

			}
		}

		public function delete($id)
		{
			$data_acara = $this->Acara_m->get_detail_acara($id);
			$id_gambar = $data_acara->foto;
			$this->Acara_m->delete_acara($id, $id_gambar);
            $this->session->set_flashdata('success', 'Berhasil DiDelete');
            redirect('acara');
		}

		public function update($id)
		{
			$data['row'] = $this->Acara_m->get_detail_acara($id);
			$data['page'] = 'pages/acara/updateAcara';
			$data['data'] = $this->Acara_m->getAllNotId($id);
			$data['kategori'] = $this->kategori_m->getAll();

			$this->form_validation->set_rules('judul', 'Judul', 'required');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required');
			$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

			if($this->form_validation->run() == FALSE){
				$this->load->view('tamplate', $data);
                echo validation_errors();
			}else{

				if($_FILES['image']['error'] == 0)
				{			
					$config['upload_path']		    = './uploads/acara/';
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

	                if($first && $second){	

						$upload_pict = $this->first_upload->data();

						$data_acara = $this->Acara_m->get_detail_acara($id);
						$id_gambar = $data_acara->foto;

						$this->Acara_m->updateData(array(
								'judul' => $_POST['judul'],
								'kategori_id' => $_POST['kategori'],
								'deskripsi' => $_POST['deskripsi'],
								'tanggal' => $_POST['tanggal'],
								'foto' => $upload_pict['file_name'],
								'jam_mulai' => $_POST['jam_mulai'],
								'jam_selesai' => $_POST['jam_selesai']
							), array(
								'id' => $id
							), $id_gambar
						);

						$this->session->set_flashdata('success', 'Data Berhasil di Update');
						redirect('acara');
		            }

				}else{

					$this->Acara_m->updateDataWithoutImg(array(
							'judul' => $_POST['judul'],
							'kategori_id' => $_POST['kategori'],
							'deskripsi' => $_POST['deskripsi'],
							'tanggal' => $_POST['tanggal'],
							'jam_mulai' => $_POST['jam_mulai'],
							'jam_selesai' => $_POST['jam_selesai']
						), array(
							'id' => $id
						)
					);

					$this->session->set_flashdata('success', 'Data Berhasil di Update');
					redirect('acara');

				}

			}
		}


	}