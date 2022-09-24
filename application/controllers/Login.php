<?php 

	class Login extends My_Controller
	{

		public function index()
		{
			$this->load->view('login');
		}

		public function doLogin()
		{
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('failed', validation_errors()); 
				redirect('login');
			}else{

				$username = $_POST['username'];
				$password = $_POST['password'];

				$admin = $this->login_m->get_admin_by_username($username);

				if(!is_null($admin))
				{
					if(password_verify($password, $admin->password))
					{
						$this->session->set_userdata(array(

							'admin_id' => $admin->id,
							'admin_name' => $admin->username,
							'admin_level' => $admin->level,
							'admin_logged_in' => TRUE

						));
						redirect('acara');
					}else{
						$this->session->set_flashdata('failed', "Username atau Password Salah");
						redirect('login');
					}
				}else{
					$this->session->set_flashdata('failed', 'Username atau Password Salah');
					redirect('login');
				}

			}
		}

		public function logout()
		{
			$this->session->unset_userdata(array(

				'admin_id',
				'admin_name',
				'admin_logged_in'

			));

			redirect('login');
		}

	}