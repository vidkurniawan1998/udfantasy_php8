<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout_report_recap extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_checkout');
		$this->load->model('m_checkout_item');
		$this->load->library('print_pdf');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$this->template->set('checkout', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Laporan Rekap Penjualan');
		$this->template->load_admin('checkout_report_recap/index', $data);
	}

	public function print_report_recap()
    {
        $data = $this->main->data_main();
        $data['date_from'] = $this->input->post('date_from');
        $data['date_to'] = $this->input->post('date_to');
        $data['date_from'] = date('Y-m-d', strtotime($data['date_from']));
        $data['date_to'] = date('Y-m-d', strtotime($data['date_to']));
        $where = array(
            'checkout.created_at >=' => $data['date_from'],
            'checkout.created_at <=' => $data['date_to'],
            'checkout.status' => 'barang diterima'
        );
		$data['checkout'] = $this
            ->m_checkout
            ->get_join_no_off_where($where)
            ->result();

		$this->print_pdf->filename = "Checkout ".$data['checkout']->invoice.".pdf";
		$this->print_pdf->load_view('pdf_template/checkout_report_recap', $data);
    }
}
