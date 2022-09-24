<?php 


	class AdminAPI extends API_Controller
	{
		public function admins()
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

						$data = $this->admin_m->getAll();
						$response['data'] = array();
						$response['status_code'] = 200;
						$response['status_message'] = "Successfull";

						foreach($data as $row)
						{
							$a['id'] = $row->id;
							$a['nama'] = $row->nama;
							$a['username'] = $row->username;
							$a['password'] = $row->password;
							$a['level'] = $row->level;

							$dataToken = $this->token_m->getAllTokens();
							foreach($dataToken as $dt)
							{
								if($row->id == $dt->id_admin)
								{									
									$a['access'] = true;
									break;
								}else{	
									$a['access'] = false;
								}
							}
							
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

		public function insert_data()
		{

			if($_SERVER['REQUEST_METHOD'] == "POST")
			{				
				$token = $_POST['token'];
				$key_token = $_POST['key_token'];
				$key = $_POST['key'];	
				$nama = $_POST['nama'];	
				$username = $_POST['username'];
				$password = $_POST['password'];
				$level = $_POST['level'];	
				$access = $_POST['access'];			
					
				$res = $this->checkToken($token, $key_token);
				if($res == true)
				{
					$this->admin_m->insert_data(array(
						'nama' => $nama,
						'username' => $username,
						'password' => password_hash($password, PASSWORD_DEFAULT),
						'level' => $level
					));

					if($access == "true")
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

						$getData = $this->admin_m->getLastId();
						// print($getId->nama);
						$d['id'] = $getData->id;
						$d['nama'] = $getData->nama;
						$d['level'] = $getData->level;

						$res = json_encode($d);

						$resEncrypt = base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt($res))));
						// $dataFromToken = json_decode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($resEncrypt)))), true);

						// print_r($dataFromToken);
						$this->token_m->insert_data(array(
							'id_admin' => $getData->id,
							'token' => $resEncrypt
						));

						$response['status_message'] = "Insert Successfull";
						$response['status_code'] = 200;
					}

					
					$response['status_message'] = "Insert Successfull";
					$response['status_code'] = 200;


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

		public function getDataById($id)
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

						$row = $this->admin_m->getDetail($id);
						$response['data'] = array();
						$response['status_code'] = 200;
						$response['status_message'] = "Successfull";

						$a['id'] = $row->id;
						$a['nama'] = $row->nama;
						$a['username'] = $row->username;
						$a['password'] = $row->password;
						$a['level'] = $row->level;

						$dataToken = $this->token_m->getAllTokens();
						foreach($dataToken as $dt)
						{
							if($row->id == $dt->id_admin)
							{									
								$a['access'] = true;
								break;
							}else{	
								$a['access'] = false;
							}
						}
						
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

		public function hapusData($id)
		{
			if($_SERVER['REQUEST_METHOD'] == "DELETE")
			{
				$token = $this->input->request_headers()['token'];
				$key = $this->input->request_headers()['key'];
				if($token != null && $key != null && $id != null)
				{					
					$res = $this->checkToken($token, $key);
					if($res == true)
					{

						$this->admin_m->delete_data($id);
						$this->token_m->delete_data($id);
						$response['status_code'] = 200;
						$response['status_message'] = "Successfull";

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

		public function destroy_access($id)
		{
			if($_SERVER['REQUEST_METHOD'] == "DELETE")
			{
				$token = $this->input->request_headers()['token'];
				$key = $this->input->request_headers()['key'];
				if($token != null && $key != null && $id != null)
				{					
					$res = $this->checkToken($token, $key);
					if($res == true)
					{

						$this->token_m->delete_data($id);
						$response['status_code'] = 200;
						$response['status_message'] = "Successfull";

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

		public function give_access($id)
		{
			if($_SERVER['REQUEST_METHOD'] == "PATCH")
			{
				$token = $this->input->request_headers()['token'];
				$key_token = $this->input->request_headers()['key_token'];
				$key = $this->input->input_stream('key');

				if($token != null && $key != null && $id != null)
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

						$data = $this->admin_m->getDetail($id);

						$d['id'] = $data->id;
						$d['nama'] = $data->nama;
						$d['level'] = $data->level;

						$res = json_encode($d);
						$resEncrypt = base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt($res))));

						$this->token_m->insert_data(array(
							'id_admin' => $id,
							'token' => $resEncrypt
						));

						$response['status_code'] = 200;
						$response['status_message'] = "Successfull";

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

		public function update_data($id)
		{
			if($_SERVER['REQUEST_METHOD'] == "PATCH")
			{
				$token = $this->input->request_headers()['token'];
				$key_token = $this->input->request_headers()['key_token'];
		
				$nama = $this->input->input_stream('nama');		
				$username = $this->input->input_stream('username');		
				$password = $this->input->input_stream('password');					
				$key = $this->input->input_stream('key');

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

					if($password != "0")
					{
						$this->admin_m->update_data(
							array(
								'nama' => $nama,
								'username' => $username,
								'password' => password_hash($password, PASSWORD_DEFAULT)
							),
							array('id' => $id)
						);
					}else{
						$this->admin_m->update_data(
							array(
								'nama' => $nama,
								'username' => $username
							),
							array('id' => $id)
						);
					}

					$data = $this->admin_m->getDetail($id);

					$d['id'] = $data->id;
					$d['nama'] = $data->nama;
					$d['level'] = $data->level;

					$res = json_encode($d);
					$resEncrypt = base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt($res))));

					$dataFromToken = json_decode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($resEncrypt)))), true);
					// print_r($dataFromToken);

					// print($resEncrypt);
					$this->token_m->update_data(
						array(
							'token' => $resEncrypt
						), 
						array(
							'id_admin' => $data->id
						)
					);

					$response = array(
						'status_code' => 200,
						'status_message' => "Successfull",
						'status_token' => $resEncrypt
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
			echo json_encode($response);
		}

	}