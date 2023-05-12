<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_us extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('main');
        $this->load->library('cart');
    }

    public function index()
    {
        $data = $this->main->data_front();
        $data['page'] = $this->db->where(array('type' => 'contact_us', 'id_language' => $data['id_language']))->get('pages')->row();
        $data['captcha'] = $this->main->captcha();
        $this->template->front('contact_us', $data);
    }

    public function captcha_check($str)
    {
        if ($str == $this->session->userdata('captcha_mwz')) {
            return TRUE;
        } else {
            $this->form_validation->set_message('captcha_check', 'security code was wrong, please fill again truly');
            return FALSE;
        }
    }

    public function send()
    {
        error_reporting(0);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('phone', 'No Telepon', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('message', 'Pesan', 'required');
        $this->form_validation->set_rules('captcha', 'Security Code', 'required|callback_captcha_check');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(array(
                'status' => 'error',
                'title' => 'Perhatian',
                'message' => 'Fill form completly',
                'errors' => array(
                    'name' => form_error('name'),
                    'phone' => form_error('phone'),
                    'email' => form_error('email'),
                    'message' => form_error('message'),
                    'captcha' => form_error('captcha'),
                    'recaptcha' => $this->session->userdata('captcha_mwz'),
                )
            ));
        } else {
            $email_admin = $this->db->where('use', 'yes')->get('email')->result();
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $message = $this->input->post('message');


            $message_admin = '

            Dear Admin,<br /><br />
            You have contact us message from web form<br />
            form details as follows:<br /><br />
            
            Name : ' . $name . '<br>
            Email : ' . $email . '<br>
            Telephone : ' . $phone . '<br>
            Message : ' . $message . '<br /><br />
            
            
            Regarding,<br />
            Contact Us System ' . $this->main->web_name() . '<br /><br />' . $this->main->credit();

            $message_user = '
                <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;margin:5% auto;width:100%;max-width:600px">
                    <tbody>
                        <tr>
                            <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FF3D00" style="padding:10px 15px;font-size:14px">
                                    <tbody>
                                        <tr>
                                            <td width="60%" align="left" style="padding:5px 0 0">
                                                <span style="font-size:18px;font-weight:300;color:#ffffff">
                                                    Fantasy Online
                                                </span>
                                            </td>
                                            <td width="40%" align="right" style="padding:5px 0 0">
                                                <span style="font-size:18px;font-weight:300;color:#ffffff">
                                                    Pesan Baru Kontak Kami
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:25px 15px 10px">
                                <table width="100%">
                                    <tbody><tr>
                                        <td>
                                            <h1 style="margin:0;font-size:16px;font-weight:bold;line-height:24px;color:rgba(0,0,0,0.70)">Hai, '.$name.'</h1>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70)">
                                                Terimakasih atas pesan anda. Admin anda akan segera memproses pesan tersebut. <br>
                                                Jika anda memiliki pertanyaan seputar Carolinas Mart, anda bisa mengecek FAQ (Frequently Asked Question) kami terlebih dahulu, yang bisa kamu akses melalui link <a href="'.site_url('faq').'"> berikut ini </a> <br> 
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td align="center" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FF3D00" style="padding:10px 15px;font-size:14px;color: #FFFFFF">'.$this->main->web_name().' | All Rights Reserved by <a href="redsystem.id" title="Developed by Redsystem" style="color: #0b0b0b">Redsystem</a></td>
                        </tr>
                    </tfoot>
                </table>';

            $this->main->mailer_auth('Kontak Kami - ' . $this->main->web_name(), $email, $this->main->web_name(), $message_user);

            foreach ($email_admin as $r) {
                $this->main->mailer_auth('Kontak Kami - Website '.$this->main->web_url(), $r->email, $this->main->web_name() . ' Administrator ', $message_admin);
            }

            $data['name'] = $name;
            $data['phone'] = $phone;
            $data['email'] = $email;
            $data['message'] = $message;
            $this->load->model('m_contact');
            $this->m_contact->input_data($data);

            echo json_encode(array(
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Thank you for contact us, we will follow up you as soon as possible',
                'reloadPage' => 'true',
            ));

        }
    }
}
