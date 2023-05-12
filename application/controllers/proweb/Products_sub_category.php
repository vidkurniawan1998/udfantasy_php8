<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_sub_category extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_products_sub_category');
		$this->load->model('m_products_category');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index($id_parent)
	{
		$data = $this->main->data_main();
		$data['category'] = $this->m_products_sub_category->get_data($id_parent)->result();
		$where = array ( 'id' => $id_parent );
		$data['parent'] = $this->m_products_category->row_data($where);
		$this->template->set('category', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Management Sub Category Wine');
		$this->template->load_admin('products_sub_category/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_parent_category', 'Parent Category', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
//		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');

		$this->load->model('m_products_sub_category');

		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'id_parent_category' => form_error('id_parent_category'),
					'title' => form_error('title'),
					'description' => form_error('description'),
//					'thumbnail_alt' => form_error('thumbnail_alt'),
					'meta_title' => form_error('meta_title'),
					'meta_description' => form_error('meta_description'),
					'meta_keywords' => form_error('meta_keywords'),
				)
			));
		} else {

			$data = $this->input->post(NULL);
			$data['slug'] = $this->main->slug($this->input->post('title'));

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

			$this->m_products_sub_category->input_data($data);

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data',
			));
		}
	}

	public function delete($id)
	{
		$where = array('id' => $id);
//		$row = $this->m_products_sub_category->row_data($where);
//		$this->main->delete_file($row->thumbnail);
		$this->m_products_sub_category->delete_data($where);
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_parent_category', 'Parent Category', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
//		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'id_parent_category' => form_error('id_parent_category'),
					'title' => form_error('title'),
//					'thumbnail_alt' => form_error('thumbnail_alt'),
					'meta_title' => form_error('meta_title'),
					'meta_description' => form_error('meta_description'),
					'meta_keywords' => form_error('meta_keywords'),
				)
			));
		} else {

			$id = $this->input->post('id');
			$data = $this->input->post(NULL);
			$data['slug'] = $this->main->slug($this->input->post('title'));
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
//					$row_data = $this->m_products_sub_category->row_data($where);
//					$this->main->delete_file($row_data->thumbnail);

					$data['thumbnail'] = $response['filename'];
				}
			}


			$this->m_products_sub_category->update_data($where, $data);
			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}
	}

	public function get_sub_category($id_parent)
    {

		$data = $this->db->select('products_sub_category.id, products_sub_category.title')->where('id_parent_category',$id_parent)->order_by('title', 'ASC')->get('products_sub_category')->result_array();

		echo json_encode($data);
    }
}
