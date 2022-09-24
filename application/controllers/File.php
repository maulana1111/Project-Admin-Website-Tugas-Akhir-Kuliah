<?php 


	class File extends BackEnd_Controller
	{
		public function index()
		{
			$data['data'] = $this->file_m->getAll();
			$data['page'] = 'pages/file/index';

			$this->form_validation->set_rules('key', 'Key', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('Failed', validation_errors());
				$this->load->view('tamplate', $data);
			}else{
				$start_time = microtime(true);
				$key = $_POST['key'];	
				$keterangan = $_POST['keterangan'];	
				$keys = "";
				if(strlen($key) != 16)
				{
					$count = 16 - strlen($key);
					$str = "";
					for($i=0; $i < $count; $i++)
					{
						$str .= "0";
					}
					$keys = $key.$str;
				}else{
					$keys = $key;
				}

				$ObjectAES = new AES($keys);
				$ObjectRC4 = new RC4();

				date_default_timezone_set('Asia/Jakarta');
	            $date = new DateTime();
	            $resDate = $date->format("Y-m-d H:i:s");

	            $file_tmpname = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$name = rand(1000,100000).'-'.pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
				$final_name = str_replace(' ','-', (strtolower($name)));

				$file           = rand(1000,100000)."-".$_FILES['file']['name'];
		        $new_file_name  = strtolower($file);
		        $final_file     = str_replace(' ','-',$new_file_name);

			    $size = filesize($file_tmpname);
			    $size2 = (filesize($file_tmpname))/1024;


			    $info           = pathinfo($final_file);
			    $file_source	= fopen($file_tmpname, 'rb');
			    $ext            = $info["extension"];
					// print_r($info);

			    	$url="";
				    $file_url="";
					if($ext == "docx")
					{
						$url   = $final_name.".docx";
				        $file_url = "uploads/file/file_encrypt/$url";
					}else if($ext == "xlsx"){
						$url   = $final_name.".xlsx";
				        $file_url = "uploads/file/file_encrypt/$url";
					}else if($ext == "pdf"){
						$url   = $final_name.".pdf";
				        $file_url = "uploads/file/file_encrypt/$url";
					}else if($ext == "pptx"){
						$url   = $final_name.".pptx";
				        $file_url = "uploads/file/file_encrypt/$url";
					}
				
				$file_output = fopen($file_url, 'wb');

				$mod    = $size%16;
		        if($mod==0){
		            $banyak = $size / 16;
		        }else{
		            $banyak = ($size - $mod) / 16;
		            $banyak = $banyak+1;
		        }

		        ini_set('max_execution_time', -1);
	          	ini_set('memory_limit', -1);

				for($bawah=0;$bawah<$banyak;$bawah++){
	                $data    = fread($file_source, $size);
	                $cipher  = $ObjectAES->encrypt($ObjectRC4->proses($keys, $data));

	                // $cipher  = base64_encode($ObjectAES->encrypt(base64_encode($ObjectRC4->proses($keys, $data))));
	                fwrite($file_output, $cipher);
	            }

	            fclose($file_source);
	            fclose($file_output);

				$file_sz  = sprintf("%.2f", filesize($file_url) / 1024);

	            $this->file_m->insert_data(array(
  					'file_name_source' => $fileName,
  					'final_file_name' => $final_name,
  					'file_path' => $file_url,
  					'file_size' => $file_sz,
  					'tanggal_upload' => $resDate,
  					'tanggal_update' => $resDate,
  					'keterangan' => $keterangan,
  					'status_file' => "1",
  					'status_enkrip' => base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt('terlihat'))))
  				));

				$end_time = microtime(true);				
				$execution_time = sprintf("%.2f", $end_time - $start_time);

  				$this->session->set_flashdata('success', 'Data Berhasil di Masukan');
  				$this->session->set_flashdata('eksekusi', $execution_time);
				redirect('file');

			}
		}

		public function delete_data($id)
		{			
			$res = $this->file_m->get_where_data($id);

            unlink($res->file_path);

			$this->file_m->delete_data(
				array(
					'id' => $id
				)
			);

			$this->session->set_flashdata('success', 'Data Berhasil di Hapus');
			redirect('file');
		}

		public function update_data()
		{			
			$id = $_POST['id_data'];
			$keterangan = $_POST['keterangan'];

			$this->file_m->update_data(
				array(
					'keterangan' => $keterangan
				),array(
					'id' => $id
				)
			);

			$this->session->set_flashdata('success', 'Data Berhasil di Ubah');
			redirect('file');
		}

		public function enkrip_file()
		{
			$start_time = microtime(true);
			$key = $_POST['key'];
			$id = $_POST['id_data'];
			if(strlen($key) != 16)
			{
				$count = 16 - strlen($key);
				$str = "";
				for($i=0; $i < $count; $i++)
				{
					$str .= "0";
				}
				$keys = $key.$str;
			}else{
				$keys = $key;
			}

			$ObjectAES = new AES($keys);
			$ObjectRC4 = new RC4();

			date_default_timezone_set('Asia/Jakarta');
            $date = new DateTime();
            $resDate = $date->format("Y-m-d H:i:s");

			$res = $this->file_m->get_where_data($id);


			$file_path  = $res->file_path;
		    $file_name  = $res->file_name_source;
		    $size       = $res->file_size;

		    $name = rand(1000,100000).'-'.$file_name;
			$final_name = str_replace(' ','-', (strtolower($name)));

		    $file_size  = filesize($file_path);

			$mod        = $file_size%16;

			$fopen1     = fopen($file_path, "rb");
		    $plain      = "";
		    $cache      = "uploads/file/file_encrypt/$final_name";
		    $fopen2     = fopen($cache, "wb");

			if($mod==0){
			    $banyak = $file_size / 16;
			}else{
			    $banyak = ($file_size - $mod) / 16;
			    $banyak = $banyak+1;
			}

		    ini_set('max_execution_time', -1);
		    ini_set('memory_limit', -1);
		    for($bawah=0;$bawah<$banyak;$bawah++)
		    {
			    $filedata    = fread($fopen1, $file_size);
                $plain  = $ObjectAES->encrypt($ObjectRC4->proses($keys, $filedata));

			    fwrite($fopen2, $plain);
			}


            fclose($fopen1);
            fclose($fopen2);

			$file_sz  = sprintf("%.2f", filesize($cache) / 1024);

            unlink($file_path);

            $this->file_m->update_data(
				array(
					'status_file' => '1',
	                'tanggal_update' => $resDate,
	                'file_size' => $file_sz,
	                'file_path'      => $cache,
	                'final_file_name' => $final_name,
  					'status_enkrip' => base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt('terlihat'))))
				),array(
					'id' => $id
				)
			);

			$end_time = microtime(true);			  
			$execution_time = sprintf("%.2f", $end_time - $start_time);

			$this->session->set_flashdata('eksekusi', $execution_time);
			$this->session->set_flashdata('success', 'Data Berhasil di Enkripsi');
			redirect('file');

		}


		public function dekrip_file()
		{			

			$key = $_POST['key'];
			$id = $_POST['id_data'];
			$keys = "";
			if(strlen($key) != 16)
			{
				$count = 16 - strlen($key);
				$str = "";
				for($i=0; $i < $count; $i++)
				{
					$str .= "0";
				}
				$keys = $key.$str;
			}else{
				$keys = $key;
			}

			$ObjectAES = new AES($keys);
			$ObjectRC4 = new RC4();

			date_default_timezone_set('Asia/Jakarta');
            $date = new DateTime();
            $resDate = $date->format("Y-m-d H:i:s");

			$res = $this->file_m->get_where_data($id);
			$proses = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($res->status_enkrip))));
			if($proses == "terlihat")
			{
				$start_time = microtime(true);
				$file_path  = $res->file_path;
			    $file_name  = $res->file_name_source;
			    $size       = $res->file_size;

			    $file_size  = filesize($file_path);

				$mod        = $file_size%16;

				$fopen1     = fopen($file_path, "rb");
			    $plain      = "";
			    $cache      = "uploads/file/file_decrypt/$file_name";
			    $fopen2     = fopen($cache, "wb");

				if($mod==0){
				    $banyak = $file_size / 16;
				}else{
				    $banyak = ($file_size - $mod) / 16;
				    $banyak = $banyak+1;
				}

			    ini_set('max_execution_time', -1);
			    ini_set('memory_limit', -1);
			    for($bawah=0;$bawah<$banyak;$bawah++)
			    {
				    $filedata    = fread($fopen1, $file_size);
				    // $plain 		 = $ObjectRC4->proses($keys, base64_decode($ObjectAES->decrypt(base64_decode($filedata))));
				    $plain 		 = $ObjectRC4->proses($keys, $ObjectAES->decrypt($filedata));
				    fwrite($fopen2, $plain);
				}


	            fclose($fopen1);
	            fclose($fopen2);

				$file_sz  = sprintf("%.2f", filesize($cache) / 1024);

	            unlink($file_path);

	            $this->file_m->update_data(
					array(
						'status_file' => '2',
		                'tanggal_update' => $resDate,
		                'file_size' => $file_sz,
		                'file_path'      => $cache,
		                'final_file_name' => $file_name,
					),array(
						'id' => $id
					)
				);
				
				$end_time = microtime(true);
				$execution_time = sprintf("%.2f", $end_time - $start_time);
  				$this->session->set_flashdata('success', 'Data Berhasil di Dekripsi');
  				$this->session->set_flashdata('eksekusi', $execution_time);
				redirect('file');

			}else{
  				$this->session->set_flashdata('failed', 'Key Yang Dimasukan Salah');
				redirect('file');
			}
		}
	}