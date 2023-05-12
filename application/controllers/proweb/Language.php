<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_language');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['data'] = $this->m_language->get_data()->result();
		$this->template->set('Language', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'management Slider Image');
		$this->template->load_admin('language/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('code', 'Code', 'required');
		$this->form_validation->set_rules('use', 'Use', 'required');
		$this->form_validation->set_error_delimiters('', '');
		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'title' => form_error('title'),
					'code' => form_error('code'),
					'use' => form_error('use')
				)
			));
		} else {
			$data = $this->input->post(NULL);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_slider('thumbnail', $this->input->post('title'));
				if (!$response['status']) {
					echo json_encode(array(
						'status' => 'error',
						'message' => 'The form is not correct',
						'errors' => array(
							'thumbnail' => $response['message']
						)
					));
					exit;
				} else {
					$data['thumbnail'] = $response['filename'];
				}
			}

			$this->m_language->input_data($data);

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data',
			));
		}
	}

	public function delete($id)
	{
		$where = array('id' => $id);
//		$row = $this->m_slider->row_data($where);
//		$this->main->delete_file($row->thumbnail);
		$this->m_language->delete_data($where);
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('code', 'Code', 'required');
		$this->form_validation->set_rules('use', 'Use', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'title' => form_error('title'),
					'code' => form_error('code'),
					'use' => form_error('use')
				)
			));
		} else {
			$id = $this->input->post('id');
			$data = $this->input->post(NULL);
			$where = array(
				'id' => $id
			);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_slider('thumbnail', $this->input->post('title'));
				if (!$response['status']) {
					echo json_encode(array(
						'status' => 'error',
						'message' => 'The form is not correct',
						'errors' => array(
							'thumbnail' => $response['message']
						)
					));
					exit;
				} else {
					//$row_data = $this->m_slider->row_data($where);
					//$this->main->delete_file($row_data->thumbnail);

					$data['thumbnail'] = $response['filename'];
				}
			}


			$this->m_language->update_data($where, $data);
			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}
	}
}
