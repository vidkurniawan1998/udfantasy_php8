<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Rekap Penjualan <?= $date_from.' - '.$date_to ?></title>

    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box {
            max-width: 1000px;
            margin: auto;
            padding: 30px 10px 30px 10px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            text-align: center;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="5">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="<?php echo FCPATH.'assets/template_front/images/logo_dark.png' ?>" style="width:100%; max-width:150px;">
                            </td>

                            <td>
                                <span>Laporan Rekap Penjualan</span><br>
                                Tanggal Transaksi: <?php echo $date_from.' - '.$date_to ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Invoice</td>

                <td colspan="2">District</td>

                <td>Payment Method</td>

                <td>Total Harga</td>
            </tr>

            <?php
            $count = 0;
            $max_item = count($checkout);
            $total_price = 0;
            foreach ($checkout as $key => $item) {
                $total_price += $item->total_price;
                $count++;
            ?>
                <tr class="item <?php if ($count == $max_item) { echo 'last'; } ?>">
                    <td><?php echo $item->invoice ?></td>

                    <td colspan="2"><?php echo $item->district_name ?></td>

                    <td style="text-align: center;"><?php echo $item->payment_method ?></td>

                    <td style="text-align: right;"><?php echo 'Rp. '.$this->main->format_money($item->total_price); ?></td>
                </tr>
            <?php } ?>

            <tr class="total">
                <td><strong>Total</strong></td>

                <td colspan="4">
                    <span>
                        <?php echo 'Rp. '.$this->main->format_money($total_price); ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>