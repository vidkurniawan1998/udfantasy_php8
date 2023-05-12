<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_transaction extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('main');
        $this->load->model('m_checkout');
        $this->load->library('cart');

		$this->main->check_member();
    }

    public function upload()
    {
        $this->load->library('form_validation');
		$this->form_validation->set_rules('invoice', 'Invoice Not Found', 'required');
		$this->form_validation->set_error_delimiters('', '');
		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'invoice' => form_error('invoice'),
				)
			));
		} else {
			$data = $this->input->post(NULL);
			$checkout_data = $this->db->where('invoice', $data['invoice'])->get('checkout')->row();
			$item_checkout = $this->db->where('id_checkout', $checkout_data->id)->get('checkout_item')->result();
			$member = $this->db->where('id', $checkout_data->id_member)->get('member')->row();
			$member_address = $this->db->where('id', $checkout_data->id_member_address)->get('member_address')->row();
			$where = array(
				'id' => $checkout_data->id,
			);
			$data['status'] = 'dibayarkan';

			if ($_FILES['payment_proof']['name']) {
				$response = $this->main->upload_file_custom('payment_proof', $this->input->post('invoice'), 600, 600);
				if (!$response['status']) {
					echo json_encode(array(
						'status' => 'error',
						'message' => 'The form is not correct',
						'errors' => array(
							'payment_proof' => $response['message']
						)
					));
					exit;
				} else {
					$data['payment_proof'] = $response['filename'];
				}
			}

			unset($data['invoice']);
			unset($data['user']);

			$this->m_checkout->update_data($where, $data);

            $email_admin = $this->db->where('use', 'yes')->get('email')->result();
            $this->upload_payment_mail($checkout_data, $item_checkout, $member, $member_address, $email_admin, $response['filename']);

            echo json_encode(array(
                'status' => 'success',
                'title' => 'Success!',
                'reloadPage' => 'reload',
                'message' => 'Sukses mengupload bukti pembayaran. Silahkan menunggu kabar dari admin jika pesanan kamu telah kami konfirmasi atau telah kami kirimkan ke alamat kamu!',
            ));
        }
    }

    public function upload_payment_mail($checkout, $item_checkout, $member, $member_address, $email_admin, $image_payment_name)
    {
        $message_admin = '
            Hallo Admin,<br /><br />
            Kita mendapatkan pesanan yang telah diuploadkan bukti pembayarannya!<br />
            dengan detail pemesanan sebagai berikut:<br /><br />
            
            No. Invoice : '. $checkout->invoice .'<br>
            Nama Pemesan : ' . $member->name . '<br>
            Telephone Pemesan : ' . $member->phone . '<br>
            Email : ' . $member->email . '<br>
            Nama Penerima : ' . $member_address->receiver_name . '<br>
            Alamat : ' . $member_address->address . '<br>
            Kota / Kecamatan : ' . $member_address->district_name . '<br>
            Kode POS : ' . $member_address->postcode . '<br>
            Telephone : ' . $member_address->phone . '<br>
            Catatan Order : ' . $checkout->order_note . '<br /><br />
            List Order
            <table border="1" style="margin: 0 auto;">
                <tr>
                    <th>No</th>
                    <th>ID Produk</th>
                    <th>Name Produk</th>
                    <th>Qty Produk</th>
                    <th>Price Produk</th>
                    <th>Subtotal Produk</th>
                </tr>
                ';

            $number = 0;
            foreach($item_checkout as $index => $item) {
                $number++;
                $message_admin .=
                    '<tr>
                        <td>' . $number . '</td>
                        <td>' . $item->id_product. '</td>
                        <td>' . $item->name_product . '</td>
                        <td>' . $item->qty_product . '</td>
                        <td>Rp. ' . $this->main->format_money($item->price_product) . '</td>
                        <td>Rp. ' . $this->main->format_money($item->subtotal_product) . '</td>
                    </tr>';
            }

        $message_admin .=
                '
                    <tr>
                        <td colspan="4">Biaya Kirim</td>
                        <td colspan="1">Rp. '.$this->main->format_money($checkout->shipping_price).'</td>                                                
                    </tr>
                    <tr>
                        <td colspan="4">Total</td>
                        <td colspan="1">Rp. '.$this->main->format_money($checkout->total_price).'</td>                   
                    </tr>
             </table>
             
            Mengenai,<br />
            System pemesanan online ' . $this->main->web_name();

        foreach ($email_admin as $r) {
            $this->main->mailer_auth('Bukti Pembayaran Pesanan '.$checkout->invoice.' '.$this->main->web_url(), $r->email, $this->main->web_name() . ' Administrator ', $message_admin, $image_payment_name);
        }
    }

    public function cancel_order($id)
    {
        $canceled_order = $this->db->where(array('id' => $id))->get('checkout')->row();

        $where_cancel_order = array('id' => $id);
        $update_order = array('status' => 'dibatalkan');
        $this->m_checkout->update_data($where_cancel_order, $update_order);

        $member = $this->db->where('id', $canceled_order->id_member)->get('member')->row();
        $member_address = $this->db->where('id', $canceled_order->id_member_address)->get('member_address')->row();
        $item_checkout = $this->db->where('id_checkout', $canceled_order->id)->get('checkout_item')->result();

        $email_admin = $this->db->where('use', 'yes')->get('email')->result();

        $this->cancel_order_mail($canceled_order, $member, $member_address, $item_checkout, $email_admin);

        echo json_encode(array(
            'status' => 'success',
            'title' => 'Success!',
            'reloadPage' => 'reload',
            'message' => 'Pesanan anda telah berhasil dibatalkan. Untuk informasi lebih lanjut, silahkan mengecek email anda!',
        ));
    }

    public function cancel_order_mail($canceled_order, $member, $member_address, $item_checkout, $email_admin)
    {
        $message_admin = '
            Hallo Admin,<br /><br />
            terdapat member yang membatalkan pesanannya<br />
            dengan detail pemesanan sebagai berikut:<br /><br />
            
            No. Invoice : '. $canceled_order->invoice .'<br>
            Nama Penerima : ' . $member_address->receiver_name . '<br>
            Alamat : ' . $member_address->address . '<br>
            Kota / Kecamatan : ' . $member_address->district_name . '<br>
            Kode POS : ' . $member_address->postcode . '<br>
            Email : ' . $member->email . '<br>
            Telephone : ' . $member_address->phone . '<br>
            Catatan Order : ' . $canceled_order->order_note . '<br /><br />
            List Order
            <table border="1" style="margin: 0 auto;">
                <tr>
                    <th>No</th>
                    <th>ID Produk</th>
                    <th>Name Produk</th>
                    <th>Qty Produk</th>
                    <th>Price Produk</th>
                    <th>Subtotal Produk</th>
                </tr>
                ';

            $number = 0;
            foreach($item_checkout as $index => $item) {
                $number++;
                $message_admin .=
                    '<tr>
                        <td>' . $number . '</td>
                        <td>' . $item->id_product. '</td>
                        <td>' . $item->name_product . '</td>
                        <td>' . $item->qty_product . '</td>
                        <td>Rp. ' . $this->main->format_money($item->price_product) . '</td>
                        <td>Rp. ' . $this->main->format_money($item->subtotal_product) . '</td>
                    </tr>';
            }

        $message_admin .=
                '
                    <tr>
                        <td colspan="4">Biaya Kirim</td>
                        <td colspan="1">Rp. '.$this->main->format_money($canceled_order->shipping_price).'</td>                                                
                    </tr>
                    <tr>
                        <td colspan="4">Total</td>
                        <td colspan="1">Rp. '.$this->main->format_money($canceled_order->total_price).'</td>                   
                    </tr>
             </table>
             
            Mengenai,<br />
            System pemesanan online ' . $this->main->web_name();

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
                                        Pesanan anda telah kami batalkan. Terimakasih telah berkunjung dan berbelanja di website kami. Jika terdapat pertanyaan seputar website kami
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
                            Berikut, rincian pesanan yang anda batalkan :
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
                                    <td colspan="1">Rp. '.$this->main->format_money($canceled_order->shipping_price).'</td>                                                
                                </tr>
                                <tr>
                                    <td colspan="4">Total</td>
                                    <td colspan="1">Rp. '.$this->main->format_money($canceled_order->total_price).'</td>                   
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>';

        $message_user .= '
                </tbody>
            </table>';

        $this->main->mailer_auth('Products Order From ' . $this->main->web_name(), $member->email, $this->main->web_name(), $message_user, '', 'logo_dark.png');

        foreach ($email_admin as $r) {
            $this->main->mailer_auth('Products Canceled From a Member '.$this->main->web_url(), $r->email, $this->main->web_name() . ' Administrator ', $message_admin);
        }
    }

    public function accept_order($id)
    {
        $accepted_order = $this->db->where(array('id' => $id))->get('checkout')->row();

        $where_accept_order = array('id' => $id);
        $update_order = array('status' => 'barang diterima');
        $this->m_checkout->update_data($where_accept_order, $update_order);

        $member = $this->db->where('id', $accepted_order->id_member)->get('member')->row();
        $member_address = $this->db->where('id', $accepted_order->id_member_address)->get('member_address')->row();
        $item_checkout = $this->db->where('id_checkout', $accepted_order->id)->get('checkout_item')->result();

        $email_admin = $this->db->where('use', 'yes')->get('email')->result();

        $this->accept_order_mail($accepted_order, $member, $member_address, $item_checkout, $email_admin);

        echo json_encode(array(
            'status' => 'success',
            'title' => 'Success!',
            'reloadPage' => 'reload',
            'message' => 'Pesanan anda telah berhasil dibatalkan. Untuk informasi lebih lanjut, silahkan mengecek email anda!',
        ));
    }

    public function accept_order_mail($accepted_order, $member, $member_address, $item_checkout, $email_admin)
    {
        $message_admin = '
            Hallo Admin,<br /><br />
            terdapat member yang telah menerima pesanannya<br />
            dengan detail pemesanan sebagai berikut:<br /><br />
            
            No. Invoice : '. $accepted_order->invoice .'<br>
            Nama Penerima : ' . $member_address->receiver_name . '<br>
            Alamat : ' . $member_address->address . '<br>
            Kota / Kecamatan : ' . $member_address->district_name . '<br>
            Kode POS : ' . $member_address->postcode . '<br>
            Email : ' . $member->email . '<br>
            Telephone : ' . $member_address->phone . '<br>
            Catatan Order : ' . $accepted_order->order_note . '<br /><br />
            List Order
            <table border="1" style="margin: 0 auto;">
                <tr>
                    <th>No</th>
                    <th>ID Produk</th>
                    <th>Name Produk</th>
                    <th>Qty Produk</th>
                    <th>Price Produk</th>
                    <th>Subtotal Produk</th>
                </tr>
                ';

            $number = 0;
            foreach($item_checkout as $index => $item) {
                $number++;
                $message_admin .=
                    '<tr>
                        <td>' . $number . '</td>
                        <td>' . $item->id_product. '</td>
                        <td>' . $item->name_product . '</td>
                        <td>' . $item->qty_product . '</td>
                        <td>Rp. ' . $this->main->format_money($item->price_product) . '</td>
                        <td>Rp. ' . $this->main->format_money($item->subtotal_product) . '</td>
                    </tr>';
            }

        $message_admin .=
                '
                    <tr>
                        <td colspan="4">Biaya Kirim</td>
                        <td colspan="1">Rp. '.$this->main->format_money($accepted_order->shipping_price).'</td>                                                
                    </tr>
                    <tr>
                        <td colspan="4">Total</td>
                        <td colspan="1">Rp. '.$this->main->format_money($accepted_order->total_price).'</td>                   
                    </tr>
             </table>
             
            Mengenai,<br />
            System pemesanan online ' . $this->main->web_name();

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
                                            Pesanan Diterima
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
                                        Terimakasih telah berkunjung dan berbelanja di website kami. Jika terdapat pertanyaan seputar website kami
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
                            Berikut, rincian pesanan yang anda terima :
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
                                    <td colspan="1">Rp. '.$this->main->format_money($accepted_order->shipping_price).'</td>                                                
                                </tr>
                                <tr>
                                    <td colspan="4">Total</td>
                                    <td colspan="1">Rp. '.$this->main->format_money($accepted_order->total_price).'</td>                   
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>';

        $message_user .= '
                </tbody>
            </table>';

        $this->main->mailer_auth('Accepted Order From ' . $this->main->web_name(), $member->email, $this->main->web_name(), $message_user, '', '');

        foreach ($email_admin as $r) {
            $this->main->mailer_auth('Products Accepted From a Member '.$this->main->web_url(), $r->email, $this->main->web_name() . ' Administrator ', $message_admin);
        }
    }
}
