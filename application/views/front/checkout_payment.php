<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1><?php echo $page->title_sub ?></h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="<?php echo site_url() ?>" title="<?php echo $home->title; ?>"><?php echo $home->title; ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $page->title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="main_content">

    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="checkout-payment">
                        <div class="checkout-timer text-center" data-date="<?php echo $checkout->expired_date; ?>">
                            <span><p><?php echo $dict_checkout_payment_title_1 ?></p></span>
                            <div class="countdown-timer-wrapper">
                                <div class="timer" id="countdown"></div>
                            </div>
                            <span>
                                <p><?php echo $dict_checkout_payment_title_2 ?></p>
                            </span>
                            <div class="checkout-payment-total">
                                <p>Rp. <?php echo $this->main->format_money($total_price) ?></p>
                            </div>
                            <span>
                                <p class="m-top-50"><?php echo $dict_checkout_payment_title_3 ?></p>
                                <?php
                                $data_1 = json_decode($page->data_1, TRUE);
                                foreach ($data_1['account_number'] as $key => $account_number) {
                                ?>
                                <p><img class="logo-bank" src="<?php echo $this->main->image_preview_url($data_1['images'][$key]) ?>" alt="logo bank"></p>
                                <p class="mt-n3"><?php echo $data_1['account_number'][$key] ?> <br><?php echo $dict_checkout_payment_title_5 ?> <br><?php echo $data_1['under_behalf'][$key] ?></p>
                                <?php } ?>
                            </span>
                            <span class="checkout-info">
                                <p class="m-top-50"><?php echo $dict_checkout_payment_title_4 ?> <strong>( <?php echo date('d-M-Y h:i:sa' ,strtotime($checkout->created_at.'+1 day')) ?> )</strong></p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>