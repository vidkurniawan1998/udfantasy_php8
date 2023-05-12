<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller
{

	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_email');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['email'] = $this->m_email->get_data()->result();
		$this->template->set('email', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'management Email');
		$this->template->load_admin('email/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$email = $this->input->post('email');
		$use = $this->input->post('use');
		$this->load->model('m_admin');
		$this->form_validation->set_error_delimiters('', '');
		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'status' => form_error('status'),
					'email' => form_error('email')
				)
			));
		} else {
			$data = array(
				'email' => $email,
				'use' => $use,
			);
			$this->m_email->input_data($data, 'email');

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}
	}

	public function delete($id)
	{
		$where = array('id' => $id);
		$this->m_email->delete_data($where, 'email');
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'username' => form_error('username'),
					'password1' => form_error('password1'),
					'password2' => form_error('password2'),
					'email' => form_error('email')
				)
			));
		} else {
			$id = $this->input->post('id');
			$data = $this->input->post(NULL, TRUE);
			$where = array(
				'id' => $id
			);

			$this->m_email->update_data($where, $data);
			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}
	}
}
