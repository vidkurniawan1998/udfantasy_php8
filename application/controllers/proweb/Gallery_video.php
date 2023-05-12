<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_video extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_video');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['video'] = $this->m_video->get_data()->result();
		$this->template->set('video', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Gallery Video');
		$this->template->load_admin('gallery_video/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('video', 'Video', 'required');

		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$video = $this->input->post('video');

		$this->load->model('m_video');

		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Isi form belum benar',
				'errors' => array(
					'title' => form_error('title'),
					'description' => form_error('description'),
					'video' => form_error('video')
				)
			));
		} else {
			$data = array(
				'title' => $title,
				'description' => $description,
				'video' => $video
			);
			$this->m_video->input_data($data, 'video');

			echo json_encode(array(
				'status' => 'success',
				'message' => 'data berhasil diinput'
			));
		}
	}

	public function delete($id)
	{
		$where = array('id' => $id);
		$this->m_video->delete_data($where, 'video');
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('video', 'video', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Isi form belum benar',
				'errors' => array(
					'title' => form_error('title'),
					'description' => form_error('description'),
					'video' => form_error('video')
				)
			));
		} else {
			$id = $this->input->post('id');
			$title = $this->input->post('title');
			$description = $this->input->post('description');
			$video = $this->input->post('video');
			$this->load->model('m_video');
			$data = array(
				'id' => $id,
				'title' => $title,
				'description' => $description,
				'video' => $video,
			);
			$where = array(
				'id' => $id
			);

			$this->m_video->update_data($where, $data, 'video');
			echo json_encode(array(
				'status' => 'success',
				'message' => 'data berhasil diinput'
			));
		}
	}
}
