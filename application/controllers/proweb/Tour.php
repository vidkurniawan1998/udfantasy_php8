<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tour extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model(array('m_tour', 'm_category'));
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['tour'] = $this->db
			->select('t.*, c.title AS category_title')
			->where('t.id_language', $data['id_language'])
			->join('category c', 'c.id = t.id_category', 'left')
			->get('tour t')
			->result();
		$data['category'] = $this->m_category->get_where(array('use' => 'yes', 'id_language' => $data['id_language']))->result();

		$this->template->set('tour', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'management tour');
		$this->template->load_admin('tour/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Service Title', 'required');
//		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alternative', 'required');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'meta_keywords', 'required');

		$this->form_validation->set_error_delimiters('', '');
		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Isi form belum benar',
				'errors' => array(
					'title' => form_error('title'),
					'thumbnail_alt' => form_error('thumbnail_alt'),
					'description' => form_error('description'),
					'meta_title' => form_error('meta_title'),
					'meta_description' => form_error('meta_description'),
					'meta_keywords' => form_error('meta_keywords'),
				)
			));
		} else {

			$data = $this->input->post(NULL, TRUE);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_thumbnail('thumbnail', $this->input->post('title'));
				if (!$response['status']) {
					echo json_encode(array(
						'status' => 'error',
						'message' => 'Isi form belum benar',
						'errors' => array(
							'thumbnail' => $response['message']
						)
					));
					exit;
				} else {
					$data['thumbnail'] = $response['filename'];
				}
			}


			$this->m_tour->input_data($data);

			echo json_encode(array(
				'status' => 'success',
				'message' => 'data berhasil diinput',
			));
		}
	}

	public function delete($id)
	{
		$where = array('id' => $id);
		$_id = $this->db->get_where('tour', $where)->row();
		$this->m_tour->delete_data($where, 'tour');
		unlink("upload/" . $_id->image);
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Service Title', 'required');
//		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alternative', 'required');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'meta_keywords', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Isi form belum benar',
				'errors' => array(
					'title' => form_error('title'),
					'thumbnail_alt' => form_error('thumbnail_alt'),
					'description' => form_error('description'),
					'meta_title' => form_error('meta_title'),
					'meta_description' => form_error('meta_description'),
					'meta_keywords' => form_error('meta_keywords'),
				)
			));
		} else {
			$id = $this->input->post('id');
			$data = $this->input->post(NULL, TRUE);
			$where = array(
				'id' => $id
			);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_thumbnail('thumbnail', $this->input->post('title'));
				if (!$response['status']) {
					echo json_encode(array(
						'status' => 'error',
						'message' => 'Isi form belum benar',
						'errors' => array(
							'thumbnail' => $response['message']
						)
					));
					exit;
				} else {
					$data['thumbnail'] = $response['filename'];
				}
			}

			$this->m_tour->update_data($where, $data);


			echo json_encode(array(
				'status' => 'success',
				'message' => 'data berhasil diperbarui',
			));

		}
	}

}
