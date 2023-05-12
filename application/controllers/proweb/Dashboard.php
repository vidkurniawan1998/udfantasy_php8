<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller
{

	public function __construct()
	{
		parent:: __construct();
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function master()
	{

		$data = $this->main->data_main();
		$this->load->view('template/index', $data);
	}

	public function index()
	{
		$data = $this->main->data_main();
		$this->template->set('dashboard', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Dashboard');
		$this->template->load_admin('dashboard/index', $data);
	}
}
