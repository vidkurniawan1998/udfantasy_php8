<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_reset_password extends CI_Controller
{
    private $ci;

    public function __construct()
    {
        parent:: __construct();
        $this->load->library('main');
        $this->load->model('m_member');
        $this->load->library('cart');

        $this->ci =& get_instance();
    }

    public function form_reset_password($hash, $activation_token)
    {
        $where_check_request = array('hash' => $hash, 'activation_token' => $activation_token);
        $num_check = $this->m_member->get_where($where_check_request)->num_rows();

        if ($num_check == 0) {
//            $this->router->show_404();
            redirect('404_override');
        } else {
            $data = $this->main->data_front();
            $data['home'] = $this->db->where(array('type' => 'home', 'id_language' => $data['id_language']))->get('pages')->row();
            $data['page'] = $this->db->where(array('type' => 'reset_password', 'id_language' => $data['id_language']))->get('pages')->row();
            $data['member'] = $this->m_member->get_where($where_check_request)->row();

            $this->template->front('reset_password', $data);
        }
    }

    public function process_reset_password()
    {
        $this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
		$this->form_validation->set_error_delimiters('', '');
		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'password' => form_error('password'),
                    'password_confirm' => form_error('password_confirm'),
				)
			));
		} else {
			$data = $this->input->post(NULL);
			$where = array(
				'id' => $this->db->where('id', $data['id'])->get('member')->row()->id,
			);
			$data['password'] = md5($data['password']);
			$data['activation_token'] = null;

			unset($data['password_confirm']);
			unset($data['id']);

			$this->m_member->update_data($where, $data);

			echo json_encode(array(
				'status' => 'success',
				'message' => 'Pergantian password berhasil!',
                'redirect' => 'login',
			));
		}
    }

    public function send_reset_password($id)
    {
        $member = $this->db->where('id', $id)->get('member')->row();

        $activation_token = md5($member->email.date('c'));
        $hash_email = md5($member->email);
        $update_hash = array('activation_token' => $activation_token);
        $where_hash = array('id' => $member->id);
        $this->m_member->update_data($where_hash, $update_hash);

        $this->send_reset_password_mail($member, $activation_token, $hash_email);

        echo json_encode(array(
            'status' => 'success',
            'message' => 'Permintaan reset password dikirimkan. Silahkan mengecek email anda untuk melanjutkan proses reset password',
            'reloadPage' => 'reload'
        ));
    }

    public function send_reset_password_mail($member, $activation_token, $hash_email)
    {
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
                                            Reset Password
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
                                    <h1 style="margin:0;font-size:16px;font-weight:bold;line-height:24px;color:rgba(0,0,0,0.70)">Hai, '.$member->name.'</h1>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70)">
                                        Anda telah melakukan permintaan untuk mereset password akun anda di '.$this->main->web_name().'. Untuk melanjutkan proses reset password, 
                                        <a href="'.site_url('user-profile/reset-password/'.$hash_email.'/'.$activation_token).'">silahkan mengikuti link berikut ini</a>. 
                                    </p>
                                    <p></p><p></p>
                                    <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70)">
                                        Namun apabila anda tidak pernah meminta proses ini, maka kami berharap anda mengabaikan email ini. 
                                    </p>
                                    <br>
                                    <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70)">
                                        Terimaksih, <br>
                                        '.$this->main->web_name().' 
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>';

        $this->main->mailer_auth('Reset Password Akun ' . $this->main->web_name(), $member->email, $this->main->web_name(), $message_user, '', 'logo_dark.png');
    }
}
