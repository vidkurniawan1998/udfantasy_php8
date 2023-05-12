<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout_routine extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('main');
        $this->load->library('cart');
        $this->load->model('m_member');
        $this->load->model('m_checkout');
        $this->load->model('m_checkout_item');
    }

    public function index()
    {
        $header = apache_request_headers();
        if (!$header['Ini-Kode-Apaan'] == 'jd6&msHBjzC%') {
//            return $this->router->show_404();
            redirect('404_override');
        } else {
            $data_front = $this->main->data_front();

            $page_checkout_payment = $this->db->where(array('type' => 'checkout_payment', 'id_language' => $data_front['id_language']))->get('pages')->row();
            $data_1 = json_decode($page_checkout_payment->data_1, TRUE);

            $array_result_cat_12 = array();
            $array_result_cat_0 = array();
            $where_update_cat_12 = array();
            $where_update_cat_0 = array();
            $array_result_item_cat_0 = array();
            $where_unpaid = array(
                'checkout.status' => 'menunggu pembayaran'
            );
            $unpaid_order = $this->m_checkout->get_join_no_off_where($where_unpaid)->result();

            if (!empty($unpaid_order)) {
                foreach ($unpaid_order as $order) {
                    try {
                        $time_db = new DateTime($order->expired_date, new DateTimeZone('Asia/Makassar'));
                    } catch (Exception $e) {
                    }

                    try {
                        date_default_timezone_set('Asia/Makassar');
                        $time_now = date_create(date('d-m-Y H:i'), timezone_open('Asia/Makassar'));
                    } catch (Exception $e) {
                    }

                    $date_diff = $time_now->diff($time_db);
                    $time_difference = $date_diff->format('%d') . ' Days ' . $date_diff->format('%h') . ' Hours ' . $date_diff->format('%i') . ' Minutes';

                    $where_update = array('id' => $order->id);

                    if ($time_difference === '0 Days 12 Hours 0 Minutes') {
                        array_push($array_result_cat_12, $order);

                        array_push($where_update_cat_12, $order->id);

                        $update_data = array(
                            'is_reminded' => 'reminded 12',
                        );
                        $this->m_checkout->update_data($where_update, $update_data);
                    } else if ($time_difference === '0 Days 0 Hours 0 Minutes') {
                        array_push($array_result_cat_0, $order);

                        $where_item_checkout = array('id_checkout' => $order->id);
                        $item_checkout = $this->m_checkout_item->get_where($where_item_checkout)->result();
                        $array_result_item_cat_0[$order->id] = json_encode($item_checkout);

                        array_push($where_update_cat_0, $order->id);
                    }

                }

                if (count($where_update_cat_12) > 0) {
                    foreach ($where_update_cat_12 as $key => $id_order_12) {
                        $where_update = array('id' => $id_order_12);

                        $update_data = array('is_reminded' => 'reminded 12');
                        $this->m_checkout->update_data($where_update, $update_data);
                    }
                }

                if (count($where_update_cat_0) > 0) {
                    foreach ($where_update_cat_0 as $key => $id_order_0) {
                        $where_update = array('id' => $id_order_0);

                        $update_data = array(
                            'is_reminded' => 'reminded 0',
                            'status' => 'dibatalkan'
                        );
                        $this->m_checkout->update_data($where_update, $update_data);
                    }
                }

                if (count($array_result_cat_12) > 0) {
                    $this->sending_mail(json_encode($array_result_cat_12), null, $data_1, 12);
                }

                if (count($array_result_cat_0) > 0) {
                    $this->sending_mail(json_encode($array_result_cat_0), $array_result_item_cat_0, $data_1, 0);
                }
            }
        }
    }

    public function sending_mail($array_result, $item_checkout = null, $data_1, $time)
    {
        $array_result = json_decode($array_result);

        /**
         * setup email message dan kirim email
         */
        foreach ($array_result as $key => $value) {
            $item_checkout[$value->id] = json_decode($item_checkout[$value->id]);

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
                                                Pengingat Pembayaran
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
                                        <h1 style="margin:0;font-size:16px;font-weight:bold;line-height:24px;color:rgba(0,0,0,0.70)">Hai '.$value->name.'</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    ';
                                        if ($time == 12) {
                                            $message_user .= '
                                            <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70)">
                                                Kami ingin mengingatkan anda untuk membayar pesanan anda. Karena sisa waktu pembayaran anda hanya tinggal 12 jam lagi.
                                                Yuk segera bayar, sebelum pesanan kamu terbatalkan!
                                            </p>';
                                        } else if ($time == 0) {
                                            $message_user .= '
                                            <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70)">
                                                Mohon maaf waktu pembayaran pesanan anda telah habis. Pesanan anda akan kami batalkan. <br>
                                                Jika terdapat pertanyaan anda dapat melihat halaman Pertanyaan yang Sering Ditanyakan (FAQ), melalui <a href="'.site_url('frequently-asked-question').'">link</a> berikut ini.
                                                Atau anda juga dapat mengontak kami langsung pada halaman Kontak Kami, melalui <a href="'.site_url('kontak-kami').'">link</a> berikut ini.
                                            </p>
                                            <br>
                                            <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70)">
                                                Berikut ini adalah rincian pesanan anda yang telah dibatalkan :
                                            </p>';
                                        }
                                    $message_user .= '
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>';
                    if ($time == 0) {
                        $message_user .= '
                        <tr>
                        <td style="padding:0 15px">
                            <div style="margin:auto;width:100%;text-align:center;font-weight:700;padding:5px 0">
                                Rincian Pesanan
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
                                $no = 0;
                                foreach($item_checkout[$value->id] as $index => $item) {
                                    $no++;
                                    $message_user .=
                                        '<tr>
                                            <td>' . $no . '</td>
                                            <td>' . $item->name_product . '</td>
                                            <td>' . $item->qty_product . '</td>
                                            <td>Rp. ' . $this->main->format_money($item->price_product) . '</td>
                                            <td>Rp. ' . $this->main->format_money($item->subtotal_product) . '</td>
                                        </tr>';
                                }
                        $message_user .= '
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Shipping Cost</td>
                                        <td colspan="1">Rp. '.$this->main->format_money($value->shipping_price).'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Total</td>
                                        <td colspan="1">Rp. '.$this->main->format_money($value->total_price).'</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>';
                    } else if ($time == 12) {
                        $message_user .= '
                        <tr>
                            <td style="padding:25px 15px 10px">
                                <table width="100%">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70)">
                                                Silahkan mengirimkan uang sejumlah transaksi yang anda lakukan, sebesar : <p></p><br><br><p style="margin:0;font-size:32px;line-height:24px;color:rgba(0,0,0,0.70);font-weight: bold;text-align: center">Rp. ' . $this->main->format_money($value->total_price) . '</p>
                                                <br><br><p style="margin:0;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70);text-align: center"> Sebelum Tanggal dan Jam : <strong>' . $value->expired_date . '</strong> </p>
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

                                                foreach ($data_1['account_number'] as $number => $account_number) {
                                                    $message_user .=
                                                        '<p style="margin:0 auto;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70);text-align: center">Rekening Bank : ' . $data_1['bank_name'][$number] . '</p>
                                                                    <p style="margin:0 auto;font-size:16px;line-height:24px;color:rgba(0,0,0,0.70);text-align: center">No. Rekening : ' . $account_number . '<br> A.N. <br>' . $data_1['under_behalf'][$number] . '</p><p></p><br>';
                                                }
                        $message_user .= '
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>';
                    }

            $message_user .= '
                    </tr>
                    </tbody>
                </table>';

            $this->main->mailer_auth('Peringatan pembayaran pesanan di ' . $this->main->web_name(), $value->email, $this->main->web_name(), $message_user, '', 'logo_dark.png');

        }
    }

}