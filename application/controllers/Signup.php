<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->helper('string');
        $this->load->library('main');
        $this->load->library('cart');
        $this->load->model('m_member');
    }

    public function index()
    {
        $data = $this->main->data_front();
        $data['page'] = $this->db->where(array('type' => 'signup', 'id_language' => $data['id_language']))->get('pages')->row();
        $data['captcha'] = $this->main->captcha();

        $this->template->front('signup', $data);

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

    public function create_member()
    {
        $this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[member.email]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('captcha', 'Security Code', 'required|callback_captcha_check');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'name' => form_error('name'),
					'email' => form_error('email'),
					'password' => form_error('password'),
					'password_confirm' => form_error('password_confirm'),
                    'captcha' => form_error('captcha'),
				)
			));
		} else {
			$password = md5($this->input->post('password'));
			$password_confirm = md5($this->input->post('password_confirm'));
			$email = $this->input->post('email');
			$name = $this->input->post('name');
			$phone = $this->input->post('phone');
			$hash = md5($email);
			$activation_token = random_string('alnum', 8);
			$this->load->model('m_member');
			if ($password == $password_confirm) {
				$data = array(
					'name' => $name,
					'email' => $email,
					'password' => $password,
                    'phone' => $phone,
                    'hash' => $hash,
                    'activation_token' => $activation_token,
                    'status' => 'not_active',
				);
				$this->m_member->input_data($data);
				$id_member = $this->db->insert_id();
				$this->send_verification($id_member);
				echo json_encode(array(
					'status' => 'success',
					'message' => 'success input data',
                    'redirect' => 'signup/notice_verification/'.$activation_token,
				));
			} else {
				echo json_encode(array(
					'status' => 'error',
					'message' => 'The form is not correct',
					'errors' => array(
						'password' => 'Incorrect Password'
					)
				));
			}
		}
    }

    public function send_verification($id_member)
    {
        $member = $this->db->where('id', $id_member)->get('member')->row();

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
                                            Verifikasi Akun
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
                                    <h1 style="margin:0;font-size:16px;font-weight:bold;line-height:24px;color:rgba(0,0,0,0.70)">Hai,'.$member->name.',</h1>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70)">
                                        Terimakasih telah membuat akun di '.$this->main->web_name(). '. Silahkan mengklik di bawah ini untuk memverifikasi dan mengaktifkan akun anda : 
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 15px">
                        <p style="margin:0;font-size:20px;line-height:24px;color:rgb(255, 61, 0);text-align: center">
                            <a href="' .site_url('signup/verification/'.$member->activation_token).'">Verifikasi Akun</a>
                        </p><br>
                        <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70);">
                            Dengan memverifikasi dan mengaktifkan akun anda, maka anda telah menyetujui segala persyaratan dan aturan yang berlaku di dalam website ini.
                            Untuk mengetahui syarat dan ketentuan yang berlaku pada website ini, anda dapat mengklik <a href="'.site_url('syarat-ketentuan').'">link ini</a>.
                        </p>
                        <br>
                        <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70);">
                            Untuk pertanyaan lebih lanjut, anda dapat menghubungi kami melalui <a href="'.site_url('contact-us').'">link ini</a>. 
                            Maupun melihat Pertanyaan yang Sering ditanyakan, melalui <a href="'.site_url('frequently-asked-question').'">link ini</a>. 
                        </p>
                        <br><br><br>
                        <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70);">
                            Hormat kami,<br>
                            Fantasy Online. 
                        </p>
                        
                    </td>
                </tr>
                </tbody>
            </table>';

        $this->main->mailer_auth('Verifikasi Akun ' . $this->main->web_name(), $member->email, $this->main->web_name(), $message_user, '');
    }

    public function resend_verification($activation_token)
    {
        $where = array('activation_token' => $activation_token);
        $id_member = $this->m_member->get_where($where)->row()->id;

        $this->send_verification($id_member);

        echo json_encode(array(
                'status' => 'success',
                'title' => 'Kirim Ulang',
                'message' => 'Sukses mengirim ulang verifikasi',
                'reloadPage' => 'true'
            ));
    }

    public function notice_verification($activation_token)
    {
        $data = $this->main->data_front();
        $data['page'] = $this->db->where(array('type' => 'notice_verification', 'id_language' => $data['id_language']))->get('pages')->row();
        $data['home'] = $this->db->where(array('type' => 'home', 'id_language' => $data['id_language']))->get('pages')->row();

        $where = array('activation_token' => $activation_token);
        $data['member'] = $this->m_member->get_where($where)->row();

        $this->template->front('notice_verification', $data);
    }

    public function verification($activation_token)
    {
        $where = array('activation_token' => $activation_token);
        $data['status'] = 'active';
        $data['activation_token'] = null;
//        $data['hash'] = null;
        $this->m_member->update_data($where, $data);

        $data = $this->main->data_front();
        $data['page'] = $this->db->where(array('type' => 'signup_verification', 'id_language' => $data['id_language']))->get('pages')->row();
        $data['home'] = $this->db->where(array('type' => 'home', 'id_language' => $data['id_language']))->get('pages')->row();

        $this->template->front('signup_verification', $data);
    }
}
