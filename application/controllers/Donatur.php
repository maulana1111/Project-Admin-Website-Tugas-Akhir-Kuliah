<?php 

	require_once 'vendor/autoload.php';
	use Dompdf\Adapter\CPDF;      
	use Dompdf\Dompdf;
	use Dompdf\Exception;
	class Donatur extends BackEnd_Controller
	{
		public function index()
		{

			$data['data'] = $this->donatur_m->getAll();
			$data['page'] = 'pages/donatur/index';
			// $key = "1234567891234567";
			// $ObjectRC4 = new RC4();
   //          $ObjectAES = new AES($key);
			// echo base64_encode($ObjectAES->encrypt("MpLc5g=="));
			$this->load->view('tamplate', $data);
		}

		public function make_pdf()
		{
			$from 	= $_POST['from'];
			$to 	= $_POST['to'];
			$opsi 	= $_POST['opsi'];
			$key 	= $_POST['key'];
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

			$data = $this->donatur_m->getDataFilter($from, $to, $opsi);

			$response['from'] = $from;
			$response['to'] = $to;
			$response['opsi'] = $opsi;
			$response['data'] = array();
			foreach($data as $row)
			{
				$sts = $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($row->status_enkrip))));
				$stss = $row->status_show;
				if($sts == false)
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

			// print_r("<pre>");
			// print_r($response['data']);
			// print_r("</pre>");
			$dompdf = new Dompdf();
			$dompdf->loadHtml($this->load->view('document_data', $response, TRUE));

			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('A4', 'landscape');

			// Render the HTML as PDF
			$dompdf->render();

			// Output the generated PDF to Browser
			$dompdf->stream();
		}	

		public function detail($id = NULL)
		{			
			if($id == null)
			{
				$key = $_POST['key'];
				$id_data = $_POST['id_data'];

				if($key != "1234567891234567") {
					$data_donatur = $this->donatur_m->getDataWhere($id_data);
				}else{
					$data_donatur = $this->donatur_m->getDataParentWhere($id_data);
				}

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

				$data['id'] 			= $data_donatur->id;
				$data['pemilik'] 		= $data_donatur->pemilik_rekening;
				$data['no_rekening'] 	= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->no_rekening))));
				$data['organisasi'] 	= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->organisasi))));
				$data['jumlah'] 		= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->jumlah))));
				$data['gmail'] 			= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->gmail))));
				$data['pesan'] 			= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->pesan))));
				$data['status'] 		= $data_donatur->status;
				$data['bukti'] 			= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->bukti_transfer))));
				$data['status_enkrip'] 	= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->status_enkrip))));
				$data['tanggal_donate'] = $data_donatur->tanggal_donate;
				$data['status_show'] 	= $data_donatur->status_show;

			}else{
				$data_donatur = $this->donatur_m->getDataWhere($id);

				$data['id'] 			= $data_donatur->id;
				$data['pemilik'] 		= $data_donatur->pemilik_rekening;
				$data['no_rekening'] 	= $data_donatur->no_rekening;
				$data['organisasi'] 	= $data_donatur->organisasi;
				$data['jumlah'] 		= $data_donatur->jumlah;
				$data['gmail'] 			= $data_donatur->gmail;
				$data['pesan'] 			= $data_donatur->pesan;
				$data['status'] 		= $data_donatur->status;
				$data['bukti'] 			= $data_donatur->bukti_transfer;
				$data['status_enkrip'] 	= $data_donatur->status_enkrip;
				$data['tanggal_donate'] = $data_donatur->tanggal_donate;
				$data['status_show']	= $data_donatur->status_show;
			}
			$data['page'] = 'pages/donatur/donatur_detail';
			$this->load->view('tamplate', $data);
		}
		
		public function changeKey()
		{
			$id_data = $_POST['id_data'];
			$key_baru = $_POST['key_baru'];
			$key_lama = $_POST['key_lama'];

			if($key_lama != "1234567891234567")
			{
				$data = $this->donatur_m->getDataWhere($id_data);
			}else{
				$data = $this->donatur_m->getDataParentWhere($id_data);
			}

			$keys = "";
			if(strlen($key_baru) != 16)
			{
				$count = 16 - strlen($key_baru);
				$str = "";
				for($i=0; $i < $count; $i++)
				{
					$str .= "0";
				}
				$keys = $key_baru.$str;
			}else{
				$keys = $key_baru;
			}

            $ObjectAES = new AES($keys);
            $ObjectAESLama = new AES($key_lama);
			$ObjectRC4 = new RC4();


			// diubah terlebih dahulu ke dalam data asli
			$no_rekening 	= $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($key_lama, base64_decode($data->no_rekening))));
			$jumlah 		= $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($key_lama, base64_decode($data->jumlah))));
			$gmail 			= $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($key_lama, base64_decode($data->gmail))));
			$organisasi 	= $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($key_lama, base64_decode($data->organisasi))));
			$pesan 			= $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($key_lama, base64_decode($data->pesan))));
			$bukti 			= $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($key_lama, base64_decode($data->bukti_transfer))));
            $status_enkrip 	= $ObjectAESLama->decrypt(base64_decode($ObjectRC4->proses($key_lama, base64_decode($data->status_enkrip))));

            // di enkrip lagi dengan key yang baru
            $en_no_rekening 	= base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt($no_rekening))));
			$en_jumlah 			= base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt($jumlah))));
			$en_gmail 			= base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt($gmail))));
			$en_organisasi		= base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt($organisasi))));
			$en_pesan 			= base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt($pesan))));
			$en_bukti 			= base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt($bukti))));
            $en_status_enkrip 	= base64_encode($ObjectRC4->proses($keys, base64_encode($ObjectAES->encrypt($status_enkrip))));


			$this->donatur_m->enkripsiData(array(
				'no_rekening' => $en_no_rekening,
				'organisasi' => $en_organisasi,
				'jumlah' => $en_jumlah,
				'gmail' => $en_gmail,
				'pesan' => $en_pesan,
                'bukti_transfer' => $en_bukti,
                'status_enkrip' => $en_status_enkrip
			), array(
				'id' => $id_data
			));

            $this->session->set_flashdata('success', 'Data Berhasil di Ubah');
            redirect('donatur');
		}

		public function checkData()
		{
			$key = $_POST['key'];
			$id_data = $_POST['id_data'];

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

			if($key != "1234567891234567")
			{
				$data_donatur = $this->donatur_m->getDataWhere($id_data);
			}else{				
				$data_donatur = $this->donatur_m->getDataParentWhere($id_data);
			}

			$data['key_lama'] = $keys;

			$data['id'] 			= $data_donatur->id;
			$data['pemilik'] 		= $data_donatur->pemilik_rekening;
			$data['no_rekening'] 	= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->no_rekening))));
			$data['jumlah'] 		= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->jumlah))));
			$data['gmail'] 			= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->gmail))));
			$data['pesan'] 			= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->pesan))));
			$data['status'] 		= $data_donatur->status;
			$data['bukti'] 			= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->bukti_transfer))));
			$data['status_enkrip'] 	= $ObjectAES->decrypt(base64_decode($ObjectRC4->proses($keys, base64_decode($data_donatur->status_enkrip))));
			$data['status_show'] 	= $data_donatur->status_show;

			$data['page'] = 'pages/donatur/cek_data_donatur';
			$this->load->view('tamplate', $data);
		}

		public function changeStatusTerima($id)
		{
			$this->donatur_m->changeStatus(array(
				'status' => 'diterima'
			),array('id' => $id));
			$this->session->set_flashdata('success', 'Data Berhasil di Ubah');
			redirect('donatur');
		}

		public function changeStatusTolak($id)
		{
			$this->donatur_m->changeStatus(array(
				'status' => 'tidak_diterima'
			),array('id' => $id));
			$this->session->set_flashdata('success', 'Data Berhasil di Ubah');
			redirect('donatur');
		}
}