<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('main');
        $this->load->library('cart');
        $this->load->model('m_member');
        $this->load->model('m_member_address');
        $this->load->model('m_districts');
        $this->load->model('m_provinces');
        $this->load->model('m_delivery_coverage');
        $this->load->model('m_checkout');

        $this->main->check_member();
    }

    public function index()
    {
        $data = $this->main->data_front();

        $data['page'] = $this->db->where(array('type' => 'checkout', 'id_language' => $data['id_language']))->get('pages')->row();
        $data['home'] = $this->db->where(array('type' => 'home', 'id_language' => $data['id_language']))->get('pages')->row();
        $where_province = array(
            'provinces.name' => 'BALI'
        );
        $data['districts'] = $this->m_districts->get_where($where_province)->result();
        $data['captcha'] = $this->main->captcha();
        $data['count_cart'] = count($this->cart->contents());
        $data['member'] = $this->db->where('email', $this->session->userdata('email_member'))->get('member')->row();
        $where_member_address = array(
            'id_member' => $data['member']->id
        );
        $data['member_address'] = $this->m_member_address->get_join_where($where_member_address)->result();

        $this->template->front('checkout', $data);
    }

    public function cek_waktu()
    {
        echo json_encode($this->main->checkout_respond_time());
    }

    public function cek_tanggal()
    {
        echo json_encode($this->main->checkout_respond_date());
    }

    public function cart_destroy()
    {
        $this->cart->destroy();
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

    public function shipping_cost($type, $id) {
        $data_front = $this->main->data_front();

        if ($type == 'id_address') {
            $id_district = $this->db->where('id', intval($id))->get('member_address')->row()->id_district;
        } else if ($type == 'id_district') {
            $id_district = $id;
        }

        $where_ship_num = array('id_district' => $id_district);
        $ship_num = $this->db->where($where_ship_num)->get('delivery_coverage')->num_rows();

        if ($ship_num > 0 || !empty($ship_num)) {
            $where_ship_cost = array('id_district' => $id_district);
        } else {
            $where_ship_cost = array('id_district' => 0);
        }

        $shipping_cost = $this->m_delivery_coverage->row_data($where_ship_cost);

        if (empty($shipping_cost)) {
            $status = 'error';
            if ($data_front->lang_code == 'en') {
                $message = "Can't find the cost for this area";
            } else if ($data_front->lang_code == 'id') {
                $message = "Tidak dapat menemukan harga untuk area ini";
            }
        } else {
            $status = 'success';
            $message = '';
        }

        echo json_encode(array(
            'status' => $status,
            'title' => 'Success!',
            'message' => $message,
            'ship_cost_raw' => $shipping_cost->price,
            'id_district' => $shipping_cost->id_district,
            'shipping_cost' => $this->main->format_money($shipping_cost->price),
        ));
    }

    public function checkout_process()
    {
        error_reporting(0);
        $this->load->library('form_validation');

        $new_address = $this->input->post('new_address');

        $data_front = $this->main->data_front();

        if ($new_address == 'yes') {
//            create new member address
            $this->form_validation->set_rules('address_name', 'Address Name', 'required');
            $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('id_district', 'City / District', 'required');
            $this->form_validation->set_rules('postcode', 'Postcode', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
        } else {
            $this->form_validation->set_rules('id_member_address', 'Address', 'required');
        }
        $this->form_validation->set_rules('captcha', 'Security Code', 'required|callback_captcha_check');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');

        $this->load->model('m_checkout');
        $this->load->model('m_checkout_item');

		$this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() === FALSE) {
            if ($new_address == 'yes') {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Please fill out the form correctly',
                    'errors' => array(
                        'address_name' => form_error('address_name'),
                        'receiver_name' => form_error('receiver_name'),
                        'address' => form_error('address'),
                        'id_district' => form_error('id_district'),
                        'postcode' => form_error('postcode'),
                        'phone' => form_error('phone'),
                        'captcha' => form_error('captcha'),
                        'payment_method' => form_error('payment_method'),
                    )
                ));
			} else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Please fill out the form correctly',
                    'errors' => array(
                        'id_member_address' => form_error('id_member_address'),
                        'captcha' => form_error('captcha'),
                        'payment_method' => form_error('payment_method'),
                    )
                ));
            }
		} else {
            $member = $this->db->where('email', $this->session->userdata('email_member'))->get('member')->row();

            /**
             * inisiasi post
             */
            if ($new_address == 'yes') {
                $where_province = array('provinces.name' => 'BALI');
                $province = $this->m_provinces->get_where($where_province)->row();

                $data_address['address_name'] = $this->input->post('address_name');
                $data_address['receiver_name'] = $this->input->post('receiver_name');
                $data_address['address'] = $this->input->post('address');
                $data_address['id_district'] = $this->input->post('id_district');
                $data_address['id_province'] = $province->id;
                $data_address['postcode'] = $this->input->post('postcode');
                $data_address['phone'] = $this->input->post('phone');
                $data_address['id_member'] = $member->id;

                $this->m_member_address->input_data($data_address);

                $data['id_member_address'] = $this->db->insert_id();
            } else {
                $data['id_member_address'] = $this->input->post('id_member_address');
            }

            $date = new DateTime("now");
            $curr_date = $date->format('Y-m-d ');
            $order_num = $this->m_checkout->get_today_order_num($curr_date);

            $data['order_note'] = $this->input->post('order_note');
            $data['id_member'] = $member->id;
            $data['invoice'] = 'INV/'.$this->main->slug(date('d?m?Y')).'/'.(intval($order_num)+1);
            $data['payment_method'] = $this->input->post('payment_method');
            if ($data['payment_method'] == 'cod') {
                $data['is_reminded'] = 'done';
                $data['status'] = 'dibayarkan';
            } else {
                $data['is_reminded'] = 'not reminded';
                $data['status'] = 'menunggu pembayaran';
            }

            $where_ship_num = array('id_district' => $this->input->post('id_district'));
            $ship_num = $this->db->where($where_ship_num)->get('delivery_coverage')->num_rows();

            if ($ship_num > 0 || !empty($ship_num)) {
                $where_ship_cost = array('id_district' => $this->input->post('id_district'));
            } else {
                $where_ship_cost = array('id_district' => 0);
            }

            $data['shipping_price'] = $this->m_delivery_coverage->row_data($where_ship_cost)->price;
            date_default_timezone_set('Asia/Makassar');
            $datetime_now = time();
            $expired_time = date('Y-m-d H:i', strtotime('+1 day', $datetime_now));
            $data['expired_date'] = $expired_time;

            /**
             * input data ke database
             */
            $this->m_checkout->input_data($data);
			$id_checkout = $this->db->insert_id();

			$where_checkout = array('checkout.id' => $id_checkout);
			$checkout = $this->m_checkout->get_join_no_off_where($where_checkout)->row();
			$page_checkout_payment = $this->db->where(array('type' => 'checkout_payment', 'id_language' => $data_front['id_language']))->get('pages')->row();
            $data_1 = json_decode($page_checkout_payment->data_1, TRUE);

            $total_price = 0;
            foreach ($this->cart->contents() as $index => $items) {
                $item['id_checkout'] = $id_checkout;
                $item['id_product'] = $items['id'];
                $item['name_product'] = $items['name'];
                $item['price_product'] = $items['price'];
                $item['qty_product'] = $items['qty'];
                $item['subtotal_product'] = $items['subtotal'];
                $total_price += $items['subtotal'];

                $this->m_checkout_item->input_data($item);
            }

            $total_price = $total_price + $data['shipping_price'];
            $where_update_checkout = array('id' => $id_checkout);
            $update_checkout = array('total_price' => $total_price);
            $this->m_checkout->update_data($where_update_checkout, $update_checkout);

			$email_admin = $this->db->where('use', 'yes')->get('email')->result();
            $where_member_address = array('member_address.id' => $data['id_member_address']);
            $member_address = $this->m_member_address->get_join_where($where_member_address)->row();

            /**
             * setup email message dan kirim email
             */
            $message_admin = '

            Hallo Admin,<br /><br />
            Kita mendapatkan order baru<br />
            dengan detail pemesanan sebagia berikut:<br /><br />
            
            Nama Penerima : ' . $member_address->receiver_name . '<br>
            Alamat : ' . $member_address->address . '<br>
            Kota / Kecamatan : ' . $member_address->district_name . '<br>
            Kode POS : ' . $member_address->postcode . '<br>
            Email : ' . $member->email . '<br>
            Telephone : ' . $member_address->phone . '<br>
            Catatan Order : ' . $data['order_note'] . '<br /><br />
            Metode Pembayaran : ' . $data['payment_method'] . '<br><br>
            List Order
            <table border="1" style="margin: 0 auto;">
                <tr>
                    <th>ID Produk</th>
                    <th>Name Produk</th>
                    <th>Qty Produk</th>
                    <th>Price Produk</th>
                    <th>Subtotal Produk</th>
                </tr>
                ';

            foreach ($this->cart->contents() as $key => $items) {
                $message_admin .=
                    '<tr>
                        <td>' . $items['id'] . '</td>
                        <td>' . $items['name'] . '</td>
                        <td>' . $items['qty'] . '</td>
                        <td>Rp. ' . $this->main->format_money($items['price']) . '</td>
                        <td>Rp. ' . $this->main->format_money($items['subtotal']) . '</td>
                    </tr>';
            }
             $message_admin .=
                '
                    <tr>
                        <td colspan="4">Biaya Kirim</td>
                        <td colspan="1">Rp. '.$this->main->format_money($data['shipping_price']).'</td>                                                
                    </tr>
                    <tr>
                        <td colspan="4">Total</td>
                        <td colspan="1">Rp. '.$this->main->format_money($total_price).'</td>                   
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
                                                Checkout Berhasil
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
                                            Terimakasih atas pesanan anda, Admin kami akan menghubungi anda lebih lanjut jika terdapat permasalahan terhadap pesanan anda. 
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
                                Rincian Pesanan
                            </div>
                            <table width="100%" style="margin:15px 0;color:rgba(0,0,0,0.70);font-size:14px;border-collapse:collapse">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                ';
                                foreach ($this->cart->contents() as $key => $items) {
                                    $message_user .=
                                        '<tr>
                                            <td>' . $items['id'] . '</td>
                                            <td>' . $items['name'] . '</td>
                                            <td>' . $items['qty'] . '</td>
                                            <td>Rp. ' . $this->main->format_money($items['price']) . '</td>
                                            <td>Rp. ' . $this->main->format_money($items['subtotal']) . '</td>
                                        </tr>';
                                }

                if ($data['payment_method'] == 'bank transfer') {
                    $message_user .=
                        '
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Shipping Cost</td>
                                        <td colspan="1">Rp. ' . $this->main->format_money($data['shipping_price']) . '</td>                                                
                                    </tr>
                                    <tr>
                                        <td colspan="4">Total</td>
                                        <td colspan="1">Rp. ' . $this->main->format_money($total_price) . '</td>                   
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:25px 15px 10px">
                            <table width="100%">
                                <tbody>
                                <tr>
                                    <td>
                                        <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70)">
                                            Silahkan mengirimkan uang sejumlah transaksi yang anda lakukan, sebesar : <p style="margin:0;font-size:32px;line-height:24px;color:rgba(0,0,0,0.70);font-weight: bold;text-align: center"><br><br>Rp. ' . $this->main->format_money($total_price) . '</p>
                                            <br><p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70);text-align: center"> Sebelum Tanggal dan Jam : <strong>' . $checkout->expired_date . '</strong> </p>
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:25px 15px 10px">
                            <table width="100%">
                                <tbody>
                                <tr>
                                    <td>
                                        <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70);text-align: center">
                                            Anda dapat mentransfer menuju rekening berikut ini : ';

                    foreach ($data_1['account_number'] as $key => $account_number) {
                        $message_user .=
                            '<p style="margin:0 auto;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70);text-align: center">Rekening Bank : ' . $data_1['bank_name'][$key] . '</p>
                                                     <p style="margin:0 auto;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70);text-align: center">No. Rekening : ' . $account_number . ' A.N. ' . $data_1['under_behalf'][$key] . '</p><p></p><br>';
                    }

                    $message_user .= '
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>';
                } else if ($data['payment_method'] == 'cod') {
                    $message_user .=
                        '
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Shipping Cost</td>
                                        <td colspan="1">Rp. ' . $this->main->format_money($data['shipping_price']) . '</td>                                                
                                    </tr>
                                    <tr>
                                        <td colspan="4">Total</td>
                                        <td colspan="1">Rp. ' . $this->main->format_money($total_price) . '</td>                   
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>';
                }

            $this->main->mailer_auth('Products Order From ' . $this->main->web_name(), $member->email, $this->main->web_name(), $message_user, '', 'logo_dark.png');

            foreach ($email_admin as $r) {
                $this->main->mailer_auth('Products Order From Website '.$this->main->web_url(), $r->email, $this->main->web_name() . ' Administrator ', $message_admin);
            }

            /**
             * hapus cart session dan tampilkan alert
             */
            $this->cart_destroy();

            if ($data['payment_method'] == 'bank transfer') {
                echo json_encode(array(
                    'status' => 'success',
                    'title' => 'Success!',
                    'redirect' => 'produk/checkout-payment/' . $id_checkout,
                    'message' => 'Terima kasih telah berbelanja bersama kami.',
                ));
            } elseif ($data['payment_method'] == 'cod') {
                echo json_encode(array(
                    'status' => 'success',
                    'title' => 'Success!',
                    'message' => 'Terima kasih telah berbelanja bersama kami.',
                    'redirect' => 'produk',
                ));
            }
        }

    }

    public function checkout_payment($id)
    {
        $data = $this->main->data_front();

        $data['page'] = $this->db->where(array('id_language' => $data['id_language'], 'type' => 'checkout_payment'))->get('pages')->row();
        $data['home'] = $this->db->where(array('id_language' => $data['id_language'], 'type' => 'home'))->get('pages')->row();

        $member = $this->db->where(array('email', $this->session->userdata('member_email')))->get('member')->row();

        $where_checkout = array('id' => $id);
        $data['checkout'] = $this->m_checkout->get_where($where_checkout)->row();
        $data['checkout_item'] = $this->db->where('id_checkout', $data['checkout']->id)->get('checkout_item')->result();

        foreach ($data['checkout_item'] as $item) {
            $data['total_price'] += $item->subtotal_product;
        }
        $data['total_price'] = $data['total_price'] + $data['checkout']->shipping_price;

        $this->template->front('checkout_payment', $data);
    }
}