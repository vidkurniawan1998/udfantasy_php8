<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_products_by_category extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_pages');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$type = 'home_products_by_category';
		$where = array(
			'id_language'=>$data['id_language'],
            'type' => $type
		);
        $data['row'] = $this->m_pages->row_data($where);
        $data['type'] = $type;
		$data['items'] = $this->db->where(array('use' => 'yes', 'id_language' => $data['id_language']))->order_by('id', 'ASC')->get('products_category')->result();
		$this->template->set('home_products_by_category', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Management Home Products by Category');
		$this->template->load_admin('home_products_by_category/index', $data);
	}

	public function update($id = '')
	{
		$this->load->library('form_validation');
        $this->form_validation->set_rules('data_1[]', 'Data Category', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
                    'data_1' => form_error('data_1'),
				)
			));
		} else {
			$data = $this->input->post(NULL);
            $data['data_1'] = json_encode($data['data_1']);
			$where = array(
				'id' => $id
			);

			$this->m_pages->update_data($where, $data);
			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}
	}
}