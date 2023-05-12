$(document).ready(function () {
    $('.form-send').submit(function (e) {
        e.preventDefault();
        $('.container-loading').hide().removeClass('hide').fadeIn('fast');
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: function (response) {
                $('.container-loading').fadeOut('fast').addClass('hide');
                var data = JSON.parse(response);
                $('div').removeClass('has-error');
                $('.help-block').remove();

                if(data.status === 'success') {
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Baik'
                    }).then(function (result) {
                        if (result.value) {
                            window.location.reload();
                        }
                    });;
                } else {
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Baik'
                    });

                    $.each(data.errors  , function(field, desc) {
                        if(desc) {
                            $('[name="'+field+'"]').parent('div').addClass('has-error');
                            $('[name="'+field+'"]').after('<span class="help-block">'+desc+'</span>');
                        }
                    });
                }
            }
        });

        return false;
    });

    $('.artikel-list').packery({
        itemSelector: '.artikel-item',
        gutter: 0,
        isInitLayout: true,
        isResizeBound: true
    });

    $('.artikel-list').imagesLoaded( function() {
        $('.artikel-list').packery();
    });

    $('.grid').packery({
        itemSelector: '.grid-item',
        gutter: 0,
        isInitLayout: true,
        isResizeBound: true
    });

    $('.grid').imagesLoaded( function() {
        $('.grid').packery();
    });
});

var tpj = jQuery;
var revapi46;
tpj(document).ready(function () {
    if (tpj("#rev_slider_46_1").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_46_1");
    } else {
        revapi46 = tpj("#rev_slider_46_1").show().revolution({
            sliderType: "standard",
            jsFileLocation: "revolution/js/",
            // sliderLayout: "fullscreen",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                },
                bullets: {
                    enable: true,
                    hide_onmobile: true,
                    hide_under: 800,
                    style: "zeus",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "center",
                    v_align: "bottom",
                    h_offset: 0,
                    v_offset: 30,
                    space: 5,
                }

            },
            responsiveLevels: [1240, 1024, 778, 480],
            gridwidth: [1240, 1024, 778, 480],
            gridheight: [768, 668, 860, 620],
            lazyType: "none",
            parallax: {
                type: "mouse",
                origo: "slidercenter",
                speed: 2000,
                levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50],
                disable_onmobile: "on"
            },
            shadow: 0,
            spinner: "off",
            stopLoop: "off",
            stopAfterLoops: -1,
            stopAtSlide: -1,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "0px",
            disableProgressBar: "on",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "on",
                nextSlideOnWindowFocus: "on",
                disableFocusListener: false,
            }
        });
    }
});