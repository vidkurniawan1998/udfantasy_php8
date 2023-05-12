<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_404 extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('main');
    }

    public function index()
    {
        $data = $this->main->data_front();

//        $data['page'] = $this->db->where(array('type' => 'home', 'id_language' => $data['id_language']))->get('pages')->row();
//        $data['slider'] = $this->db->where(array('use' => 'yes', 'id_language' => $data['id_language']))->order_by('id', 'ASC')->get('slider')->result();
//        $sesi_home = $this->db
//            ->where_in('type', array(
//                'home_sesi_1',
//                'home_sesi_2',
//                'home_sesi_3',
//                'faq',
//                'home_sesi_5',
//                'home_sesi_6',
//                'home_sesi_7',
//            ))
//            ->where('id_language', $data['id_language'])
//            ->get('pages')
//            ->result();
//
//        foreach ($sesi_home as $row) {
//            $data[$row->type] = $row;
//        }

        $this->template->front('page_404', $data);

    }
}
