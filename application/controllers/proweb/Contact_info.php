<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_info extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_contact_info');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['contact_info'] = $this->m_contact_info->get_data()->result();
		$data['phone_text_use'] = $this->db->where('type', 'phone_text_link')->get('contact_info')->row();
		$this->template->set('contact_info', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Management Contact Info');
		$this->template->load_admin('contact_info/index', $data);
	}

	public function update()
	{
//		$this->load->library('form_validation');
//		$this->form_validation->set_rules('use', 'Use', 'required');
//		$this->form_validation->set_error_delimiters('', '');

//		if ($this->form_validation->run() === FALSE) {
//			echo json_encode(array(
//				'status' => 'error',
//				'message' => 'The form is not correct',
//				'errors' => array(
//					'use' => form_error('use'),
//				)
//			));
//		} else {
            $id_array = $this->input->post('id');
            $description_array = $this->input->post('description');
            $use_array = $this->input->post('use');
            $type_array = $this->input->post('type');
            $use_text = $this->input->post('use_text');
            $id_text = $this->input->post('id_text');

//            var_dump($description_array[1]);
            foreach ($id_array as $key => $id){
                if ($type_array[$key] == 'phone' && !empty($description_array[$key])) {
                    $preg_phone = preg_replace('/\s+/', '', $description_array[$key]);
                    $contact_link['phone_text_link'] = 'sms:'.$preg_phone;
                    $use_link['phone_text_link'] = $use_text;
                    $contact_link['phone_link'] = 'tel:'.$preg_phone;
                    $use_link['phone_link'] = $use_array[$key];
                } else if($type_array[$key] == 'whatsapp' && !empty($description_array[$key])) {
                    $contact_link['whatsapp_link'] = 'https://wa.me/'.$this->main->trim_number_wa(preg_replace('/\s+/', '', $description_array[$key]));
                    $use_link['whatsapp_link'] = $use_array[$key];
                } else if($type_array[$key] == 'line_link' && !empty($description_array[$key])) {
                    $contact_link['line_link'] = 'http://line.me/ti/p/~'.$description_array[$key];
                    $use_link['line_link'] = $use_array[$key];
                } else if($type_array[$key] == 'email' && !empty($description_array[$key])) {
                    $contact_link['email_link'] = 'mailto:'.$description_array[$key];
                    $use_link['email_link'] = $use_array[$key];
                } else if($type_array[$key] == 'instagram_link' && !empty($description_array[$key])) {
                    $contact_link['instagram_link'] = ' http://www.instagram.com/'.$description_array[$key];
                    $use_link['instagram_link'] = $use_array[$key];
                }

                $data['description'] = $description_array[$key];
                $data['use'] = $use_array[$key];

                $where = array(
                    'id' => $id
                );

                $this->m_contact_info->update_data($where, $data);
            }

            foreach ($contact_link as $key => $link) {
                $data_text['description'] = $link;
                $data_text['use'] = $use_link[$key];

                $where_text = array (
                    'type' => $key
                );

                $this->m_contact_info->update_data($where_text, $data_text);
            }
			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
//		}
	}
}
