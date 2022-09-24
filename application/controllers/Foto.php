<?php 

	class Foto extends BackEnd_Controller{

		public function index()
		{
			$data['page'] = 'pages/foto/foto';
			$data['data'] = $this->foto_m->getAll();
			$data['kategori'] = $this->kategori_m->getAll();

			$this->form_validation->set_rules('option', 'kategori', 'required');

			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('Failed', validation_errors());
				$this->load->view('tamplate', $data);
			}else{
				//upload gambar

				$config['upload_path']		    = './uploads/foto/';
                $config['allowed_types']	    = 'gif|jpg|png|jpeg|bmp|JPG|PNG';
                $config['overwrite']		    = TRUE;

				$this->load->library('upload', $config, 'first_upload');
                $this->first_upload->initialize($config);
                $first = $this->first_upload->do_upload('image');

                //upload gambar

				$config['upload_path']			= 'D:/xampp/htdocs/krc/image/';
                $config['allowed_types']	    = 'gif|jpg|png|jpeg|bmp|JPG|PNG';
                $config['overwrite']		    = TRUE;

				$this->load->library('upload', $config, 'second_upload');
                $this->second_upload->initialize($config);
                $second = $this->second_upload->do_upload('image');
                
                if($first & $second){	

					$upload_pict = $this->first_upload->data();

					$this->foto_m->insert_data(array(
						'category_id' => $_POST['option'],
						'foto' => $upload_pict['file_name']
					));

					$this->session->set_flashdata('success', 'Data Berhasil di Masukan');
					redirect('foto');
	            }else{
                    $this->session->set_flashdata('failed', 'Masukan Gambar!');
                    redirect('foto');
	            }

			}

		}

		public function delete($id)
		{
			$data = $this->foto_m->getDetail($id);
			$id_gambar = $data->foto;
			$this->foto_m->delete_data($id, $id_gambar);
			$this->session->set_flashdata('success', 'Data Berhasil di Hapus');
			redirect('foto');
		}

	}