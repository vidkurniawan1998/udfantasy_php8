<!DOCTYPE html>
<html lang="<?php echo $lang_active->code ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $page->meta_title ?></title>
    <meta name="keywords" content="<?php echo $page->meta_keywords ?>"/>
    <meta name="description" content="<?php echo $page->meta_description ?>">
    <meta name="author" content="<?php echo $author ?>">
    <meta name="revisit-after" content="2 days"/>
    <meta name="robots" content="index, follow"/>
    <meta name="rating" content="General"/>
    <meta http-equiv="charset" content="ISO-8859-1"/>
    <meta http-equiv="expires" content="Mon, 28 Jul <?php echo date('Y')+1;?> 11:12:01 GMT">
    <meta http-equiv="content-language" content="<?php echo $lang_active->code ?>"/>
    <meta content="telephone=no" name="format-detection">
    <meta name="MSSmartTagsPreventParsing" content="true"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="reply-to" content="info@redsystem.id">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <link rel="icon" href="<?php echo base_url() ?>assets/template_front/img/favicon.png" type="image/png" sizes="192x192">

<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url() ?>assets/template_front/images/favicon.png">

<link rel="stylesheet" href="<?php echo base_url() ?>assets/template_front/css/fantasy-online.min.css">

</head>

<body>


<div class="preloader hide">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>


<div id="base_url" class="hide"><?php echo base_url(); ?></div>
<div id="site_url" class="hide"><?php echo site_url(); ?></div>
<div id="lang_code" class="hide"><?php echo $lang_active->code ?></div>
<header class="header_wrap fixed-top">
	<div class="top-header light_skin bg_dark d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                	<div class="header_topbar_info">
                    	<div class="header_offer">
                    		<span>Fantasy Online</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4">
                	<div class="d-flex align-items-center justify-content-center justify-content-md-end">
                        <div class="lng_dropdown">
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle added-setting-lang" type="button" id="dropdownLangButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo $this->main->image_preview_url($lang_active->thumbnail) ?>" height="20" alt="<?php echo $lang_active->title ?>"> &nbsp; <?php echo $lang_active->title; ?>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownLangButton">
                                    <?php foreach ($language_list as $row) { ?>
                                        <?php echo anchor($this->lang->switch_uri($row->code), '<img src="' . $this->main->image_preview_url($row->thumbnail) . '" height="20" alt="' . $row->title . '"> &nbsp' . $row->title, 'class="dropdown-item lang-dropdown"') ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="middle-header dark_skin">
    	<div class="container">
            <div class="nav_block">
                <a class="navbar-brand" href="<?php echo site_url() ?>" title="Logo">
                    <img class="logo_light" src="<?php echo base_url() ?>assets/template_front/images/logo_light.png" alt="logo">
                    <img class="logo_dark" src="<?php echo base_url() ?>assets/template_front/images/logo_dark.png" alt="logo">
                </a>
                <div class="product_search_form radius_input search_form_btn">
                    <form action="<?php echo site_url('produk') ?>" method="get">
                        <div class="input-group">
                            <input class="form-control" placeholder="<?php echo $dict_product_search ?>" required="" name="search" type="text">
                            <button type="submit" class="search_btn3"><?php echo $dict_search_label ?></button>
                        </div>
                    </form>
                </div>
                <div class="contact_phone contact_support">
                    <?php if (!empty($contact_info['phone_link'])) { ?><a href="<?php echo $contact_info['phone_link'] ?>"><i class="linearicons-phone-wave"></i></a> <?php } ?>
                    <?php if (!empty($contact_info['whatsapp_link'])) { ?><a href="<?php echo $contact_info['whatsapp_link'] ?>"><i class="ion-social-whatsapp"></i></a><?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_header dark_skin main_menu_uppercase border-top">
    	<div class="container">
            <div class="row align-items-center">
            	<div class="col-lg-3 col-md-4 col-sm-6 col-3">
                	<div class="categories_wrap">
                        <button type="button" data-toggle="collapse" data-target="#navCatContent" aria-expanded="false" class="categories_btn categories_menu">
                            <span><?php echo $dict_category; ?> </span><i class="linearicons-menu"></i>
                        </button>
                        <div id="navCatContent" class="navbar collapse">
                            <ul>
                                <?php
                                foreach ($category_product as $category) {
                                    if (array_key_exists($category->id, $sub_category_product)){
                                        if ($lang_code == 'id') {
                                ?>
                                        <li class="dropdown">
                                            <a class="dropdown-item nav-link dropdown-toggler overflow-hidden" href="<?php echo site_url('produk/'.$category->slug); ?>" data-toggle="dropdown" title="<?php echo $category->title ?>"> <span><?php echo $category->title ?></span></a>
                                            <div class="dropdown-menu">
                                                <ul>
                                                    <?php
                                                    foreach ($sub_category_product[$category->id] as $sub_category) {
                                                    ?>
                                                        <li><a class="dropdown-item nav-link nav_item" href="<?php echo site_url('produk/'.$category->slug.'/'.$sub_category->slug); ?>" title="<?php echo $sub_category->title; ?>"><?php echo $sub_category->title; ?></a></li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </li>
                                <?php
                                        } elseif ($lang_code == 'eng ') {
                                ?>
                                        <li class="dropdown">
                                            <a class="dropdown-item nav-link dropdown-toggler" href="<?php echo site_url('produk/'.$category->slug); ?>" data-toggle="dropdown" title="<?php echo $category->title_eng ?>"> <span><?php echo $category->title_eng ?></span></a>
                                            <div class="dropdown-menu">
                                                <ul>
                                                    <?php
                                                    foreach ($sub_category_product[$category->id] as $sub_category) {
                                                    ?>
                                                        <li><a class="dropdown-item nav-link nav_item" href="<?php echo site_url('produk/'.$category->slug.'/'.$sub_category->slug); ?>" title="<?php echo $sub_category->title_eng; ?>"><?php echo $sub_category->title_eng; ?></a></li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </li>
                                <?php
                                        }
                                    } else {
                                        if ($lang_code == 'id') {
                                ?>
                                        <li><a class="dropdown-item nav-link nav_item" href="<?php echo site_url('produk/'.$category->slug) ?>" title="<?php echo $category->title; ?>"> <span><?php echo $category->title; ?></span></a></li>
                                <?php
                                        } elseif ($lang_code == 'en') {
                                ?>
                                        <li><a class="dropdown-item nav-link nav_item" href="<?php echo site_url('produk/'.$category->slug) ?>" title="<?php echo $category->title_eng; ?>"> <span><?php echo $category->title_eng; ?></span></a></li>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-6 col-9">
                	<nav class="navbar navbar-expand-lg">
                    	<button class="navbar-toggler side_navbar_toggler" type="button" data-toggle="collapse" data-target="#navbarSidetoggle" aria-expanded="false">
                            <span class="ion-android-menu"></span>
                        </button>
                        <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
                            <ul class="navbar-nav">
                                <li><a class="nav-link nav_item <?php echo $page->type == "home" ? "active" : "" ?>" href="<?php echo site_url() ?>" title="<?php echo $home->title_menu ?>"><?php echo $home->title_menu ?></a></li>
                                <li><a class="nav-link nav_item <?php echo $page->type == "products" ? "active" : "" ?>" href="<?php echo site_url('produk') ?>" title="<?php echo $products->title_menu ?>"><?php echo $products->title_menu ?></a></li>
                                <li><a class="nav-link nav_item <?php echo $page->type == "terms_condition" ? "active" : "" ?>" href="<?php echo site_url('syarat-ketentuan') ?>" title="<?php echo $terms_condition->title_menu ?>"><?php echo $terms_condition->title_menu ?></a></li>
                                <li><a class="nav-link nav_item <?php echo $page->type == "faq" ? "active" : "" ?>" href="<?php echo site_url('frequently-asked-question') ?>" title="<?php echo $faq->title_menu ?>"><?php echo $faq->title_menu ?></a></li>
                                <li><a class="nav-link nav_item <?php echo $page->type == "about_us" ? "active" : "" ?>" href="<?php echo site_url('about-us') ?>" title="<?php echo $about_us->title_menu ?>"><?php echo $about_us->title_menu ?></a></li>
                                <li><a class="nav-link nav_item <?php echo $page->type == "contact_us" ? "active" : "" ?>" href="<?php echo site_url('contact-us') ?>" title="<?php echo $contact_us->title_menu ?>"><?php echo $contact_us->title_menu ?></a></li>
                            </ul>
                        </div>
                        <ul class="navbar-nav attr-nav align-items-center">
                            <li class="dropdown user-dropdown"><a href="<?php echo site_url('login') ?>" class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" title="User"><i class="linearicons-user"></i></a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-round-bottom">
                                    <ul class="user_list">
                                        <?php if ($this->session->userdata('status_member') == 'login') { ?>
                                            <li>
                                                <a
                                                    <?php if ($this->uri->segment(2) == 'user-profile') { ?>
                                                        data-toggle="tab" data-target="#biodata" onclick="change_active_tab('biodata')" role="tab" aria-controls="biodata" aria-selected="false"
                                                    <?php } else { ?>
                                                        href="<?php echo site_url('user-profile#biodata'); ?>"
                                                    <?php } ?>
                                                        title="<?php echo $dict_user_tab_bio ?>"
                                                >
                                                    <button type="button" class="dropdown-item">
                                                        <i class="linearicons-list"></i><span class="ml-3"><?php echo $dict_user_tab_bio ?></span>
                                                    </button>
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    <?php if ($this->uri->segment(2) == 'user-profile') { ?>
                                                        data-toggle="tab" data-target="#alamat" onclick="change_active_tab('alamat')" role="tab" aria-controls="alamat" aria-selected="false"
                                                    <?php } else { ?>
                                                        href="<?php echo site_url('user-profile#alamat'); ?>"
                                                    <?php } ?>
                                                        title="<?php echo $dict_user_tab_address ?>"
                                                >
                                                    <button type="button" class="dropdown-item">
                                                        <i class="linearicons-home"></i><span class="ml-3"><?php echo $dict_user_tab_address ?></span>
                                                    </button>
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    <?php if ($this->uri->segment(2) == 'user-profile') { ?>
                                                        data-toggle="tab" data-target="#transaksi" onclick="change_active_tab('transaksi')" role="tab" aria-controls="transaksi" aria-selected="false"
                                                    <?php } else { ?>
                                                        href="<?php echo site_url('user-profile#transaksi'); ?>"
                                                    <?php } ?>
                                                        title="<?php echo $dict_user_tab_transaction ?>"
                                                >
                                                    <button type="button" class="dropdown-item">
                                                        <i class="linearicons-cash-dollar"></i><span class="ml-3"><?php echo $dict_user_tab_transaction ?></span>
                                                    </button>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('logout') ?>" title="<?php echo $dict_user_logout ?>">
                                                    <button type="button" class="dropdown-item">
                                                        <i class="linearicons-exit-right"></i><span class="ml-3"><?php echo $dict_user_logout ?></span>
                                                    </button>
                                                </a>
                                            </li>
                                        <?php } else { ?>
                                            <li>
                                                <a href="<?php echo site_url('login') ?>" title="<?php echo $dict_user_login ?>">
                                                    <button type="button" class="dropdown-item">
                                                        <i class="linearicons-exit-right"></i><span class="ml-3"><?php echo $dict_user_login ?></span>
                                                    </button>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('signup') ?>" title="<?php echo $dict_login_signup ?>">
                                                    <button type="button" class="dropdown-item">
                                                        <i class="linearicons-user-plus"></i><span class="ml-3"><?php echo $dict_login_signup ?></span>
                                                    </button>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown cart_dropdown"><a class="nav-link cart_trigger" href="#" data-toggle="dropdown" title="Cart"><i class="linearicons-bag2"></i><span class="cart_count">0</span></a>
                                <div class="cart_box cart_right dropdown-menu dropdown-menu-right dropdown-round-bottom">
                                    <ul class="cart_list">
                                        <li class="hide">
                                            <a href="javascript:void(0);" class="item_remove" title="Remove"><i class="ion-close"></i></a>
                                            <a href="#" class="cart-info"><img src="" alt="cart_thumb1"><div class="cart-title"></div></a>
                                            <span class="cart_quantity"> 1 x <span class="cart_amount"> <span class="price_symbole"></span></span></span>
                                        </li>
                                        <?php
                                            $total = 0;
                                            $count = 0;
                                            foreach ($this->cart->contents() as $items) {
                                            $total += $items['subtotal'];
                                        ?>
                                            <li class="item-<?php echo $count ?> row-<?php echo $items['rowid'] ?>" data-rowid="<?php echo $items['rowid'] ?>">
                                                <a href="javascript:void(0);" class="item_remove" title="Remove"><i class="ion-close"></i></a>
                                                <a href="<?php echo site_url('produk-detail/'.$items['slug']) ?>" class="cart-info" title="<?php echo $items['name'] ?>"><img src="<?php echo $this->main->image_preview_url($items['thumbnail']) ?>" alt="<?php echo $items['thumbnail_alt'] ?>"><div class="cart-title"><?php echo $items['name'] ?></div></a>
                                                <span class="cart_quantity"> <?php echo $items['qty'] ?> x <span class="cart_amount"> <span class="price_symbole">Rp.</span></span> <?php echo $this->main->format_money($items['price']) ?></span>
                                            </li>
                                        <?php
                                                $count++;
                                            }
                                        ?>
                                    </ul>
                                    <div class="cart_footer">
                                        <p class="cart_total"><strong>Subtotal:</strong> <span class="cart_price"> <span class="price_symbole">Rp.</span></span><?php echo $this->main->format_money($total); ?></p>
                                        <p class="cart_buttons"><a href="<?php echo site_url('cart') ?>" class="btn btn-fill-line view-cart" title="<?php echo $dict_cart_view_cart ?>"><?php echo $dict_cart_view_cart ?></a><a href="<?php echo site_url('checkout') ?>" class="btn btn-fill-out checkout" title="Checkout">Checkout</a></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>


<?php echo $content ?>


<footer class="footer_dark">
	<div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                	<div class="widget">
                        <div class="footer_logo">
                            <a href="<?php echo site_url() ?>" title="Logo"><img src="<?php echo base_url() ?>assets/template_front/images/logo_light.png" alt="logo ud fantasy"/></a>
                        </div>
                        <p><?php echo $dict_footer_title_1 ?></p>
                    </div>
                    <div class="widget">
                        <ul class="social_icons social_white">
                            <?php if (!empty($facebook_link)) { ?>
                            <li><a href="<?php echo $facebook_link ?>" title="Facebook"><i class="ion-social-facebook"></i></a></li>
                            <?php } ?>

                            <?php if (!empty($twitter_link)) { ?>
                            <li><a href="<?php echo $twitter_link ?>" title="Twitter"><i class="ion-social-twitter"></i></a></li>
                            <?php } ?>

                            <?php if (!empty($youtube_link)) { ?>
                            <li><a href="<?php echo $youtube_link ?>" title="Youtube"><i class="ion-social-youtube-outline"></i></a></li>
                            <?php } ?>

                            <?php if (!empty($instagram_link)) { ?>
                            <li><a href="<?php echo $instagram_link ?>" title="Instagram"><i class="ion-social-instagram-outline"></i></a></li>
                            <?php } ?>

                        </ul>
                    </div>
        		</div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                	<div class="widget">
                        <h6 class="widget_title"><?php echo $dict_footer_title_2 ?></h6>
                        <ul class="widget_links">
                            <li><a href="<?php echo site_url() ?>" title="<?php echo $home->title_menu; ?>"><?php echo $home->title_menu; ?></a></li>
                            <li><a href="<?php echo site_url('produk') ?>" title="<?php echo $shop->title_menu; ?>"><?php echo $shop->title_menu; ?></a></li>
                            <li><a href="<?php echo site_url('syarat-ketentuan') ?>" title="<?php echo $terms_condition->title_menu; ?>"><?php echo $terms_condition->title_menu; ?></a></li>
                            <li><a href="<?php echo site_url('frequently-asked-question') ?>" title="<?php echo $faq->title_menu; ?>"><?php echo $faq->title_menu; ?></a></li>
                            <li><a href="<?php echo site_url('about-us') ?>" title="<?php echo $about_us->title_menu; ?>"><?php echo $about_us->title_menu; ?></a></li>
                            <li><a href="<?php echo site_url('contact-us') ?>" title="<?php echo $contact_us->title_menu; ?>"><?php echo $contact_us->title_menu; ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                	<div class="widget">
                        <h6 class="widget_title"><?php echo $dict_footer_title_3 ?></h6>
                        <ul class="contact_info contact_info_light">
                            <?php if (!empty($contact_info['address'])) { ?>
                            <li>
                                <i class="ti-location-pin"></i>
                                <p><a href="<?php echo $contact_info['address_link'] ?>" title="Address"><?php echo $contact_info['address'] ?></a></p>
                            </li>
                            <?php } ?>

                            <?php if (!empty($contact_info['email'])) { ?>
                            <li>
                                <i class="ti-email"></i>
                                <a href="<?php echo $contact_info['email_link'] ?>" title="Email"><?php echo $contact_info['email'] ?></a>
                            </li>
                            <?php } ?>

                            <?php if (!empty($contact_info['phone'])) { ?>
                            <li>
                                <i class="ti-mobile"></i>
                                <p><a href="<?php echo $contact_info['phone_link'] ?>" title="Phone"><?php echo $contact_info['phone'] ?></a></p>
                            </li>
                            <?php } ?>

                            <?php if (!empty($contact_info['whatsapp'])) { ?>
                            <li>
                                <i class="ion-social-whatsapp"></i>
                                <p><a href="<?php echo $contact_info['whatsapp_link'] ?>" title="Whatsapp"><?php echo $contact_info['whatsapp'] ?></a></p>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer border-top-tran">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-md-0 text-center text-md-left">© <?php echo date('Y') ?> All Rights Reserved by <a href="redsystem.id" title="Developed by Redsystem">Redsystem</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>


<div class="modal fade" id="shop-modal" tabindex="-1" role="dialog" aria-labelledby="shop-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header categories_btn">
                <h4 class="modal-title text-white" id="myModalLabel">Add Item To Cart</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row vcenter">
                    <div class="col-sm-4 col-xs-4 shop-modal-img">
                        <img src="" alt="image description" class="img-responsive">
                    </div>
                    <div class="col-sm-8 col-xs-8 shop-modal-text">
                        <div class="pr_detail">
                            <div class="product_description">
                                <h4 class="product_title shop-modal-title"><?php echo $info_products->title; ?></h4>
                                <div class="product_price">
                                    <span class="price shop-modal-price">Rp. <?php echo $this->main->format_money($info_products->promotion_price); ?></span>
                                    <del class="shop-modal-del">Rp. <?php echo $this->main->format_money($info_products->price); ?></del>
                                    <div class="on_sale">
                                        <span class="shop-modal-on-sale"><?php echo $this->main->count_discount($info_products->price, $info_products->promotion_price); ?>% Off</span>
                                    </div>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate shop-modal-product-rate"></div>
                                    </div>
                                    <span class="rating_num shop-modal-product-rate-num">()</span>
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
                                    <button class="btn btn-fill-out btn-addtocart shop-cart shop-modal-data-id" data-id="<?php echo $info_products->id; ?>" type="button"><i class="icon-basket-loaded"></i> <?php echo $dict_add_to_cart; ?></button>
                                </div>
                            </div>
                            <hr/>
                            <ul class="product-meta">
                                <li class="shop-modal-sku">SKU: <?php echo $info_products->sku ?></li>
                                <li><?php echo $dict_category ?>: <a href="" class="shop-modal-category"></a></li>
                            </ul>

                            <div class="product_share">
                                <span><?php echo $dict_share; ?>:</span>
                                <ul class="social_icons">
                                    <li><a href="<?php echo $this->main->share_link('facebook', $info_products->title, site_url('produk/'.$info_products->category_slug.'/'.$info_products->sub_category_slug.'/'.$info_products->slug)) ?>" title="Facebook Share"><i class="ion-social-facebook"></i></a></li>
                                    <li><a href="<?php echo $this->main->share_link('twitter', $info_products->title, site_url('produk/'.$info_products->category_slug.'/'.$info_products->sub_category_slug.'/'.$info_products->slug)) ?>" title="Twitter Share"><i class="ion-social-twitter"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="#" class="scrollup" title="Scroll Up"><i class="ion-ios-arrow-up"></i></a>


<script src="<?php echo base_url() ?>js/fantasy-online.min.js"></script>
</body>
</html>