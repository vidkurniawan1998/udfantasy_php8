<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dictionary extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('m_dictionary');
        $this->load->library('main');
        $this->main->check_admin();
    }

    public function index()
    {
        $data = $this->main->data_main();
        $data['dictionary'] = $this->db
            ->distinct()
            ->select('dict_variable')
            ->order_by('dict_variable')
            ->get('dictionary')
            ->result();
        $data['language_list'] = $this->db->where('use', 'yes')->order_by('title', 'ASC')->get('language')->result();
        $this->template->set('dictionary', 'kt-menu__item--active');
        $this->template->set('breadcrumb', 'Web Dictionary Manager');
        $this->template->load_admin('dictionary/index', $data);
    }

    public function update()
    {
        $this->db->empty_table('dictionary');


        $dict_word_list = $this->input->post('dict_word');
        foreach ($dict_word_list as $dict_variable => $data) {
            foreach ($data as $id_language => $dict_word) {
                $data_insert = array(
                    'id_language' => $id_language,
                    'dict_variable' => $dict_variable,
                    'dict_word' => $dict_word
                );

                $this->db->insert('dictionary', $data_insert);
            }
        }

        echo json_encode(array(
            'status' => 'success',
            'message' => 'success input data'
        ));
    }
}
