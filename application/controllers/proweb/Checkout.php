<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_checkout');
		$this->load->model('m_checkout_item');
		$this->load->model('m_districts');
		$this->load->library('print_pdf');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['checkout'] = $this->m_checkout->get_join_data()->result();
		foreach ($data['checkout'] as $checkout){
            $data['checkout_item'][$checkout->id] = $this->db->select('checkout_item.*')->where('id_checkout', $checkout->id)->get('checkout_item')->result();
            $checkout->town = $this->db->where('id', $checkout->town)->get('districts')->row()->name;
        }
		$where_district = array(
		    'provinces.name' => 'BALI'
        );
		$data['districts'] = $this->m_districts->get_where($where_district)->result();
		$this->template->set('checkout', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Checkout');
		$this->template->load_admin('checkout_content/index', $data);
	}

	public function delete($id)
	{
		$where = array('id' => $id);
		$row = $this->m_checkout->row_data($where);
		$this->main->delete_file($row->thumbnail);
		$this->m_checkout->delete_data($where);
	}

	public function print_checkout($id)
    {
        $data = $this->main->data_main();
		$data['checkout'] = $this->db->where('id', $id)->get('checkout')->row();
		$data['checkout_item'] = $this->db->where('id_checkout', $id)->get('checkout_item')->result();
		$data['member'] = $this->db->where('id', $data['checkout']->id_member)->get('member')->row();
		$data['member_address'] = $this->db->where('id', $data['checkout']->id_member_address)->get('member_address')->row();

		$this->print_pdf->filename = "Checkout ".$data['checkout']->invoice.".pdf";
		$this->print_pdf->load_view('pdf_template/checkout', $data);
    }

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'status' => form_error('status'),
				)
			));
		} else {
			$id = $this->input->post('id');
			$checkout_status_before = $this->db->select('status')->where('id', $id)->get('checkout')->row()->status;
			$data = $this->input->post(NULL);
			$where = array(
				'id' => $id
			);

			$this->m_checkout->update_data($where, $data);

			//Send mail to user
            if (($data['status'] == 'terkonfirmasi' || $data['status'] == 'barang dikirim') && ($checkout_status_before != 'terkonfirmasi' || $checkout_status_before != 'barang dikirim')) {
                $checkout = $this->db->where('id', $id)->get('checkout')->row();
                $item_checkout = $this->db->where('id_checkout', $id)->get('checkout_item')->result();
                $member = $this->db->where('id', $checkout->id_member)->get('member')->row();

                // Change reminded status
                $update_reminded['is_reminded'] = 'done';
                $this->m_checkout->update_data($where, $update_reminded);

                $this->confirmed_order_mail($member, $checkout, $item_checkout);
            } else if ($data['status'] == 'dibatalkan' && $checkout_status_before != 'dibatalkan') {
                $checkout = $this->db->where('id', $id)->get('checkout')->row();
                $item_checkout = $this->db->where('id_checkout', $id)->get('checkout_item')->result();
                $member = $this->db->where('id', $checkout->id_member)->get('member')->row();

                // Change reminded status
                $update_reminded['is_reminded'] = 'done';
                $this->m_checkout->update_data($where, $update_reminded);

                $this->canceled_order_mail($member, $checkout, $item_checkout);
            }

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}
	}

	public function confirmed_order_mail($member, $checkout, $item_checkout)
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
                                            Pesanan Dikonfirmasi
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
                                        Pembayaran pesanan anda dengan invoice '.$checkout->invoice.' telah kami konfirmasi. Kami akan segera mengirimkan pesanan anda menuju alamat tujuan. <br><br>
                                        Jika terdapat pertanyaan seputar website kami
                                        anda dapat melihat pada halaman Pertanyaan yang Sering Ditanyakan (FAQ), dengan mengklik <a href="'.site_url('frequently-asked-question').'">link berikut ini</a>.
                                        Atau jika anda ingin menyampaikan keluhan anda secara langsung, anda dapat menghubungi kami melalui halaman Kontak Kami, dengan mengklik <a href="'.site_url('kontak-kami').'">link berikut ini </a>. 
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 15px">
                        <div style="margin:auto;width:100%;text-align:center;font-weight:700;padding:5px 0">
                            Berikut, rincian pesanan anda :
                        </div>
                        <table width="100%" style="margin:15px 0;color:rgba(0,0,0,0.70);font-size:14px;border-collapse:collapse">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                            ';
                            $number = 0;
                            foreach($item_checkout as $index => $item) {
                                $number++;
                                $message_user .=
                                    '<tr>
                                        <td>' . $number . '</td>
                                        <td>' . $item->name_product . '</td>
                                        <td>' . $item->qty_product . '</td>
                                        <td>Rp. ' . $this->main->format_money($item->price_product) . '</td>
                                        <td>Rp. ' . $this->main->format_money($item->subtotal_product) . '</td>
                                    </tr>';
                            }
        $message_user .=
                '
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">Shipping Cost</td>
                                    <td colspan="1">Rp. '.$this->main->format_money($checkout->shipping_price).'</td>                                                
                                </tr>
                                <tr>
                                    <td colspan="4">Total</td>
                                    <td colspan="1">Rp. '.$this->main->format_money($checkout->total_price).'</td>                   
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>';

        $message_user .= '
                </tbody>
            </table>';

        $this->main->mailer_auth('Konfirmasi pembayaran '.$checkout->invoice.' '. $this->main->web_name(), $member->email, $this->main->web_name(), $message_user, '', 'logo_dark.png');

    }

	public function canceled_order_mail($member, $checkout, $item_checkout)
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
                                            Pesanan Dibatalkan
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
                                        Mohon maaf pesanan anda telah kami batalkan, dikarenakan satu dan lain hal. <br>
                                        Jika terdapat pertanyaan anda dapat melihat halaman Pertanyaan yang Sering Ditanyakan (FAQ), melalui <a href="'.site_url('frequently-asked-question').'">link</a> berikut ini.
                                        Atau anda juga dapat mengontak kami langsung pada halaman Kontak Kami, melalui <a href="'.site_url('kontak-kami').'">link</a> berikut ini.
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 15px">
                        <div style="margin:auto;width:100%;text-align:center;font-weight:700;padding:5px 0">
                            Berikut ini adalah rincian pesanan anda yang telah dibatalkan :
                        </div>
                        <table width="100%" style="margin:15px 0;color:rgba(0,0,0,0.70);font-size:14px;border-collapse:collapse">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                            ';
                            $number = 0;
                            foreach($item_checkout as $index => $item) {
                                $number++;
                                $message_user .=
                                    '<tr>
                                        <td>' . $number . '</td>
                                        <td>' . $item->name_product . '</td>
                                        <td>' . $item->qty_product . '</td>
                                        <td>Rp. ' . $this->main->format_money($item->price_product) . '</td>
                                        <td>Rp. ' . $this->main->format_money($item->subtotal_product) . '</td>
                                    </tr>';
                            }
        $message_user .=
                '
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">Shipping Cost</td>
                                    <td colspan="1">Rp. '.$this->main->format_money($checkout->shipping_price).'</td>                                                
                                </tr>
                                <tr>
                                    <td colspan="4">Total</td>
                                    <td colspan="1">Rp. '.$this->main->format_money($checkout->total_price).'</td>                   
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>';

        $message_user .= '
                </tbody>
            </table>';

        $this->main->mailer_auth('Konfirmasi pembayaran '.$checkout->invoice.' '. $this->main->web_name(), $member->email, $this->main->web_name(), $message_user, '', 'logo_dark.png');

    }
}
