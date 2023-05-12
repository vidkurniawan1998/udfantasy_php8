<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_profile extends CI_Controller
{
    private $ci;

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

        $this->ci =& get_instance();

		$this->main->check_member();
    }

    public function index()
    {
        $data = $this->main->data_front();
        $offset = $this->uri->segment(4);

        $where_member = array('member.hash' => md5($this->ci->session->userdata('email_member')));
        $data['member'] = $this->m_member->get_where($where_member)->row();

        $jumlah_data = $this->db
            ->where(array(
                'id_member'=> $data['member']->id
            ))
            ->get('checkout')
            ->num_rows();

        $this->load->library('pagination');
        $config['base_url'] = site_url('user-profile/');
        $config['total_rows'] = $jumlah_data;
        $config['per_page'] = 10;

        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = '<i class="linearicons-arrow-right"></i>';
        $config['prev_link'] = '<i class="linearicons-arrow-left"></i>';
        $config['full_tag_open'] = '<ul class="pagination mt-3 justify-content-center pagination_style3">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</li></span>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</li></span>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</li></span>';

        $this->pagination->initialize($config);

        $data['page'] = $this->db->where(array('type' => 'user_profile', 'id_language' => $data['id_language']))->get('pages')->row();
        $data['home'] = $this->db->where(array('type' => 'home', 'id_language' => $data['id_language']))->get('pages')->row();
        $where_district = array('provinces.name' => 'BALI');
        $data['districts'] = $this->m_districts->get_where($where_district)->result();
        $where_address = array('member_address.id_member' => $data['member']->id);
        $data['member_address'] = $this->m_member_address->get_join_where($where_address)->result();
        $where_checkout = array('checkout.id_member' => $data['member']->id);
        $data['data_checkout'] = $this->m_checkout->get_join_where($where_checkout, $offset)->result();
        foreach ($data['data_checkout'] as $checkout) {
            $where_checkout_item = array('checkout_item.id_checkout' => $checkout->id);
            $data['checkout_item'][$checkout->id] = $this->m_checkout_item->get_where($where_checkout_item)->result();
        }

        $this->template->front('user_profile', $data);
    }
    
    public function biodata()
    {
        $this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'User Name', 'required');
		$this->form_validation->set_rules('email', 'User Email', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');

		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'name' => form_error('name'),
                    'email' => form_error('email'),
                    'phone' => form_error('phone'),
				)
			));
		} else {
			$data = $this->input->post(NULL);

            $hash = $data['hash'];
            $where_member = array('hash' => $hash);
            $member = $this->m_member->get_where($where_member)->row();

			if ($_FILES['user_photo']['name']) {
				$response = $this->main->upload_file_custom('user_photo', md5($member->email), 301, 301);
				if (!$response['status']) {
					echo json_encode(array(
						'status' => 'error',
						'message' => 'The form is not correct',
						'errors' => array(
							'user_photo' => $response['message']
						)
					));
					exit;
				} else {
//				    $fInfo = $this->ci->upload->data();
//				    $this->main->adjustPicOrientation($fInfo['full_path']);
					$data['user_photo'] = $response['filename'];
				}
			}

            unset($data['hash']);

            $where_update = array('id' => $member->id);
            $this->m_member->update_data($where_update, $data);

            echo json_encode(array(
                'status' => 'success',
                'message' => 'Sukses update profil',
                'reloadPage' => 'reload'
            ));
        }
    }
}
