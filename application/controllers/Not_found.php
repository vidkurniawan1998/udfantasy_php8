<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Not_found extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->library('main');
        $this->load->library('cart');

	}

	public function index()
	{
	    $this->output->set_status_header('404');
		$data = $this->main->data_front();
		$data['page'] = $this->db->where(array('type' => 'not_found', 'id_language' => $data['id_language']))->get('pages')->row();
		$data['home'] = $this->db->where(array('type' => 'home', 'id_language' => $data['id_language']))->get('pages')->row();
		$this->template->front('not_found', $data);
	}
}
