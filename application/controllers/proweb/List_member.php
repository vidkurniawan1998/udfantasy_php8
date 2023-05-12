<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_member extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_member');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['member'] = $this->db->get('member')->result();
		$this->template->set('member', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Management Blog');
		$this->template->load_admin('list_member/index', $data);
	}

	public function delete($id)
	{
		$where = array('id' => $id);
		$row = $this->m_member->row_data($where);
		$this->main->delete_file($row->thumbnail);
		$this->m_member->delete_data($where);
	}
}
