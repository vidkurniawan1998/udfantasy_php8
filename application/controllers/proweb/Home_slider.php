<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_slider extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_slider');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$where = array(
			'id_language'=>$data['id_language']
		);
		$data['slider'] = $this->m_slider->get_where($where)->result();
		$this->template->set('slider', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'management Slider Image');
		$this->template->load_admin('slider/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_rules('url', 'Url', '');
		$this->form_validation->set_error_delimiters('', '');
		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'url' => form_error('url'),
					'thumbnail_alt' => form_error('thumbnail_alt'),
				)
			));
		} else {
			$data = $this->input->post(NULL);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_custom('thumbnail', $this->input->post('thumbnail_alt').'-'.$data['id_language'], 1903, 500);
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

			$this->m_slider->input_data($data);

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
		$this->m_slider->delete_data($where);
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('url', 'URL', 'required');
		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'url' => form_error('url'),
					'thumbnail_alt' => form_error('thumbnail_alt'),
				)
			));
		} else {
			$id = $this->input->post('id');
			$data = $this->input->post(NULL);
			$where = array(
				'id' => $id
			);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_custom('thumbnail', $this->input->post('thumbnail_alt').'-'.$data['id_language'], 1903, 500);
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


			$this->m_slider->update_data($where, $data);
			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}
	}
}
