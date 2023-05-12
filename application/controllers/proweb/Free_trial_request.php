<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Free_trial_request extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('m_blog');
        $this->load->library('main');
        $this->main->check_admin();
    }

    public function index()
    {
        $data = $this->main->data_main();
        $data['data'] = $this
            ->db
            ->order_by('id', 'DESC')
            ->get('free_trial')
            ->result();
        $this->template->set('breadcrumb', 'Data Free Trial Request');
        $this->template->load_admin('free_trial/index', $data);
    }

}
