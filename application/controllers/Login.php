<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_login');
		$this->load->library('main');
		$this->load->library('cart');

		$this->main->check_login_member();
	}

	public function index()
	{
//	    echo json_encode($this->session->all_userdata());
		$data = $this->main->data_front();
		$data['page'] = $this->db->where(array('type' => 'login', 'id_language' => $data['id_language']))->get('pages')->row();

		$this->template->front('login', $data);
	}

	function check_akun() {
		$this->load->library('form_validation');

		$data_front = $this->main->data_front();

		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));
		$where = array(
			'email' => $email,
			'password' => $password
		);
		$cek = $this->m_login->cek_login("member", $where)->num_rows();
		$active = $this->m_login->cek_login('member', $where)->row()->status;
		if ($cek > 0 && $active == 'active') {
			$user = $this->db->get_where('member', $where)->row();
			$data_session = array(
				'email_member' => $user->email,
				'name_member' => $user->name,
				'code_member' =>$user->password,
				'status_member' => "login"
			);

			$this->session->set_userdata($data_session);

			return TRUE;

		} else if ($cek > 0 && $active == 'not_active') {
		    if ($data_front['lang_code'] == 'en') {
		        $this->form_validation->set_message('check_akun', 'Your account is not active yet! Please validate your account first!');
            } else if ($data_front['lang_code'] == 'id') {
		        $this->form_validation->set_message('check_akun', 'Akun belum aktif! Mohon validasi akun anda terlebih dahulu!');
            }

			return FALSE;
        } else {
		    if ($data_front['lang_code'] == 'en') {
		        $this->form_validation->set_message('check_akun', 'Incorrect Email or Password!');
            } else if ($data_front['lang_code'] == 'id') {
		        $this->form_validation->set_message('check_akun', 'Email atau Password Ada Salah!');
            }

			return FALSE;
		}
	}

	public function process()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|callback_check_akun');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'email' => form_error('email'),
					'password' => form_error('password'),
				)
			));
		} else {
			echo json_encode(array(
				'status' => 'success',
                'no_swal' => 'true',
                'redirect' => 'user-profile/'
			));
		}

	}

	function logout()
	{
	    $data_session = array(
				'email_member',
				'name_member',
				'status_member'
			);
		$this->session->unset_userdata($data_session);
		redirect('login');
	}
}
