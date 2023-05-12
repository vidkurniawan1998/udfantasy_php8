<div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap">
    <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-ride="carousel">
        <div class="carousel-inner">

            <?php
            foreach ($sliders as $key => $slider) {
                if ($key == 0) {
            ?>
                <div class="carousel-item active background_bg pointer" data-img-src="<?php echo $this->main->image_preview_url($slider->thumbnail); ?>" data-link-href="<?php echo $slider->url; ?>"></div>
            <?php
                } else {
            ?>
                <div class="carousel-item background_bg pointer" data-img-src="<?php echo $this->main->image_preview_url($slider->thumbnail); ?>" data-link-href="<?php echo $slider->url; ?>"></div>
            <?php
                }
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev" title="Next"><i class="ion-chevron-left"></i></a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next" title="Previous"><i class="ion-chevron-right"></i></a>
    </div>
</div>

<div class="main_content">

    <div class="section pb_20">
        <div class="container">
            <div class="row">
                <?php
                foreach ($banners as $banner) {
                ?>
                    <div class="col-md-6">
                        <a href="<?php echo site_url($banner->url); ?>" title="<?php echo $banner->thumbnail_alt ?>">
                            <div class="single_banner">
                                <img src="<?php echo $this->main->image_preview_url($banner->thumbnail); ?>" alt="<?php echo $banner->thumbnail_alt ?>"/>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="section small_pt pb_70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="heading_s1 text-center">
                        <h2><?php echo $home_sesi_1->title; ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-style1">
                        <ul class="nav nav-tabs justify-content-center" role="tablist">
                            <?php
                            $count = 0;
                            $length_best_category = count($best_selling_category);
                            foreach ($best_selling_category as $best_category) {
                                $count++;
                                if ($lang_code == 'id') {
                                    if ($count == 1) {
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="<?php echo $best_category->slug; ?>-tab" data-toggle="tab" href="#<?php echo $best_category->slug; ?>" role="tab" aria-controls="<?php echo $best_category->slug; ?>" aria-selected="true" title="<?php echo $best_category->title ?>"><?php echo $best_category->title ?></a>
                                    </li>
                                <?php
                                    } else {
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="<?php echo $best_category->slug; ?>-tab" data-toggle="tab" href="#<?php echo $best_category->slug; ?>" role="tab" aria-controls="<?php echo $best_category->slug; ?>" aria-selected="true" title="<?php echo $best_category->title ?>"><?php echo $best_category->title ?></a>
                                    </li>
                                <?php
                                    }

                                } elseif ($lang_code == 'en') {
                                    if ($count == 1) {
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="<?php echo $best_category->slug; ?>-tab" data-toggle="tab" href="#<?php echo $best_category->slug; ?>" role="tab" aria-controls="<?php echo $best_category->slug; ?>" aria-selected="true" title="<?php echo $best_category->title ?>"><?php echo $best_category->title ?></a>
                                    </li>
                                <?php
                                    } else {
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="<?php echo $best_category->slug; ?>-tab" data-toggle="tab" href="#<?php echo $best_category->slug; ?>" role="tab" aria-controls="<?php echo $best_category->slug; ?>" aria-selected="true" title="<?php echo $best_category->title ?>"><?php echo $best_category->title ?></a>
                                    </li>
                                <?php
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <?php
                        $count = 0;
                        foreach ($best_selling_category as $id_category => $best_category) {
                            $count++;
                            if ($count == 1) {
                        ?>
                            <div class="tab-pane fade show active" id="<?php echo $best_category->slug; ?>" role="tabpanel" aria-labelledby="arrival-tab">
                                <div class="row shop_container">
                                    <?php
                                    foreach ($products_list_best as $product) {
                                        if ($product->id_products_category == $best_category->id) {
                                    ?>
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <div class="product">
                                                <?php
                                                if ($product->best_seller == 'yes') {
                                                ?>
                                                    <span class="pr_flash bg-danger">Hot</span>
                                                <?php
                                                }

                                                if ($product->is_new == 'yes') {
                                                ?>
                                                    <span class="pr_flash bg-success">New</span>
                                                <?php
                                                }
                                                ?>
                                                <div class="product_img">
                                                    <?php if ($lang_code == 'id') { ?>
                                                        <?php if (!empty($product->sub_category_slug)) { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title ?>">
                                                        <?php } else { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title ?>">
                                                        <?php } ?>
                                                            <img src="<?php echo $this->main->image_preview_url($products_image_best[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ? $product->thumbnail_alt : $product->title ?>" title="<?= $product->thumbnail_alt ? $product->thumbnail_alt : $product->title ?>">
                                                        </a>
                                                    <?php } elseif ($lang_code == 'en') { ?>
                                                        <?php if (!empty($product->sub_category_slug)) { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng ?>">
                                                        <?php } else { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng ?>">
                                                        <?php } ?>
                                                            <img src="<?php echo $this->main->image_preview_url($products_image_best[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ? $product->thumbnail_alt : $product->title_eng ?>" title="<?= $product->thumbnail_alt ? $product->thumbnail_alt : $product->title_eng ?>">
                                                        </a>
                                                    <?php } ?>
                                                    <div class="product_action_box">
                                                        <ul class="list_none pr_action_btn">
                                                            <li class="add-to-cart"><a href="javascript:(0);" class="shop-cart-swal-qty" data-id="<?php echo $product->id ?>" title="<?php echo $dict_add_to_cart ?>"><i class="icon-basket-loaded"></i> <?php echo $dict_add_to_cart ?></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product_info">
                                                    <?php if ($lang_code == 'id') { ?>
                                                        <?php if (!empty($product->sub_category_slug)) { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>">
                                                        <?php } else { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>">
                                                        <?php } ?>
                                                            <h6 class="product_title"><?php echo $product->title; ?></h6>
                                                            <?php
                                                            if ($product->promotion_status === 'yes') {
                                                            ?>
                                                                <div class="product_price">
                                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->promotion_price); ?></span>
                                                                    <del>Rp. <?php echo $this->main->format_money($product->price); ?></del>
                                                                    <div class="on_sale">
                                                                        <span><?php echo $this->main->count_discount($product->price, $product->promotion_price); ?>% Off</span>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <div class="product_price">
                                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->price); ?></span>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </a>
                                                    <?php } elseif ($lang_code == 'en') { ?>
                                                        <?php if (!empty($product->sub_category_slug)) { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng; ?>">
                                                        <?php } else { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng; ?>">
                                                        <?php } ?>
                                                            <h6 class="product_title"><?php echo $product->title_eng; ?></h6>
                                                            <?php
                                                            if ($product->promotion_status === 'yes') {
                                                            ?>
                                                                <div class="product_price">
                                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->promotion_price); ?></span>
                                                                    <del>Rp. <?php echo $this->main->format_money($product->price); ?></del>
                                                                    <div class="on_sale">
                                                                        <span><?php echo $this->main->count_discount($product->price, $product->promotion_price); ?>% Off</span>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <div class="product_price">
                                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->price); ?></span>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </a
                                                    <?php } ?>
                                                    <div class="rating_wrap">
                                                        <div class="rating">
                                                            <div class="product_rate" style="width:<?php echo $product->average_rating; ?>%"></div>
                                                        </div>
                                                        <span class="rating_num">(<?php echo $product->count_rating ? $product->count_rating : 0; ?>)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    }
                                ?>
                                </div>
                            </div>
                        <?php
                            } else {
                        ?>
                            <div class="tab-pane fade show" id="<?php echo $best_category->slug; ?>" role="tabpanel" aria-labelledby="arrival-tab">
                                <div class="row shop_container">
                                    <?php
                                    foreach ($products_list_best as $product) {
                                        if ($product->id_products_category == $best_category->id) {
                                    ?>
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <div class="product">
                                                <?php
                                                if ($product->best_seller == 'yes') {
                                                ?>
                                                    <span class="pr_flash bg-danger">Hot</span>
                                                <?php
                                                }

                                                if ($product->is_new == 'yes') {
                                                ?>
                                                    <span class="pr_flash bg-success">New</span>
                                                <?php
                                                }
                                                ?>
                                                <div class="product_img">
                                                    <?php if ($lang_code == 'id') { ?>
                                                        <?php if (!empty($product->sub_category_slug)) { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title ?>">
                                                        <?php } else { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title ?>">
                                                        <?php } ?>
                                                            <img src="<?php echo $this->main->image_preview_url($products_image_best[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ? $product->thumbnail_alt : $product->title ?>" title="<?= $product->thumbnail_alt ? $product->thumbnail_alt : $product->title ?>">
                                                        </a>
                                                    <?php } elseif ($lang_code == 'en') { ?>
                                                        <?php if (!empty($product->sub_category_slug)) { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng ?>">
                                                        <?php } else { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng ?>">
                                                        <?php } ?>
                                                            <img src="<?php echo $this->main->image_preview_url($products_image_best[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ? $product->thumbnail_alt : $product->title ?>" title="<?= $product->thumbnail_alt ? $product->thumbnail_alt : $product->title_eng ?>">
                                                        </a>
                                                    <?php } ?>
                                                    <div class="product_action_box">
                                                        <ul class="list_none pr_action_btn">
                                                            <li class="add-to-cart"><a href="javascript:(0);" class="shop-cart-swal-qty" data-id="<?php echo $product->id ?>"><i class="icon-basket-loaded"></i> <?php echo $dict_add_to_cart ?></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product_info">
                                                    <?php if ($lang_code == 'id') { ?>
                                                        <?php if (!empty($product->sub_category_slug)) { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>">
                                                        <?php } else { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>">
                                                        <?php } ?>
                                                        <h6 class="product_title">
                                                            <?php echo $product->title; ?>
                                                        </h6>
                                                    <?php } elseif ($lang_code == 'en') { ?>
                                                        <?php if (!empty($product->sub_category_slug)) { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng; ?>">
                                                        <?php } else { ?>
                                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng; ?>">
                                                        <?php } ?>
                                                        <h6 class="product_title">
                                                            <?php echo $product->title_eng; ?>
                                                        </h6>
                                                    <?php
                                                    }
                                                    if ($product->promotion_status === 'yes') {
                                                    ?>
                                                        <div class="product_price">
                                                            <span class="price">Rp. <?php echo $this->main->format_money($product->promotion_price); ?></span>
                                                            <del>Rp. <?php echo $this->main->format_money($product->price); ?></del>
                                                            <div class="on_sale">
                                                                <span><?php echo $this->main->count_discount($product->price, $product->promotion_price); ?>% Off</span>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="product_price">
                                                            <span class="price">Rp. <?php echo $this->main->format_money($product->price); ?></span>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="rating_wrap">
                                                        <div class="rating">
                                                            <div class="product_rate" style="width:<?php echo $product->average_rating; ?>%"></div>
                                                        </div>
                                                        <span class="rating_num">(<?php echo $product->count_rating ? $product->count_rating : 0; ?>)</span>
                                                    </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    }
                                ?>
                                </div>
                            </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section bg_light_blue2 small_pt pb_20">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading_tab_header">
                        <div class="heading_s2">
                            <h2><?php echo $home_sesi_2->title; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="product_slider product_list carousel_slider owl-carousel owl-theme nav_style3" data-loop="true" data-dots="false" data-nav="true" data-margin="20"
                         data-responsive='{"0":{"items": "1"}, "767":{"items": "2"}, "991":{"items": "3"}, "1199":{"items": "3"}}'>
                        <?php
                        $count = 0;
                        $length_product_new = count($products_list_new);
                        foreach ($products_list_new as $product) {
                            if ($count == 0 || ($count % 3) == 0) {
                                if ($count != 0) {
                                    echo "</div>";
                                }
                        ?>
                                <div class="item">
                                    <div class="product">
                                        <div class="product_img">
                                            <?php if ($lang_code == 'id') { ?>
                                                <?php if (!empty($product->sub_category_slug)) { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title ?>">
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title ?>">
                                                <?php } ?>
                                                    <img  src="<?php echo $this->main->image_preview_url($products_image_new[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ?>" title="<?= $product->thumbnail_alt ? $product->thumbnail_alt : $product->title ?>">
                                                </a>
                                            <?php } elseif ($lang_code == 'en') { ?>
                                                <?php if (!empty($product->sub_category_slug)) { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng ?>">
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng ?>">
                                                <?php } ?>
                                                    <img  src="<?php echo $this->main->image_preview_url($products_image_new[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ?>" title="<?= $product->thumbnail_alt ? $product->thumbnail_alt : $product->title_eng ?>">
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="product_info">
                                            <?php if ($lang_code == 'id') { ?>
                                                <h6 class="product_title">
                                                    <?php if (!empty($product->sub_category_slug)) { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>"><?php echo $product->title; ?></a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>"><?php echo $product->title; ?></a>
                                                    <?php } ?>
                                                </h6>
                                            <?php } elseif ($lang_code == 'en') { ?>
                                                <h6 class="product_title">
                                                    <?php if (!empty($product->sub_category_slug)) { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng; ?>"><?php echo $product->title_eng; ?></a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng; ?>"><?php echo $product->title_eng; ?></a>
                                                    <?php } ?>
                                                </h6>
                                            <?php
                                            }
                                            if ($product->promotion_status == 'yes') {
                                            ?>
                                                <div class="product_price">
                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->promotion_price); ?></span>
                                                    <del>Rp. <?php echo $this->main->format_money($product->price) ?></del>
                                                    <div class="on_sale">
                                                        <span><?php echo $this->main->count_discount($product->price, $product->promotion_price) ?>% Off</span>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="product_price">
                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->price) ?></span>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php if (($count+1) == $length_product_new) { ?> </div> <?php } ?>
                        <?php
                            } else {
                        ?>
                                <div class="product">
                                    <div class="product_img">
                                        <?php if ($lang_code == 'id') { ?>
                                            <?php if (!empty($product->sub_category_slug)) { ?>
                                                <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title ?>">
                                            <?php } else { ?>
                                                <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title ?>">
                                            <?php } ?>
                                                <img  src="<?php echo $this->main->image_preview_url($products_image_new[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ? $product->thumbnail_alt : $product->title ?>">
                                            </a>
                                        <?php } elseif ($lang_code == 'en') { ?>
                                            <?php if (!empty($product->sub_category_slug)) { ?>
                                                <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng ?>">
                                            <?php } else { ?>
                                                <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng ?>">
                                            <?php } ?>
                                                <img  src="<?php echo $this->main->image_preview_url($products_image_new[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ? $product->thumbnail_alt : $product->title_eng ?>">
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <div class="product_info">
                                        <?php if ($lang_code == 'id') { ?>
                                            <h6 class="product_title">
                                                <?php if (!empty($product->sub_category_slug)) { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>"><?php echo $product->title; ?></a>
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>"><?php echo $product->title; ?></a>
                                                <?php } ?>
                                            </h6>
                                        <?php } elseif ($lang_code == 'en') { ?>
                                            <h6 class="product_title">
                                                <?php if (!empty($product->sub_category_slug)) { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>"><?php echo $product->title; ?></a>
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>"><?php echo $product->title; ?></a>
                                                <?php } ?>
                                            </h6>
                                        <?php
                                        }
                                        if ($product->promotion_status == 'yes') {
                                        ?>
                                            <div class="product_price">
                                                <span class="price">Rp. <?php echo $this->main->format_money($product->promotion_price) ?></span>
                                                <del>Rp. <?php echo $this->main->format_money($product->price) ?></del>
                                                <div class="on_sale">
                                                    <span><?php echo $this->main->count_discount($product->price, $product->promotion_price) ?>% Off</span>
                                                </div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="product_price">
                                                <span class="price">Rp. <?php echo $this->main->format_money($product->price) ?></span>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php if (($count+1) == $length_product_new) { ?> </div> <?php } ?>
                        <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section small-pt pb_20">
        <div class="custom-container">
            <div class="row">
                <?php
                foreach ($category_products_by_category as $data_category) {
                    foreach ($data_category as $category) {
                ?>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="heading_tab_header">
                                <div class="heading_s2">
                                    <?php if ($lang_code == 'id') { ?>
                                        <h4><?php echo $category->title; ?></h4>
                                    <?php } elseif ($lang_code == 'en') { ?>
                                        <h4><?php echo $category->title_eng; ?></h4>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="product_slider carousel_slider product_list owl-carousel owl-theme nav_style3" data-nav="true" data-dots="false" data-loop="true" data-margin="20"
                                 data-responsive='{"0":{"items": "1"}, "380":{"items": "1"}, "640":{"items": "2"}, "991":{"items": "1"}}'>
                                <?php
                                $count = 0;
                                $length_product_by_category = count($list_products_by_category[$category->id]);
                                foreach ($list_products_by_category[$category->id] as $product) {
                                    if ($count == 0 || ($count % 3) == 0) {
                                        if ($count != 0){
                                            echo "</div>";
                                        }
                                ?>
                                <div class="item">
                                    <div class="product_wrap">
                                        <div class="product_img">
                                            <?php if ($lang_code == 'id') { ?>
                                                <?php if (!empty($product->sub_category_slug)) { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug); ?>" title="<?php echo $product->title ?>">
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug); ?>" title="<?php echo $product->title ?>">
                                                <?php } ?>
                                                    <img  src="<?php echo $this->main->image_preview_url($list_products_image_by_category[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ? $product->thumbnail_alt : $product->title ?>" title="<?= $product->thumbnail_alt ? $product->thumbnail_alt : $product->title ?>">
                                                </a>
                                            <?php } elseif ($lang_code == 'en') { ?>
                                                <?php if (!empty($product->sub_category_slug)) { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug); ?>" title="<?php echo $product->title_eng ?>">
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug); ?>" title="<?php echo $product->title_eng ?>">
                                                <?php } ?>
                                                    <img  src="<?php echo $this->main->image_preview_url($list_products_image_by_category[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ? $product->thumbnail_alt : $product->title_eng ?>" title="<?= $product->thumbnail_alt ? $product->thumbnail_alt : $product->title ?>">
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="product_info">
                                            <?php if ($lang_code == 'id') { ?>
                                                <h6 class="product_title">
                                                    <?php if (!empty($product->sub_category_slug)) { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>"><?php echo $product->title; ?></a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>"><?php echo $product->title; ?></a>
                                                    <?php } ?>
                                                </h6>
                                            <?php } elseif ($lang_code == 'en') { ?>
                                                <h6 class="product_title">
                                                    <?php if (!empty($product->sub_category_slug)) { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng; ?>"><?php echo $product->title_eng; ?></a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng; ?>"><?php echo $product->title_eng; ?></a>
                                                    <?php } ?>
                                                </h6>
                                            <?php
                                            }
                                            if ($product->promotion_status == 'yes') {
                                            ?>
                                                <div class="product_price">
                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->promotion_price); ?></span>
                                                    <del>Rp. <?php echo $this->main->format_money($product->price); ?></del>
                                                    <div class="on_sale">
                                                        <span><?php echo $this->main->count_discount($product->price, $product->promotion_price) ?>% Off</span>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="product_price">
                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->price) ?></span>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php if ($length_product_by_category == ($count+1)) { ?> </div> <?php } ?>
                                    <?php
                                    } else {
                                    ?>
                                    <div class="product_wrap">
                                        <div class="product_img">
                                            <?php if ($lang_code == 'id') { ?>
                                                <?php if (!empty($product->sub_category_slug)) { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug); ?>" title="<?php echo $product->title ?>">
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug); ?>" title="<?php echo $product->title ?>">
                                                <?php } ?>
                                                    <img  src="<?php echo $this->main->image_preview_url($list_products_image_by_category[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ?>" title="<?= $product->thumbnail_alt ? $product->thumbnail_alt : $product->title ?>">
                                                </a>
                                            <?php } elseif ($lang_code == 'en') { ?>
                                                <?php if (!empty($product->sub_category_slug)) { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug); ?>" title="<?php echo $product->title_eng ?>">
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug); ?>" title="<?php echo $product->title_eng ?>">
                                                <?php } ?>
                                                    <img  src="<?php echo $this->main->image_preview_url($list_products_image_by_category[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt ?>" title="<?= $product->thumbnail_alt ? $product->thumbnail_alt : $product->title_eng ?>">
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="product_info">
                                            <?php if ($lang_code == 'id') { ?>
                                                <h6 class="product_title">
                                                    <?php if (!empty($product->sub_category_slug)) { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>"><?php echo $product->title; ?></a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title; ?>"><?php echo $product->title; ?></a>
                                                    <?php } ?>
                                                </h6>
                                            <?php } elseif ($lang_code == 'en') { ?>
                                                <h6 class="product_title">
                                                    <?php if (!empty($product->sub_category_slug)) { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng; ?>"><?php echo $product->title_eng; ?></a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->title_eng; ?>"><?php echo $product->title_eng; ?></a>
                                                    <?php } ?>
                                                </h6>
                                            <?php
                                            }
                                            if ($product->promotion_status == 'yes') {
                                            ?>
                                                <div class="product_price">
                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->promotion_price); ?></span>
                                                    <del>Rp. <?php echo $this->main->format_money($product->price); ?></del>
                                                    <div class="on_sale">
                                                        <span><?php echo $this->main->count_discount($product->price, $product->promotion_price) ?>% Off</span>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="product_price">
                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->price) ?></span>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php if ($length_product_by_category == ($count+1)) { ?> </div> <?php } ?>
                                <?php
                                    }
                                    $count++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

</div>