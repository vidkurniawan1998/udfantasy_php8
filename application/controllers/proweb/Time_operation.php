<?php
defined ('BASEPATH') or exit ('No direct script access allowed');

class Time_operation extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_timeoperation');
        $this->load->library('main');
        $this->main->check_admin();
    }

    public function index()
    {
        $data = $this->main->data_main();
        $data['timeoperation'] = $this->m_timeoperation->get_data()->result(); 
        $this->template->set('timeoperation', 'kt-menu__item--active');
        $this->template->set('breadcrumb', 'Time Operation');
        $this->template->load_admin('timeoperation/index', $data);
    }

    public function createprocess()
    {
        // var_dump($this->input->post());
        // die();
        // echo 'dataku';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('jam_buka', 'Jambuka', 'required');
        $this->form_validation->set_rules('jam_tutup', 'Jamtutup', 'required');
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE)
        {
            echo json_encode(array(
                'status' => 'error',
                'message'=> 'Isi Form Belum Benar',
                'errors' => array(
                    'hari'      => form_error('hari'),
                    'jam_buka' => form_error('jam_buka'),
                    'jam_tutup'=> form_error('jam_tutup'),
                )
            ));
        }
        else
        {
            $data = $this->input->post(NULL);
            $this->m_timeoperation->input_data($data,'timeoperation');

            echo json_encode(array(
                'status' => 'success',
                'message'=> 'data berhasil diinput',
            ));
        }
    }

    public function delete($id)
    {
        $where = array('id' => $id);
        $this->m_timeoperation->delete_data($where, 'timeoperation');
    }

    public function update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('jam_buka', 'jam_buka', 'required');
        $this->form_validation->set_rules('jam_tutup', 'jam_tutup', 'required');
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE)
        {
            echo json_encode(array(
                'status' => 'error',
                'message'=> 'Isi Form Belum Benar',
                'errors' => array(
                    'hari'      => form_error('hari'),
                    'jam_buka' => form_error('jam_buka'),
                    'jam_tutup'=> form_error('jam_tutup'),
                )
            ));
        }
        
        else
        {
            $id   = $this->input->post('id');
            $data = $this->input->post(NULL);
            $where = array(
                'id' => $id
            );
            
            $this->m_timeoperation->update_data($where, $data, 'timeoperation');
            echo json_encode(array(
                'status'  => 'success',
                'message' => 'data berhasil diinput'
            ));
        }
    }
}
?>