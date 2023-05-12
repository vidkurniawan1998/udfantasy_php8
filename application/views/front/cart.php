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
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive shop_cart_table">
                        <form action="<?php echo site_url('produk/cart-update') ?>" method="post" class="cart-update" >
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name"><?php echo $dict_cart_product ?></th>
                                        <th class="product-price"><?php echo $dict_cart_price ?></th>
                                        <th class="product-quantity"><?php echo $dict_cart_quantity ?></th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-remove"><?php echo $dict_cart_remove ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $total = 0;
                                    $count = 0;
                                    foreach ($this->cart->contents() as $key => $items) {
                                    $total += $items['subtotal'];
                                ?>
                                        <tr class="item-<?php echo $count ?>">
                                            <td class="product-thumbnail">
                                                <?php if (!empty($items['sub_category_slug'])) { ?>
                                                    <a href="<?php echo site_url('produk/'.$items['category_slug'].'/'.$items['sub_category_slug'].'/'.$items['slug']) ?>" title="<?php echo $items['thumbnail_alt'] ?>">
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('produk/'.$items['category_slug'].'/'.$items['slug']) ?>" title="<?php echo $items['thumbnail_alt'] ?>">
                                                <?php } ?>
                                                    <img src="<?php echo $this->main->image_preview_url($items['thumbnail']) ?>" alt="<?php echo $items['thumbnail_alt'] ?>">
                                                </a>
                                            </td>
                                            <td class="product-name" data-title="Product">
                                                <?php if (!empty($items['sub_category_slug'])) { ?>
                                                    <a href="<?php echo site_url('produk/'.$items['category_slug'].'/'.$items['sub_category_slug'].'/'.$items['slug']) ?>" title="<?php echo $items['name']; ?>"><?php echo $items['name']; ?></a>
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('produk/'.$items['category_slug'].'/'.$items['slug']) ?>" title="<?php echo $items['name']; ?>"><?php echo $items['name']; ?></a>
                                                <?php } ?>
                                            </td>
                                            <td class="product-price" data-title="Price">Rp. <?php echo $this->main->format_money($items['price']) ?></td>
                                            <td class="product-quantity" data-title="Quantity">
                                                <div class="quantity">
                                                    <input type="button" value="-" class="minus">
                                                    <input type="text" class="update-qty qty" name="qty[]" value="<?php echo $items['qty'] ?>" title="Qty" size="4">
                                                    <input type="button" value="+" class="plus">
                                                </div>
                                                <input type="hidden" class="update-rowid" name="rowid[]" value="<?php echo $items['rowid'] ?>">
                                                <input type="hidden" class="update-id" name="id[]" value="<?php echo $items['id']?>">
                                                <input type="hidden" class="update-price" name="price[]" value="<?php echo $items['price'] ?>">
                                                <input type="hidden" class="update-subtotal" name="subtotal[]" value="<?php echo $items['subtotal'] ?>">
                                            </td>
                                            <td class="product-subtotal" data-title="Total">Rp. <?php echo $this->main->format_money($items['subtotal']) ?></td>
                                            <td class="product-remove" data-title="Remove"><a href="#"><i class="ti-close"></i></a></td>
                                        </tr>
                                <?php
                                        $count++;
                                    }
                                ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="px-0">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
<!--                                                    <div class="coupon field_form input-group">-->
<!--                                                        <input type="text" value="" class="form-control form-control-sm" placeholder="--><?php //echo $dict_cart_coupon_code ?><!--..">-->
<!--                                                        <div class="input-group-append">-->
<!--                                                            <button class="btn btn-fill-out btn-sm" type="submit">--><?php //echo $dict_cart_coupon ?><!--</button>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
                                                </div>
                                                <div class="col-lg-8 col-md-6 text-left text-md-right">
                                                    <button class="btn btn-line-fill btn-sm" type="submit"><?php echo $dict_cart_update ?></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="medium_divider"></div>
                    <div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
                    <div class="medium_divider"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="border p-3 p-md-4">
                        <div class="heading_s1 mb-3">
                            <h6><?php echo $dict_cart_total ?></h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td class="cart_total_label"><?php echo $dict_cart_total ?></td>
                                    <td class="cart_total_amount"><strong>Rp. <?php echo $this->main->format_money($total); ?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="<?php echo site_url('checkout') ?>" class="btn btn-fill-out" title="<?php echo $dict_cart_checkout ?>"><?php echo $dict_cart_checkout ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>