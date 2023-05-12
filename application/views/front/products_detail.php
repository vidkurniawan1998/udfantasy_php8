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
                <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                    <div class="product-image">
                        <div class="product_img_box">
                            <img id="product_img" src="<?php echo $this->main->image_preview_url($products_images[0]->thumbnail) ?>" data-zoom-image="<?php echo $this->main->image_preview_url($products_image[0]->thumbnail) ?>" alt="<?php $products_detail->thumbnail_alt ?>"/>
                            <a href="#" class="product_img_zoom" title="Zoom">
                                <span class="linearicons-zoom-in"></span>
                            </a>
                        </div>
                        <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">
                            <?php
                            foreach ($products_images as $image) {
                            ?>
                                <div class="item">
                                    <a href="<?php echo $this->main->image_preview_url($image->thumbnail) ?>" class="product_gallery_item active" data-image="<?php echo $this->main->image_preview_url($image->thumbnail) ?>" data-zoom-image="<?php echo $this->main->image_preview_url($image->thumbnail) ?>" title="<?php echo $image->thumbnail_alt ?>">
                                        <img src="<?php echo $this->main->image_preview_url($image->thumbnail) ?>" alt="<?php echo $image->thumbnail_alt ?>" />
                                    </a>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="pr_detail">
                        <div class="product_description">
                            <h4 class="product_title"><?php if ($lang_code == 'id') { echo $products_detail->title; } elseif ($lang_code == 'en') { echo $products_detail->title_eng; } ?></h4>
                            <div class="product_price">
                                <?php if ($products_detail->promotion_status == 'yes') { ?>
                                    <span class="price">Rp. <?php echo $this->main->format_money($products_detail->promotion_price); ?></span>
                                    <del>Rp. <?php echo $this->main->format_money($products_detail->price); ?></del>
                                    <div class="on_sale">
                                        <span><?php echo $this->main->count_discount($products_detail->price, $products_detail->promotion_price); ?>% Off</span>
                                    </div>
                                <?php } else {
                                ?>
                                    <span class="price">Rp. <?php echo $this->main->format_money($products_detail->price); ?></span>
                                <?php
                                } ?>
                            </div>
                            <div class="rating_wrap">
                                <div class="rating">
                                    <div class="product_rate" style="width:<?php echo $products_detail->average_rating; ?>%"></div>
                                </div>
                                <span class="rating_num">(<?php echo $products_detail->count_rating ? $products_detail->count_rating : 0; ?>)</span>
                            </div>
                        </div>
                        <hr/>
                        <div class="cart_extra">
                            <div class="cart-product-quantity">
                                <div class="quantity">
                                    <input type="button" value="-" class="minus">
                                    <input type="text" name="qty" value="1" title="Qty" class="qty" size="4">
                                    <input type="button" value="+" class="plus">
                                </div>
                            </div>
                            <div class="cart_btn">
                                <button class="btn btn-fill-out btn-addtocart shop-cart" data-id="<?php echo $products_detail->id; ?>" type="button"><i class="icon-basket-loaded"></i> <?php echo $dict_add_to_cart; ?></button>
                            </div>
                        </div>
                        <hr/>
                        <ul class="product-meta">
                            <li>SKU: <?php echo $products_detail->sku ?></li>
                            <li><?php echo $dict_category ?>: <?php if ($lang_code == 'id') { echo $products_category->title; } elseif ($lang_code == 'en') { echo $products_category->title_eng; } ?></li>
                        </ul>

                        <div class="product_share">
                            <span><?php echo $dict_share; ?>:</span>
                            <ul class="social_icons">
                                <li>
                                    <?php if (!empty($products_detail->sub_category_slug)) { ?>
                                        <a href="<?php echo $this->main->share_link('facebook', $products_detail->title, site_url('produk/'.$products_detail->category_slug.'/'.$products_detail->sub_category_slug.'/'.$products_detail->slug)) ?>" title="Facebook Share"><i class="ion-social-facebook"></i></a>
                                    <?php } else { ?>
                                        <a href="<?php echo $this->main->share_link('facebook', $products_detail->title, site_url('produk/'.$products_detail->category_slug.'/'.$products_detail->slug)) ?>" title="Facebook Share"><i class="ion-social-facebook"></i></a>
                                    <?php } ?>
                                </li>
                                <li>
                                    <?php if (!empty($products_detail->sub_category_slug)) { ?>
                                        <a href="<?php echo $this->main->share_link('twitter', $products_detail->title, site_url('produk/'.$products_detail->category_slug.'/'.$products_detail->sub_category_slug.'/'.$products_detail->slug)) ?>" title="Twitter Share"><i class="ion-social-twitter"></i></a>
                                    <?php } else { ?>
                                        <a href="<?php echo $this->main->share_link('twitter', $products_detail->title, site_url('produk/'.$products_detail->category_slug.'/'.$products_detail->slug)) ?>" title="Twitter Share"><i class="ion-social-twitter"></i></a>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                        <div class="whatsapp-ask mt-3">
                            <?php
                            if (!empty($products_detail->sub_category_slug)) {
                            ?>
                            <a href="javascript:();" id="btn-ask-whatsapp" data-target="#modal-ask-whatsapp" data-toggle="modal" data-product-name="<?= $products_detail->title ?>" data-product-link="<?= site_url('produk/'.$products_detail->category_slug.'/'.$products_detail->sub_category_slug.'/'.$products_detail->slug) ?>">
                            <?php } else {
                            ?>
                            <a href="javascript:();" id="btn-ask-whatsapp" data-target="#modal-ask-whatsapp" data-toggle="modal" data-product-name="<?= $products_detail->title ?>" data-product-link="<?= site_url('produk/'.$products_detail->category_slug.'/'.$products_detail->slug) ?>">
                            <?php
                            }
                            ?>
                                <img src="<?= base_url() ?>assets/template_front/images/whatsapp-button.png" alt="Whatsapp Form">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="large_divider clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-style3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true" title="<?php echo $dict_product_description; ?>"><?php echo $dict_product_description; ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Additional-info-tab" data-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false" title="php echo $dict_product_information; ?>"><?php echo $dict_product_information; ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false" title="php echo $dict_product_review; ?>"><?php echo $dict_product_review; ?></a>
                            </li>
                        </ul>
                        <div class="tab-content shop_info_tab">
                            <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                                <?php if ($lang_code == 'id') { echo $products_detail->description; } elseif ($lang_code == 'en') { echo $products_detail->description_eng; } ?>
                            </div>
                            <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                                <table class="table table-bordered">
                                    <?php
                                    $information_name = json_decode($products_detail->data_info)->information_name;
                                    $information_value = json_decode($products_detail->data_info)->information_value;
                                    foreach ($information_name as $key => $info) { ?>
                                    <tr>
                                        <td><?php echo $information_name[$key]; ?></td>
                                        <td><?php echo $information_value[$key]; ?></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                                <div class="comments">
                                    <ul class="list_none comment_list mt-4">
<!--                                        TODO : bikinkan 2 jenis user, 1 tipe guest yang membuat review tanpa login, dan lagi 1 untuk user yang login.
                                                tipe guest = fotonya stock
                                                tipe login = foto dari foto user -->
                                        <?php
                                        foreach ($products_review as $review) {
                                        ?>
                                            <li>
                                                <div class="comment_img">
                                                    <img src="<?php echo base_url() ?>assets/template_front/images/user1.jpg" alt="user1"/>
                                                </div>
                                                <div class="comment_block">
                                                    <div class="rating_wrap">
                                                        <div class="rating">
                                                            <div class="product_rate" style="width:<?php echo $review->rating; ?>%"></div>
                                                        </div>
                                                    </div>
                                                    <p class="customer_meta">
                                                        <span class="review_author"><?php echo $review->name; ?></span>
                                                        <span class="comment-date"><?php echo $review->created_at; ?></span>
                                                    </p>
                                                    <div class="description">
                                                        <?php echo $review->message; ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="review_form field_form">
                                    <h5><?php echo $dict_add_review; ?></h5>
                                    <form class="row mt-3 form-send" action="<?php echo site_url('produk/review/'.$products_detail->slug) ?>" method="post">
                                        <div class="form-group col-12">
                                            <div class="star_rating">
                                                <span data-value="1"><i class="far fa-star"></i></span>
                                                <span data-value="2"><i class="far fa-star"></i></span>
                                                <span data-value="3"><i class="far fa-star"></i></span>
                                                <span data-value="4"><i class="far fa-star"></i></span>
                                                <span data-value="5"><i class="far fa-star"></i></span>
                                                <input type="hidden" name="rating">
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <textarea required="required" placeholder="Masukkan Ulasan *" class="form-control" name="message" rows="4"></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input required="required" placeholder="Masukkan Nama *" class="form-control" name="name" type="text">
                                         </div>
                                        <div class="form-group col-md-6">
                                            <input required="required" placeholder="Masukkan Email *" class="form-control" name="email" type="email">
                                        </div>


                                        <div class="form-group col-md-3">
                                            <?php echo $captcha ?>
                                            <input type="text" name="captcha" class="form-control mt-2" placeholder="Captcha*">
                                        </div>
                                        <div class="form-group col-12">
                                            <button type="submit" class="btn btn-fill-out" name="submit" value="Submit"><?php echo $dict_add_review; ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="small_divider"></div>
                    <div class="divider"></div>
                    <div class="medium_divider"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="heading_s1">
                        <h3><?php echo $dict_related_product; ?></h3>
                    </div>
                    <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20"
                         data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                        <?php foreach ($products_random as $random) {
                        ?>
                            <div class="item">
                                <div class="product">
                                    <div class="product_img">
                                        <?php if (!empty($random->sub_category_slug)) { ?>
                                            <a href="<?php echo site_url('produk/'.$random->category_slug.'/'.$random->sub_category_slug.'/'.$random->slug); ?>" title="<?php echo $random->thumbnail_alt ?>">
                                        <?php } else { ?>
                                            <a href="<?php echo site_url('produk/'.$random->category_slug.'/'.$random->slug); ?>" title="<?php echo $random->thumbnail_alt ?>">
                                        <?php } ?>
                                            <img src="<?php echo $this->main->image_preview_url($products_random_images[$random->id]->thumbnail) ?>" alt="<?php echo $random->thumbnail_alt ?>">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#" title="<?php echo $dict_add_to_cart; ?>"><i class="icon-basket-loaded"></i> <?php echo $dict_add_to_cart; ?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title">
                                            <?php if (!empty($random->sub_category_slug)) { ?>
                                                <a href="<?php echo site_url('produk/'.$random->category_slug.'/'.$random->sub_category_slug.'/'.$random->slug) ?>" title="<?php if ($lang_code == 'id') { echo $random->title; } elseif ($lang_code == 'en') { echo $random->title_eng; } ?>"><?php if ($lang_code == 'id') { echo $random->title; } elseif ($lang_code == 'en') { echo $random->title_eng; } ?></a>
                                            <?php } else { ?>
                                                <a href="<?php echo site_url('produk/'.$random->category_slug.'/'.$random->slug) ?>" title="<?php if ($lang_code == 'id') { echo $random->title; } elseif ($lang_code == 'en') { echo $random->title_eng; } ?>"><?php if ($lang_code == 'id') { echo $random->title; } elseif ($lang_code == 'en') { echo $random->title_eng; } ?></a>
                                            <?php } ?>
                                        </h6>
                                        <div class="product_price">
                                            <?php if ($random->promotion_status == 'yes') { ?>
                                                <span class="price">Rp. <?php echo $this->main->format_money($random->promotion_price); ?></span>
                                                <del>Rp. <?php echo $this->main->format_money($random->price); ?></del>
                                                <div class="on_sale">
                                                    <span><?php echo $this->main->count_discount($random->price, $random->promotion_price) ?>% Off</span>
                                                </div>
                                            <?php } else { ?>
                                                <span class="price">Rp. <?php echo $this->main->format_money($random->price); ?></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="modal-ask-whatsapp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AskViaWhatsapp" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bertanya via Whatsapp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= $contact_info['whatsapp_link'] ?>" id="ask-via-whatsapp">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Enter Name *" required>
                        <input type="hidden" name="product_link">
                        <input type="hidden" name="product_name">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Enter Email *" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" cols="30" rows="10" class="form-control" placeholder="Enter Message *"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-border-fill" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-fill-out">Kirim Pertanyaan</button>
                </div>
            </form>
        </div>
    </div>
</div>