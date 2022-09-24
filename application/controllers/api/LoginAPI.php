<?php 

	class LoginAPI extends API_Controller{

		public function login()
		{

			if($_SERVER['REQUEST_METHOD'] == "POST")
			{
				$username = $_POST['username'];
				$password = $_POST['password'];
				$key = $_POST['key'];
				if( ($username != null) && ($password != null) && ($key != null))
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

					$result = $this->api_m->getDataAdmin($username);
					if($result != null)
					{
						$res_tokens = $this->token_m->get_token_by_id_admin($result->id);
						if($res_tokens != null)
						{
							if(password_verify($password, $result->password))
							{
								$d['id'] = $result->id;
								$d['nama'] = $result->nama;
								$d['level'] = $result->level;

								$res = json_encode($d);
								$resEncrypt = base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt($res))));

								$response = array(
									'status_code' => 200,
									'status_message' => "Successfull",
									'id' => $result->id,
									'nama' => $result->nama,
									'level'=> $result->level,
									'token' => $resEncrypt
								);

						    }else{
						    	$response = array(
								'status_message' => "Invalid Authentication, Username or Password is Wrong",
								'status_code' => 401
								);
						    }
						}else{
							$response = array(
								'status_message' => "Invalid Authentication, You don't have access",
								'status_code' => 401
							);
						}
					}else{
						$response = array(
							'status_message' => "Invalid Authentication, Username or Password is Wrong1",
							'status_code' => 401
						);
					}
				}else{
					$response = array(
						'status_message' => "Bad Request, Username or Password Cannot Null",
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