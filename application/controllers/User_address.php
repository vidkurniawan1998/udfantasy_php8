<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_address extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('main');
        $this->load->model('m_provinces');
        $this->load->model('m_districts');
        $this->load->model('m_member');
        $this->load->model('m_member_address');
        $this->load->model('m_checkout');
        $this->load->model('m_checkout_item');
        $this->load->library('cart');

		$this->main->check_member();
    }

    public function add_address()
    {
        $user = $this->db->where('id', $this->input->post('id_member'))->get('member')->row();

        $this->load->library('form_validation');
		$this->form_validation->set_rules('receiver_name', 'Receiver Name', 'required');
		$this->form_validation->set_rules('address_name', 'Address Name', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('id_district', 'City/District', 'required');
		$this->form_validation->set_rules('postcode', 'Postcode', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');

		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'receiver_name' => form_error('receiver_name'),
                    'address_name' => form_error('address_name'),
                    'phone' => form_error('phone'),
                    'id_district' => form_error('id_district'),
                    'postcode' => form_error('postcode'),
                    'address' => form_error('address'),
				)
			));
		} else {
			$data = $this->input->post(NULL);

			$where_province = array('provinces.name' => 'BALI');
			$data['id_province'] = $this->m_provinces->get_where($where_province)->row()->id;
			$this->m_member_address->input_data($data);

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data',
                'reloadPage' => 'reload'
			));
		}
    }

    public function update_address()
    {
        $user = $this->db->where('id', $this->input->post('id_member'))->get('member')->row();

        $this->load->library('form_validation');
		$this->form_validation->set_rules('receiver_name', 'Receiver Name', 'required');
		$this->form_validation->set_rules('address_name', 'Address Name', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('id_district', 'City/District', 'required');
		$this->form_validation->set_rules('postcode', 'Postcode', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');

		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'receiver_name' => form_error('receiver_name'),
                    'address_name' => form_error('address_name'),
                    'phone' => form_error('phone'),
                    'id_district' => form_error('id_district'),
                    'postcode' => form_error('postcode'),
                    'address' => form_error('address'),
				)
			));
		} else {

			$id = $this->input->post('id');
			$data = $this->input->post(NULL);
			$where = array(
				'id' => $id
			);

			$this->m_member_address->update_data($where, $data);
			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data',
                'reloadPage' => 'reload'
			));
		}
    }

	public function delete_address($id_address)
	{
		$where = array('id' => $id_address);
		$response = $this->m_member_address->delete_data($where);

		if ($response == FALSE) {
		    echo json_encode(array(
		        'response' => 'failed'
            ));
        } else {
		    echo json_encode(array(
		       'response' => 'success'
            ));
        }
	}
}
