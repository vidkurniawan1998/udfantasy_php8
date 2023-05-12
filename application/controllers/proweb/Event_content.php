<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_content extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_event');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['event'] = $this
            ->db
            ->select('event.*')
            ->where('event.id_language', $data['id_language'])
            ->order_by('event.id', 'DESC')
            ->get('event')
            ->result();
		$data['team'] = $this->db->order_by('title', 'ASC')->get('team')->result();
//		$data['event_category'] = $this->db->order_by('title', 'ASC')->get('event_category')->result();
		$this->template->set('event', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Management Blog');
		$this->template->load_admin('event_content/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
//		$this->form_validation->set_rules('id_team', 'Team', 'required');
//		$this->form_validation->set_rules('id_event_category', 'Blog Category', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');

		$this->load->model('m_event');

		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
//					'id_team' => form_error('id_team'),
//					'id_event_category' => form_error('id_event_category'),
					'title' => form_error('title'),
					'description' => form_error('description'),
					'thumbnail_alt' => form_error('thumbnail_alt'),
					'meta_title' => form_error('meta_title'),
					'meta_description' => form_error('meta_description'),
					'meta_keywords' => form_error('meta_keywords'),
				)
			));
		} else {

			$data = $this->input->post(NULL);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_thumbnail('thumbnail', $this->input->post('title'));
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

			$data['created_at'] = date('Y-m-d H:i:s');
			$data['slug'] = $this->main->slug($this->main->remove_special_characters($data['title']));

			$this->m_event->input_data($data);

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data',
			));
		}
	}

	public function delete($id)
	{
		$where = array('id' => $id);
		$row = $this->m_event->row_data($where);
		$this->main->delete_file($row->thumbnail);
		$this->m_event->delete_data($where);
	}

	public function update()
	{
		$this->load->library('form_validation');
//		$this->form_validation->set_rules('id_team', 'Team', 'required');
//		$this->form_validation->set_rules('id_event_category', 'Blog Category', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'title' => form_error('title'),
//					'id_team' => form_error('id_team'),
//					'id_event_category' => form_error('id_event_category'),
					'meta_title' => form_error('meta_title'),
					'meta_description' => form_error('meta_description'),
					'meta_keywords' => form_error('meta_keywords'),
				)
			));
		} else {

			$id = $this->input->post('id');
			$data = $this->input->post(NULL);
            $data['slug'] = $this->main->slug($this->main->remove_special_characters($data['title']));
			$where = array(
				'id' => $id
			);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_thumbnail('thumbnail', $this->input->post('title'));
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
//					$row_data = $this->m_event->row_data($where);
//					$this->main->delete_file($row_data->thumbnail);

					$data['thumbnail'] = $response['filename'];
				}
			}


			$this->m_event->update_data($where, $data);
			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}
	}
}
