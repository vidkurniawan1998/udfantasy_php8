$(document).ready(function () {

    var base_url = $('#base_url').html();
    var site_url = $('#site_url').html();
    var lang_code = $('#lang_code').html();

    update_total_items();

    var select2_placeholder = '';
    if (lang_code === 'en') {
        select2_placeholder = 'Select an option';
    } else if (lang_code === 'id') {
        select2_placeholder = 'Pilih Opsi';
    }
    $('.input-select2').select2({
        placeholder : select2_placeholder
    });

    $('.form-send').submit(function (e) {
        e.preventDefault();

        $('.preloader').hide().removeClass('hide').fadeIn('fast').removeClass('loaded');
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (json) {
                $('.preloader').fadeOut('fast').addClass('hide').addClass('loaded');
                var data = JSON.parse(json);
                $('.form-group').removeClass('validated');
                $('.invalid-feedback').remove();
                $('.form-control').removeClass('is-invalid');
                if (data.status === 'error') {
                    swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: data.message,
                    });

                    $.each(data.errors, function (field, message) {
                        if (message) {
                            $('[name=' + field + ']').parents('.form-group').addClass('validated');
                            $('[name=' + field + ']').after('<div class="invalid-feedback">' + message + '</div>');
                            $('[name=' + field + ']').addClass('is-invalid');
                        }
                    });
                } else if (data.status == 'success') {
                    if (!isEmpty(data.no_swal) && data.no_swal === 'true' && !isEmpty(data.redirect)) {
                        window.location = site_url + data.redirect;
                    } else if(!isEmpty(data.no_swal) && data.no_swal === 'false' && isEmpty(data.redirect)) {
                        window.location.reload();
                    } else if (!isEmpty(data.reloadPage)) {
                        swal.fire({
                            title: data.title,
                            text: data.message,
                            icon: 'success',
                        }).then(function () {
                            window.location.reload();
                        });
                    } else if (isEmpty(data.redirect)){
                        Swal.fire({
                             title: data.title,
                             text: data.message,
                             icon: data.status
                        });
                    } else {
                        Swal.fire({
                             title: data.title,
                             text: data.message,
                             icon: data.status
                         })
                        .then(function () {
                            window.location = site_url + data.redirect;
                        });
                    }
                } else {
                    swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Something Wrong!',
                    });
                }
            }
        });

        return false;
    });

    $('body').on('click', '.process-link', function (e) {
        e.preventDefault();

        var href = $(this).attr('href');
        var data_validate = $(this).attr('data-validate');

        if ($('.modal').hasClass('show')) {
            $('.modal').modal('hide');
        }

        if (!isEmpty(data_validate)) {
            var data_validate_message = $(this).attr('data-validate-message');
            swal.fire({
            title: 'Anda Yakin?',
            text: data_validate_message,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
            }).then(function (result) {
                if (result.value) {
                    this.ajax_get(href);
                } else if (result.dismiss === 'cancel') {
                    swal.fire(
                        'Canceled',
                        'Aksi dibatalkan!',
                        'error'
                    );
                }
            });
        }
    });

    $('.star_rating').on('click', 'span', function(e) {
        e.preventDefault();
        var star_value = $(this).data('value');
        var percentage_rating = 20 * star_value;

        $(this).parents('form').find('input[name="rating"]').val(percentage_rating);
    });

    $('.shop-cart').click(function(){
        var id = $(this).attr('data-id');
        var qty = $(this).parents('.cart_extra').find('input[name="qty"]').val() ? $(this).parents('.cart_extra').find('input[name="qty"]').val() : 1;
        $('.preloader').hide().removeClass('hide').fadeIn('fast').removeClass('loaded');
        $.ajax({
            url: site_url + 'produk/cart/' + id + '/' + qty,
            type: 'POST',
            error: function() {
                $('.preloader').fadeOut('fast').addClass('hide').addClass('loaded');
                console.log('Something is wrong');
             },
            success: function(data) {
                $('.preloader').fadeOut('fast').addClass('hide').addClass('loaded');
                data = JSON.parse(data);
                 if (data.response == 'false'){
                     Swal.fire({
                         title: 'Warning!',
                         text: 'Failed to add item into cart!',
                         icon: 'warning'
                     });
                 } else {
                     Swal.fire({
                         title: 'Success',
                         text: 'Item added to cart!',
                         icon: 'success'
                     });
                    $('.cart_dropdown').find('.cart_count').html(data.total_items);

                    var count = $('.cart_dropdown').children('.cart_box').children('.cart_list').children('li').length;
                    var list_cart_item = $('.cart_dropdown').children('.cart_box').children('.cart_list');
                    var subtotal = data.qty * data.item.price;
                    if (data.is_new == 'yes'){
                        list_cart_item.children('li:first-child').clone().appendTo('.cart_list').attr('data-rowid',data.rowid).removeAttr('class').attr('class', 'item-'+count+' row-'+data.rowid);
                    }

                    list_cart_item.children('.row-'+data.rowid).children('.cart-info').attr('href', site_url+'produk/'+data.item.category_slug+'/'+data.item.sub_category_slug+'/'+data.item.slug).attr('title', data.item.slug).children('.cart-title').html(data.item.title);
                    list_cart_item.children('.row-'+data.rowid).children('.cart_quantity').html(data.qty+' x Rp. '+addCommas(data.item.price));
                    list_cart_item.children('.row-'+data.rowid).children('.cart-info').find('img').attr('src', base_url+'upload/images/'+data.item.thumbnail);
                    list_cart_item.children('.row-'+data.rowid).children('.cart-info').find('img').attr('alt', data.item.thumbnail_alt);
                    list_cart_item.siblings('.cart_footer').find('.cart_total').html('<strong>Subtotal</strong> Rp. '+addCommas(data.total_price));
                 }
             }
        });
    });

    $('.cart_box').on('click', '.item_remove', function () {
        var self = $(this);
        var rowid = self.parents('li').data('rowid');
        var num = parseInt($(this).parents('.cart_dropdown').find('.cart_count').html());
        swal.fire({
            title: 'Are you sure?',
            text: "You want to remove this item from the cart?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: site_url + 'produk/cart-remove-row/' + rowid,
                    type: 'POST',
                    success: function (e) {
                        $('.row-'+rowid).remove();
                        num--;
                        $('.cart_count').html(num);
                        $('.cart_total').html('<strong>Subtotal</strong> Rp. '+addCommas(e));
                        swal.fire(
                        	'Success!',
                        	'Item has been removed',
                        	'success'
                        )
                    }
                });
            } else if (result.dismiss === 'cancel') {
                swal.fire(
                    'Canceled',
                    'item not removed',
                    'error'
                );
            }
        });
    });

    $('.cart-update').on('click', '.plus, .minus', function(){
        var direction = this.defaultValue < this.value;
        this.defaultValue = this.value;

        var qty = 0;
        if ($(this).hasClass('plus')) {
            qty = parseInt($(this).prev().val());
        } else {
            qty = parseInt($(this).next().val());
        }
        var price = parseInt($(this).parent().siblings('.update-price').val());
        var new_subtotal = price * qty;
        var total = parseInt($(this).parents('.shopping-cart').find('#total-price').html());
        var new_total = 0;
        var input_length = $('.update-qty').length;

        for (var i=0;i<input_length;i++) {
            var item_qty = $('.item-'+i).find('.update-qty').val();
            var price_qty = $('.item-'+i).find('.update-price').val();
            var multiple = item_qty * price_qty;
            new_total += multiple;
        }

        $(this).parents('tr').find('.product-subtotal').html('Rp. '+addCommas(new_subtotal));
        $(this).parents('.container').find('.cart_total_amount').html('<strong> Rp. '+addCommas(new_total)+'</strong>');
        $('.row-'+$(this).parent().siblings('.update-rowid').val()).children('.cart_quantity').html(qty+' x Rp. '+addCommas(price));
        $('.cart-price').html('Rp. '+addCommas(new_total));
    });

    $('.cart-update').on('click', '.product-remove', function(){
        var self = $(this);
        var rowid = self.parent('tr').find('.update-rowid').val();
        var num = parseInt($('.cart_dropdown').find('.cart_count').html());
        swal.fire({
            title: 'Are you sure?',
            text: "You want to remove this item from the cart?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: site_url + 'produk/cart-remove-row/' + rowid,
                    type: 'POST',
                    success: function (e) {
                        $('.row-'+rowid).remove();
                        num--;
                        $('.cart_dropdown').find('.cart_count').html(num);
                        $('.cart_total').html('<strong>Subtotal</strong> Rp. '+addCommas(e));
                        self.parents('tr').remove();
                        $('.cart_total_amount').html('<strong>Rp. '+addCommas(e)+'</strong>')
                        swal.fire(
                        	'Success!',
                        	'Item has been removed',
                        	'success'
                        )
                    }
                });
            } else if (result.dismiss === 'cancel') {
                swal.fire(
                    'Canceled',
                    'item not removed',
                    'error'
                );
            }
        });
    });

    $('.shop-cart-swal-qty').click(function () {
        var id = $(this).data('id');
        $('#shop-modal').find('.qty').val('1'); //class qty tadi belum ada
        // $('#shop-modal').find('.shop-modal-qty-input').val('1');
        $('.preloader').hide().removeClass('hide').fadeIn('fast').removeClass('loaded');
        $.ajax({
            url: site_url + 'produk/cart-get-item/' + id,
            type: 'POST',
            error: function() {
                console.log('Something is wrong');
             },
            success: function(data) {
                $('.preloader').fadeOut('fast').addClass('hide').addClass('loaded');
                data = JSON.parse(data);
                 if (data.response == 'false'){
                     Swal.fire({
                         title: 'Warning!',
                         text: 'Failed to add item into cart!',
                         icon: 'warning'
                     });
                 } else {
                    var base_div = $('#shop-modal');
                 //   update data

                 console.log('halo');
                     base_div.find('.shop-modal-input-qty').val('1');
                     base_div.find('.shop-modal-qty-input').val('1');
                     base_div.find('.shop-cart').removeAttr('data-id').attr('data-id',id);
                     base_div.find('.shop-modal-img').children('img').attr('src', base_url+'upload/images/'+data.item.thumbnail);
                     base_div.find('.shop-modal-img').children('img').attr('alt', data.item.thumbnail_alt);
                     base_div.find('.shop-modal-title').html(data.item.title);
                     base_div.find('.shop-modal-product-rate').attr('style','width:'+parseInt(data.item.average_rating)+'%;');
                     var count_rating = data.item.count_rating ? data.item.count_rating : 0;
                     base_div.find('.shop-modal-product-rate-num').html('('+ count_rating +')');
                     base_div.find('.shop-modal-data-id').attr('data-id', data.item.id);
                     base_div.find('.shop-modal-sku').html('SKU : '+data.item.sku);
                     base_div.find('.shop-modal-category').html(data.item.category_title);
                     base_div.find('.shop-modal-category').attr('href', site_url + 'produk?category='+ data.item.category_slug);
                     if (data.item.promotion_status === 'yes'){
                         base_div.find('.shop-modal-price').html('Rp. '+ addCommas(data.item.promotion_price));
                         base_div.find('.shop-modal-del').removeClass('hide').html('Rp. '+addCommas(data.item.price));
                         base_div.find('.shop-modal-on-sale').removeClass('hide').html(count_discount(data.item.price, data.item.promotion_price)+'% Off');
                     } else {
                         base_div.find('.shop-modal-price').html('Rp. '+ addCommas(data.item.price));
                         base_div.find('.shop-modal-del').addClass('hide');
                         base_div.find('.shop-modal-on-sale').addClass('hide');
                     }
                     base_div.find('.jcf-number').css('margin', '0');

                     base_div.modal('show');
                 }

             }
        });
    })

    $('#shop-modal').on('click', '.shop-cart', function () {
        $('#shop-modal').modal('hide');
    });

    $('.auto-filled-form').on('click', '.auto-edit-button', function (e) {
        e.preventDefault();
        var self = $(this);
        var data = self.siblings('.auto-filled-data').html();
        var name_modal = self.data('modal');
        var modal = $('#'+name_modal);
        var json = JSON.parse(data);

        $.each(json, function (field, value) {
            switch (field) {
                case 'user_photo' :
                    $('#'+name_modal+' img').attr('src', base_url+'upload/images/'+value);
                    break;
                default :
                    $('#'+name_modal+' [name="'+field+'"]').val(value);
            }
        })

        modal.modal('show');
    })

    $('#alamat').on('click', '.edit-address', function (e) {
        e.preventDefault();
        var self = $(this);
        var data = self.parent().siblings('.hide').html();
        var modal = $('#edit-address');
        var json = JSON.parse(data);

        $.each(json, function (field, value) {
                $('#edit-address [name="'+field+'"]').val(value);
        })

        modal.modal('show');
    });

    $('.user-modal').on('click', '.submit-btn',function () {
        $('.user-modal').modal('hide');
    });

    $('#alamat').on('click', '.delete-address', function (e) {
        e.preventDefault();
        var id = $(this).data('address');
        var swal_title = '';
        var swal_text = '';

        if (lang_code == 'en') {
            swal_title = 'Are you sure?';
            swal_text = 'You want to remove this address?';
        } else if (lang_code == 'id') {
            swal_title = 'Apakah anda yakin?';
            swal_text = 'Anda akan menghapus alamat ini?'
        }

        swal.fire({
            title: swal_title,
            text: swal_text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {
                $('.preloader').hide().removeClass('hide').fadeIn('fast').removeClass('loaded');
                $.ajax({
                    url: site_url + 'user_address/delete_address/' + id,
                    type: 'POST',
                    success: function (e) {
                        e = JSON.parse(e);
                        if (e.response == 'success') {
                            $('.preloader').fadeOut('fast').addClass('hide').addClass('loaded');
                            $('tr[data-address="'+id+'"]').remove();
                            if (lang_code == 'en') {
                                swal.fire({
                                    title: 'Success!',
                                    text: 'Item has been removed',
                                    icon: 'success'
                                }).then(function () {
                                    window.location.reload();
                                })
                            } else if (lang_code == 'id') {
                                swal.fire({
                                    title: 'Sukses!',
                                    text: 'Data telah terhapus',
                                    icon: 'sukses'
                                }).then(function () {
                                    window.location.reload();
                                })
                            }
                        } else {
                            $('.preloader').fadeOut('fast').addClass('hide').addClass('loaded');
                            if (lang_code == 'en') {
                                Swal.fire({
                                    title: 'Warning!',
                                    text: 'Failed to delete address!',
                                    icon: 'warning'
                                }).then(function () {
                                    window.location.reload();
                                });
                            } else if (lang_code == 'id') {
                                Swal.fire({
                                    title: 'Peringatan!',
                                    text: 'Gagal menghapus alamat!',
                                    icon: 'warning'
                                }).then(function () {
                                    window.location.reload();
                                });
                            }
                        }
                    }
                });
            } else if (result.dismiss === 'cancel') {
                $('.preloader').fadeOut('fast').addClass('hide').addClass('loaded');
                if (lang_code == 'en') {
                    Swal.fire({
                        title: 'Canceled',
                        text: 'item not removed',
                        icon: 'error'
                    });
                } else if (lang_code == 'id') {
                    swal.fire({
                        title: 'Batal',
                        text: 'Data tidak dihapus',
                        icon: 'error'
                    });
                }
            }
        });
    });

    $('#transaksi').on('click', '.detail-transaction', function (e) {
        e.preventDefault();
        var self = $(this);
        var data_checkout = self.siblings('.data_checkout').html();
        var data_checkout_item = self.siblings('.data_checkout_item').html();
        var modal = $('#detail-transaction');
        var transaction_list = $('#detail-transaction').find('.product_list');
        var json_checkout = JSON.parse(data_checkout);
        var json_checkout_item = JSON.parse(data_checkout_item);
        var id = 0;
        var subtotal = 0;
        var total = 0;
        var category_slug = '';
        var sub_category_slug = '';
        var slug = '';
        $('.product_list').children().not('tr:first').remove();

        $.each(json_checkout, function (field, value) {
            value = value ? value : 0;

            if (field === 'id') {
                id = value;
            } else if (field === 'shipping_price') {
                total += parseInt(value);
                $('#detail-transaction').find('.data_'+field).html(addCommas(value));
            } else if (field === 'status') {
                if (value === 'menunggu pembayaran') {
                    $('.btn-transaction').removeClass('hide');
                    $('.btn-checkout-payment').find('a').attr('href', site_url+'produk/checkout-payment/'+id);
                    $('.btn-cancel-order').find('a').attr('href', site_url+'produk/cancel-order/'+id);
                    $('.btn-accept-order').addClass('hide');
                } else if (value === 'dibayarkan') {
                    $('.btn-transaction').removeClass('hide');
                    $('.btn-checkout-payment').addClass('hide');
                    $('.btn-accept-order').addClass('hide');
                    $('.btn-cancel-order').find('a').attr('href', site_url+'produk/cancel-order/'+id);
                } else if (value === 'barang dikirim') {
                    $('.btn-transaction').removeClass('hide');
                    $('.btn-checkout-payment').addClass('hide');
                    $('.btn-accept-order').addClass('hide');
                    $('.btn-accept-order').hasClass('hide').removeClass('hide');
                    $('.btn-accept-order').find('a').attr('href', site_url+'produk/accept-order/'+id);
                } else {
                    $('.btn-checkout-payment').addClass('hide');
                    $('.btn-cancel-order').addClass('hide');
                }
                $('#detail-transaction').find('.data_'+field).html(value.replace(/^./, value[0].toUpperCase()));
            } else {
                $('#detail-transaction').find('.data_'+field).html(value);
            }
        })

        $.each(json_checkout_item, function (index, items) {
            category_slug = null;
            sub_category_slug = null;
            $.each(items, function (field, value) {
                switch (field) {
                    case 'id' :
                        id = value;
                        transaction_list.children('tr:first-child').clone().appendTo('.product_list').removeClass('hide').addClass('product_' + value);
                        break;
                    case 'thumbnail' :
                        transaction_list.children('.product_'+id).find('.data_'+field).attr('src',base_url+'upload/images/'+value);
                        break;
                    case 'thumbnail_alt' :
                        transaction_list.children('.product_'+id).find('.data_'+field).attr('alt',value);
                        break;
                    case 'price_product' :
                        transaction_list.children('.product_'+id).find('.data_'+field).html(addCommas(value));
                        break;
                    case 'subtotal_product' :
                        subtotal += parseInt(value);
                        total += parseInt(value);
                        transaction_list.children('.product_'+id).find('.data_'+field).html(addCommas(value));
                        break;
                    case 'category_slug' :
                        category_slug = value;
                        break;
                    case 'sub_category_slug' :
                        sub_category_slug = value;
                        break;
                    case 'slug' :
                        slug = value;
                        break;
                    default :
                        transaction_list.children('.product_'+id).find('.data_'+field).html(value);
                }
                if (!isEmpty(sub_category_slug)) {
                    transaction_list.children('.product_' + id).find('.data_slug').attr('href', site_url + 'produk/' + category_slug + '/' + sub_category_slug + '/' + slug).attr('title', slug);
                } else {
                    transaction_list.children('.product_' + id).find('.data_slug').attr('href', site_url + 'produk/' + category_slug + '/' + slug).attr('title', slug);
                }
            });

            $('#detail-transaction').find('.data_subtotal').html(addCommas(subtotal));
            $('#detail-transaction').find('.data_total').html(addCommas(total));
        })

        modal.modal('show');
    })

    $('#btn-ask-whatsapp').click(function () {
        var data_product_name = $(this).attr('data-product-name'),
            data_product_link = $(this).attr('data-product-link'),
            form_whatsapp = $('#ask-via-whatsapp');

        form_whatsapp.find('input[name="product_name"]').val(data_product_name);
        form_whatsapp.find('input[name="product_link"]').val(data_product_link);
    });

    $('#ask-via-whatsapp').submit(function (e) {
        e.preventDefault();
        var link_wa = $(this).attr('action'),
            name_person = $(this).find('input[name="name"]').val(),
            email_person = $(this).find('input[name="email"]').val(),
            message_person = $(this).find('textarea[name="message"]').val(),
            product_name = $(this).find('input[name="product_name"]').val(),
            product_link = $(this).find('input[name="product_link"]').val();

        var text =  'Nama : ' + name_person + '\n' +
                    'Email : ' + email_person + '\n' +
                    'Nama Produk : ' + product_name + '\n' +
                    'Link Produk : ' + product_link + '\n' +
                    'Pesan : ' + message_person;

        window.open(link_wa+'?text='+encodeURI(text));
    })


    // $('#checktimes').ready(function(){
       
    // })
    window.onload = function(){
        var e = document.getElementById("checktimes");
        if(e !=null){
            $.ajax({
                url: site_url+"Checkout/cek_waktu",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    if(res.status=='tutup')
                    {
                        swal.fire({
                            title: 'Peringatan',
                            text: 'Mohon Maaf Toko Saat Ini Tutup. Jika Anda Melanjutkan Pemesanan, Pemesanan Akan Kami Proses Besok Hari',
                            icon: 'warning',
                        }).then(function(){
                            window.location = site_url + data.redirect;
                        });
                    }
                    if(res.status_libur=='libur')
                    {
                        swal.fire({
                            title: 'Peringatan',
                            text: 'Toko Libur Mulai Dari Tanggal '+ res.tanggal_mulai_libur+' Sampai Tanggal '+ res.tanggal_selesai_libur+' . Pesanan Akan Segera Diproses Setelah Toko Buka ',
                            icon: 'warning',
                        }).then(function(){
                            window.location = site_url + data.redirect;
                        });
                    }
                }
            });
        }
    }
    
    // window.onload = function(){
    //     var e = document.getElementsByClassName("checkdate");
    //     if(e !=null){
    //         $.ajax({
    //             url: site_url+"Checkout/cek_tanggal",
    //             type: 'GET',
    //             dataType: 'json', // added data type
    //             success: function(res) {
    //                 if(res=='tutup')
    //                 {
    //                     swal.fire({
    //                         title: 'Peringatan',
    //                         text: 'Toko Sedang Libur Dari Tanggal',
    //                         icon: 'warning',
    //                     }).then(function(){
    //                         window.location = site_url + data.redirect;
    //                     });
    //                 }
    //             }
    //         });
    //     }
    // }
});


function update_total_items(){
    var site_url = $('#site_url').html();
    $.ajax({
        url: site_url + 'cart/cart_count_items/',
        type: 'GET',
        error: function() {
            console.log('Something is wrong');
         },
        success: function(data) {
            $('.cart_dropdown').find('.cart_count').html(data);
         }
    });

    $('.cart-update').submit(function (e) {
        e.preventDefault();

        $('.preloader').hide().removeClass('hide').fadeIn('fast').removeClass('loaded');
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (json) {
                $('.preloader').fadeOut('fast').addClass('hide').addClass('loaded');
                var data = JSON.parse(json);
                $('.form-group').removeClass('validated');
                $('.invalid-feedback').remove();
                $('.form-control').removeClass('is-invalid');
                if (data.status === 'error') {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: data.message,
                        icon: 'warning'
                    });

                    $.each(data.errors, function (field, message) {
                        if (message) {
                            $('[name=' + field + ']').parents('.form-group').addClass('validated');
                            $('[name=' + field + ']').after('<div class="invalid-feedback">' + message + '</div>');
                            $('[name=' + field + ']').addClass('is-invalid');
                        }
                    });
                } else if (data.status == 'success') {
                    // window.location.reload();
                    Swal.fire({
                         title: data.title,
                         text: data.message,
                         icon: data.status
                    });

                    $.ajax({
                        url: site_url + 'produk/cart-total-price',
                        type: 'GET',
                        success: function(data) {
                            $('#total-price').html(data);
                        }
                    });

                    update_total_items();
                } else {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Something Wrong!',
                    });
                }
            }
        });

        return false;
    });

    $(".browse-preview-img").change(function () {
        readURL(this, $(this), 'single');
    });

    function readURL(input, self, type) {
        switch (type) {
            case 'single' :
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        self.parents('div').siblings('img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
                break;
            case 'multi' :
                if (input.files) {
                    $('.thumbnail-preview').empty();
                    var length = input.files.length;
                    for (var i = 0; i < length; i++) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#cloned-thumbnail').clone().appendTo('.thumbnail-preview').removeAttr('id').removeClass('hidden').children('img').attr('src', e.target.result).attr('width','200');
                        };

                        reader.readAsDataURL(input.files[i]);

                        reader.onloadend = function (f) {
                            $.each(input.files, function (index, value) {
                                var obj = $('.thumbnail-preview');
                                obj.children().eq(index).attr('id','img_'+index);
                            })
                        }
                    }
                }
                break;
            default :
                console.log('Value Not Found!');
        }
    }

    $('#transaksi').on('click', '.upload-proof', function (e) {
        e.preventDefault();

        var invoice = $(this).data('invoice');

        $('#upload-proof').find('input[name="invoice"]').val(invoice);

        $('#upload-proof').modal('show');
    })

    $('.form-send').on('change', '#id_member_address', function (e) {
        e.preventDefault()

        var id_address = $(this).val();
        var subtotal = parseInt($('.subtotal-price').html());
        $('.preloader').hide().removeClass('hide').fadeIn('fast').removeClass('loaded');
        $.ajax({
            url: site_url + 'checkout/shipping_cost/id_address/' + id_address,
            type: 'GET',
            success: function (json) {
                $('.preloader').fadeOut('fast').addClass('hide').addClass('loaded');
                var data = JSON.parse(json);
                if (data.status === 'error') {
                    Swal.fire({
                        position: 'center',
                        title: 'Warning',
                        text: data.message,
                        icon: 'warning'
                    });

                } else if (data.status == 'success') {
                    subtotal = subtotal + parseInt(data.ship_cost_raw);
                    $('.text-shipping-cost').html(data.shipping_cost);
                    $('input[name="id_district"]').val(data.id_district);
                    $('.product-total').html('Rp. '+addCommas(subtotal))

                } else {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Something Wrong!',
                    });
                }
            }
        });
    });

    $('.form-send').on('change', '#select_district', function (e) {
        e.preventDefault()

        var id_district = $(this).val();
        var subtotal = parseInt($('.subtotal-price').html());
        $('.preloader').hide().removeClass('hide').fadeIn('fast').removeClass('loaded');
        $.ajax({
            url: site_url + 'checkout/shipping_cost/id_district/' + id_district,
            type: 'GET',
            success: function (json) {
                $('.preloader').fadeOut('fast').addClass('hide').addClass('loaded');
                var data = JSON.parse(json);
                if (data.status === 'error') {
                    Swal.fire({
                        position: 'center',
                        title: 'Warning',
                        text: data.message,
                        icon: 'warning'
                    });

                } else if (data.status == 'success') {
                    subtotal = subtotal + parseInt(data.ship_cost_raw);
                    $('.text-shipping-cost').html(data.shipping_cost);
                    $('input[name="id_district"]').val(data.id_district);
                    $('.product-total').html('Rp. '+addCommas(subtotal))

                } else {
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Something Wrong!',
                    });
                }
            }
        });
    });
    
    $('.checkout-payment').ready(function () {
        var date_db = $('.checkout-timer').data('date');
        var myDate = moment(date_db);

        $("#countdown").countdown(myDate._d, function (event) {
            $(this).html(
                event.strftime(
                    '<div class="timer-wrapper"><div class="time">%D</div><span class="text">days</span></div><div class="timer-wrapper"><div class="time">%H</div><span class="text">hrs</span></div><div class="timer-wrapper"><div class="time">%M</div><span class="text">mins</span></div><div class="timer-wrapper"><div class="time">%S</div><span class="text">sec</span></div>'
                )
            );
        });
    })

    $('.main_content').on('change', '#product-sort', function () {
        var self = $(this);
        var url = window.location.href;
        var selected = self.val()

        var index = url.indexOf('&sort=');
        var index2 = url.indexOf('?sort=');

        if (index >= 0 || index2 >= 0){
            if (index > 0) {
                var split_url = url.split('&sort=')[0];
                window.location = split_url+'&sort='+selected;
            } else if (index2 > 0) {
                var split_url = url.split('?sort=')[0];
                var second_split = url.split('&');
                var other_param = '';
                for (var i=1; i < second_split.length; i++) {
                    other_param += '&' + second_split[i];
                }
                window.location = split_url+'?sort='+selected+other_param;
            }
        } else {
            var is_any_query = url.indexOf('?');
            if (is_any_query > 0) {
                window.location = url + '&sort=' + selected;
            } else {
                window.location = url + '?sort=' + selected;
            }
        }

    });

    $('#biodata').ready(function () {
        var url = window.location.href;
        var count_active_tab = (url.match(/#/g) || []).length
        var active_tab = url.substring(url.indexOf("#") + 1);

        if (count_active_tab > 0) {
            $(".tab-pane").removeClass("active show");
            $('.nav-tabs').children().children().removeClass('active');
            $('#' + active_tab + '-tab').addClass('active');
            $("#" + active_tab).addClass("active show");
        }
    });

    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    
}

function isEmpty(obj) {
    for (var key in obj) {
        if (obj.hasOwnProperty(key))
        {
            return false;
        }
    }
    return true;
}

function change_active_tab(id_name) {
    $('.nav-tabs').children().children().removeClass('active');
    $('#' + id_name + '-tab').addClass('active');
}

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return x1 + x2;
}

function count_discount(normal_price, promotion_price)
{
    normal_price = parseInt(normal_price);
    promotion_price = parseInt(promotion_price);
    var formula = ((normal_price - promotion_price) / normal_price) * 100
    return Math.round(formula);
}

function ajax_get(href)
{
    $('.preloader').hide().removeClass('hide').fadeIn('fast').removeClass('loaded');
    $.ajax({
        url : href,
        type : 'GET',
        cache: false,
        processData: false,
        success: function(json){
            $('.preloader').fadeOut('fast').addClass('hide').addClass('loaded');
            var data = JSON.parse(json);
            if (data.status == 'success') {
                if (!isEmpty(data.redirect)) {
                    swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: 'success',
                    }).then(function(){
                        window.location = site_url + data.redirect;
                    });
                } else if (!isEmpty(data.reloadPage)) {
                    swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: 'success',
                    }).then(function(){
                        window.location.reload();
                    });
                } else {
                    swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: 'success',
                    });
                }
            } else {
                if (lang_code == 'en') {
                    swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Something Wrong!',
                    });
                } else if (lang_code == 'id') {
                    swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Terjadi Kesalahan!',
                    });
                }
            }
        }
    });
}