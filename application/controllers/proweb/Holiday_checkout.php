<?php
defined ('BASEPATH') or exit('no direct script access allowed');

class Holiday_checkout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_holidaycheckout');
        $this->load->library('main');
        $this->main->check_admin();
    }

    public function index()
    {
        $data = $this->main->data_main();
        $data['holiday_checkout'] = $this->m_holidaycheckout->get_data()->result();
        $this->template->set('holiday_checkout', 'kt-menu__item--active');
        $this->template->set('breadcrumb', 'Holiday Checkout');
        $this->template->load_admin('holiday_checkout/index', $data);
    }

    public function createprocess()
    {
        //di date nya pakai strtdate
        $this->load->library('form_validation');
        $this->form_validation->set_rules('date_start', 'Datestart', 'required');
        $this->form_validation->set_rules('date_finish', 'Datefinish', 'required');
        $this->form_validation->set_error_delimiters('', '');
        if($this->form_validation->run() === FALSE)
        {
            echo json_encode(array(
                'status' => 'error',
                'message'=> 'Isi Form Belum Benar',
                'errors' => array(
                    'date_start'      => form_error('date_start'),
                    'date_finish'     => form_error('date_finish'),
                )
            ));
        }
        else
        {
            $data = $this->input->post(NULL);
            $this->m_holidaycheckout->input_data('holiday_checkout', $data);

            echo json_encode(array(
                'status' => 'success',
                'message'=> 'data berhasil diinput',
            ));
        }
    }

    public function delete($id)
    {
        $where = array('id' => $id);
		$this->m_holidaycheckout->delete_data($where, 'holiday_checkout');
    }

    public function update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('date_start', 'Datestart', 'required');
        $this->form_validation->set_rules('date_finish', 'Datefinish', 'required');
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE)
        {
            echo json_encode(array(
                'status' => 'error',
                'message'=> 'Isi Form Belum Benar',
                'errors' => array(
                    'date_start'      => form_error('date_start'),
                    'date_finish'     => form_error('date_finish'),
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
            
            $this->m_holidaycheckout->update_data($where, $data, 'holiday_checkout');
            echo json_encode(array(
                'status'  => 'success',
                'message' => 'data berhasil diinput'
            ));
        }
    }
}
?>