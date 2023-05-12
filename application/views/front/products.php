<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1><?php echo $page->title ?></h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>" title="php echo $home->title_menu; ?>"><?php echo $home->title_menu; ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $page->title_menu; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>



<div class="main_content">

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row align-items-center mb-4 pb-1">
                        <div class="col-12">
                            <div class="product_header">
                                <div class="product_header_left">
                                    <div class="custom_select">
                                        <select class="form-control form-control-sm" id="product-sort">
                                            <option value="latest" <?php if ($sort == 'latest') { ?> selected <?php } ?> ><?php echo $dict_sort_latest ?></option>
                                            <option value="bestseller" <?php if ($sort == 'bestseller') { ?> selected <?php } ?> ><?php echo $dict_sort_bestseller ?></option>
                                            <option value="average-rating"<?php if ($sort == 'average-rating') { ?> selected <?php } ?> ><?php echo $dict_sort_rate ?></option>
                                            <option value="price-low-high"<?php if ($sort == 'price-low-high') { ?> selected <?php } ?> ><?php echo $dict_sort_price_low_high ?></option>
                                            <option value="price-high-low"<?php if ($sort == 'price-high-low') { ?> selected <?php } ?> ><?php echo $dict_sort_price_high_low ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="product_header_right">
                                    <div class="products_view">
                                        <a href="javascript:Void(0);" class="shorting_icon grid active" title="View Grid"><i class="ti-view-grid line-h-unset"></i></a>
                                        <a href="javascript:Void(0);" class="shorting_icon list" title="Layout List"><i class="ti-layout-list-thumb"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($searched_keyword)) { ?>
                    <p class="serach-word d-block"><?php echo $dict_product_search_title ?> "<?php echo $searched_keyword; ?>"</p>
                    <?php } ?>
                    <div class="row shop_container grid">
                        <?php
                        if (count($products_list) == 0) {
                        ?>
                            <div class="zero-products text-center col-12"><strong><span><?= $dict_zero_products_message ?></span></strong></div>
                        <?php
                        }
                        foreach ($products_list as $product) {
                        ?>
                            <div class="col-lg-4 col-md-4 col-6">
                                <div class="product" id="hideshow2">
                                    <div class="product_img">
                                        <?php if (!empty($product->sub_category_slug)) { ?>
                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php echo $product->thumbnail_alt; ?>">
                                        <?php } else { ?>
                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php echo $product->thumbnail_alt; ?>">
                                        <?php } ?>
                                            <img src="<?php echo $this->main->image_preview_url($products_image[$product->id]->thumbnail) ?>" alt="<?php echo $product->thumbnail_alt; ?>">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart">
                                                    <a href="javascript:(0);" class="shop-cart-swal-qty" data-id="<?php echo $product->id ?>" title="<?php echo $dict_add_to_cart ?>">
                                                        <i class="icon-basket-loaded"></i> <?php echo $dict_add_to_cart ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <?php if (!empty($product->sub_category_slug)) { ?>
                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->sub_category_slug.'/'.$product->slug) ?>" title="<?php if ($lang_code == 2) { echo $product->title; } elseif ($lang_code == 1) { echo $product->title_eng; } ?>">
                                        <?php } else { ?>
                                            <a href="<?php echo site_url('produk/'.$product->category_slug.'/'.$product->slug) ?>" title="<?php if ($lang_code == 2) { echo $product->title; } elseif ($lang_code == 1) { echo $product->title_eng; } ?>">
                                        <?php } ?>
                                            <h6 class="product_title">
                                                <?php if ($lang_code == 'id') { echo $product->title; } elseif ($lang_code == 'en') { echo $product->title_eng; } ?>
                                            </h6>
                                            <div class="product_price">
                                                <?php
                                                if ($product->promotion_status === 'yes') {
                                                ?>
                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->promotion_price); ?></span>
                                                    <del>Rp. <?php echo $this->main->format_money($product->price); ?></del>
                                                    <div class="on_sale">
                                                        <span><?php echo $this->main->count_discount($product->price, $product->promotion_price); ?>% Off</span>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <span class="price">Rp. <?php echo $this->main->format_money($product->price); ?></span>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </a>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:<?php echo $product->average_rating; ?>%"></div>
                                            </div>
                                            <span class="rating_num">(<?php echo $product->count_rating ? $product->count_rating : 0; ?>)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <?php if ($lang_code == 'id') { ?>
                                                <p><?php echo $product->description; ?></p>
                                            <?php } elseif ($lang_code == 'en') { ?>
                                                <p><?php echo $product->description_eng; ?></p>
                                            <?php } ?>
                                        </div>
                                        <div class="list_product_action_box m-top-20">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart">
                                                    <a data-target="#shop-modal" href="javascript:(0);" data-toggle="modal" class="shop-cart-swal-qty" data-id="<?php echo $product->id ?>" title="<?php echo $dict_add_to_cart ?>">
                                                        <i class="icon-basket-loaded"></i> <?php echo $dict_add_to_cart ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
            	<div class="sidebar">
                	<div class="widget">
                        <h5 class="widget_title"><?php echo $dict_category; ?></h5>
                        <ul class="widget_categories">
                            <?php if (empty($searched_keyword) && empty($sort)) { ?>
                            <li>
                                <a class="opac-0">
                                    <i class="fa fa-angle-right pull-left m-right-10" aria-hidden="true"></i>
                                </a>
                                <?php if ($lang_code == 'id') { ?>
                                    <a href="<?php echo site_url('produk') ?>"><span class="categories_name">Semua Kategori</span></a>
                                <?php } elseif ($lang_code == 'en') { ?>
                                    <a href="<?php echo site_url('produk') ?>"><span class="categories_name">All Category</span></a>
                                <?php } ?>
                            </li>
                            <?php } else { ?>
                            <li>
                                <a class="opac-0">
                                    <i class="fa fa-angle-right pull-left m-right-10" aria-hidden="true"></i>
                                </a>
                                <a href="<?php echo site_url('produk?');
                                echo $searched_keyword ? 'search='.$searched_keyword.'&' : NULL;
                                echo $sort ? 'sort='.$sort.'&' : NULL;
                                echo $lowest_price_range ? 'lowest_price_range='.$lowest_price_range.'&' : NULL;
                                echo $highest_price_range ? 'highest_price_range='.$highest_price_range.'&' : NULL;
                                ?>">
                                    <?php if ($lang_code == 'id') { ?>
                                        <span class="categories_name">Semua Kategori</span>
                                    <?php } elseif ($lang_code == 'en') { ?>
                                        <span class="categories_name">All Category</span>
                                    <?php } ?>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                            foreach ($category_product as $category) {
                                if ($lang_code == 'id') {
                                    if (array_key_exists($category->id, $sub_category_product)) {
                            ?>
                                <li>
                                    <a data-toggle="collapse" href="#collapse-<?php echo $this->main->slug($category->title); ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="fa fa-angle-right pull-left m-right-10" aria-hidden="true"></i>
                                    </a>

                                    <?php if (empty($searched_keyword) && empty($sort)) { ?>
                                        <a href="<?php echo site_url('produk/'.$category->slug) ?>"><span class="categories_name"><?php echo $category->title; ?></span></a>
                                    <?php } else { ?>
                                        <a href="<?php echo site_url('produk/'.$category->slug.'?');
                                        echo $searched_keyword ? 'search='.$searched_keyword.'&' : NULL;
                                        echo $sort ? 'sort='.$sort.'&' : NULL;
                                        echo $lowest_price_range ? 'lowest_price_range='.$lowest_price_range.'&' : NULL;
                                        echo $highest_price_range ? 'highest_price_range='.$highest_price_range.'&' : NULL;
                                        ?>">
                                            <span class="categories_name"><?php echo $category->title; ?></span>
                                        </a>
                                    <?php } ?>

                                    <div class="collapse" id="collapse-<?php echo $this->main->slug($category->title); ?>">
                                        <ul class="sub-widget-categories">
                                            <?php
                                            foreach ($sub_category_product[$category->id] as $sub_category) {
                                                if (empty($searched_keyword) && empty($sort)) {
                                            ?>
                                                <li><a href="<?php echo site_url('produk/'.$category->slug.'/'.$sub_category->slug) ?>"><?php echo $sub_category->title; ?></a></li>
                                            <?php
                                                } else {
                                            ?>
                                                <li>
                                                    <a href="<?php echo site_url('produk/'.$category->slug.'/'.$sub_category->slug.'?');
                                                    echo $searched_keyword ? 'search='.$searched_keyword.'&' : NULL;
                                                    echo $sort ? 'sort='.$sort.'&' : NULL;
                                                    echo $lowest_price_range ? 'lowest_price_range='.$lowest_price_range.'&' : NULL;
                                                    echo $highest_price_range ? 'highest_price_range='.$highest_price_range.'&' : NULL;
                                                    ?>"><?php echo $sub_category->title; ?></a>
                                                </li>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php
                                } else {
                                    if (empty($searched_keyword) && empty($sort)) {
                            ?>
                                <li>
                                    <a class="opac-0">
                                        <i class="fa fa-angle-right pull-left m-right-10" aria-hidden="true"></i>
                                    </a>
                                    <a href="<?php echo site_url('produk/'.$category->slug) ?>"><span class="categories_name"><?php echo $category->title; ?></span></a>
                                </li>
                            <?php
                                    } else {
                            ?>
                                <li>
                                    <a class="opac-0">
                                        <i class="fa fa-angle-right pull-left m-right-10" aria-hidden="true"></i>
                                    </a>
                                    <a href="<?php echo site_url('produk/'.$category->slug.'?');
                                    echo $searched_keyword ? 'search='.$searched_keyword.'&' : NULL;
                                    echo $sort ? 'sort='.$sort.'&' : NULL;
                                    echo $lowest_price_range ? 'lowest_price_range='.$lowest_price_range.'&' : NULL;
                                    echo $highest_price_range ? 'highest_price_range='.$highest_price_range.'&' : NULL;
                                    ?>">
                                        <span class="categories_name"><?php echo $category->title; ?></span>
                                    </a>
                                </li>
                            <?php
                                        }
                                    }
                                } elseif ($lang_code == 'en') {
                                    if (array_key_exists($category->id, $sub_category_product)) {
                            ?>
                                <li>
                                    <a data-toggle="collapse" href="#collapse-<?php echo $this->main->slug($category->title); ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="fa fa-angle-right pull-left m-right-10" aria-hidden="true"></i>
                                    </a>

                                    <?php if (empty($searched_keyword) && empty($sort)) { ?>
                                        <a href="<?php echo site_url('produk/'.$category->slug) ?>"><span class="categories_name"><?php echo $category->title_eng; ?></span></a>
                                    <?php } else { ?>
                                        <a href="<?php echo site_url('produk/'.$category->slug.'?');
                                        echo $searched_keyword ? 'search='.$searched_keyword.'&' : NULL;
                                        echo $sort ? 'sort='.$sort.'&' : NULL;
                                        echo $lowest_price_range ? 'lowest_price_range='.$lowest_price_range.'&' : NULL;
                                        echo $highest_price_range ? 'highest_price_range='.$highest_price_range.'&' : NULL;
                                        ?>">
                                            <span class="categories_name"><?php echo $category->title_eng; ?></span>
                                        </a>
                                    <?php } ?>

                                    <div class="collapse" id="collapse-<?php echo $this->main->slug($category->title); ?>">
                                        <ul class="sub-widget-categories">
                                            <?php
                                            foreach ($sub_category_product[$category->id] as $sub_category) {
                                                if (empty($searched_keyword) && empty($sort)) {
                                            ?>
                                                <li><a href="<?php echo site_url('produk/'.$category->slug.'/'.$sub_category->slug) ?>"><?php echo $sub_category->title_eng; ?></a></li>
                                            <?php
                                                } else {
                                            ?>
                                                <li>
                                                    <a href="<?php echo site_url('produk/'.$category->slug.'/'.$sub_category->slug.'?');
                                                    echo $searched_keyword ? 'search='.$searched_keyword.'&' : NULL;
                                                    echo $sort ? 'sort='.$sort.'&' : NULL;
                                                    echo $lowest_price_range ? 'lowest_price_range='.$lowest_price_range.'&' : NULL;
                                                    echo $highest_price_range ? 'highest_price_range='.$highest_price_range.'&' : NULL;
                                                    ?>"><?php echo $sub_category->title_eng; ?></a>
                                                </li>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php
                                } else {
                                    if (empty($searched_keyword) && empty($sort)) {
                            ?>
                                <li>
                                    <a class="opac-0">
                                        <i class="fa fa-angle-right pull-left m-right-10" aria-hidden="true"></i>
                                    </a>
                                    <a href="<?php echo site_url('produk/'.$category->slug) ?>"><span class="categories_name"><?php echo $category->title_eng; ?></span></a>
                                </li>
                            <?php
                                    } else {
                            ?>
                                <li>
                                    <a class="opac-0">
                                        <i class="fa fa-angle-right pull-left m-right-10" aria-hidden="true"></i>
                                    </a>
                                    <a href="<?php echo site_url('produk/'.$category->slug.'?');
                                    echo $searched_keyword ? 'search='.$searched_keyword.'&' : NULL;
                                    echo $sort ? 'sort='.$sort.'&' : NULL;
                                    echo $lowest_price_range ? 'lowest_price_range='.$lowest_price_range.'&' : NULL;
                                    echo $highest_price_range ? 'highest_price_range='.$highest_price_range.'&' : NULL;
                                    ?>">
                                        <span class="categories_name"><?php echo $category->title_eng; ?></span>
                                    </a>
                                </li>
                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <form action="<?php echo current_url(); ?>" method="get" class="mt-4">
                        <div class="widget">
                            <h5 class="widget_title"><?php echo $dict_filter ?></h5>
                            <div class="filter_price">
                                 <div id="price_filter" data-min="0" data-max="<?php echo $max_price; ?>" data-min-value="<?php if (!empty($lowest_price_range)){ echo $lowest_price_range; } else { echo '0'; } ?>" data-max-value="<?php if (!empty($highest_price_range)){ echo $highest_price_range; } else { echo $max_price; } ?>" data-price-sign="Rp."></div>
                                 <div class="price_range">
                                     <span><?php echo $dict_cart_price ?>: <span id="flt_price"></span></span>
                                     <input type="hidden" name="lowest_price_range" id="price_first">
                                     <input type="hidden" name="highest_price_range" id="price_second">
                                     <?php if (!empty($searched_keyword)) { ?>
                                         <input type="hidden" name="search" value="<?php echo $searched_keyword ?>">
                                     <?php } ?>
                                     <?php if (!empty($sort)) { ?>
                                         <input type="hidden" name="sort" value="<?php echo $sort ?>">
                                     <?php } ?>
                                 </div>
                             </div>
                        </div>
                        <div class="widget">
                            <button class="btn btn-fill-out" role="button"><?php echo $dict_filter ?></button>
                            <a class="btn btn-border-fill" href="<?php echo site_url('produk') ?>"><?php echo $dict_reset ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>