<?php 

	class DonaturAPI extends API_Controller
	{

		public function donaturs()
		{
			if($_SERVER['REQUEST_METHOD'] === 'GET')
			{
				$token = $this->input->request_headers()['token'];
				$key = $this->input->request_headers()['key'];
				if($token != null && $key != null)
				{
					$res = $this->checkToken($token, $key);
					if($res == true)
					{
						$data = $this->donatur_m->getAll();
						$response['data_proses'] = array();
						$response['data_diterima'] = array();
						$response['data_ditolak'] = array();
						$response['status_code'] = 200;
						$response['status_message'] = "Successfull";

						foreach($data as $row)
						{
							if($row->status == "proses")
							{
								$a['id'] = $row->id;
								$a['no_rekening'] = $row->no_rekening;
								$a['pemilik_rekening'] = $row->pemilik_rekening;
								$a['organisasi'] = $row->organisasi;
								$a['jumlah'] = $row->jumlah;
								$a['gmail'] = $row->gmail;
								$a['pesan'] = $row->pesan;
								$a['status'] = $row->status;
								$a['bukti_transfer'] = $row->bukti_transfer;
								$a['status_enkrip'] = $row->status_enkrip;
								$a['tanggal_donate'] = $row->tanggal_donate;
								$a['status_show'] = $row->status_show;
								array_push($response['data_proses'], $a);
							}else if($row->status == "diterima")
							{
								$b['id'] = $row->id;
								$b['no_rekening'] = $row->no_rekening;
								$b['pemilik_rekening'] = $row->pemilik_rekening;
								$b['organisasi'] = $row->organisasi;
								$b['jumlah'] = $row->jumlah;
								$b['gmail'] = $row->gmail;
								$b['pesan'] = $row->pesan;
								$b['status'] = $row->status;
								$b['bukti_transfer'] = $row->bukti_transfer;
								$b['status_enkrip'] = $row->status_enkrip;
								$b['tanggal_donate'] = $row->tanggal_donate;
								$b['status_show'] = $row->status_show;
								array_push($response['data_diterima'], $b);
							}else if($row->status == "tidak_diterima")
							{
								$c['id'] = $row->id;
								$c['no_rekening'] = $row->no_rekening;
								$c['pemilik_rekening'] = $row->pemilik_rekening;
								$c['organisasi'] = $row->organisasi;
								$c['jumlah'] = $row->jumlah;
								$c['gmail'] = $row->gmail;
								$c['pesan'] = $row->pesan;
								$c['status'] = $row->status;
								$c['bukti_transfer'] = $row->bukti_transfer;
								$c['status_enkrip'] = $row->status_enkrip;
								$c['tanggal_donate'] = $row->tanggal_donate;
								$c['status_show'] = $row->status_show;
								array_push($response['data_ditolak'], $c);
							}
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

		public function donatur_detail($id, $key)
		{
			if($_SERVER['REQUEST_METHOD'] == "GET")
			{
				$token = $this->input->request_headers()['token'];
				$key_token = $this->input->request_headers()['key_token'];
				$key = $key;
				$id = $id;
				if($token != null && $id != null && $key != null && $key_token != null)
				{
					$res = $this->checkToken($token, $key_token);
					if($res == true)
					{
						$start_time = microtime(true);
						if($key != "1234567891234567")
						{
							$row = $this->donatur_m->getDataWhere($id);
							if($row != null)
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
								
								$sts = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->status_enkrip))));

								$dt = $row->status_show;

								$response['data'] = array();
								$response['status_code'] = 200;
								$response['status_message'] = "Successfull";
								// print_r($dt);
								if($dt == "false")
								{

									if($sts == "terlihat")
									{
										$a['id'] = $row->id;
										$a['pemilik_rekening'] = $row->pemilik_rekening;
										$a['no_rekening'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->no_rekening))));
										$a['organisasi'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->organisasi))));
										$a['jumlah'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->jumlah))));
										$a['gmail'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->gmail))));
										$a['pesan'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->pesan))));
										$a['status'] = $row->status;
										$a['bukti_transfer'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->bukti_transfer))));
										$a['status_enkrip'] = $sts;
										$a['tanggal_donate'] = $row->tanggal_donate;
										$a['status_show'] = $row->status_show;
									}else{									
										$a['id'] = $row->id;
										$a['pemilik_rekening'] = $row->pemilik_rekening;
										$a['no_rekening'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->no_rekening)))));
										$a['organisasi'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->organisasi)))));
										$a['jumlah'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->jumlah)))));
										$a['gmail'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->gmail)))));
										$a['pesan'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->pesan)))));
										$a['status'] = $row->status;
										$a['bukti_transfer'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->bukti_transfer)))));
										$a['status_enkrip'] = base64_encode($sts);
										$a['tanggal_donate'] = $row->tanggal_donate;
										$a['status_show'] = $row->status_show;
									}

								}else{					
									$a['id'] = $row->id;
									$a['no_rekening'] = $row->no_rekening;
									$a['pemilik_rekening'] = $row->pemilik_rekening;
									$a['organisasi'] = $row->organisasi;
									$a['jumlah'] = $row->jumlah;
									$a['gmail'] = $row->gmail;
									$a['pesan'] = $row->pesan;
									$a['status'] = $row->status;
									$a['bukti_transfer'] = $row->bukti_transfer;
									$a['status_enkrip'] = $row->status_enkrip;
									$a['tanggal_donate'] = $row->tanggal_donate;
									$a['status_show'] = $row->status_show;
								}
								array_push($response["data"], $a);
							}else{
								$response = array(
									'status_message' => "Data Not Found",
									'status_code' => 404
								);
							}	
						}else{
							$row = $this->donatur_m->getDataParentWhere($id);
							if($row != null)
							{									
								$keys = $key;
								$ObjectAES = new AES($keys);
								$ObjectRC4 = new RC4();
								
								$sts = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->status_enkrip))));
								$dt = $row->status_show;

								$response['data'] = array();
								$response['status_code'] = 200;
								$response['status_message'] = "Successfull";
								// print_r($dt);
								if($dt == "false")
								{

									if($sts == "terlihat")
									{
										$a['id'] = $row->id;
										$a['pemilik_rekening'] = $row->pemilik_rekening;
										$a['no_rekening'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->no_rekening))));
										$a['organisasi'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->organisasi))));
										$a['jumlah'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->jumlah))));
										$a['gmail'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->gmail))));
										$a['pesan'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->pesan))));
										$a['status'] = $row->status;
										$a['bukti_transfer'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->bukti_transfer))));
										$a['status_enkrip'] = $sts;
										$a['tanggal_donate'] = $row->tanggal_donate;
										$a['status_show'] = $row->status_show;
									}else{									
										$a['id'] = $row->id;
										$a['pemilik_rekening'] = $row->pemilik_rekening;
										$a['no_rekening'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->no_rekening)))));
										$a['organisasi'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->organisasi)))));
										$a['jumlah'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->jumlah)))));
										$a['gmail'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->gmail)))));
										$a['pesan'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->pesan)))));
										$a['status'] = $row->status;
										$a['bukti_transfer'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->bukti_transfer)))));
										$a['status_enkrip'] = base64_encode($sts);
										$a['tanggal_donate'] = $row->tanggal_donate;
										$a['status_show'] = $row->status_show;
									}

								}else{					
									$a['id'] = $row->id;
									$a['no_rekening'] = $row->no_rekening;
									$a['pemilik_rekening'] = $row->pemilik_rekening;
									$a['organisasi'] = $row->organisasi;
									$a['jumlah'] = $row->jumlah;
									$a['gmail'] = $row->gmail;
									$a['pesan'] = $row->pesan;
									$a['status'] = $row->status;
									$a['bukti_transfer'] = $row->bukti_transfer;
									$a['status_enkrip'] = $row->status_enkrip;
									$a['tanggal_donate'] = $row->tanggal_donate;
									$a['status_show'] = $row->status_show;
								}
								array_push($response["data"], $a);
							}else{
								$response = array(
									'status_message' => "Data Not Found",
									'status_code' => 404
								);
							}
						}	

						$end_time = microtime(true);				
						$execution_time = sprintf("%.2f", $end_time - $start_time);
						$response['execution_time']= $execution_time;				
					}else{
						$response = array(
							'status_message' => "Invalid Authentication",
							'status_code' => 401
						);
					}
				}else{					
					$response = array(
						'status_message' => "Bad Requestt",
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

		public function donatur_action($id_data)
		{
			if($_SERVER['REQUEST_METHOD'] == "PATCH")
			{
				$token = $this->input->request_headers()['token'];
				$key_token = $this->input->request_headers()['key_token'];
				$action = $this->input->input_stream('action');
				$id = $id_data;

				if($token != null && $key_token != null && $action != null && $id != null)
				{
					$res = $this->checkToken($token, $key_token);
					if($res == true)
					{ 
						if($action == "1")
						{

							$row = $this->donatur_m->changeStatusApi(
								array(
									'status' => 'diterima'
								),array('id' => $id));

						}else if($action == "2")
						{
							$row = $this->donatur_m->changeStatusApi(
								array(
									'status' => 'tidak_diterima'
								),array('id' => $id));
						}

						if($row != false)
						{
							$response['status_message'] = "Update Successfull";
							$response['status_code'] = 200;
						}else{
							$response = array(
								'status_message' => "Somthing Error",
								'status_code' => 500
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

		public function changeKey($id_data)
		{
			if($_SERVER['REQUEST_METHOD'] == "PATCH")
			{
				$token = $this->input->request_headers()['token'];
				$key_token = $this->input->request_headers()['key_token'];
				$key_lama =  $this->input->input_stream('key_lama');
				$key_baru = $this->input->input_stream('key_baru');
				$id = $id_data;


				if($token != null && $key_token != null && $key_lama != null && $key_baru != null && $id != null)
				{
					$res = $this->checkToken($token, $key_token);
					if($res == true)
					{
						$keys_lama = "";
						if(strlen($key_lama) != 16)
						{
							$count = 16 - strlen($key_lama);
							$str = "";
							for($i=0; $i < $count; $i++)
							{
								$str .= "0";
							}
							$keys_lama = $key_lama.$str;
						}else{
							$keys_lama = $key_lama;
						}
						$ObjectAESLama = new AES($keys_lama);

						$keys_baru = "";
						if(strlen($key_baru) != 16)
						{
							$count1 = 16 - strlen($key_baru);
							$str1 = "";
							for($j=0; $j < $count1; $j++)
							{
								$str1 .= "0";
							}
							$keys_baru = $key_baru.$str1;
						}else{
							$keys_baru = $key_baru;
						}
						$ObjectAESBaru = new AES($keys_baru);

						$ObjectRC4 = new RC4();

						$row = $this->donatur_m->getDataWhere($id);
						if($row != null)
						{
							$no_rekening = $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($keys_lama, base64_decode($row->no_rekening))));
							$organisasi = $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($keys_lama, base64_decode($row->organisasi))));
							$jumlah = $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($keys_lama, base64_decode($row->jumlah))));
							$gmail = $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($keys_lama, base64_decode($row->gmail))));
							$pesan = $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($keys_lama, base64_decode($row->pesan))));
							$bukti_transfer = $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($keys_lama, base64_decode($row->bukti_transfer))));
							$status_enkrip = $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($keys_lama, base64_decode($row->status_enkrip))));


							$en_no_rekening = base64_encode($ObjectRC4->proses($keys_baru, base64_encode($ObjectAESBaru->encrypt($no_rekening))));
	                        $en_organisasi = base64_encode($ObjectRC4->proses($keys_baru, base64_encode($ObjectAESBaru->encrypt($organisasi))));
	                        $en_jumlah = base64_encode($ObjectRC4->proses($keys_baru, base64_encode($ObjectAESBaru->encrypt($jumlah))));
	                        $en_gmail = base64_encode($ObjectRC4->proses($keys_baru, base64_encode($ObjectAESBaru->encrypt($gmail))));
	                        $en_pesan = base64_encode($ObjectRC4->proses($keys_baru, base64_encode($ObjectAESBaru->encrypt($pesan))));
	                        $en_bukti = base64_encode($ObjectRC4->proses($keys_baru, base64_encode($ObjectAESBaru->encrypt($bukti_transfer))));
	                        $en_status_enkrip = base64_encode($ObjectRC4->proses($keys_baru, base64_encode($ObjectAESBaru->encrypt($status_enkrip))));

							// echo "hasil enkrip :".$en_status_enkrip;

							$this->donatur_m->enkripsiData(array(
								'no_rekening' => $en_no_rekening,
				                'organisasi' => $en_organisasi,
								'jumlah' => $en_jumlah,
								'gmail' => $en_gmail,
								'pesan' => $en_pesan,
				                'bukti_transfer' => $en_bukti,
				                'status_enkrip' => $en_status_enkrip
							), array(
								'id' => $id
							));


							$response['status_code'] = 200;
							$response['status_message'] = "Successfull";

						}else{
							$response = array(
								'status_message' => "Data Not Found",
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

		public function checkKey($id, $key)
		{
			if($_SERVER['REQUEST_METHOD'] == "GET")
			{
				
				$token = $this->input->request_headers()['token'];
				$key_token = $this->input->request_headers()['key_token'];
				$key = $key;
				$id = $id;

				$res = $this->checkToken($token, $key_token);

				if($res == true)
				{
					if($key != "1234567891234567")
					{
						$row = $this->donatur_m->getDataWhere($id);
						if($row != null)
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
							
							$sts = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->status_enkrip))));

							$response['status_code'] = 200;
							$response['status_message'] = "Successfull";

							if($sts == "terlihat")
							{						
								$response['status_key'] = "true";	
							}else{				
								$response['status_key'] = "false";	
							}

						}else{
							$response = array(
								'status_message' => "Data Not Found",
								'status_code' => 404
							);
						}	
					}else{
						$row = $this->donatur_m->getDataParentWhere($id);
						if($row != null)
						{									
							$keys = $key;
							$ObjectAES = new AES($keys);
							$ObjectRC4 = new RC4();
							
							$sts = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->status_enkrip))));

							$response['status_code'] = 200;
							$response['status_message'] = "Successfull";
							$response['status_key'] = "true";	
						}else{
							$response = array(
								'status_message' => "Data Not Found",
								'status_code' => 404
							);
						}
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
			echo json_encode($response);
		}

		public function donatur_post()
		{
			if($_SERVER['REQUEST_METHOD'] == "POST")
			{				
				$token = $_POST['token'];
				$key_token = $_POST['key_token'];

				$res = $this->checkToken($_POST['token'], $_POST['key_token']);
				if($res == true)
				{ 
					$start_time = microtime(true);
					$no_rekening = $_POST['no_rekening'];
					$pemilik_rekening = $_POST['pemilik_rekening'];
					$organisasi = $_POST['organisasi'];
					$jumlah = $_POST['jumlah'];
					$gmail = $_POST['gmail'];
					$pesan = $_POST['pesan'];
					$tanggal_donate = $_POST['tanggal_donate'];
					$opsi = $_POST['opsi'];
					$key = $_POST['key'];

					$config['upload_path']		    = './uploads/donatur/';
	                $config['allowed_types']	    = 'gif|jpg|png|jpeg|bmp';
	                $config['overwrite']		    = TRUE;

	                $this->upload->initialize($config);
	                $first = $this->upload->do_upload('bukti_transfer');

	                if($first)
	                {
		                $upload_pict = $this->upload->data();

		                if($opsi == "True")
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

							$no_rekening1 = base64_encode($ObjectRC4->proses($keys, $no_rekening));
						    $organisasi1 = base64_encode($ObjectRC4->proses($keys, $organisasi));
						    $jumlah1 = base64_encode($ObjectRC4->proses($keys, $jumlah));
						    $gmail1 = base64_encode($ObjectRC4->proses($keys, $gmail));
						    $pesan1 = base64_encode($ObjectRC4->proses($keys, $pesan));
						    $status_enkrip1 = base64_encode($ObjectRC4->proses($keys, "terlihat"));
						    $bukti1 = base64_encode($ObjectRC4->proses($keys, $upload_pict['file_name']));

						    $this->donatur_m->insert_data(array(
								'no_rekening' => $no_rekening1,
								'pemilik_rekening' =>  $pemilik_rekening,
						        'organisasi' => $organisasi1,
								'jumlah' => $jumlah1,
								'gmail' => $gmail1,
								'pesan' => $pesan1,
								'status' => "diterima",
						        'bukti_transfer' => $bukti1,
						        'status_enkrip' => $status_enkrip1,
						        'tanggal_donate' => $tanggal_donate,
						        'status_show' => "false"
							));

						    $this->donatur_m->insert_data_parent(array(
								'no_rekening' => $no_rekening1,
								'pemilik_rekening' =>  $pemilik_rekening,
						        'organisasi' => $organisasi1,
								'jumlah' => $jumlah1,
								'gmail' => $gmail1,
								'pesan' => $pesan1,
								'status' => "diterima",
						        'bukti_transfer' => $bukti1,
						        'status_enkrip' => $status_enkrip1,
						        'tanggal_donate' => $tanggal_donate,
						        'status_show' => "false"
							));

		                }else{
							$this->donatur_m->insert_data(array(
								'no_rekening' => $no_rekening,
								'pemilik_rekening' =>  $pemilik_rekening,
						        'organisasi' => $organisasi,
								'jumlah' => $jumlah,
								'gmail' => $gmail,
								'pesan' => $pesan,
								'status' => "diterima",
						        'bukti_transfer' => $upload_pict['file_name'],
						        'status_enkrip' => "terilhat",
						        'tanggal_donate' => $tanggal_donate,
						        'status_show' => "true"
							));

							$this->donatur_m->insert_data_parent(array(
								'no_rekening' => $no_rekening,
								'pemilik_rekening' =>  $pemilik_rekening,
						        'organisasi' => $organisasi,
								'jumlah' => $jumlah,
								'gmail' => $gmail,
								'pesan' => $pesan,
								'status' => "diterima",
						        'bukti_transfer' => $upload_pict['file_name'],
						        'status_enkrip' => "terilhat",
						        'tanggal_donate' => $tanggal_donate,
						        'status_show' => "true"
							));
		                }

						$response['status_message'] = "Insert Successfull";
						$response['status_code'] = 200;
						$end_time = microtime(true);				
						$execution_time = sprintf("%.2f", $end_time - $start_time);
						$response['execution_time']= $execution_time;	
		            }else{
	                	$response = array(
							'status_message' => "Error When Uploading Picture : ".$this->upload->display_errors(),
							'status_code' => 500
						);
		            }
		        }else{
					$response = array(
						'status' => "Invalid Authentication",
						'status_code' => 401
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

		public function get_data_by_filter($key, $from, $to, $opsi)
		{
			if($_SERVER['REQUEST_METHOD'] == "GET")
			{				
				$token = $this->input->request_headers()['token'];
				$key_token = $this->input->request_headers()['key_token'];

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
					if($opsi == "diproses")
					{
						$opsi = "proses";
					}
					$data = $this->donatur_m->getDataFilter($from, $to, $opsi);
					// print_r($data);
					
					$response['data'] = array();
					$response['status_code'] = 200;
					$response['status_message'] = "Successfull";

					if($key != "1234567891234567")
					{
						$response['status_key'] = "wrong";
					}else{
						$response['status_key'] = "correct";
					}

					foreach($data as $row)
					{
						$sts = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->status_enkrip))));
						$stss = $row->status_show;
						if($stss == "false")
						{
							if($sts == "terlihat")
							{							
								$a['id'] = $row->id;
								$a['pemilik_rekening'] = $row->pemilik_rekening;
								$a['no_rekening'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->no_rekening))));
								$a['organisasi'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->organisasi))));
								$a['jumlah'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->jumlah))));
								$a['gmail'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->gmail))));
								$a['pesan'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->pesan))));
								$a['status'] = $row->status;
								$a['bukti_transfer'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->bukti_transfer))));
								$a['status_enkrip'] = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->status_enkrip))));
								$a['tanggal_donate'] = $row->tanggal_donate;
								$a['status_show'] = $row->status_show;
							}else{
								$a['id'] = $row->id;
								$a['pemilik_rekening'] = $row->pemilik_rekening;
								$a['no_rekening'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->no_rekening)))));
								$a['organisasi'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->organisasi)))));
								$a['jumlah'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->jumlah)))));
								$a['gmail'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->gmail)))));
								$a['pesan'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->pesan)))));
								$a['status'] = $row->status;
								$a['bukti_transfer'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->bukti_transfer)))));
								$a['status_enkrip'] = base64_encode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->status_enkrip)))));
								$a['tanggal_donate'] = $row->tanggal_donate;
								$a['status_show'] = $row->status_show;
							}
						}else{
							$a['id'] = $row->id;
							$a['pemilik_rekening'] = $row->pemilik_rekening;
							$a['no_rekening'] = $row->no_rekening;
							$a['organisasi'] = $row->organisasi;
							$a['jumlah'] = $row->jumlah;
							$a['gmail'] = $row->gmail;
							$a['pesan'] = $row->pesan;
							$a['status'] = $row->status;
							$a['bukti_transfer'] = $row->bukti_transfer;
							$a['status_enkrip'] = $row->status_enkrip;
							$a['tanggal_donate'] = $row->tanggal_donate;
							$a['status_show'] = $row->status_show;
						}
						
						array_push($response['data'], $a);
					}
				}else{					
					$response = array(
						'status' => "Invalid Authentication",
						'status_code' => 401
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