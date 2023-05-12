<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller
{

	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_contact');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['contact'] = $this->m_contact->get_data()->result();
		$this->template->set('contact', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'management Contact');
		$this->template->load_admin('contact/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('position', 'Position', 'required');
		$this->form_validation->set_rules('url', 'URL', 'required');
		$this->form_validation->set_rules('publish', 'Publish', 'required');

		$position = $this->input->post('position');
		$title = $this->input->post('title');
		$url = $this->input->post('url');
		$publish = $this->input->post('publish');

		$this->load->model('m_contact');
		$this->form_validation->set_error_delimiters('', '');


		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'title' => form_error('title'),
					'position' => form_error('position'),
					'url' => form_error('url'),
				)
			));
		} else {
			$config['upload_path'] = 'upload';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('berkas')) {
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			} else {
				$data = array('upload_data' => $this->upload->data());
			}

			$data = array(
				'position' => $position,
				'title' => $title,
				'url' => $url,
				'publish' => $publish,
				'image' => $data['upload_data']['file_name'],
			);
			$this->m_contact->input_data($data, 'contact');

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}

	}

	public function delete($id)
	{
		$where = array('id' => $id);
		$_id = $this->db->get_where('contact', $where)->row();
		$this->m_contact->delete_data($where, 'contact');
		unlink("upload/" . $_id->image);
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('position', 'Position', 'required');
		$this->form_validation->set_rules('url', 'URL', 'required');
		$this->form_validation->set_rules('publish', 'Publish', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'title' => form_error('title'),
				)
			));
		} else {
			$id = $this->input->post('id');
			$position = $this->input->post('position');
			$title = $this->input->post('title');
			$url = $this->input->post('url');
			$publish = $this->input->post('publish');
			$berkas = $this->input->post('berkas');
			$image = $this->input->post('image');


			$this->load->model('m_contact');
			if ($this->form_validation->run() === FALSE) {
				echo json_encode(array(
					'status' => 'error',
					'message' => 'The form is not correct',
					'errors' => array(
						'publish' => form_error('publish'),
					)
				));
			} else {
				if (empty($berkas)) {
					$config['upload_path'] = 'upload';
					$config['allowed_types'] = 'gif|jpg|png';

					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('berkas')) {
						$error = array('error' => $this->upload->display_errors());
						$data = array(
							'id' => $id,
							'title' => $title,
							'position' => $position,
							'url' => $url,
							'publish' => $publish,
							'image' => $image
						);
						$where = array(
							'id' => $id
						);
						$this->m_contact->update_data($where, $data, 'contact');
						echo json_encode(array(
							'status' => 'success',
							'message' => 'success input data'
						));
					} else {
						$nilai = array('upload_data' => $this->upload->data());
						$data = array(
							'position' => $position,
							'title' => $title,
							'url' => $url,
							'publish' => $publish,
							'image' => $nilai['upload_data']['file_name'],
						);
						$where = array(
							'id' => $id
						);
						$_id = $this->db->get_where('contact', $where)->row();
						unlink("upload/" . $_id->image);

						$this->m_contact->update_data($where, $data, 'contact');

						echo json_encode(array(
							'status' => 'success',
							'message' => 'success input data'
						));
					}


				}
			}
		}
	}
}
