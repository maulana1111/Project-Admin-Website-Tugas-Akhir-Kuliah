<?php 


	class My_Controller extends CI_Controller{

		public function __construct(){
			parent::__construct();

			//load database
			$this->load->database();
			//load library
			$this->load->library(array('form_validation','pagination','session','upload'));

			$this->load->helper(array('url','string', 'form','text','jwt_helper','aes_helper','rc4_helper'));

			$this->load->model(array('Acara_m', 'admin_m', 'kategori_m', 'kritik_m', 'berita_m', 'foto_m', 'spot_m', 'login_m', 'donatur_m', 'tiket_m', 'api_m', 'api/token_m', 'api/file_m'));
		}

	}


	class BackEnd_Controller extends My_Controller{

		public function __construct(){
			parent::__construct();
			if($this->session->userdata('admin_logged_in') != TRUE)
			{
				redirect('login');
			}
		}
	}

	class API_Controller extends My_Controller
	{
		public function checkToken($token, $key)
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

			$data = $this->token_m->getAllTokens();

			// print($token);

			$dataFromToken = json_decode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($token)))), true);
			// print_r($dataFromToken);

			foreach($data as $row)
			{
				$dataFromDB = json_decode($ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->token)))), true);

				// print_r($dataFromDB);

				// if($token == $row->token)
				// {
				// 	print("sama");
				// }
				// echo $row->token;
				// if($dataFromDB == null)
				// {
				// 	echo "data db gagal dekrip";
				// }else{
				// 	echo "data db berhasil";
				// }

				// if($dataFromToken == null)
				// {
				// 	echo "data token gagal dekrip";
				// }else{
				// 	echo "data db berhasil";
				// }



				if($dataFromDB != null && $dataFromToken != null)
				{
					if($dataFromToken['id'] == $dataFromDB['id'] && $dataFromToken['nama'] == $dataFromDB['nama'] && $dataFromToken['level'] == $dataFromDB['level'])
					{
						return true;
						break;
					}
				}else{
					continue;
				}			

			}
			return false;
		}
	}