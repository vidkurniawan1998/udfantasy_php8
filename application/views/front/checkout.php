<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1><?php echo $page->title; ?></h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>" title="<?php echo $home->title; ?>"><?php echo $home->title; ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $page->title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="main_content">

    <div class="section">
        <div class="container">
            <form action="<?php echo site_url('produk/checkout-process') ?>" method="post" class="form-send">
                <div class="row">
                    <div class="col-md-6">
                        <div class="heading_s1">
                            <h4><?php echo $dict_checkout_billing_title; ?></h4>
                        </div>
                        <?php if (count($member_address) > 0) { ?>
                            <div class="form-group">
                                <input type="hidden" name="new_address" value="no">
                                <input type="hidden" name="id_district">
                                <label for="id_member_address"><?php echo $dict_checkout_form_member_address ?></label>
                                <select name="id_member_address" id="id_member_address" class="form-control input-select2" required>
                                    <option value="">Select an option</option>
                                    <?php
                                    foreach ($member_address as $address) {
                                    ?>
                                        <option value="<?php echo $address->id ?>"><span class="address_name"><?php echo $address->address_name; ?> | <?php echo $address->receiver_name ?></span> | <span class="address_detail"><?php echo $address->phone ?> | <?php echo $address->address.', '.$address->province_name.', '.$address->district_name.', '.$address->postcode ?></span></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } else { ?>
                            <div class="form-group">
                                <input type="text" required class="form-control" name="address_name" placeholder="<?php echo $dict_checkout_form_address_name ?> *">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="new_address" value="yes">
                                <input type="text" required class="form-control" name="receiver_name" placeholder="<?php echo $dict_checkout_form_name ?> *">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="address" required="" placeholder="<?php echo $dict_checkout_form_address ?> *">
                            </div>
                            <div class="form-group">
                                <select name="id_district" id="select_district" class="form-control input-select2" required>
                                    <option value=""><?php echo $dict_checkout_form_city ?></option>
                                    <?php
                                    foreach ($districts as $district) {
                                    ?>
                                        <option value="<?php echo $district->id ?>"><?php echo $district->name; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control" required type="text" name="postcode" placeholder="<?php echo $dict_checkout_form_pos ?> *">
                            </div>
                            <div class="form-group">
                                <input class="form-control" required type="text" name="phone" placeholder="<?php echo $dict_checkout_form_phone ?> *">
                            </div>
                        <?php
                        }
                        ?>
                            <div class="heading_s1">
                                <h4><?php echo $dict_checkout_form_info ?></h4>
                            </div>
                            <div class="form-group">
                                <textarea rows="5" class="form-control" name="order_note" placeholder="<?php echo $dict_checkout_form_order_note ?>"></textarea>
                            </div>
                            <div class="form-group mb-0">
                                <?php echo $captcha; ?>
                                <input type="text" name="captcha" class="form-control" placeholder="Captcha *" required>
                            </div>
<!--                            <div class="" id="checkout-item">-->
<!--                                --><?php
//                                    $total = 0;
//                                    foreach ($this->cart->contents() as $key => $items) {
//                                ?>
<!--                                        <div class="list-item---><?php //echo $key ?><!--">-->
<!--                                            <input type="hidden" id="id---><?php //echo $key ?><!--" name="item_id[]" value="--><?php //echo $items['id'] ?><!--">-->
<!--                                            <input type="hidden" id="name---><?php //echo $key ?><!--" name="item_name[]" value="--><?php //echo $items['name'] ?><!--">-->
<!--                                            <input type="hidden" id="qty---><?php //echo $key ?><!--" name="item_qty[]" value="--><?php //echo $items['qty'] ?><!--">-->
<!--                                            <input type="hidden" id="price---><?php //echo $key ?><!--" name="item_price[]" value="--><?php //echo $items['price'] ?><!--">-->
<!--                                            <input type="hidden" id="subtotal---><?php //echo $key ?><!--" name="item_subtotal[]" value="--><?php //echo $items['subtotal'] ?><!--">-->
<!--                                        </div>-->
<!--                                --><?php
//                                    }
//                                ?>
<!--                            </div>-->
                    </div>
                    <div class="col-md-6">
                        <div class="order_review">
                            <div class="heading_s1">
                                <h4><?php echo $dict_checkout_bill_order ?></h4>
                            </div>
                            <div class="table-responsive order_table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th><?php echo $dict_cart_product; ?></th>
                                        <th><?php echo $dict_cart_total; ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $total=0;
                                    foreach ($this->cart->contents() as $content) {
                                        $total += $content['subtotal'];
                                    ?>
                                    <tr>
                                        <td><?php echo $content['name'] ?> <span class="product-qty">x <?php echo $content['qty'] ?></span></td>
                                        <td>Rp. <?php echo $this->main->format_money($content['subtotal']) ?></td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>SubTotal</th>
                                        <td class="product-subtotal">Rp. <?php echo $this->main->format_money($total); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $dict_checkout_bill_shipping; ?></th>
                                        <td class="product-subtotal">Rp. <span class="text-shipping-cost"></span> <span class="subtotal-price hide"><?php echo $total ? $total : 0 ?></span></td>
                                    </tr>
                                    <tr class="total">
                                        <th><?php echo $dict_cart_total; ?></th>
                                        <td class="product-subtotal product-total">Rp. <?php echo $this->main->format_money($total); ?></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="payment_method" id="checktimes">
                                <div class="heading_s1">
                                    <h4><?php echo $dict_checkout_bill_payment; ?></h4>
                                </div>
                                <div class="payment_option">
                                    <div class="custome-radio form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="PaymentMethod1" value="bank_transfer" checked>
                                        <label class="form-check-label" for="PaymentMethod1">Transfer Bank</label>
                                    </div>
                                    <div class="custome-radio form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="PaymentMethod2" value="cod">
                                        <label class="form-check-label" for="PaymentMethod2">COD (Cash On Delivery)</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-fill-out btn-block">Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>