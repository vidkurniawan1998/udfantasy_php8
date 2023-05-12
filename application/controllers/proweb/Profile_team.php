<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_team extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_team');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['team'] = $this->m_team->get_data()->result();
		$this->template->set('gallery', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Management Team');
		$this->template->load_admin('profile_team/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('position', 'Position', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
//		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_error_delimiters('', '');

		$title = $this->input->post('title');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'title' => form_error('title'),
					'position' => form_error('position'),
					'description' => form_error('description'),
//					'thumbnail_alt' => form_error('thumbnail_alt'),
				)
			));
		} else {

			$data = $this->input->post(NULL, TRUE);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_thumbnail('thumbnail', $title);
				if (!$response['status']) {
					echo json_encode(array(
						'status' => 'error',
						'message' => 'The form is not correct',
						'errors' => array(
							'image' => $response['message']
						)
					));
					exit;
				} else {
					$data['thumbnail'] = $response['filename'];
				}
			}

			$this->m_team->input_data($data);

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data',
			));
		}
	}

	public function delete($id)
	{

		$where = array('id' => $id);
//		$row = $this->m_gallery->row_data($where);
//		$this->main->delete_file($row->thumbnail);
		$this->m_gallery->delete_data($where);
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('position', 'Position', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
//		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'title' => form_error('title'),
                    'position' => form_error('position'),
                    'description' => form_error('description'),
//					'description' => form_error('description'),
//					'thumbnail_alt' => form_error('thumbnail_alt'),
				)
			));
		} else {

			$this->load->model('m_slider');
			if ($this->form_validation->run() === FALSE) {
				echo json_encode(array(
					'status' => 'error',
					'message' => 'The form is not correct',
					'errors' => array(
						'title' => form_error('title'),
//						'description' => form_error('description'),
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
							'message' => 'The form is not correct',
							'errors' => array(
								'image' => $response['message']
							)
						));
						exit;
					} else {
//						$row_data = $this->m_gallery->row_data($where);
//						$this->main->delete_file($row_data->thumbnail);
						$data['thumbnail'] = $response['filename'];
					}
				}

				$this->m_team->update_data($where, $data);
				echo json_encode(array(
					'status' => 'success',
					'message' => 'success input data'
				));
			}
		}
	}
}
