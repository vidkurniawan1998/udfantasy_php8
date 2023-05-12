<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_coverage extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_delivery_coverage');
		$this->load->model('m_districts');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['delivery_coverage'] = $this->m_delivery_coverage->get_data()->result();
		$where_districts = array(
		    'provinces.name' => 'BALI',
        );
		$data['districts'] = $this->m_districts->get_where($where_districts)->result();
		$this->template->set('delivery_coverage', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Management Category');
		$this->template->load_admin('delivery_coverage/index', $data);
	}

	public function createprocess()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_district', 'Data Deliver Coverage', 'required|is_unique[delivery_coverage.id_district]');
		$this->form_validation->set_rules('price', 'Price', 'required');

		$this->load->model('m_delivery_coverage');

		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'id_district' => form_error('id_district'),
                    'price' => form_error('price'),
				)
			));
		} else {
			$data = $this->input->post(NULL);

			$this->m_delivery_coverage->input_data($data);

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data',
			));
		}
	}

	public function delete($id)
	{
		$where = array('id' => $id);
//		$row = $this->m_delivery_coverage->row_data($where);
//		$this->main->delete_file($row->thumbnail);
		$this->m_delivery_coverage->delete_data($where);
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_district', 'Data Deliver Coverage', 'required');
		$this->form_validation->set_rules('price', 'Price', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'id_district' => form_error('id_district'),
                    'price' => form_error('price'),
				)
			));
		} else {

			$id = $this->input->post('id');
			$data = $this->input->post(NULL);
			$where = array(
				'id' => $id
			);

			$this->m_delivery_coverage->update_data($where, $data);
			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}
	}
}
