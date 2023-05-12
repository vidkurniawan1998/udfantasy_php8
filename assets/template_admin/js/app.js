$(document).ready(function () {

    data_1_status_view();
    status_seo_view();
    data_1_hapus();
    promotion_status_view('modal-create');
    promotion_status_view('modal-edit');


    var base_url = $('#base_url').attr('title');
    var path_img = base_url + 'upload/images/';
    var datatable_sortable = $('.datatable-sortable');
    
    $(document).on('change', '.switchbutton', function(){
        // $('#hideshow2').hide();
        var id = $(this).data('idproducts');
        // console.log(id);
        var status = 'a';
        if ($(this).is(':checked')) {
            status = 'yes';
            console.log(' is now checked');
        } else {
            status = 'no';
            console.log( ' is now unchecked');
        }
        console.log(status);
        // $.ajax({
        //     type: "POST",
        //     url: base_url+"proweb/products_content/updatestatus",
        //     data: "idproducts="+id,
        //     success: function(msg){
        //     //   alert( "Data Saved: " + msg );
        //       console.log(msg)
        //     }
        //   });
          $.ajax({
            method: "POST",
            url: base_url+"proweb/products_content/updatestatus",
            data: { idproducts: id, status: status }
          }).done(function( msg ) {
            //   alert( "Data Saved: " + msg );
            });
    });


    $('.input-time').timepicker({
        format: 'HH:mm',
        showMeridian: false
    });

    $('.input-date').datepicker({
        format:'dd-mm-yyyy'
        // dateFormat: "d-M-Y"
    });

    $('.input-select2').select2({
        placeholder : 'Select an option'
    });

    $('.input-select2-clear').select2({
        placeholder : 'Select an option',
        allowClear : true,
    });

    datatable_sortable.DataTable({
        "ordering" : true,
        "order" : [[1, 'asc']],
        "sort" : true,
    });

    if ($('.tinymce').length > 0) {

        tinymce.init({
            selector: '.tinymce',
            height: 300,
            theme: 'modern',
            relative_urls: false,
            remove_script_host: false,
            convert_urls: false,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools filemanager responsivefilemanager'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true,
            templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
            ],
            content_css: [
                '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                '//www.tinymce.com/css/codepen.min.css'
            ],

            external_filemanager_path: base_url + 'assets/template_admin/tinymce/plugins/filemanager/',
            filemanager_title: 'Responsive Filemanager',
            external_plugins: {'filemanager ': base_url + 'assets/template_admin/tinymce/plugins/filemanager/plugin.min.js'}

        });


    }


    $('.datatable').on("click", ".btn-delete", function (e) {
        e.preventDefault();

        var action = $(this).data('action');
        var self = $(this);
        swal.fire({
            title: 'Are you sure?',
            text: "Want to delete this data?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: action,
                    method: 'get',
                    data: {},
                    success: function (e) {
                        self.parents('tr').remove();
                        // swal.fire(
                        // 	'Berhasil!',
                        // 	'Data Berhasil di hapus',
                        // 	'success'
                        // )
                    }
                });
            } else if (result.dismiss === 'cancel') {
                swal.fire(
                    'Cancel',
                    'not removing the data',
                    'error'
                )
            }
        });

        return false;
    });

    $('.kt-portlet__head-toolbar').on("click", ".btn-create", function (e) {
        e.preventDefault();
        reset_row_product('#modal-create');
        reset_img_row('#modal-create');
        $('#form-create').trigger('reset');
        $('#form-create .custom-file-input').siblings('label').html('');

        $('.form-group').removeClass('validated');
        $('.invalid-feedback').remove();
        $('.form-control').removeClass('is-invalid');
        $('.input-select2').val(null).trigger('change');

        $('#modal-create').modal('show');

        return false;
    });
    
    $('.datatable').on("click", ".btn-edit", function (e) {
        e.preventDefault();
        var json = $(this).parents('td').siblings('td.data-row').children('textarea').val();
        var json_image = $(this).parents('td').siblings('td.data-image-row').children('textarea').val();
        var json_item = $(this).parents('td').siblings('td.data-row').children('.data_item').val();
        var action = $(this).data('action');
        var data = JSON.parse(json);
        var modal = '#modal-edit';
        var total_price = 0;
        var shipping_price = 0;
        if (!isEmpty(json_item)){
            var data_item = JSON.parse(json_item);
        }
        console.log(data);

        reset_img_row('#modal-edit');
        $('#form-edit').trigger('reset');
        $('#form-edit .custom-file-input').siblings('label').html('');

        $('#modal-edit').parents('form').attr('action', action);
        $.each(data, function (field, value) {
            console.log('field : '+ field);
            if (field == 'shipping_price') {
                shipping_price = parseInt(value);
            }

            $('.form-group').removeClass('validated');
            $('.invalid-feedback').remove();
            $('.form-control').removeClass('is-invalid');

            if ($('#modal-edit [name="' + field + '"]').hasClass('tinymce') && !isEmpty(value)) {
                if (tinymce.editors.length > 1) {
                    tinymce.get(field).setContent(value);
                } else {
                    tinymce.activeEditor.setContent(value);
                }
            } else if ($('#modal-edit [name="' + field + '"]').hasClass('browse-preview-img')) {
                $('#modal-edit [name="' + field + '"]').parents('div').siblings('img').attr('src', path_img + value);
            } else if ($('#modal-edit [name="' + field + '"]').attr('type') == 'checkbox') {
                if (value == 'yes') {
                    $('#modal-edit [name="' + field + '"]').prop('checked', true);
                    promotion_status_view('modal-edit');
                } else if (value === 'no') {
                    $('#modal-edit [name="' + field + '"]').prop('checked', false);
                    promotion_status_view('modal-edit');
                }
            } else if ($('#modal-edit [name="' + field + '"]').hasClass('input-select2')) {
                $('.input-select2').val(value);
                $('.input-select2').trigger('change');
            } else if (field === 'data_info' && !isEmpty(value)) {
                reset_row_product('#modal-edit');
                value = JSON.parse(value);
                $.each(value, function (array_key, array_value) {
                    var row_number = 0;
                    $.each(array_value, function (key, info_value) {
                        if (array_key === 'information_name') {
                            row_number = clone_row_product('#modal-edit');
                            $('#modal-edit .product-info-'+(key+1)).find('input[name="data_info[information_name][]"]').val(info_value);
                        } else if (array_key === 'information_value'){
                            $('#modal-edit .product-info-'+(key+1)).find('input[name="data_info[information_value][]"]').val(info_value);
                        }
                    });
                });
            } else {
                $('#modal-edit [name="' + field + '"]').val(value);
            }

        });

        if (!isEmpty(json_image)) {
            reset_img_row('#modal-edit');
            var data_image = JSON.parse(json_image);

            $.each(data_image, function (key, row) {
                $.each(row, function (field, value) {
                    if ($('#modal-edit [name="' + field + '[]"]').hasClass('browse-preview-multi-img')) {
                        if (!$('#modal-edit [name="' + field + '[]"]').parent().siblings('img').hasClass('hidden')){
                            $('#modal-edit [name="' + field + '[]"]').parent().siblings('img').addClass('hidden');
                        }
                        $('#cloned-thumbnail-edit').clone().appendTo('#modal-edit .thumbnail-uploaded').removeAttr('id').removeClass('hidden').addClass('img_'+strip_img_ext(value)+'_'+key).children('img').attr('src', path_img + value).attr('width','200');
                        $('.img_'+strip_img_ext(value)+'_'+key).children('#modal-edit .remove-thumbnail').attr('data-remove', value);
                        return false;
                    }
                });
            });
        }

        if (!isEmpty(data_item)) {
            $('.data-item tbody').empty();
            $('.data-item tfoot').empty();
            $.each(data_item, function (field, values) {
                $('.data-item tbody').append('<tr class="data-item-'+field+'">' +
                    '<td data-'+field+'="no">'+ (field+1) +'</td>' +
                    '<td data-'+field+'="name_product"></td>' +
                    '<td data-'+field+'="price_product"></td>' +
                    '<td data-'+field+'="qty_product"></td>' +
                    '<td data-'+field+'="subtotal_product"></td>' +
                    '</tr>');

                $.each(values, function (field_item, value_item) {
                    if (field_item == 'subtotal_product') {
                        total_price += parseInt(value_item);
                    }
                    switch (field_item) {
                        case 'price_product' :
                            $('.data-item-'+ field +' [data-'+ field +'="' + field_item + '"]').html('Rp. '+addCommas(value_item));
                            break;
                        case 'subtotal_product' :
                            $('.data-item-'+ field +' [data-'+ field +'="' + field_item + '"]').html('Rp. '+addCommas(value_item));
                            break;
                        default :
                            $('.data-item-'+ field +' [data-'+ field +'="' + field_item + '"]').html(value_item);
                            break;
                    }
                });

            });
            total_price = total_price + shipping_price;
            $('.data-item tbody').append(
                '<tr class="data-shipping-price">' +
                    '<td colspan="4">Shipping Price</td>' +
                    '<td>Rp. '+addCommas(shipping_price)+'</td>' +
                '</tr>' +
                '<tr class="data-total-price">'+
                    '<td colspan="4">Total</td>' +
                    '<td>Rp. '+addCommas(total_price)+'</td>' +
                '</tr>'
            );
        }

        $('#modal-edit').modal('show');


        return false;
    });

    $('.datatable').on("click", ".btn-edit-items", function (e) {
        var json = $(this).parents('td').siblings('td.data-row').children('textarea').val();
        var json_item = $(this).parents('td').siblings('td.data-row').children('.data_item').val();
        var total_items = $(this).parents('td').siblings('td.data-row').children('.total_items').val();
        var action = $(this).data('action');
        var data = JSON.parse(json);
        if (!isEmpty(json_item)){
            var data_item = JSON.parse(json_item);
        }
        reset_row_product('#modal-edit');

        $('.items-all').remove();

        $('#modal-edit-items').parents('form').attr('action', action);
        $.each(data, function (field, value) {

            if ($('#modal-edit-items [name="' + field + '"]').hasClass('tinymce')) {
                tinyMCE.activeEditor.setContent(value);
            } else if ($('#modal-edit-items [name="' + field + '"]').hasClass('browse-preview-img')) {
                $('#modal-edit-items [name="' + field + '"]').parents('div').siblings('img').attr('src', path_img + value);
            } else {
                $('#modal-edit-items [name="' + field + '"]').val(value);
            }
        });

        if (!isEmpty(data_item)) {
            $.each(data_item, function (field, value) {
                $('#select-items').clone().appendTo('#modal-edit-items .div-items').addClass('select-items-'+field).addClass('items-all').removeAttr('id').removeClass('hidden');
                $('.select-items-'+field).children('.col-md-11').children('.select-items').attr('name','items[]');
                $('.select-items-'+field).children('.col-md-1').children('.remove-button').removeAttr('data-remove');
                $('.select-items-'+field).children('.col-md-1').children('.remove-button').attr('data-remove',field);

                if ($('.select-items-' + field).children('.col-md-11').children('.select-items').children('option').val() !== value.id_item) {
                    $('.select-items-' + field).children('.col-md-11').children('.select-items').children('option').attr('selected', 'true');
                }
            });
        };


        $('#modal-edit-items').modal('show');


        return false;
    });

    $('.datatable').on("click", ".btn-detail", function (e) {
        e.preventDefault();
        var json = $(this).parents('td').siblings('td.data-row').children('textarea').val();
        var json_item = $(this).parents('td').siblings('td.data-row').children('.data_item').val();
        var action = $(this).data('action');
        var data = JSON.parse(json);
        var total_price = 0;
        var shipping_price = 0;
        if (!isEmpty(json_item)){
            var data_item = JSON.parse(json_item);
        }
        reset_row_product('#modal-detail');

        $('#modal-detail').parents('form').attr('action', action);
        $.each(data, function (field, value) {
            if (field == 'shipping_price') {
                shipping_price = parseInt(value);
            } else if (field == 'id') {
                $('.print-pdf').attr('href', base_url+'proweb/checkout/print_checkout/'+value);
            }
            if ($('#modal-detail [name="' + field + '"]').hasClass('tinymce')) {
                tinyMCE.activeEditor.setContent(value);
            } else if ($('#modal-detail [name="' + field + '"]').hasClass('browse-preview-img')) {
                $('#modal-detail [name="' + field + '"]').parents('div').siblings('img').attr('src', path_img + value);
            } else {
                $('#modal-detail [name="' + field + '"]').val(value);
            }

        });

        if (!isEmpty(data_item)) {
            $('.data-item tbody').empty();
            $('.data-item tfoot').empty();
            $.each(data_item, function (field, values) {
                $('.data-item tbody').append('<tr class="data-item-'+field+'">' +
                    '<td data-'+field+'="no">'+ (field+1) +'</td>' +
                    '<td data-'+field+'="name_product"></td>' +
                    '<td data-'+field+'="price_product"></td>' +
                    '<td data-'+field+'="qty_product"></td>' +
                    '<td data-'+field+'="subtotal_product"></td>' +
                    '</tr>');

                $.each(values, function (field_item, value_item) {
                    if (field_item == 'subtotal_product') {
                        total_price += parseInt(value_item);
                    }
                    switch (field_item) {
                        case 'price_product' :
                            $('.data-item-'+ field +' [data-'+ field +'="' + field_item + '"]').html('Rp. '+addCommas(value_item));
                            break;
                        case 'subtotal_product' :
                            $('.data-item-'+ field +' [data-'+ field +'="' + field_item + '"]').html('Rp. '+addCommas(value_item));
                            break;
                        default :
                            $('.data-item-'+ field +' [data-'+ field +'="' + field_item + '"]').html(value_item);
                            break;
                    }
                });

            });
            total_price = total_price + shipping_price;
            $('.data-item tbody').append(
                '<tr class="data-shipping-price">' +
                    '<td colspan="4">Shipping Price</td>' +
                    '<td>Rp. '+addCommas(shipping_price)+'</td>' +
                '</tr>' +
                '<tr class="data-total-price">'+
                    '<td colspan="4">Total</td>' +
                    '<td>Rp. '+addCommas(total_price)+'</td>' +
                '</tr>'
            );
        }


        $('#modal-detail').modal('show');


        return false;
    });

    $('.form-send').submit(function (e) {
        e.preventDefault();

        $('.container-loading').hide().removeClass('hide').fadeIn('fast');
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (json) {
                $('.container-loading').fadeOut('fast').addClass('hide');
                var data = JSON.parse(json);
                $('.form-group').removeClass('validated');
                $('.invalid-feedback').remove();
                $('.form-control').removeClass('is-invalid');
                if (data.status === 'error') {
                    Swal.fire({
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
                    window.location.reload();
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

    $('.language-change').click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            url: base_url + 'proweb/general/language_change/' + id,
            type: 'get',
            success: function () {
                window.location.reload();
            }
        });

        return false;
    });

    $('.thumbnail-uploaded').on('click', '.remove-thumbnail', function (e) {
        var no_remove = $(this).attr('data-remove');
        var deleted_parent = $(this).parent();

        e.preventDefault();

        $('.container-loading').hide().removeClass('hide').fadeIn('fast');
        $.ajax({
            url: base_url + 'proweb/products_content/remove_multi_image/'+no_remove,
            type: 'POST',
            data_type: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (json) {
                $('.container-loading').fadeOut('fast').addClass('hide');
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
                            $('[name=' + field + '[]' + ']').parents('.form-group').addClass('validated');
                            $('[name=' + field + '[]' + ']').after('<div class="invalid-feedback">' + message + '</div>');
                            $('[name=' + field + '[]' + ']').addClass('is-invalid');
                        }
                    });
                } else if (data.status == 'success') {
                    deleted_parent.remove();
                    // window.location.reload();
                } else {
                    swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Something Wrong!',
                    });
                }
            }
        });

    })

    $(".browse-preview-img").change(function () {
        readURL(this, $(this), 'single');
    });


    $(".browse-preview-multi-img").change(function () {
        readURL(this, $(this), 'multi');
        $(this).parent().siblings('img').addClass('hidden');
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

    $('.data-1-status').change(function () {
        data_1_status_view();
    });

    $('.status-seo').change(function () {
        status_seo_view();
    });

    $('#modal-edit').on('change', '.promotion-status', function () {
        promotion_status_view('modal-edit');
    });

    $('#modal-create').on('change', '.promotion-status', function () {
        promotion_status_view('modal-create');
    })

    $('.btn-data-1-tambah').click(function () {
        var form = $('.data-1-data').html();

        $('.data-1-wrapper ol').append(form);
        data_1_hapus();

        $(".browse-preview-img").change(function () {
            readURL(this, $(this));
        });
    });

    function data_1_status_view() {
        var data_1_status = $('input[name="data_1_status"]:checked').val();
        if (data_1_status === 'yes') {
            $('.data-1-wrapper').removeClass('hide');
        } else {
            $('.data-1-wrapper').addClass('hide');
        }
    }

    function status_seo_view() {
        var status_seo_view = $('input[name="status_seo"]:checked').val();
        if (status_seo_view === 'yes') {
            $('.status-seo-wrapper').removeClass('hide');
        } else {
            $('.status-seo-wrapper').addClass('hide');
        }
    }

    function promotion_status_view(id_modal) {
        var status_seo_view = $('#'+id_modal).find('input[name="promotion_status"]:checked').val();
        if (status_seo_view === 'yes') {
            $('#'+id_modal).find('.promotion-status-wrapper').removeClass('hide');
        } else {
            $('#'+id_modal).find('.promotion-status-wrapper').addClass('hide');
        }
    }

    function data_1_hapus() {
        $('.btn-data-1-hapus').click(function () {
            $(this).parents('li').remove();
        });
    }

    $('#modal-create').on('change','select[name="id_products_category"]',function () {
        selectedIdCategory = $('#modal-create').find('select[name="id_products_category"]').val();
        find_sub_category(selectedIdCategory, $('#modal-create'));
    });

    $('#modal-edit').on('change','select[name="id_products_category"]',function () {
        selectedIdCategory = $('#modal-edit').find('select[name="id_products_category"]').val();
        find_sub_category(selectedIdCategory, $('#modal-edit'));
    });

    $('#modal-edit').on('shown.bs.modal',function () {
        selectedIdCategory = $('#modal-edit').find('select[name="id_products_category"]').val();
        find_sub_category(selectedIdCategory, $('#modal-edit'));
    });

    function find_sub_category(id_parent, id_modal){
        $.ajax({
            method: 'POST',
            url: base_url + '/proweb/products_sub_category/get_sub_category/'+selectedIdCategory,
            dataType: 'json',
            success: function (data) {
                var selectSubCategory = id_modal.find('select[name="id_products_sub_category"]');
                selectSubCategory.empty();
                selectSubCategory.append('<option value="">Select Sub Category</option>')
                for (let index = 0; index < data.length; index++) {
                    selectSiblings = selectSubCategory.siblings('input[name="id_products_sub_category"]').val();
                    if (isEmpty(selectSiblings)){
                        selectSubCategory.append('<option value="' + data[index].id + '" >' + data[index].title + '</option>')
                    } else {
                        if (data[index].id == selectSiblings){
                            selectSubCategory.append('<option value="' + data[index].id + '" selected>' + data[index].title + '</option>')
                        } else {
                            selectSubCategory.append('<option value="' + data[index].id + '" >' + data[index].title + '</option>')
                        }
                    }
                }
            }
        })
    }

    $('#modal-create').ready(function(){
        var total_item = $('input[name="total-item"]').val();
        if (!isEmpty(total_item) && total_item > 1) {
            for (var i=0;i<total_item;i++){
                $('.select-items-'+i).remove();
            }
        }
    });

    $('.modal').on('click','.tambah-item',function(){
        var count = $('.total-item').val();
        count++;
        $('.total-item').val(count);
        $('#select-items').clone().appendTo('.div-items').addClass('select-items-'+count).removeAttr('id').removeClass('hidden');
        $('.select-items-'+count).children('.col-md-11').children('.select-items').attr('name','items[]');
        $('.select-items-'+count).children('.col-md-1').children('.remove-button').removeAttr('data-remove');
        $('.select-items-'+count).children('.col-md-1').children('.remove-button').attr('data-remove',count);
    });

    $('.modal').on('click','.remove-button', function(){
        var no_remove = $(this).attr('data-remove');
        $('.select-items-'+no_remove).remove();
    });

    $('.items-edit').ready(function(){
        var id = $('input[name="id"]').val();

    });

    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }

    function strip_img_ext(img_name){
        var exts = ['.jpg', '.gif', '.png', '.jpeg'];
        $.each(exts, function(i,v){
            img_name = img_name.replace(v, '');
        });

        return img_name;
    }

    function reset_img_row(modal) {
        $(modal + ' .thumbnail-preview').empty();
        $(modal + ' .thumbnail-uploaded').empty();
    }

    $('.wrapper-filter-checkout').ready(function () {
        $('.wrapper-filter-checkout').on('change', '#filter-checkout-district', function () {
            filterColumn($(this).attr('data-column'));
        });

        $('.wrapper-filter-checkout').on('change', '#filter-checkout-payment-method', function () {
            filterColumn($(this).attr('data-column'));
        })

        $('.wrapper-filter-checkout').on('change', '#filter-checkout-status', function () {
            filterColumn($(this).attr('data-column'));
        })
    });


    // $('#modal-edit').on('shown.bs.modal',function () {
    //     selectedIdCategory = $('#id_products_category').val();
    //     console.log(selectedIdCategory);
    //
    //     $.ajax({
    //         method: 'POST',
    //         url: base_url + '/proweb/products_sub_category/get_sub_category/'+selectedIdCategory,
    //         data: {
    //             'id_parent': selectedIdCategory,
    //             '_token': $("input[name=_token]").val()
    //         },
    //         dataType: 'json',
    //         success: function (data) {
    //             var selectSubCategory = $('#id_products_sub_category');
    //             selectSubCategory.empty();
    //             selectSubCategory.append('<option value="">Select Sub Category</option>')
    //             for (let index = 0; index < data.length; index++) {
    //                 selectSubCategory.append('<option value="' + data[index].id + '" >' + data[index].title + '</option>')
    //             }
    //         }
    //     })
    // });

});

function clone_row_product(modal) {
    var product_info = $(modal+' .product-info');
    var product_row = product_info.find('#product-row');
    var container_info = product_info.find('.container-info');
    var count_product_info = $(modal+' input[name = "count_product_info"]').val();
    count_product_info++;

    $(modal+' input[name = "count_product_info"]').val(count_product_info);
    product_row.clone().appendTo(container_info).removeAttr('id').removeClass('hidden').addClass('row').addClass('product-info-'+count_product_info);
    $(modal+' .product-info-'+count_product_info).find('.information-name').attr('name','data_info[information_name][]');
    $(modal+' .product-info-'+count_product_info).find('.information-value').attr('name','data_info[information_value][]');
    $(modal+' .product-info-'+count_product_info).find('.remove-info').attr('onclick','remove_row_product("'+count_product_info+'","'+modal+'")');

    return count_product_info;
}

function remove_row_product(remove_no, modal) {
    $(modal+' .product-info-'+remove_no).remove();
}

function reset_row_product(modal) {
    $(modal + ' .container-info').empty();
    $(modal + ' input[name="count_product_info"]').val('0');
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

function filterColumn ( i ) {
    console.log(i)
    $('.datatable').DataTable().column( i ).search(
        $('.filter-table-'+i).val(),
    ).draw();
}
