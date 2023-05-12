<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_admin');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['admin'] = $this->m_admin->get_data()->result();
		$this->template->set('admin', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'management Admin');
		$this->template->load_admin('admin/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password1', 'Password', 'required');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'required|matches[password1]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('name', 'Nama', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'username' => form_error('username'),
					'password1' => form_error('password1'),
					'password2' => form_error('password2'),
					'email' => form_error('email'),
					'name' => form_error('name'),
				)
			));
		} else {
			$username = $this->input->post('username');
			$password1 = md5($this->input->post('password1'));
			$password2 = md5($this->input->post('password2'));
			$email = $this->input->post('email');
			$name = $this->input->post('name');
			$this->load->model('m_admin');
			if ($password1 == $password2) {
				$data = array(
					'username' => $username,
					'password' => $password1,
					'email' => $email,
					'name' => $name,
				);
				$this->m_admin->input_data($data, 'admin');
				echo json_encode(array(
					'status' => 'success',
					'message' => 'success input data'
				));
			} else {
				echo json_encode(array(
					'status' => 'error',
					'message' => 'The form is not correct',
					'errors' => array(
						'password1' => 'Incorrect Password'
					)
				));
			}
		}
	}

	public function delete($id)
	{
		$where = array('id' => $id);
		$this->m_admin->delete_data($where, 'admin');
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Isi form belum benar',
				'errors' => array(
					'username' => form_error('username'),
					'password1' => form_error('password1'),
					'password2' => form_error('password2'),
					'email' => form_error('email'),
					'name' => form_error('name'),
				)
			));
		} else {
			$username = $this->input->post('username');
			$id = $this->input->post('id');
			$password1 = md5($this->input->post('password1'));
			$password2 = md5($this->input->post('password2'));
			$email = $this->input->post('email');
			$name = $this->input->post('name');
			$this->load->model('m_admin');
			if ($password1 == $password2) {
				$data = array(
					'id' => $id,
					'username' => $username,
					'email' => $email,
					'name' => $name,
				);
				$where = array(
					'id' => $id
				);

				$this->m_admin->update_data($where, $data, 'admin');
				echo json_encode(array(
					'status' => 'success',
					'message' => 'success input data'
				));
			} else {
				echo json_encode(array(
					'status' => 'error',
					'message' => 'The form is not correct',
					'errors' => array(
						'password1' => 'Incorrect Password'
					)
				));
			}
		}
	}
}
