<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_us extends CI_Controller
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

        $data['page'] = $this->db->where(array('type' => 'about_us', 'id_language' => $data['id_language']))->get('pages')->row();
        $data['home'] = $this->db->where(array('type' => 'home', 'id_language' => $data['id_language']))->get('pages')->row();

        $this->template->front('about_us', $data);

    }
}
