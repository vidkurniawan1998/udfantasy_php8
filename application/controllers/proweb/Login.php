<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_login');
		$this->load->library('main');

		$this->main->check_login();
	}

	public function index()
	{
//	    echo json_encode($this->session->all_userdata());
		$data = $this->main->data_main();
		$this->load->view('admins/login/index', $data);
	}

	function check_akun() {
		$this->load->library('form_validation');

		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		$where = array(
			'username' => $username,
			'password' => $password
		);
		$cek = $this->m_login->cek_login("admin", $where)->num_rows();
		if ($cek > 0) {
			$user = $this->db->get_where('admin', $where)->row();
			$data_session = array(
				'username' => $user->username,
				'name' => $user->name,
				'status' => "login"
			);

			$this->session->set_userdata($data_session);

			return TRUE;

		} else {
			$this->form_validation->set_message('check_akun', 'Incorrect Username or Password');
			return FALSE;
		}
	}

	public function process()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|callback_check_akun');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'username' => form_error('username'),
					'password' => form_error('password'),
				)
			));
		} else {
			echo json_encode(array(
				'status' => 'success'
			));
			redirect('proweb/dashboard');
		}

	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}
