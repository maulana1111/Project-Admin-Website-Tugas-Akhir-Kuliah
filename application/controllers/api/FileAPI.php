<?php 

	class FileAPI extends API_Controller
	{

		public function files()
		{			
			if($_SERVER['REQUEST_METHOD'] == "GET")
			{
				$token = $this->input->request_headers()['token'];
				$key = $this->input->request_headers()['key'];
				if($token != null && $key != null)
				{					
					$res = $this->checkToken($token, $key);
					if($res == true)
					{
						$data = $this->file_m->getAll();
						$response['data'] = array();
						$response['status_code'] = 200;
						$response['status_message'] = "Successfull";
						
						foreach($data as $row)
						{
							$a['id'] = $row->id;
							$a['file_name_source'] = $row->file_name_source;
							$a['file_file_name'] = $row->final_file_name;
							$a['file_path'] = $row->file_path;
							$a['file_size'] = $row->file_size;
							$a['tanggal_upload'] = $row->tanggal_upload;
							$a['tanggal_update'] = $row->tanggal_update;
							$a['keterangan'] = $row->keterangan;
							$a['status_file'] = $row->status_file;
							$a['status_enkrip'] = $row->status_enkrip;
							array_push($response['data'], $a);
						}
					}else{
						$response = array(
							'status_message' => "Invalid Authentication",
							'status_code' => 401
						);
					}
				}else{
					$response = array(
						'status_message' => "Bad Request",
						'status_code' => 400
					);
				}
			}else{
				$response = array(
					'status_message' => "Bad Request",
					'status_code' => 400
				);
			}
			echo json_encode($response);
		}

		public function getFileById($id)
		{						
			if($_SERVER['REQUEST_METHOD'] == "GET")
			{
				$token = $this->input->request_headers()['token'];
				$key = $this->input->request_headers()['key'];

				if($token != null && $key != null && $id != null)
				{					
					$res = $this->checkToken($token, $key);
					if($res == true)
					{						
						$row = $this->file_m->getById($id);
						$response['data'] = array();
						$response['status_code'] = 200;
						$response['status_message'] = "Successfull";

						$a['id'] = $row->id;
						$a['file_name_source'] = $row->file_name_source;
						$a['file_file_name'] = $row->final_file_name;
						$a['file_path'] = "http://192.168.18.45/AdminKrcV2/".$row->file_path;
						$a['file_size'] = $row->file_size;
						$a['tanggal_upload'] = $row->tanggal_upload;
						$a['tanggal_update'] = $row->tanggal_update;
						$a['keterangan'] = $row->keterangan;
						$a['status_file'] = $row->status_file;
						$a['status_enkrip'] = base64_encode($row->status_enkrip);
						array_push($response['data'], $a);
						
					}else{
						$response = array(
							'status_message' => "Invalid Authentication",
							'status_code' => 401
						);
					}
				}else{
					$response = array(
						'status_message' => "Bad Request",
						'status_code' => 400
					);
				}
			}else{
				$response = array(
					'status_message' => "Bad Request",
					'status_code' => 400
				);
			}
			echo json_encode($response);
		}

		public function insert_file()
		{
			if($_SERVER['REQUEST_METHOD'] == "POST")
			{				
				$token = $_POST['token'];
				$key_token = $_POST['key_token'];
				$key = $_POST['key'];	
				$keterangan = $_POST['keterangan'];			
				if($token != null && $key_token != null && $key != null)
				{					
					$res = $this->checkToken($token, $key_token);
					if($res == true)
					{
						$start_time = microtime(true);
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
					    $ext            = strtolower($info["extension"]);
						// print_r($ext);

					    if($ext == "docx" || $ext == "xlsx" || $ext == "pdf" || $ext == "pptx")
					    {
						    
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
				                $cipher  = $ObjectRC4->proses($keys, $data);
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
							$response = array(
								'status_message' => "Successfull",
								'status_code' => 200,
								'execution_time' => $execution_time
							);

					    }else{
					    	$response = array(
								'status_message' => "Invalid, extension is not allowed",
								'status_code' => 401
							);
					    }

					}else{						
						$response = array(
							'status_message' => "Invalid Authentication",
							'status_code' => 401
						);
					}
				}else{
					$response = array(
						'status_message' => "Bad Request",
						'status_code' => 400
					);
				}
			}else{
				$response = array(
					'status_message' => "Bad Request",
					'status_code' => 400
				);
			}

			echo json_encode($response);
		}

		public function dekrip_file($id)
		{
			if($_SERVER['REQUEST_METHOD'] == "PATCH")
			{				
				$token = $this->input->request_headers()['token'];
				$key_token = $this->input->request_headers()['key_token'];
				$key = $this->input->input_stream('key');
				if($token != null && $key_token != null && $key != null)
				{					
					$res = $this->checkToken($token, $key_token);
					if($res == true)
					{
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

						if($res != null)
						{
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
								    // $plain       = $ObjectRC4->proses($keys, $ObjectRC4->proses($key, $ObjectRC4->proses($keys, $filedata)));

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
								$response = array(
									'status_message' => "Successfull",
									'status_code' => 200,
									'execution_time' => $execution_time
								);

							}else{
								$response = array(
									'status_message' => "Invalid Key",
									'status_code' => 401
								);
							}
						}else{
							$response = array(
								'status_message' => "Data not Found",
								'status_code' => 400
							);
						}

					}else{						
						$response = array(
							'status_message' => "Invalid Authentication",
							'status_code' => 401
						);
					}
				}else{
					$response = array(
						'status_message' => "Bad Request",
						'status_code' => 400
					);
				}
			}else{
				$response = array(
					'status_message' => "Bad Request",
					'status_code' => 400
				);
			}

			echo json_encode($response);
		}

		public function enkrip_file($id)
		{
			if($_SERVER['REQUEST_METHOD'] == "PATCH")
			{				
				$token = $this->input->request_headers()['token'];
				$key_token = $this->input->request_headers()['key_token'];
				$key = $this->input->input_stream('key');
				if($token != null && $key_token != null && $key != null)
				{					
					$res = $this->checkToken($token, $key_token);
					if($res == true)
					{
						$start_time = microtime(true);
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
								'status_file' 		=> '1',
				                'tanggal_update' 	=> $resDate,
				                'file_size' 		=> $file_sz,
				                'file_path'      	=> $cache,
				                'final_file_name' 	=> $final_name,
				                'status_enkrip' 	=> base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt('terlihat'))))
							),array(
								'id' => $id
							)
						);

						$end_time = microtime(true);				
						$execution_time = sprintf("%.2f", $end_time - $start_time);
						$response = array(
							'status_message' => "Successfull",
							'status_code' => 200,
							'execution_time' => $execution_time
						);

					}else{						
						$response = array(
							'status_message' => "Invalid Authentication",
							'status_code' => 401
						);
					}
				}else{
					$response = array(
						'status_message' => "Bad Request",
						'status_code' => 400
					);
				}
			}else{
				$response = array(
					'status_message' => "Bad Request",
					'status_code' => 400
				);
			}

			echo json_encode($response);
		}


	}