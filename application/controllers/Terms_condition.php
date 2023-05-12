<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms_condition extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('main');
        $this->load->library('cart');
    }

    public function index()
    {
        $data = $this->main->data_front();

        $data['page'] = $this->db->where(array('type' => 'terms_condition', 'id_language' => $data['id_language']))->get('pages')->row();

        $this->template->front('terms_condition', $data);

    }
}
