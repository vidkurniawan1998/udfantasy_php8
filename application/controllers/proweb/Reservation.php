<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_reservation');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['reservation'] = $this->m_reservation->get_data()->result();
		$this->template->set('reservation', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'management Reservation');
		$this->template->load_admin('reservation/index', $data);
	}
}
