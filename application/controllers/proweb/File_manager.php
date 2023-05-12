<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_manager extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('m_pages');
        $this->load->library('main');
        $this->main->check_admin();
    }

    public function index()
    {
        $data = $this->main->data_main();
        $this->template->set('email', 'kt-menu__item--active');
        $this->template->set('breadcrumb', 'File Manager');
        $this->template->load_admin('file_manager/index', $data);
    }
}
