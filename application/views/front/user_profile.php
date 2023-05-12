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
                    <li class="breadcrumb-item"><a href="<?php echo site_url() ?>" title="<?php echo $home->title ?>"><?php echo $home->title ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $page->title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="main_content">

    <div class="section small_pb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="heading_tab_header">
                        <div class="heading_s2">
                            <h2><?php echo $member->name; ?></h2>
                        </div>
                        <div class="tab-style3">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#tabmenubar" aria-expanded="false">
                                <span class="ion-android-menu"></span>
                            </button>
                            <ul class="nav nav-tabs justify-content-center justify-content-md-end" id="tabmenubar" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="biodata-tab" data-toggle="tab" href="#biodata" role="tab" aria-controls="biodata" aria-selected="false" title="<?php echo $dict_user_tab_bio ?>"><?php echo $dict_user_tab_bio ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="alamat-tab" data-toggle="tab" href="#alamat" role="tab" aria-controls="alamat" aria-selected="false" title="<?php echo $dict_user_tab_address ?>"><?php echo $dict_user_tab_address ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="transaksi-tab" data-toggle="tab" href="#transaksi" role="tab" aria-controls="transaksi" aria-selected="false" title="<?php echo $dict_user_tab_transaction ?>"><?php echo $dict_user_tab_transaction ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content shop_info_tab">
                        <div class="tab-pane fade show active auto-filled-form" id="biodata" role="tabpanel" aria-labelledby="biodata-tab">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="row shop_container list">
                                        <div class="col-md-4 col-6">
                                            <div class="product">
                                                <div class="product_img">
                                                    <a href="shop-product-detail.html" title="User Photo">
                                                        <?php if (!empty($member->user_photo)) { ?>
                                                            <img src="<?php echo $this->main->image_preview_url($member->user_photo) ?>" alt="user_photo">
                                                        <?php } else { ?>
                                                            <img src="<?php echo base_url() ?>assets/template_front/images/blank-picture-holder.png" alt="product_img1">
                                                        <?php } ?>
                                                    </a>
                                                </div>
                                                <div class="product_info">
                                                    <h6 class="product_title"><?php echo $dict_user_bio; ?></h6>
                                                    <div class="pr_desc">
                                                        <table class="table">
                                                            <tr>
                                                                <td colspan="4"><strong><?php echo $dict_user_name ?></strong></td>
                                                                <td colspan="7"><?php echo $member->name ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4"><strong>Email</strong></td>
                                                                <td colspan="7"><?php echo $member->email ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4"><strong>Telephone</strong></td>
                                                                <td colspan="7"><?php echo $member->phone ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="hide auto-filled-data"><?php echo json_encode($member); ?></div>
                                                    <a href="javascript:();" data-modal="change-bio" class="btn btn-fill-out btn-sm mt-5 auto-edit-button" title="<?php echo $dict_user_change_bio ?>"><?php echo $dict_user_change_bio ?></a>
                                                    <a href="<?php echo site_url('user-profile/send-reset-password/'.$member->id); ?>" class="btn btn-line-fill btn-sm mt-5 process-link"
                                                       data-validate="true" data-validate-message="Apakah anda yakin ingin mengubah password?" title="<?php echo $dict_user_change_pass ?>"><?php echo $dict_user_change_pass ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                            <div class="col-lg-12">
                                <a href="javascript:();" class="btn btn-fill-out m-bot-30 float-left" data-toggle="modal" data-target="#add-address" title="<?php echo $dict_user_button_add_address ?>"><i class="fa fa-plus"></i> <?php echo $dict_user_button_add_address ?></a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th><?php echo $dict_user_data_receiver ?></th>
                                            <th><?php echo $dict_user_data_address ?></th>
                                            <th><?php echo $dict_user_data_area ?></th>
                                            <th><?php echo $dict_user_data_action ?></th>
                                        </tr>
                                        <?php
                                        $count = 0;
                                        foreach ($member_address as $address) {
                                            $count++;
                                        ?>
                                            <tr data-address="<?php echo $address->id ?>">
                                                <td class="hide"><?php echo json_encode($address); ?></td>
                                                <td><?php echo $count ?></td>
                                                <td><span><strong><?php echo $address->receiver_name ?></strong></span> <p><?php echo $address->phone ?></p></td>
                                                <td><span><strong><?php echo $address->address_name ?></strong></span> <p><?php echo $address->address ?></p></td>
                                                <td><p><?php echo $address->province_name ?>, <?php echo $address->district_name ?>, <?php echo $address->postcode ?></p></td>
                                                <td width="220px">
                                                    <a href="javascript:(0);" class="edit-address" title="<?php echo $dict_user_button_edit_address ?>"><button type="button" class="btn btn-info btn-sm"><?php echo $dict_user_button_edit_address ?></button></a>
                                                    <a href="javascript:(0);" class="align-self-center delete-address ml-2" data-address="<?php echo $address->id ?>" title="<?php echo $dict_user_button_delete_address ?>"><button type="button" class="btn btn-fill-out btn-sm"><?php echo $dict_user_button_delete_address ?></button></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="transaksi" role="tabpanel" aria-labelledby="transaksi-tab">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="row shop_container list">
                                        <div class="col-md-4 col-6">
                                            <?php
                                            foreach ($data_checkout as $checkout) {
                                            ?>
                                                <div class="product">
                                                    <div class="top-info m-2">
                                                        <span class="float-left m-2"><?php echo date('d-m-Y', strtotime($checkout->created_at)) ?></span>
                                                        <span class="float-right m-2"><?php echo $checkout->invoice ?></span>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <hr class="mt-0">
                                                    <div class="transaction-detail">
                                                        <img src="<?php echo $this->main->image_preview_url($checkout_item[$checkout->id][0]->thumbnail) ?>" alt="<?php echo $checkout_item[$checkout->id][0]->thumbnail_alt ?>">
                                                        <div class="transaction_status">
                                                            <div class="status_content">
                                                                <span><strong><?php echo $dict_user_data_order_status ?></strong></span>
                                                                <p><?php echo ucfirst($checkout->status) ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="transaction_product">
                                                            <div class="status_content">
                                                                <span>
                                                                    <strong>
                                                                        <?php if (!empty($checkout_item[$checkout->id][0]->sub_category_slug)) { ?>
                                                                            <a href="<?php echo site_url('produk/'.$checkout_item[$checkout->id][0]->category_slug.'/'.$checkout_item[$checkout->id][0]->sub_category_slug.'/'.$checkout_item[$checkout->id][0]->slug) ?>" class="text-red" title="<?php echo $checkout_item[$checkout->id][0]->name_product; ?>"><?php echo $checkout_item[$checkout->id][0]->name_product; ?></a>
                                                                        <?php } else { ?>
                                                                            <a href="<?php echo site_url('produk/'.$checkout_item[$checkout->id][0]->category_slug.'/'.$checkout_item[$checkout->id][0]->slug) ?>" class="text-red" title="<?php echo $checkout_item[$checkout->id][0]->name_product; ?>"><?php echo $checkout_item[$checkout->id][0]->name_product; ?></a>
                                                                        <?php } ?>
                                                                    </strong>
                                                                </span>
                                                                <p>
                                                                    <?php if (!empty($checkout_item[$checkout->id][0]->sub_category_slug)) { ?>
                                                                        <a href="<?php echo site_url('produk/'.$checkout_item[$checkout->id][0]->category_slug.'/'.$checkout_item[$checkout->id][0]->sub_category_slug.'/'.$checkout_item[$checkout->id][0]->slug) ?>" class="mr-2 text-red" title="Harga Produk">Rp. <?php  echo $this->main->format_money($checkout_item[$checkout->id][0]->price_product); ?></a> x <?php echo $checkout_item[$checkout->id][0]->qty_product; ?> Produk
                                                                    <?php } else { ?>
                                                                        <a href="<?php echo site_url('produk/'.$checkout_item[$checkout->id][0]->category_slug.'/'.$checkout_item[$checkout->id][0]->slug) ?>" class="mr-2 text-red" title="Harga Produk">Rp. <?php  echo $this->main->format_money($checkout_item[$checkout->id][0]->price_product); ?></a> x <?php echo $checkout_item[$checkout->id][0]->qty_product; ?> Produk
                                                                    <?php } ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="transaction_total">
                                                            <div class="status_content">
                                                                <span><strong><?php echo $dict_user_data_total ?></strong></span>
                                                                <p>Rp. <?php echo $this->main->format_money($checkout_item[$checkout->id][0]->subtotal_product); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <hr class="mt-0">
                                                    <div class="transaction_button mb-3">
                                                        <div class="hide data_checkout"><?php echo json_encode($checkout) ?></div>
                                                        <div class="hide data_checkout_item"><?php echo json_encode($checkout_item[$checkout->id]) ?></div>
                                                        <a href="javascript:();" data-toggle="modal" data-target="#detail-transaction" class="btn btn-border-fill btn-sm ml-3 detail-transaction" data-invoice="<?php echo $checkout->invoice ?>" title="<?php echo $dict_user_button_detail_transaction ?>"><?php echo $dict_user_button_detail_transaction ?></a>
                                                        <?php if ($checkout->status == 'dibayarkan') { ?>
                                                            <a href="<?php echo site_url('produk/cancel-order/'.$checkout->id) ?>" class="btn btn-border-fill btn-sm ml-3 process-link" data-validate="true" data-validate-message="Apakah kamu yakin akan membatalkan pesanan?" title="<?php echo $dict_user_button_cancel_order ?>"><?php echo $dict_user_button_cancel_order ?></a>
                                                        <?php } else if ($checkout->status == 'menunggu pembayaran') { ?>
                                                            <a href="javascript:();" class="btn btn-fill-out btn-sm ml-3 upload-proof" data-invoice="<?php echo $checkout->invoice ?>" title="<?php echo $dict_user_button_upload_transaction ?>"><?php echo $dict_user_button_upload_transaction ?></a>
                                                            <a href="<?php echo site_url('produk/checkout-payment/'.$checkout->id) ?>" class="btn btn-fill-out btn-sm ml-3" data-invoice="<?php echo $checkout->invoice ?>" title="<?php echo $dict_user_button_checkout_payment ?>"><?php echo $dict_user_button_checkout_payment ?></a>
                                                            <a href="<?php echo site_url('produk/cancel-order/'.$checkout->id) ?>" class="btn btn-border-fill btn-sm ml-3 process-link" data-validate="true" data-validate-message="Apakah kamu yakin akan membatalkan pesanan?" title="<?php echo $dict_user_button_cancel_order ?>"><?php echo $dict_user_button_cancel_order ?></a>
                                                        <?php } else if ($checkout->status == 'barang dikirim') { ?>
                                                            <a href="<?php echo site_url('produk/accept-order/'.$checkout->id) ?>" class="btn btn-border-fill btn-sm ml-3 process-link" data-validate="true" data-validate-message="Apakah benar pesanan kamu telah kamu terima?" title="<?php echo $dict_user_button_accept_order ?>"><?php echo $dict_user_button_accept_order ?></a>
                                                        <?php } ?>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade user-modal" id="change-bio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title margin-0-auto"><?php echo $dict_user_modal_bio_title ?></h5>
                <button type="button" class="custom-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url('user-profile/biodata/update')?>" class="form-send" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="bioUserPhoto"><?php echo $dict_user_modal_bio_photo ?> *</label>
                        <br>
                        <img src="" class="img-thumbnail" width="200">
                        <br /><br />
                        <div class="custom-file">
                            <input type="file" class="custom-file-input browse-preview-img" accept="image/*" name="user_photo" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <small id="userPhotoAddNameHelp" class="form-text text-muted"><?php echo $dict_user_modal_bio_photo_info ?></small>
                    </div>
                    <div class="form-group">
                        <label for="bioUserNama"><?php echo $dict_user_name ?> *</label>
                        <input type="text" name="name" class="form-control" id="bioUserNama" placeholder="">
                        <input type="hidden" name="hash">
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-6">
                                <label for="bioUserPhone">Telephone *</label>
                                <input type="text" name="phone" class="form-control" id="bioUserPhone" placeholder="">
                            </div>
                            <div class="col-6">
                                <label for="bioUserEmail">Email *</label>
                                <input type="email" name="email" class="form-control" id="bioUserEmail" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-fill-line modal-close" data-dismiss="modal"><?php echo $dict_user_button_cancel ?></button>
                        <button type="submit" class="btn btn-fill-out submit-btn"><?php echo $dict_user_button_change ?></button>
                    </div>
                </form>
            </div>
    	</div>
    </div>
</div>

<div class="modal fade user-modal" id="change-password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title margin-0-auto"><?php echo $dict_user_modal_password_title ?></h5>
                <button type="button" class="custom-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url('user-profile/password/') //kurang variabel id User ?>" class="form-send" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6 col-xs-12">
                                <label for="bioPassword"><?php echo $dict_user_modal_password_new ?> *</label>
                                <input type="password" name="password" class="form-control change-password-form" id="bioPassword" placeholder="">
                                <span toggle="#bioPassword" class="fa fa-fw fa-eye field-icon toggle-password">
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <label for="bioPasswordConfirm"><?php echo $dict_user_modal_password_confirm ?> *</label>
                                <input type="password" name="password_confirmation" class="form-control change-password-form" id="bioPasswordConfirm" placeholder="">
                                <span toggle="#bioPasswordConfirm" class="fa fa-fw fa-eye field-icon toggle-password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-fill-line modal-close" data-dismiss="modal"><?php echo $dict_user_button_cancel ?></button>
                        <button type="submit" class="btn btn-fill-out"><?php echo $dict_user_button_change ?></button>
                    </div>
                </form>
            </div>
    	</div>
    </div>
</div>

<div class="modal fade user-modal" id="add-address" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title margin-0-auto"><?php echo $dict_user_modal_address_title ?></h5>
                <button type="button" class="custom-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url('user-profile/address/add') ?>" class="form-send" method="post">
                    <div class="form-group">
                        <label for="addressAddName"><?php echo $dict_user_modal_address_name ?> *</label>
                        <input type="text" name="address_name" class="form-control" id="addressAddName" aria-describedby="addressAddNameHelp" placeholder="">
                        <small id="addressAddNameHelp" class="form-text text-muted"><?php echo $dict_user_modal_address_name_info ?></small>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-7">
                                <label for="addressAddReceiver"><?php echo $dict_checkout_form_name ?> *</label>
                                <input type="text" name="receiver_name" class="form-control" id="addressAddReceiver" placeholder="">
                                <input type="hidden" name="id_member" value="<?php echo $member->id ?>">
                            </div>
                            <div class="col-5">
                                <label for="addressAddPhone"><?php echo $dict_checkout_form_phone ?> *</label>
                                <input type="text" name="phone" class="form-control" id="addressAddPhone" aria-describedby="addressAddPhoneHelp" placeholder="">
                                <small id="addressAddPhoneHelp" class="form-text text-muted"><?php echo $dict_user_modal_address_phone_info ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-7">
                                <label for="addressAddCity"><?php echo $dict_checkout_form_city ?> *</label>
                                <select name="id_district" id="" class="form-control input-select2" style="width: 100%;">
                                    <option value=""><?php echo $checkout_form_city ?></option>
                                    <?php
                                    foreach ($districts as $district) {
                                    ?>
                                        <option value="<?php echo $district->id ?>"><?php echo $district->name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
<!--                                <input type="text" name="city" class="form-control" id="addressAddCity" aria-describedby="addressAddCityHelp" placeholder="">-->
                            </div>
                            <div class="col-5">
                                <label for="addressAddPos"><?php echo $dict_checkout_form_pos ?> *</label>
                                <input type="text" name="postcode" class="form-control" id="addressAddPos" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addressAddAddress"><?php echo $dict_checkout_form_address ?> *</label>
                        <textarea type="text" name="address" class="form-control resize-none h-100" id="addressAddAddress" aria-describedby="addressAddAddressHelp" placeholder=""></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-fill-line modal-close" data-dismiss="modal"><?php echo $dict_user_button_cancel ?></button>
                        <button type="submit" class="btn btn-fill-out submit-btn"><?php echo $dict_user_button_add ?></button>
                    </div>
                </form>
            </div>
    	</div>
    </div>
</div>

<div class="modal fade user-modal" id="edit-address" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="<?php echo site_url('user-profile/address/edit') ?>" class="form-send" method="post">
                    <div class="form-group">
                        <label for="addressAddName"><?php echo $dict_user_modal_address_name ?> *</label>
                        <input type="text" name="address_name" class="form-control" id="addressAddName" aria-describedby="addressAddNameHelp" placeholder="">
                        <small id="addressAddNameHelp" class="form-text text-muted"><?php echo $dict_user_modal_address_name_info ?></small>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-7">
                                <label for="addressAddReceiver"><?php echo $dict_checkout_form_name ?></label>
                                <input type="text" name="receiver_name" class="form-control" id="addressAddReceiver" placeholder="">
                                <input type="hidden" name="id_member">
                                <input type="hidden" name="id">
                            </div>
                            <div class="col-5">
                                <label for="addressAddPhone"><?php echo $dict_checkout_form_phone ?> *</label>
                                <input type="text" name="phone" class="form-control" id="addressAddPhone" aria-describedby="addressAddPhoneHelp" placeholder="">
                                <small id="addressAddPhoneHelp" class="form-text text-muted"><?php echo $dict_user_modal_address_phone_info ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-7">
                                <label for="addressAddCity"><?php echo $dict_checkout_form_city ?> *</label>
                                <select name="id_district" id="" class="form-control input-select2" style="width: 100%;">
                                    <option value=""><?php echo $checkout_form_city ?></option>
                                    <?php
                                    foreach ($districts as $district) {
                                    ?>
                                        <option value="<?php echo $district->id ?>"><?php echo $district->name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-5">
                                <label for="addressAddPos"><?php echo $dict_checkout_form_pos ?> *</label>
                                <input type="text" name="postcode" class="form-control" id="addressAddPos" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addressAddAddress"><?php echo $dict_checkout_form_address ?> *</label>
                        <textarea type="text" name="address" class="form-control resize-none h-100" id="addressAddAddress" aria-describedby="addressAddAddressHelp" placeholder=""></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-fill-line modal-close" data-dismiss="modal"><?php echo $dict_user_button_cancel ?></button>
                        <button type="submit" class="btn btn-fill-out submit-btn"><?php echo $dict_user_button_change ?></button>
                    </div>
                </form>
            </div>
    	</div>
    </div>
</div>

<div class="modal fade user-modal" id="detail-transaction" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title margin-0-auto"><?php echo $dict_user_modal_transaction_title ?></h5>
                <button type="button" class="custom-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="100px"><strong><?php echo $dict_user_modal_transaction_invoice ?></strong></td>
                                    <td class="data_invoice"></td>
                                </tr>
                                <tr>
                                    <td width="100px"><strong><?php echo $dict_user_modal_transaction_receiver ?></strong></td>
                                    <td class="data_name"></td>
                                </tr>
                                <tr>
                                    <td width="100px"><strong><?php echo $dict_user_modal_transaction_status ?></strong></td>
                                    <td class="data_status text-capitalize"></td>
                                </tr>
                                <tr>
                                    <td width="100px"><strong><?php echo $dict_user_modal_transaction_date ?></strong></td>
                                    <td class="data_created_at_formatted"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-list-item">
                            <tbody>
                                <tr>
                                    <td width="100px"><strong><?php echo $dict_user_modal_transaction_address ?></strong></td>
                                    <td class="data_address"></td>
                                </tr>
                                <tr>
                                    <td width="100px"><strong><?php echo $dict_user_modal_transaction_area ?></strong></td>
                                    <td><span class="data_province_name"></span>, <span class="data_district_name"></span> <span class="data_postcode"></span></td>
                                </tr>
                                <tr>
                                    <td width="100px"><strong><?php echo $dict_user_modal_transaction_phone ?></strong></td>
                                    <td class="data_phone"></td>
                                </tr>
                                <tr>
                                    <td width="100px"><strong><?php echo $dict_user_modal_transaction_expired_date ?></strong></td>
                                    <td class="data_expired_date"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th><?php echo $dict_user_modal_transaction_product ?></th>
                                    <th><?php echo $dict_user_modal_transaction_price ?></th>
                                </tr>
                            </thead>
                            <tbody class="product_list">
                                <tr class="transaction_list_product hide">
                                    <td>
                                        <img class="data_thumbnail data_thumbnail_alt" src="" alt="">
                                        <div class="float-left">
                                            <span><a href="javascript:();" class="text-red data_name_product data_slug"></a> <br>Rp. <span class="data_price_product"></span> x <span class="data_qty_product"></span></span>
                                        </div>
                                    </td>
                                    <td>Rp. <span class="data_subtotal_product"></span></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Subtotal</td>
                                    <td>RP. <span class="data_subtotal"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo $dict_user_modal_transaction_ship_cost ?></td>
                                    <td>Rp. <span class="data_shipping_price"></span></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>Rp. <span class="data_total"></span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row hide mt-4 btn-transaction">
                    <div class="col-md-6 col-xs-12 mb-3 text-center btn-checkout-payment">
                        <a href="" class="btn btn-fill-out" title="<?php echo $dict_user_button_checkout_payment ?>"><?php echo $dict_user_button_checkout_payment ?></a>
                    </div>
                    <div class="col-md-6 col-xs-12 text-center btn-cancel-order">
                        <a href="" class="btn btn-border-fill process-link" data-validate="true" data-validate-message="Apakah kamu yakin akan membatalkan pesanan?" title="<?php echo $dict_user_button_cancel_order ?>"><?php echo $dict_user_button_cancel_order ?></a>
                    </div>
                    <div class="col-md-6 col-xs-12 text-center btn-accept-order">
                        <a href="" class="btn btn-border-fill process-link" data-validate="true" data-validate-message="Apakah benar pesanan kamu telah kamu terima?" title="<?php echo $dict_user_button_accept_order ?>"><?php echo $dict_user_button_accept_order ?></a>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>

<div class="modal fade user-modal" id="upload-proof" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="<?php echo site_url('user_transaction/upload') ?>" class="form-send" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="exampleSelect1"><?php echo $dict_user_modal_transaction_upload ?></label>
						<br />
						<img src="" class="img-thumbnail" width="200">
						<br /><br />
						<div class="custom-file">
							<input type="file" class="custom-file-input browse-preview-img" accept="image/*" name="payment_proof" id="customFile">
                            <input type="hidden" name="invoice">
                            <input type="hidden" name="user" value="<?php echo $member->hash; ?>">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						<small id="proofPhotoAddNameHelp" class="form-text text-muted"><?php echo $dict_user_modal_bio_photo_info ?></small>
					</div>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-fill-line modal-close" data-dismiss="modal"><?php echo $dict_user_button_cancel ?></button>
                        <button type="submit" class="btn btn-fill-out submit-btn"><?php echo $dict_user_button_upload_transaction ?></button>
                    </div>
                </form>
            </div>
    	</div>
    </div>
</div>