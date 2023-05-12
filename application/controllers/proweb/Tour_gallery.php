<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tour_gallery extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model(array('m_tour', 'm_tour_gallery'));
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['gallery'] = $this->db
			->select('tg.*, t.title AS tour_title')
			->join('tour t', 't.id = tg.id_tour')
			->where(array(
				't.id_language'=>$data['id_language']
			))
			->order_by('tg.id', 'DESC')
			->get('tour_gallery tg')
			->result();
		$data['tour'] = $this->m_tour->get_where(array('id_language'=>$data['id_language']))->result();
		$this->template->set('gallery', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'management Gallery Photo');
		$this->template->load_admin('tour_gallery/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_tour', 'Tour', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_error_delimiters('', '');

		$title = $this->input->post('title');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Isi form belum benar',
				'errors' => array(
					'id_tour' => form_error('id_tour'),
					'title' => form_error('title'),
					'description' => form_error('description'),
					'thumbnail_alt' => form_error('thumbnail_alt'),
				)
			));
		} else {

			$data = $this->input->post(NULL, TRUE);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_thumbnail('thumbnail', $title);
				if (!$response['status']) {
					echo json_encode(array(
						'status' => 'error',
						'message' => 'Isi form belum benar',
						'errors' => array(
							'image' => $response['message']
						)
					));
					exit;
				} else {
					$data['thumbnail'] = $response['filename'];
				}
			}

			$this->m_tour_gallery->input_data($data);

			echo json_encode(array(
				'status' => 'success',
				'message' => 'data berhasil diinput',
			));
		}
	}

	public function delete($id)
	{

		$where = array('id' => $id);
//		$row = $this->m_tour_gallery->row_data($where);
//		$this->main->delete_file($row->thumbnail);
		$this->m_tour_gallery->delete_data($where);
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_tour', 'Tour', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Isi form belum benar',
				'errors' => array(
					'id_tour' => form_error('id_tour'),
					'title' => form_error('title'),
					'description' => form_error('description'),
					'thumbnail_alt' => form_error('thumbnail_alt'),
				)
			));
		} else {

			$id = $this->input->post('id');
			$data = $this->input->post(NULL, TRUE);
			$where = array(
				'id' => $id
			);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_thumbnail('thumbnail', $data['title']);
				if (!$response['status']) {
					echo json_encode(array(
						'status' => 'error',
						'message' => 'Isi form belum benar',
						'errors' => array(
							'image' => $response['message']
						)
					));
					exit;
				} else {
//					$row_data = $this->m_tour_gallery->row_data($where);
//					$this->main->delete_file($row_data->thumbnail);
					$data['thumbnail'] = $response['filename'];
				}
			}

			$this->m_tour_gallery->update_data($where, $data);
			echo json_encode(array(
				'status' => 'success',
				'message' => 'data berhasil diinputkan'
			));
		}
	}
}
