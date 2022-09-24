<?php 

	class Spot extends BackEnd_Controller{

		public function index()
		{
			$data['page'] = 'pages/spot/spot';
			$data['data'] = $this->spot_m->getAll();

			$this->form_validation->set_rules('judul', 'Judul', 'required');
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

			if($this->form_validation->run() == FALSE){

				$this->session->set_flashdata('Failed', validation_errors());
				$this->load->view('tamplate', $data);

			}else{

   				if(!empty($_FILES['image']['name'])){

				    $config['upload_path']		    = './uploads/spot/';
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
			            $uploadData = $this->upload->data();

					    $this->spot_m->insert_data(array(
					    	'judul' => $_POST['judul'],
					    	'deskripsi' => $_POST['deskripsi'],
					    	'foto' => $uploadData['file_name']
					    ));


						$this->session->set_flashdata('success', 'Data Berhasil di Masukan');
						redirect('spot');
			        }
			            
			    }else{				    	
					$this->session->set_flashdata('failed', 'masukan Gambar!');
					redirect('spot');
			    }
		    }
		}

		public function delete($id)
		{
			$data = $this->spot_m->getDetail($id);
			$id_gambar = $data->foto;
			$this->spot_m->delete_data($id, $id_gambar);
			$this->session->set_flashdata('success', 'Data Berhasil Di Hapus');
			redirect('spot');
		}

		public function update($id)
		{

			$data['page'] = 'pages/spot/spot_update';
			$data['data'] = $this->spot_m->getAllNotId($id);
			$data['row'] = $this->spot_m->getDetail($id);

			$this->form_validation->set_rules('judul', 'Judul', 'required');
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

			if($this->form_validation->run() == FALSE){

				$this->session->set_flashdata('Failed', validation_errors());
				$this->load->view('tamplate', $data);

			}else{


				if($_FILES['image']['error'] == 0)
				{	

					$config['upload_path']		    = './uploads/spot/';
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

			            $uploadData = $this->upload->data();

			            $data = $this->spot_m->getDetail($id);
			            $id_gambar = $data->foto;

					    $this->spot_m->update_data(array(
					    	'judul' => $_POST['judul'],
					    	'deskripsi' => $_POST['deskripsi'],
					    	'foto' => $uploadData['file_name']
					    ), array(
					    	'id' => $id
					    ), $id_gambar);


						$this->session->set_flashdata('success', 'Data Berhasil di Update');
						redirect('spot');
			        }

				}else{

				    $this->spot_m->updateDataWithoutImg(array(
				    	'judul' => $_POST['judul'],
				    	'deskripsi' => $_POST['deskripsi']
				    ), array('id' => $id));


					$this->session->set_flashdata('success', 'Data Berhasil di Update');
					redirect('spot');
				}

			}

		}

	}