/**
 * Document ready
 * 
 * Single Product Page
 */
var _single_loading = false;
var _single_remove_loading;
var _inited_gallery = false;
var _inited_gallery_key = 0;
var _timeout_changed;
if (typeof _single_variations === 'undefined') {
    var _single_variations = [];
}

jQuery(document).ready(function($) {
"use strict";

/**
 * Default init
 */
if ($('.tradeace-product-details-page .tradeace-gallery-variation-supported').length) {
    var _df_main = $('.tradeace-main-image-default-wrap').clone();
    if ($(_df_main).find('.tradeace-single-slider-arrows').length) {
        $(_df_main).find('.tradeace-single-slider-arrows').remove();
    }

    _single_variations[0] = {
        'main_image': $(_df_main).html(),
        'thumb_image': $('.tradeace-thumbnail-default-wrap').html()
    };
}
    
/**
 * Crazy Loading
 */
if ($('.woocommerce-product-gallery__wrapper').length && !$('.woocommerce-product-gallery__wrapper').hasClass('crazy-loading') && $('#tradeace-ajax-store.tradeace-crazy-load').length) {
    $('.woocommerce-product-gallery__wrapper').addClass('crazy-loading');
    
    if (typeof _single_remove_loading !== 'undefined') {
        clearInterval(_single_remove_loading);
    }
    
    setTimeout(function() {
        $('body').trigger('tradeace_product_gallery_remove_crazy');
    }, 10);
}

if ($('.tradeace-crazy-load.crazy-loading').length) {
    $('.tradeace-crazy-load.crazy-loading').removeClass('crazy-loading');
}

$('body').on('tradeace_product_gallery_remove_crazy', function() {
    _single_remove_loading = setInterval(function() {
        if ($('.woocommerce-product-gallery__wrapper .main-images img').length) {
            var _loading = $('.woocommerce-product-gallery__wrapper .main-images img').length;
            
            $('.woocommerce-product-gallery__wrapper .main-images img').each(function() {
                if (!$(this).hasClass('tradeace-loaded') && $(this).height() > 1) {
                    $(this).addClass('tradeace-loaded');
                }
            });
            
            var _loaded = $('.woocommerce-product-gallery__wrapper .main-images img.tradeace-loaded').length;
            
            if (_loading <= _loaded) {
                if ($('.woocommerce-product-gallery__wrapper.crazy-loading').length) {
                    $('.woocommerce-product-gallery__wrapper.crazy-loading').removeClass('crazy-loading');
                }

                clearInterval(_single_remove_loading);
                
                _single_loading = false;
            }
        } else {
            if ($('.woocommerce-product-gallery__wrapper.crazy-loading').length) {
                $('.woocommerce-product-gallery__wrapper.crazy-loading').removeClass('crazy-loading');
            }
            
            clearInterval(_single_remove_loading);
            
            _single_loading = false;
        }
    }, 50);
});

/**
 * Lightbox image Single product page
 */
$('body').on('click', '.easyzoom-flyout', function() {
    if (!$('body').hasClass('tradeace-disable-lightbox-image')) {
        var _click = $(this).parents('.easyzoom');
        if ($(_click).length && $(_click).find('a.product-image').length) {
            $(_click).find('a.product-image').trigger('click');
        }
    }
});

/**
 * Change gallery for variation - single
 */
$('body').on('tradeace_changed_gallery_variable_single', function() {
    load_slick_single_product($, true);
    load_gallery_popup($);

    $('body').trigger('tradeace_compatible_jetpack');

    setTimeout(function() {
        $('.product-gallery').css({'min-height': 'auto'});
        $(window).resize();
    }, 100);
});

/**
 * Change Countdown for variation - Quick view
 */
$('body').on('tradeace_reload_slick_slider', function() {
    load_slick_single_product($, true);
});

/**
 * Load single product image
 */
load_slick_single_product($);

/* Product Gallery Popup */
load_gallery_popup($);

/**
 * Single Product
 * Variable change image
 */
tradeace_single_product_found_variation($);
tradeace_single_product_reset_variation_df($);

$('body').on('tradeace_after_loaded_ajax_complete', function() {
    /**
     * Load single product image
     */
    load_slick_single_product($);
    
    /* Product Gallery Popup */
    load_gallery_popup($);
    
    if ($('.woocommerce-product-gallery__wrapper').length && !$('.woocommerce-product-gallery__wrapper').hasClass('crazy-loading')) {
        $('.woocommerce-product-gallery__wrapper').addClass('crazy-loading');
    }
    
    /**
     * Compatible UX variation
     */
    var _forms = $('.tradeace-product-details-page .variations_form');
    if ($(_forms).length && typeof wc_add_to_cart_variation_params !== 'undefined') {
        $(_forms).each(function() {
            $(this).wc_variation_form();
        });
        
        /**
         * Default init
         */
        if ($('.tradeace-product-details-page .tradeace-gallery-variation-supported').length) {
            var _df_main = $('.tradeace-main-image-default-wrap').clone();
            if ($(_df_main).find('.tradeace-single-slider-arrows').length) {
                $(_df_main).find('.tradeace-single-slider-arrows').remove();
            }

            _single_variations[0] = {
                'main_image': $(_df_main).html(),
                'thumb_image': $('.tradeace-thumbnail-default-wrap').html()
            };
        }
        
        tradeace_single_product_found_variation($);
        tradeace_single_product_reset_variation_df($);
    }
    
    setTimeout(function() {
        if ($(_forms).length) {
            $('body').trigger('tradeace_init_ux_variation_form', _forms);
        }

        /**
         * Fixed Single form add to cart
         */
        if ($('.tradeace-add-to-cart-fixed').length) {
            $('.tradeace-add-to-cart-fixed').remove();
            load_sticky_add_to_cart($);
        }
        
        /**
         * Init #Rating
         */
        $('.wc-tabs-wrapper, .woocommerce-tabs, #rating').trigger('init');
        
        if ($('.tradeace-crazy-load.crazy-loading').length) {
            $('.tradeace-crazy-load.crazy-loading').removeClass('crazy-loading');
        }
        
        _single_loading = false;
    }, 10);
    
    $('.transparent-window').trigger('click');
    
    $('body').trigger('tradeace_product_gallery_remove_crazy');
    
    /**
     * Compatible with Contact Form 7
     */
    if (typeof wpcf7 !== 'undefined' && $('.wpcf7 > form').length) {
        document.querySelectorAll(".wpcf7 > form").forEach(function (e) {
            return wpcf7.init(e);
        });
    }
});

/**
 * Event click single product thumbnail
 */
$('body').on('click', '.tradeace-single-product-slide .tradeace-single-product-thumbnails .slick-slide', function() {
    var _wrap = $(this).parents('.tradeace-single-product-thumbnails');
    var _speed = parseInt($(_wrap).attr('data-speed'));
    _speed = !_speed ? 600 : _speed;
    $(_wrap).append('<div class="tradeace-slick-fog"></div>');

    setTimeout(function() {
        $(_wrap).find('.tradeace-slick-fog').remove();
    }, _speed);
});

/* Product Gallery Popup */
$('body').on('click', '.product-lightbox-btn', function(e) {
    if ($('.tradeace-single-product-slide').length) {
        $('.product-images-slider').find('.slick-current.slick-active a').trigger('click');
    }

    else if ($('.tradeace-single-product-scroll').length) {
        $('#tradeace-main-image-0 a').trigger('click');
    }

    e.preventDefault();
});

/* Product Video Popup */
$('body').on('click', "a.product-video-popup", function(e) {
    if (! $('body').hasClass('tradeace-disable-lightbox-image')) {
        $('.product-images-slider').find('.first a').trigger('click');
        var galeryPopup = $.magnificPopup.instance;
        galeryPopup.prev();
    }
    
    else {
        var productVideo = $(this).attr('href');
        $.magnificPopup.open({
            items: {
                src: productVideo
            },
            type: 'iframe',
            tLoading: '<div class="tradeace-loader"></div>',
            closeMarkup: '<a class="tradeace-mfp-close tradeace-stclose" href="javascript:void(0);" title="' + $('input[name="tradeace-close-string"]').val() + '"></a>'
        }, 0);
    }
    
    e.preventDefault();
});

/**
 * Next Prev Single Product Slider
 */
$('body').on('click', '.tradeace-single-arrow', function() {
    var _this = $(this);
    if (!$(_this).hasClass('tradeace-disabled')) {
        var _action = $(_this).attr('data-action');
        var _wrap = $(_this).parents('.product-images-slider');
        var _slides = $(_wrap).find('.tradeace-single-product-main-image');
        if ($(_slides).find('.slick-arrow.slick-' + _action).length) {
            var _real = $(_slides).find('.slick-arrow.slick-' + _action);
            $(_real).trigger('click');
        }
    }
});

/**
 * Next Prev Single Product Slider add class "tradeace-disabled"
 */
$('body').on('tradeace_after_single_product_slick_inited', function(ev, _thumbs, _num_ver) {
    $('.tradeace-single-product-slide .tradeace-single-product-main-image').on('afterChange', function(){
        var _this = $(this);
        var _wrap = $(_this).parents('.product-images-slider');

        if ($(_wrap).find('.tradeace-single-arrow').length) {
            var _prev = $(_this).find('.slick-prev');
            var _next = $(_this).find('.slick-next');

            $(_wrap).find('.tradeace-single-arrow').removeClass('tradeace-disabled');

            if ($(_prev).hasClass('slick-disabled')) {
                $(_wrap).find('.tradeace-single-arrow[data-action="prev"]').addClass('tradeace-disabled');
            }

            if ($(_next).hasClass('slick-disabled')) {
                $(_wrap).find('.tradeace-single-arrow[data-action="next"]').addClass('tradeace-disabled');
            }
        }
    });
    
    if (_thumbs) {
        if ($(_thumbs).find('.slick-slide').length <= _num_ver && !$(_thumbs).hasClass('not-full-items')) {
            $(_thumbs).addClass('not-full-items');
        }
    }
    
    ev.preventDefault();
});

/**
 * Tab reviewes
 */
$('body').on('click', '.tradeace-product-details-page .woocommerce-review-link', function() {
    if (
        $('.woocommerce-tabs .reviews_tab a').length ||
        $('.woocommerce-tabs .tradeace-accordion-reviews').length ||
        $('.woocommerce-tabs .tradeace-anchor[data-target="#tradeace-anchor-reviews"].active').length
    ) {
        var _obj = $('.woocommerce-tabs .reviews_tab a');
        if ($(_obj).length <= 0) {
            _obj = $('.woocommerce-tabs .tradeace-accordion-reviews');
        }
        if ($(_obj).length <= 0) {
            _obj = $('.woocommerce-tabs .tradeace-anchor[data-target="#tradeace-anchor-reviews"].active');
        }
        
        if ($(_obj).length) {
            $('body').trigger('tradeace_animate_scroll_to_top', [$, _obj, 500]);
            setTimeout(function() {
                if (!$(_obj).hasClass('active')) {
                    $(_obj).trigger('click');
                    $(_obj).mousemove();
                }
            }, 500);
        }
    }
    
    return false;
});

/**
 * Scroll single product
 */
var _main_images = load_scroll_single_product($);
$(window).resize(function() {
    /* Fix scroll single product */
    _main_images = load_scroll_single_product($);
    $(window).trigger('scroll');
});

/**
 * Click thumbnail scroll
 * 
 * @type type
 */
var _timeOutThumbItem;
$('body').on('click', '.tradeace-thumb-wrap .tradeace-wrap-item-thumb', function() {
    if (typeof _timeOutThumbItem !== 'undefined') {
        clearTimeout(_timeOutThumbItem);
    }
    
    if ($(this).parents('.tradeace-single-product-scroll').length) {
        var _main = $(this).attr('data-main');

        var _topfix = 0;
        if ($('.fixed-already').length) {
            _topfix += $('.fixed-already').outerHeight();
        }

        if ($('#wpadminbar').length) {
            _topfix += $('#wpadminbar').outerHeight();
        }

        var _pos_top = $(_main).offset().top - _topfix;

        _timeOutThumbItem = setTimeout(function() {
            $('html, body').animate({scrollTop: _pos_top - 10}, 300);
        }, 100);
    }
});

/**
 * Sticky info and thumbnails
 * 
 * @type Number|scrollTop
 */
var lastScrollTop = 0;
$(window).on('scroll', function() {
    if ($('.tradeace-single-product-scroll').length) {
        var _hasThumbs = $('.tradeace-single-product-thumbnails').length ? true : false;
        var _col_main = parseInt($('.tradeace-single-product-scroll').attr('data-num_main'));
        
        var scrollTop = $(this).scrollTop();
        var bodyHeight = $(window).height();
        
        var _inMobile = $('.tradeace-check-reponsive.tradeace-switch-check').length && $('.tradeace-check-reponsive.tradeace-switch-check').width() === 1 ? true : false;
        if (!_inMobile) {
            var _down = scrollTop > lastScrollTop ? true : false;
            lastScrollTop = scrollTop;

            var _pos = $('.tradeace-main-wrap').offset();
            var _pos_end = $('.tradeace-end-scroll').offset();

            var _topfix = 0;
            if ($('.fixed-already').length === 1) {
                _topfix += $('.fixed-already').outerHeight();
            }

            if ($('#wpadminbar').length === 1) {
                _topfix += $('#wpadminbar').outerHeight();
            }

            var _higherInfo = true;
            if ($('.tradeace-product-info-scroll').outerHeight() < (bodyHeight + 10 - _topfix)) {
                _higherInfo = false;
            }

            var _higherThumb = true;
            if (_hasThumbs && $('.tradeace-single-product-thumbnails').outerHeight() < (bodyHeight + 10 - _topfix)) {
                _higherThumb = false;
            }

            var _start_top = _pos.top - _topfix;

            var _info_height = $('.tradeace-product-info-scroll').height();
            var _thumb_height = _hasThumbs ? $('.tradeace-single-product-thumbnails').height() : 0;

            var _moc_end_info = scrollTop + bodyHeight - (bodyHeight - _info_height) + _topfix + 10;
            var _moc_end_thumb = scrollTop + bodyHeight - (bodyHeight - _thumb_height) + _topfix + 10;
            var _topbar = scrollTop - _start_top;

            if (_pos_end.top > _moc_end_info) {
                if (_topbar >= 0){
                    var _scroll_wrap = $('.tradeace-product-info-scroll').parents('.tradeace-product-info-wrap');
                    var _pos_wrap = $(_scroll_wrap).offset();
                    if (!$('.tradeace-product-info-scroll').hasClass('tradeace-single-fixed')) {
                        $('.tradeace-product-info-scroll').addClass('tradeace-single-fixed');
                    }

                    if (!_higherInfo) {
                        $('.tradeace-product-info-scroll').css({
                            '-webkit-transform': 'translate3d(0,0,0)',
                            '-moz-transform': 'translate3d(0,0,0)',
                            '-ms-transform': 'translate3d(0,0,0)',
                            'transform': 'translate3d(0,0,0)',
                            'top': _topfix + 10,
                            'bottom': 'auto',
                            'left': _pos_wrap.left,
                            'width': $(_scroll_wrap).width()
                        });

                        $('.tradeace-product-info-scroll').css({'margin-top': _topbar + 10});
                    }

                    else {
                        $('.tradeace-product-info-scroll').css({
                            '-webkit-transform': 'translate3d(0,0,0)',
                            '-moz-transform': 'translate3d(0,0,0)',
                            '-ms-transform': 'translate3d(0,0,0)',
                            'transform': 'translate3d(0,0,0)',
                            'left': _pos_wrap.left,
                            'width': $(_scroll_wrap).width()
                        });

                        if (_down) {
                            $('.tradeace-product-info-scroll').css({
                                'top': 'auto',
                                'bottom': 0
                            });

                            $('.tradeace-product-info-scroll').css({'margin-top': _topbar + 10});
                        }

                        else {
                            $('.tradeace-product-info-scroll').css({
                                'top': _topfix + 10,
                                'bottom': 'auto'
                            });
                        }
                    }
                } else {
                    if ($('.tradeace-product-info-scroll').hasClass('tradeace-single-fixed')) {
                        $('.tradeace-product-info-scroll').removeClass('tradeace-single-fixed');
                    }
                    $('.tradeace-product-info-scroll').css({'margin-top': 0});
                }
            } else {
                if ($('.tradeace-product-info-scroll').hasClass('tradeace-single-fixed')) {
                    $('.tradeace-product-info-scroll').removeClass('tradeace-single-fixed');
                }
            }

            /**
             * Scroll Thumbnails
             */
            if (_hasThumbs) {
                if (_pos_end.top > _moc_end_thumb) {
                    if (_topbar >= 0){
                        var _thumb_wrap = $('.tradeace-single-product-thumbnails').parents('.tradeace-thumb-wrap');
                        var _pos_thumb = $(_thumb_wrap).offset();
                        if (!$('.tradeace-single-product-thumbnails').hasClass('tradeace-single-fixed')) {
                            $('.tradeace-single-product-thumbnails').addClass('tradeace-single-fixed');
                        }

                        if (!_higherThumb) {
                            $('.tradeace-single-product-thumbnails').css({
                                '-webkit-transform': 'translate3d(0, 0, 0)',
                                '-moz-transform': 'translate3d(0, 0, 0)',
                                '-ms-transform': 'translate3d(0, 0, 0)',
                                'transform': 'translate3d(0, 0, 0)',
                                'top': _topfix + 10,
                                'bottom': 'auto',
                                'left': _pos_thumb.left,
                                'width': $(_thumb_wrap).width()
                            });

                            $('.tradeace-single-product-thumbnails').css({'margin-top': _topbar  + 10});
                        }

                        else {
                            $('.tradeace-single-product-thumbnails').css({
                                '-webkit-transform': 'translate3d(0, 0, 0)',
                                '-moz-transform': 'translate3d(0, 0, 0)',
                                '-ms-transform': 'translate3d(0, 0, 0)',
                                'transform': 'translate3d(0, 0, 0)',
                                'left': _pos_thumb.left,
                                'width': $(_thumb_wrap).width()
                            });

                            if (_down) {
                                $('.tradeace-single-product-thumbnails').css({
                                    'top': 'auto',
                                    'bottom': 0
                                });

                                $('.tradeace-single-product-thumbnails').css({'margin-top': _topbar  + 10});
                            } else {
                                $('.tradeace-single-product-thumbnails').css({
                                    'top': _topfix + 10,
                                    'bottom': 'auto'
                                });
                            }
                        }
                    } else {
                        if ($('.tradeace-single-product-thumbnails').hasClass('tradeace-single-fixed')) {
                            $('.tradeace-single-product-thumbnails').removeClass('tradeace-single-fixed');
                        }
                        $('.tradeace-single-product-thumbnails').css({'margin-top': 0});
                    }
                } else {
                    if ($('.tradeace-single-product-thumbnails').hasClass('tradeace-single-fixed')) {
                        $('.tradeace-single-product-thumbnails').removeClass('tradeace-single-fixed');
                    }
                }
            }

            // Active image scroll
            var i = _main_images.length;
            if (i) {
                for(i; i>0; i--) {
                    if (_main_images[i-1].pos <= scrollTop + _topfix + 50){
                        var _key = $(_main_images[i-1].id).attr('data-key');
                        $('.tradeace-thumb-wrap .tradeace-wrap-item-thumb').removeClass('tradeace-active');
                        $('.tradeace-thumb-wrap .tradeace-wrap-item-thumb[data-key="' + _key + '"]').addClass('tradeace-active');
                        if (_col_main % 2 === 0) {
                            var _before_key = (parseInt(_key) - 1).toString();
                            if ($('.tradeace-thumb-wrap .tradeace-wrap-item-thumb[data-key="' + _before_key + '"]').length) {
                                $('.tradeace-thumb-wrap .tradeace-wrap-item-thumb[data-key="' + _before_key + '"]').addClass('tradeace-active');
                            }
                        }

                        break;
                    }
                }
            }
        } else {
            $('.tradeace-product-info-scroll').removeAttr('style');
            if (_hasThumbs) {
                $('.tradeace-single-product-thumbnails').removeAttr('style');
            }
            $('.tradeace-thumb-wrap .tradeace-wrap-item-thumb').removeClass('tradeace-active');
            $('.tradeace-thumb-wrap .tradeace-wrap-item-thumb[data-key="0"]').addClass('tradeace-active');
        }
    }
});

/**
 * Scroll sticky add to cart
 */
if ($('input[name="tradeace_fixed_single_add_to_cart"]').length) {
    $(window).scroll(function() {
        var scrollTop = $(this).scrollTop();
            if ($('.tradeace-product-details-page .single_add_to_cart_button').length) {
                var addToCart = $('.tradeace-product-details-page #tradeace-single-product-tabs') || $('.tradeace-product-details-page .single_add_to_cart_button');
                if ($(addToCart).length) {
                    var addToCartOffset = $(addToCart).offset();

                    if (scrollTop >= addToCartOffset.top) {
                        if (!$('body').hasClass('has-tradeace-cart-fixed')) {
                            $('body').addClass('has-tradeace-cart-fixed');
                        }
                    } else {
                        $('body').removeClass('has-tradeace-cart-fixed');
                    }
                }
            }
    });
}

/**
 * Fixed Single form add to cart
 */
load_sticky_add_to_cart($);

/**
 * Change Ux
 */
$('body').on('click', '.tradeace-attr-ux', function() {
    var _target = $(this).attr('data-target');
    if ($(_target).length) {
        var _wrap = $(_target).parents('.tradeace-attr-ux_wrap-clone');
        $(_wrap).find('.tradeace-attr-ux-clone').removeClass('selected');
        if ($(this).hasClass('selected')) {
            $(_target).addClass('selected');
        }

        if ($('.tradeace-fixed-product-btn').length) {
            setTimeout(function() {
                var _button_wrap = tradeace_clone_add_to_cart($);
                $('.tradeace-fixed-product-btn').html(_button_wrap);
                var _val = $('.tradeace-product-details-page form.cart input[name="quantity"]').val();
                $('.tradeace-single-btn-clone input[name="quantity"]').val(_val);
            }, 250);
        }

        setTimeout(function() {
            if ($('.tradeace-attr-ux').length) {
                $('.tradeace-attr-ux').each(function() {
                    var _this = $(this);
                    var _targetThis = $(_this).attr('data-target');

                    if ($(_targetThis).length) {
                        var _disable = $(_this).hasClass('tradeace-disable') ? true : false;
                        if (_disable) {
                            if (!$(_targetThis).hasClass('tradeace-disable')) {
                                $(_targetThis).addClass('tradeace-disable');
                            }
                        } else {
                            $(_targetThis).removeClass('tradeace-disable');
                        }
                    }
                });
            }
        }, 250);
    }
});

/**
 * Change Ux clone
 */
$('body').on('click', '.tradeace-attr-ux-clone', function() {
    var _target = $(this).attr('data-target');
    if ($(_target).length) {
        $(_target).trigger('click');
    }
});

/**
 * Change select
 */
$('body').on('change', '.tradeace-attr-select', function() {
    var _this = $(this);
    var _target = $(_this).attr('data-target');
    var _value = $(_this).val();

    if ($(_target).length) {
        setTimeout(function() {
            var _html = $(_this).html();
            $(_target).html(_html);
            $(_target).val(_value);
        }, 100);

        setTimeout(function() {
            var _button_wrap = tradeace_clone_add_to_cart($);
            $('.tradeace-fixed-product-btn').html(_button_wrap);
            var _val = $('.tradeace-product-details-page form.cart input[name="quantity"]').val();
            $('.tradeace-single-btn-clone input[name="quantity"]').val(_val);

            if ($('.tradeace-attr-ux').length) {
                $('.tradeace-attr-ux').each(function() {
                    var _this = $(this);
                    var _targetThis = $(_this).attr('data-target');

                    if ($(_targetThis).length) {
                        var _disable = $(_this).hasClass('tradeace-disable') ? true : false;
                        if (_disable) {
                            if (!$(_targetThis).hasClass('tradeace-disable')) {
                                $(_targetThis).addClass('tradeace-disable');
                            }
                        } else {
                            $(_targetThis).removeClass('tradeace-disable');
                        }
                    }
                });
            }
        }, 250);
    }
});

/**
 * Change select clone
 */
$('body').on('change', '.tradeace-attr-select-clone', function() {
    var _target = $(this).attr('data-target');
    var _value = $(this).val();
    if ($(_target).length) {
        $(_target).val(_value).change();
    }
});

/**
 * Reset variations
 */
$('body').on('click', '.tradeace-product-details-page .reset_variations', function() {
    if ($('.tradeace-add-to-cart-fixed .tradeace-wrap-content .selected').length) {
        $('.tradeace-add-to-cart-fixed .tradeace-wrap-content .selected').removeClass('selected');
    }

    setTimeout(function() {
        var _button_wrap = tradeace_clone_add_to_cart($);
        $('.tradeace-fixed-product-btn').html(_button_wrap);
        var _val = $('.tradeace-product-details-page form.cart input[name="quantity"]').val();
        $('.tradeace-single-btn-clone input[name="quantity"]').val(_val);

        if ($('.tradeace-product-details-page .tradeace-attr-ux').length) {
            $('.tradeace-product-details-page .tradeace-attr-ux').each(function() {
                var _this = $(this);
                var _targetThis = $(_this).attr('data-target');

                if ($(_targetThis).length) {
                    var _disable = $(_this).hasClass('tradeace-disable') ? true : false;
                    if (_disable) {
                        if (!$(_targetThis).hasClass('tradeace-disable')) {
                            $(_targetThis).addClass('tradeace-disable');
                        }
                    } else {
                        $(_targetThis).removeClass('tradeace-disable');
                    }
                }
            });
        }
    }, 250);
});

/**
 * Plus, Minus button
 */
$('body').on('click', '.tradeace-product-details-page form.cart .quantity .plus, .tradeace-product-details-page form.cart .quantity .minus', function() {
    if ($('.tradeace-single-btn-clone input[name="quantity"]').length) {
        var _val = $('.tradeace-product-details-page form.cart input[name="quantity"]').val();
        $('.tradeace-single-btn-clone input[name="quantity"]').val(_val);
    }
});

/**
 * Plus clone button
 */
$('body').on('click', '.tradeace-single-btn-clone .plus', function() {
    if ($('.tradeace-product-details-page form.cart .quantity .plus').length) {
        $('.tradeace-product-details-page form.cart .quantity .plus').trigger('click');
    }
});

/**
 * Minus clone button
 */
$('body').on('click', '.tradeace-single-btn-clone .minus', function() {
    if ($('.tradeace-product-details-page form.cart .quantity .minus').length) {
        $('.tradeace-product-details-page form.cart .quantity .minus').trigger('click');
    }
});

/**
 * Quantily input
 */
$('body').on('keyup', '.tradeace-product-details-page form.cart input[name="quantity"]', function() {
    var _val = $(this).val();
    $('.tradeace-single-btn-clone input[name="quantity"]').val(_val);
});

/**
 * Quantily input clone
 */
$('body').on('keyup', '.tradeace-single-btn-clone input[name="quantity"]', function() {
    var _val = $(this).val();
    $('.tradeace-product-details-page form.cart input[name="quantity"]').val(_val);
});

/**
 * Add to cart click
 */
$('body').on('click', '.tradeace-single-btn-clone .single_add_to_cart_button', function() {
    if ($('.tradeace-product-details-page form.cart .single_add_to_cart_button').length) {
        $('.tradeace-product-details-page form.cart .single_add_to_cart_button').trigger('click');
    }
});

/**
 * Buy Now click
 */
$('body').on('click', '.tradeace-single-btn-clone .tradeace-buy-now', function() {
    if ($('.tradeace-product-details-page form.cart .tradeace-buy-now').length) {
        $('.tradeace-product-details-page form.cart .tradeace-buy-now').trigger('click');
    }
});

/**
 * Toggle Select Options
 */
$('body').on('click', '.tradeace-toggle-variation_wrap-clone', function() {
    if ($('.tradeace-fixed-product-variations-wrap').length) {
        $('.tradeace-fixed-product-variations-wrap').toggleClass('tradeace-active');
    }
});

$('body').on('click', '.tradeace-close-wrap', function() {
    if ($('.tradeace-fixed-product-variations-wrap').length) {
        $('.tradeace-fixed-product-variations-wrap').removeClass('tradeace-active');
    }
});

/**
 * Toggle Woo Tabs in mobile
 */
$('body').on('click', '.tradeace-toggle-woo-tabs', function() {
    if ($('.mobile-tabs-off-canvas').length) {
        $('.mobile-tabs-off-canvas').toggleClass('tradeace-active');
    }
});

/**
 * Load Ajax single product
 * 
 * @param {type} $
 * @returns {String}
 */
$('body').on('click', '.tradeace-ajax-call', function(e) {
    if ($('#tradeace-single-product-ajax').length) {
        e.preventDefault();

        if (!_single_loading) {
            _single_loading = true;

            var _this = $(this);
            var _url = $(_this).attr('href');
            var _data = {};

            var $crazy_load = $('#tradeace-ajax-store').length && $('#tradeace-ajax-store').hasClass('tradeace-crazy-load') ? true : false;

            $.ajax({
                url: _url,
                type: 'get',
                dataType: 'html',
                data: _data,
                cache: true,
                beforeSend: function() {
                    if (typeof _single_remove_loading !== 'undefined') {
                        clearInterval(_single_remove_loading);
                    }

                    if ($crazy_load && $('#tradeace-ajax-store').length && !$('#tradeace-ajax-store').hasClass('crazy-loading')) {
                        $('#tradeace-ajax-store').addClass('crazy-loading');
                    }

                    if ($('.tradeace-progress-bar-load-shop').length) {
                        $('.tradeace-progress-bar-load-shop .tradeace-progress-per').removeClass('tradeace-loaded');
                        $('.tradeace-progress-bar-load-shop').addClass('tradeace-loading');
                    }

                    var _pos_obj = $('#tradeace-ajax-store');
                    animate_scroll_to_top($, _pos_obj, 700);
                },
                success: function (res) {
                    var $html = $.parseHTML(res);

                    var $mainContent = $('#tradeace-ajax-store', $html);

                    if ($('#header-content').length) {
                        var $headContent = $('#header-content', $html);
                        /**
                         * Replace Header
                         */
                        $('#header-content').replaceWith($headContent);
                    } else if ($('#tradeace-breadcrumb-site').length) {
                        /**
                         * Replace Breadcrumb
                         */
                        var $breadcrumb = $('#tradeace-breadcrumb-site', $html);
                        $('#tradeace-breadcrumb-site').replaceWith($breadcrumb);
                    }

                    /**
                     * Replace Archive
                     */
                    $('#tradeace-ajax-store').replaceWith($mainContent);

                    /**
                     * Replace Footer
                     */
                    if ($('#tradeace-footer').length) {
                        var $footContent = $('#tradeace-footer', $html);
                        $('#tradeace-footer').replaceWith($footContent);
                    }

                    /**
                     * 
                     * Title Page
                     */
                    var matches = res.match(/<title>(.*?)<\/title>/);
                    var _title = typeof matches[1] !== 'undefined' ? matches[1] : '';
                    if (_title) {
                        $('title').html(_title);
                    }

                    $('body').trigger('tradeace_after_loaded_ajax_complete');

                    /**
                     * Fix lazy load
                     */
                    setTimeout(function() {
                        if ($('img[data-lazy-src]').length) {
                            $('img[data-lazy-src]').each(function() {
                                var _img = $(this);
                                var _src_real = $(_img).attr('data-lazy-src');
                                var _srcset = $(_img).attr('data-lazy-srcset');
                                var _size = $(_img).attr('data-lazy-sizes');
                                $(_img).attr('src', _src_real);
                                $(_img).removeAttr('data-lazy-src');

                                if (_srcset) {
                                    $(_img).attr('srcset', _srcset);
                                    $(_img).removeAttr('data-lazy-srcset');
                                }

                                if (_size) {
                                    $(_img).attr('sizes', _size);
                                    $(_img).removeAttr('data-lazy-sizes');
                                }
                            });
                        }
                    }, 100);
                },
                error: function () {
                    $('#tradeace-ajax-store').removeClass('crazy-loading');

                    if ($('.tradeace-progress-bar-load-shop').length) {
                        $('.tradeace-progress-bar-load-shop').removeClass('tradeace-loading');
                    }

                    _single_loading = false;
                }
            });

            window.history.pushState(_url, '', _url);
        }
    }
});

// Back url with Ajax Call
$(window).on('popstate', function() {
    if ($('#tradeace-single-product-ajax').length) {
        location.reload(true);
    }
});

/* End Document Ready */
});

/**
 * Functions
 */
/**
 * clone add to cart button fixed
 * 
 * @param {type} $
 * @returns {String}
 */
function tradeace_clone_add_to_cart($) {
    var _ressult = '';
    
    if ($('.tradeace-product-details-page').length) {
        var _wrap = $('.tradeace-product-details-page');
        
        /**
         * Variations
         */
        if ($(_wrap).find('.single_variation_wrap').length) {
            var _price = $(_wrap).find('.single_variation_wrap .woocommerce-variation .woocommerce-variation-price').length && $(_wrap).find('.single_variation_wrap .woocommerce-variation').css('display') !== 'none' ? $(_wrap).find('.single_variation_wrap').find('.woocommerce-variation-price').html() : '';
            
            /**
             * Clone form
             */
            var _addToCart = $(_wrap).find('.single_variation_wrap').find('.woocommerce-variation-add-to-cart').clone();
            
            /**
             * Remove id
             */
            $(_addToCart).find('*').removeAttr('id');
            
            /**
             * Remove Style
             */
            if ($(_addToCart).find('.single_add_to_cart_button').length) {
                $(_addToCart).find('.single_add_to_cart_button').removeAttr('style');
            }
            
            /**
             * Remove Buy Now
             */
            if ($(_addToCart).find('.tradeace-buy-now').length && !$(_addToCart).find('.tradeace-buy-now').hasClass('has-sticky-in-desktop')) {
                $(_addToCart).find('.tradeace-buy-now').remove();
            }
            
            /**
             * Remove tags not use in sticky
             */
            if ($(_addToCart).find('.tradeace-not-in-sticky').length) {
                $(_addToCart).find('.tradeace-not-in-sticky').remove();
            }
            
            /**
             * Compatible with Uni CPO/Rangeslider.ion Plugin
             */
            if ($(_addToCart).find('.uni-builderius-container').length) {
                $(_addToCart).find('.uni-builderius-container').remove();
            }
            
            var _btn = $(_addToCart).html();
            
            var _disable = $(_wrap).find('.single_variation_wrap').find('.woocommerce-variation-add-to-cart-disabled').length ? ' tradeace-clone-disable' : '';

            _ressult = '<div class="tradeace-single-btn-clone single_variation_wrap-clone' + _disable + '">' + _price + '<div class="woocommerce-variation-add-to-cart-clone">' + _btn + '</div></div>';
            
            var _options_txt = $('input[name="tradeace_select_options_text"]').length ? $('input[name="tradeace_select_options_text"]').val() : 'Select Options';
            
            _ressult = '<a class="tradeace-toggle-variation_wrap-clone" href="javascript:void(0);">' + _options_txt + '</a>' + _ressult;
        }

        /**
         * Simple
         */
        else if ($(_wrap).find('.cart').length){
            /**
             * Clone form
             */
            var _addToCart = $(_wrap).find('.cart').clone();
            
            /**
             * Remove id
             */
            $(_addToCart).find('*').removeAttr('id');
            
            /**
             * Remove Style
             */
            if ($(_addToCart).find('.single_add_to_cart_button').length) {
                $(_addToCart).find('.single_add_to_cart_button').removeAttr('style');
            }
            
            /**
             * Remove Buy Now
             */
            if ($(_addToCart).find('.tradeace-buy-now').length && !$(_addToCart).find('.tradeace-buy-now').hasClass('has-sticky-in-desktop')) {
                $(_addToCart).find('.tradeace-buy-now').remove();
            }
            
            /**
             * Remove tags not use in sticky
             */
            if ($(_addToCart).find('.tradeace-not-in-sticky').length) {
                $(_addToCart).find('.tradeace-not-in-sticky').remove();
            }
            
            /**
             * Compatible with Uni CPO/Rangeslider.ion Plugin
             */
            if ($(_addToCart).find('.uni-builderius-container').length) {
                $(_addToCart).find('.uni-builderius-container').remove();
            }
            
            var _btn = $(_addToCart).html();
            
            _ressult = '<div class="tradeace-single-btn-clone">' + _btn + '</div>';
        }
    }
    
    return _ressult;
}

/**
 * Single slick images
 * 
 * @param {type} $
 * @param {type} restart
 * @returns {undefined}
 */
function load_slick_single_product($, restart) {
    if ($('.tradeace-single-product-slide .tradeace-single-product-main-image').length) {
        var _root_wrap = $('.tradeace-single-product-slide');
        if ($(_root_wrap).length) {
            var _restart = typeof restart === 'undefined' ? false : true;
            var _rtl = $('body').hasClass('tradeace-rtl') ? true : false;
            var _main = $(_root_wrap).find('.tradeace-single-product-main-image'),
                _thumb = $(_root_wrap).find('.tradeace-single-product-thumbnails').length ? $(_root_wrap).find('.tradeace-single-product-thumbnails') : null,

                _autoplay = $(_root_wrap).attr('data-autoplay') === 'true' ? true : false,
                _speed = parseInt($(_root_wrap).attr('data-speed')),
                _delay = parseInt($(_root_wrap).attr('data-delay')),
                _dots = $(_root_wrap).attr('data-dots') === 'true' ? true : false,
                _num_main = parseInt($(_root_wrap).attr('data-num_main'));

            _speed = !_speed ? 600 : _speed;
            _delay = !_delay ? 6000 : _delay;
            _num_main = !_num_main ? 1 : _num_main;

            if (_restart) {
                if ($(_main).length && $(_main).hasClass('slick-initialized')) {
                    $(_main).slick('unslick');
                }

                if ($(_thumb).length && $(_thumb).hasClass('slick-initialized')) {
                    $(_thumb).slick('unslick');
                }
            }

            var _interval = setInterval(function() {
                if ($(_main).find('#tradeace-main-image-0 img').height()) {
                    if (!$(_main).hasClass('slick-initialized')) {
                        $(_main).slick({
                            rtl: _rtl,
                            slidesToShow: _num_main,
                            slidesToScroll: _num_main,
                            autoplay: _autoplay,
                            autoplaySpeed: _delay,
                            speed: _speed,
                            arrows: true,
                            dots: _dots,
                            infinite: false,
                            asNavFor: _thumb,
                            responsive: [
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1
                                    }
                                }
                            ]
                        });
                    }

                    if (_thumb && !$(_thumb).hasClass('slick-initialized')) {
                        var _num_ver = parseInt($(_root_wrap).attr('data-num_thumb'));
                        _num_ver = !_num_ver ? 4 : _num_ver;

                        var _vertical = true;
                        var wrapThumb = $(_thumb).parents('.tradeace-thumb-wrap');

                        if ($(wrapThumb).length && $(wrapThumb).hasClass('tradeace-thumbnail-hoz')) {
                            _vertical = false;
                            _num_ver = 5;
                        }

                        var _setting = {
                            vertical: _vertical,
                            slidesToShow: _num_ver,
                            slidesToScroll: 1,
                            dots: false,
                            arrows: true,
                            infinite: false
                        };

                        if (!_vertical) {
                            _setting.rtl = _rtl;
                        } else {
                            _setting.verticalSwiping = true;
                        }

                        _setting.asNavFor = _main;
                        _setting.centerMode = false;
                        _setting.centerPadding = '0';
                        _setting.focusOnSelect = true;

                        $(_thumb).slick(_setting);
                        $(_thumb).attr('data-speed', _speed);
                    }

                    clearInterval(_interval);

                    $('body').trigger('tradeace_after_single_product_slick_inited', [_thumb, _num_ver]);
                }
            }, 100);

            setTimeout(function() {
                if ($('.tradeace-single-product-slide .tradeace-single-product-main-image .slick-list').length <= 0 || $('.tradeace-single-product-slide .tradeace-single-product-main-image .slick-list').height() < 2) {
                    load_slick_single_product($, true);
                }
            }, 500);
        }
    }
}

/**
 * Lightbox image single product page
 * 
 * @param {type} $
 * @returns {undefined}
 */
function load_gallery_popup($) {
    if ($('.main-images').length) {
        if (! $('body').hasClass('tradeace-disable-lightbox-image')) {
            $('.main-images').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: '<div class="tradeace-loader"></div>',
                removalDelay: 300,
                closeOnContentClick: true,
                // tClose: $('input[name="tradeace-close-string"]').val(),
                closeMarkup: '<a class="tradeace-mfp-close tradeace-stclose" href="javascript:void(0);" title="' + $('input[name="tradeace-close-string"]').val() + '"></a>',
                gallery: {
                    enabled: true,
                    navigateByImgClick: false,
                    preload: [0,1]
                },
                image: {
                    verticalFit: false,
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
                },
                callbacks: {
                    beforeOpen: function() {
                        var productVideo = $('.product-video-popup').attr('href');

                        if (productVideo){
                            // Add product video to gallery popup
                            this.st.mainClass = 'has-product-video';
                            var galeryPopup = $.magnificPopup.instance;
                            galeryPopup.items.push({
                                src: productVideo,
                                type: 'iframe'
                            });

                            galeryPopup.updateItemHTML();
                        }
                    },
                    open: function() {

                    }
                }
            });
        }
        
        /**
         * Disable lightbox image
         */
        else {
            $('body').on('click', '.main-images a.woocommerce-additional-image', function() {
                return false;
            });
        }
    }
}

/**
 * Gallery for variation of Single Product
 * 
 * @param {type} $
 * @param {type} _form
 * @param {type} variation
 * @returns {undefined}
 */
function change_gallery_variable_single_product($, _form, variation) {
    if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
        var _countSelect = $(_form).find('.variations .value select').length;
        var _selected = 0;
        if (_countSelect) {
            $(_form).find('.variations .value select').each(function() {
                if ($(this).val() !== '') {
                    _selected++;
                }
            });
        }

        if (_countSelect && _selected === _countSelect) {
            _inited_gallery = false;
            _inited_gallery_key = 1;

            var _data = {
                'variation_id': variation.variation_id,
                'main_id': (variation.image_id ? variation.image_id : 0),
                'gallery': variation.tradeace_gallery_variation
            };

            if (
                $('.tradeace-detail-product-deal-countdown').length &&
                variation.is_in_stock && variation.is_purchasable
            ) {
                _data.deal_variation = '1';
            }

            if (typeof _single_variations[variation.variation_id] === 'undefined') {
                if (
                    typeof tradeace_ajax_params !== 'undefined' &&
                    typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
                ) {
                    var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_get_gallery_variation');

                    $.ajax({
                        url: _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        data: {
                            data: _data
                        },
                        beforeSend: function () {
                            if (!$(_form).hasClass('tradeace-processing')) {
                                $(_form).addClass('tradeace-processing');
                            }

                            $('.tradeace-detail-product-deal-countdown').html('');
                            $('.tradeace-detail-product-deal-countdown').removeClass('tradeace-show');

                            if (!$('.tradeace-product-details-page').hasClass('crazy-loading')) {
                                $('.tradeace-product-details-page').addClass('crazy-loading');
                            }
                            $('.product-gallery').css({'min-height': $('.product-gallery').outerHeight()});
                        },
                        success: function (result) {
                            $(_form).removeClass('tradeace-processing');
                            $('.tradeace-product-details-page').removeClass('crazy-loading');

                            _single_variations[variation.variation_id] = result;

                            /**
                             * Deal
                             */
                            if (typeof result.deal_variation !== 'undefined') {
                                $('.tradeace-detail-product-deal-countdown').html(result.deal_variation);

                                if (result.deal_variation !== '') {
                                    /**
                                     * Trigger after changed Countdown
                                     */
                                    $('body').trigger('tradeace_load_countdown');

                                    if (!$('.tradeace-detail-product-deal-countdown').hasClass('tradeace-show')) {
                                        $('.tradeace-detail-product-deal-countdown').addClass('tradeace-show');
                                    }
                                }

                                else {
                                    $('.tradeace-detail-product-deal-countdown').removeClass('tradeace-show');
                                }
                            } else {
                                $('.tradeace-detail-product-deal-countdown').removeClass('tradeace-show');
                            } 

                            /**
                             * Main image
                             */
                            if (typeof result.main_image !== 'undefined') {
                                $('.tradeace-main-image-default').replaceWith(result.main_image);
                            }

                            /**
                             * Thumb image
                             */
                            if ($('.tradeace-thumbnail-default').length && typeof result.thumb_image !== 'undefined') {
                                $('.tradeace-thumbnail-default').replaceWith(result.thumb_image);

                                if ($('.tradeace-thumb-clone img').length && $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] img').length) {
                                    $('.tradeace-thumb-clone img').attr('src', $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] img').attr('src'));
                                }
                            } else if ($('.tradeace-thumb-clone img').length && typeof result.main_image !== 'undefined') {
                                $('.tradeace-thumb-clone img').attr('src', $('.main-images .item-wrap.first img').attr('src'));
                            }

                            /**
                             * Trigger after changed Gallery for Single product
                             */
                            $('body').trigger('tradeace_changed_gallery_variable_single');
                        },
                        error: function() {
                            $(_form).removeClass('tradeace-processing');
                            $('.tradeace-product-details-page').removeClass('crazy-loading');
                        }
                    });
                }
            } else {
                var result = _single_variations[variation.variation_id];

                /**
                 * Deal
                 */
                if (typeof result.deal_variation !== 'undefined') {
                    $('.tradeace-detail-product-deal-countdown').html(result.deal_variation);

                    if (result.deal_variation !== '') {
                        /**
                         * Trigger after changed Countdown
                         */
                        $('body').trigger('tradeace_load_countdown');

                        if (!$('.tradeace-detail-product-deal-countdown').hasClass('tradeace-show')) {
                            $('.tradeace-detail-product-deal-countdown').addClass('tradeace-show');
                        }
                    }

                    else {
                        $('.tradeace-detail-product-deal-countdown').removeClass('tradeace-show');
                    }
                } else {
                    $('.tradeace-detail-product-deal-countdown').removeClass('tradeace-show');
                }

                /**
                 * Main image
                 */
                if (typeof result.main_image !== 'undefined') {
                    if (!$('.tradeace-product-details-page').hasClass('crazy-loading')) {
                        $('.tradeace-product-details-page').addClass('crazy-loading');
                    }

                    $('.product-gallery').css({'min-height': $('.product-gallery').outerHeight()});
                    $('.tradeace-main-image-default').replaceWith(result.main_image);
                    if (typeof _timeout_changed !== 'undefined') {
                        clearTimeout(_timeout_changed);
                    }

                    _timeout_changed = setTimeout(function() {
                        $('.tradeace-product-details-page .product-gallery').find('.tradeace-loader, .tradeace-loading').remove();
                        $('.tradeace-product-details-page').removeClass('crazy-loading');

                        $('.product-gallery').css({'min-height': 'auto'});
                    }, 200);
                }

                /**
                 * Thumb image
                 */
                if ($('.tradeace-thumbnail-default').length && typeof result.thumb_image !== 'undefined') {
                    $('.tradeace-thumbnail-default').replaceWith(result.thumb_image);

                    if ($('.tradeace-thumb-clone img').length && $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] img').length) {
                        $('.tradeace-thumb-clone img').attr('src', $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] img').attr('src'));
                    }
                } else if ($('.tradeace-thumb-clone img').length && typeof result.main_image !== 'undefined') {
                    $('.tradeace-thumb-clone img').attr('src', $('.main-images .item-wrap.first img').attr('src'));
                }

                /**
                 * Trigger after changed Gallery for Single product
                 */
                $('body').trigger('tradeace_changed_gallery_variable_single');
            }
        }
    }

    /**
     * Default
     */
    else {
        if (!_inited_gallery) {

            _inited_gallery = true;

            var result = _single_variations[0];
            if ($('.tradeace-detail-product-deal-countdown').length) {
                $('.tradeace-detail-product-deal-countdown').removeClass('tradeace-show').html('');
            }

            /**
             * Main image
             */
            if (typeof result.main_image !== 'undefined') {
                $('.tradeace-main-image-default').replaceWith(result.main_image);
            }

            /**
             * Thumb image
             */
            if (typeof result.thumb_image !== 'undefined') {
                $('.tradeace-thumbnail-default').replaceWith(result.thumb_image);

                if ($('.tradeace-thumb-clone img').length && $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] img').length) {
                    $('.tradeace-thumb-clone img').attr('src', $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] img').attr('src'));
                }
            }

            /**
             * Trigger after changed Gallery for Single product
             */
            $('body').trigger('tradeace_changed_gallery_variable_single');
        }
    }
}

/**
 * Change image variable Single product
 * 
 * @param {type} $
 * @param {type} _form
 * @param {type} variation
 * @returns {undefined}
 */
function change_image_variable_single_product($, _form, variation) {
    /**
     * Trigger Easy Zoom
     */
    $('body').trigger('tradeace_before_changed_src_main_img');
    
    /**
     * Change gallery for single product variation
     */
    if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
        var _countSelect = $(_form).find('.variations .value select').length;
        var _selected = 0;
        if (_countSelect) {
            $(_form).find('.variations .value select').each(function() {
                if ($(this).val() !== '') {
                    _selected++;
                }
            });
        }

        if (_countSelect && _selected === _countSelect) {
            var src_thumb = false;

            /**
             * Support Bundle product
             */
            if ($('.tradeace-product-details-page .woosb-product').length) {
                if (variation.image.thumb_src !== 'undefined' || variation.image.gallery_thumbnail_src !== 'undefined') {
                    src_thumb = variation.image.gallery_thumbnail_src ? variation.image.gallery_thumbnail_src :  variation.image.thumb_src;
                }

                if (src_thumb) {
                    $(_form).parents('.woosb-product').find('.woosb-thumb-new').html('<img src="' + src_thumb + '" />');
                    $(_form).parents('.woosb-product').find('.woosb-thumb-ori').hide();
                    $(_form).parents('.woosb-product').find('.woosb-thumb-new').show();
                }
            }

            else {
                var _src_large = typeof variation.image_single_page !== 'undefined' ?
                    variation.image_single_page : variation.image.url;

                $('.main-images .tradeace-item-main-image-wrap[data-key="0"] img').attr('src', _src_large);
                $('.main-images .tradeace-item-main-image-wrap[data-key="0"] a').attr('href', variation.image.url);

                /**
                 * Trigger Easy Zoom
                 */
                $('body').trigger('tradeace_after_changed_src_main_img', [_src_large, variation.image.url]);

                $('.main-images .tradeace-item-main-image-wrap[data-key="0"] img').removeAttr('srcset');

                /**
                 * For thumnail
                 */
                if ($('.product-thumbnails').length) {
                    if (variation.image.thumb_src !== 'undefined') {
                        src_thumb = variation.image.thumb_src;
                    } else {
                        var thumb_wrap = $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"]');
                        if (typeof $(thumb_wrap).attr('data-thumb_org') === 'undefined') {
                            $(thumb_wrap).attr('data-thumb_org', $(thumb_wrap).find('img').attr('src'));
                        }

                        src_thumb = $(thumb_wrap).attr('data-thumb_org');
                    }

                    if (src_thumb) {
                        $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] img').attr('src', src_thumb).removeAttr('srcset');
                        if ($('body').hasClass('tradeace-focus-main-image') && $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] a').length) {
                            $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] a').trigger('click');
                        }

                        if ($('.tradeace-thumb-clone img').length) {
                            $('.tradeace-thumb-clone img').attr('src', src_thumb);
                        }
                    }
                }

                else if ($('.tradeace-thumb-clone img').length && _src_large) {
                    $('.tradeace-thumb-clone img').attr('src', _src_large);
                }
            }
        }

    } else {
        /**
         * Support Bundle product
         */
        if ($('.tradeace-product-details-page .woosb-product').length) {
            $(_form).parents('.woosb-product').find('.woosb-thumb-ori').show();
            $(_form).parents('.woosb-product').find('.woosb-thumb-new').hide();
        } else {
            var image_link = typeof $('.tradeace-product-details-page .woocommerce-main-image').attr('data-full_href') !== 'undefined' ?
                $('.tradeace-product-details-page .woocommerce-main-image').attr('data-full_href') :
                $('.tradeace-product-details-page .woocommerce-main-image').attr('data-o_href');
            var image_large = $('.tradeace-product-details-page .woocommerce-main-image').attr('data-o_href');

            $('.main-images .tradeace-item-main-image-wrap[data-key="0"] img').attr('src', image_large).removeAttr('srcset');
            $('.main-images .tradeace-item-main-image-wrap[data-key="0"] a').attr('href', image_link);

            /**
             * Trigger Easy Zoom
             */
            $('body').trigger('tradeace_after_changed_src_main_img', [image_large, image_link]);

            if ($('.product-thumbnails').length) {
                var thumb_wrap = $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"]');
                if (typeof $(thumb_wrap).attr('data-thumb_org') === 'undefined') {
                    $(thumb_wrap).attr('data-thumb_org', $(thumb_wrap).find('img').attr('src'));
                }

                var src_thumb = $(thumb_wrap).attr('data-thumb_org');
                if (src_thumb) {
                    $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] img').attr('src', src_thumb);
                    if ($('body').hasClass('tradeace-focus-main-image') && $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] a').length) {
                        $('.product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] a').trigger('click');
                    }

                    if ($('.tradeace-thumb-clone img').length) {
                        $('.tradeace-thumb-clone img').attr('src', src_thumb);
                    }
                }
            } else if ($('.tradeace-thumb-clone img').length && image_large) {
                $('.tradeace-thumb-clone img').attr('src', image_large);
            }
        }
    }

    /**
     * deal time
     */
    if ($('.tradeace-detail-product-deal-countdown').length) {
        if (
            variation && variation.variation_id &&
            variation.is_in_stock && variation.is_purchasable
        ) {
            if (typeof _single_variations[variation.variation_id] === 'undefined') {
                if (
                    typeof tradeace_ajax_params !== 'undefined' &&
                    typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
                ) {
                    var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_get_deal_variation');

                    $.ajax({
                        url: _urlAjax,
                        type: 'post',
                        cache: false,
                        data: {
                            pid: variation.variation_id
                        },
                        beforeSend: function () {
                            if (!$(_form).hasClass('tradeace-processing-countdown')) {
                                $(_form).addClass('tradeace-processing-countdown');
                            }

                            $('.tradeace-detail-product-deal-countdown').html('');
                            $('.tradeace-detail-product-deal-countdown').removeClass('tradeace-show');
                        },
                        success: function (res) {
                            $(_form).removeClass('tradeace-processing-countdown');

                            if (typeof res.success !== 'undefined' && res.success === '1') {
                                _single_variations[variation.variation_id] = res.content;
                            } else {
                                _single_variations[variation.variation_id] = '';
                            }
                            $('.tradeace-detail-product-deal-countdown').html(_single_variations[variation.variation_id]);
                            if (_single_variations[variation.variation_id] !== '') {
                                /**
                                 * Trigger after changed Countdown
                                 */
                                $('body').trigger('tradeace_load_countdown');

                                if (!$('.tradeace-detail-product-deal-countdown').hasClass('tradeace-show')) {
                                    $('.tradeace-detail-product-deal-countdown').addClass('tradeace-show');
                                }
                            } else {
                                $('.tradeace-detail-product-deal-countdown').removeClass('tradeace-show');
                            }
                        },
                        error: function() {
                            $(_form).removeClass('tradeace-processing-countdown');
                        }
                    });
                }
            } else {
                $('.tradeace-detail-product-deal-countdown').html(_single_variations[variation.variation_id]);
                if (_single_variations[variation.variation_id] !== '') {

                    /**
                     * Trigger after changed Countdown
                     */
                    $('body').trigger('tradeace_load_countdown');

                    if (!$('.tradeace-detail-product-deal-countdown').hasClass('tradeace-show')) {
                        $('.tradeace-detail-product-deal-countdown').addClass('tradeace-show');
                    }
                } else {
                    $('.tradeace-detail-product-deal-countdown').removeClass('tradeace-show');
                }
            }
        } else {
            $('.tradeace-detail-product-deal-countdown').html('');
            $('.tradeace-detail-product-deal-countdown').removeClass('tradeace-show');
        }
    }
}

/**
 * Found variation
 * 
 * @param {type} $
 * @returns {undefined}
 */
function tradeace_single_product_found_variation($) {
    $('.tradeace-product-details-page form.variations_form').on('found_variation', function(e, variation) {
        var _form = $(this);
        if ($('.tradeace-product-details-page .tradeace-gallery-variation-supported').length === 1) {
            change_gallery_variable_single_product($, _form, variation);
        } else {
            setTimeout(function() {
                load_gallery_popup($);
                change_image_variable_single_product($, _form, variation);
            }, 10);
        }
    });
}

/**
 * Found variation
 * 
 * @param {type} $
 * @returns {undefined}
 */
function tradeace_single_product_reset_variation_df($) {
    $('.tradeace-product-details-page form.variations_form').on('reset_data', function() {
        var _form = $(this);
        if ($('.tradeace-product-details-page .tradeace-gallery-variation-supported').length) {
            change_gallery_variable_single_product($, _form, null);
        } else {
            setTimeout(function() {
                load_gallery_popup($);
                change_image_variable_single_product($, _form, null);
            }, 10);
        }
    });
}

/**
 * Scroll Single Product sticky info and thumbnails
 * 
 * @param {type} $
 * @returns {Array|load_scroll_single_product._main_images}
 */
function load_scroll_single_product($) {
    var _main_images = [];
    
    if ($('.tradeace-single-product-scroll').length && $('.tradeace-end-scroll').length) {
        if ($('.tradeace-single-product-thumbnails').hasClass('tradeace-single-fixed')) {
            var _thumb_wrap = $('.tradeace-single-product-thumbnails').parents('.tradeace-thumb-wrap');
            var _pos_thumb = $(_thumb_wrap).offset();
            $('.tradeace-single-product-thumbnails').css({
                'left': _pos_thumb.left,
                'width': $(_thumb_wrap).width()
            });
        }
        
        if ($('.tradeace-product-info-scroll').hasClass('tradeace-single-fixed')) {
            var _scroll_wrap = $('.tradeace-product-info-scroll').parents('.tradeace-product-info-wrap');
            var _pos_wrap = $(_scroll_wrap).offset();
            $('.tradeace-product-info-scroll').css({
                'left': _pos_wrap.left,
                'width': $(_scroll_wrap).width()
            });
        }
        
        
        $('.tradeace-item-main-image-wrap').each(function() {
            var p = {
                id: '#' + $(this).attr('id'),
                pos: $(this).offset().top
            };
            
            _main_images.push(p);
        });
    }
    
    return _main_images;
}

/**
 * Sticky Add to cart
 * 
 * @param {type} $
 * @returns {undefined}
 */
function load_sticky_add_to_cart($) {
    if (
        $('input[name="tradeace_fixed_single_add_to_cart"]').length &&
        $('.tradeace-product-details-page').length
    ) {
        var _tradeace_in_mobile = $('input[name="tradeace_mobile_layout"]').length ? true : false;

        var _mobile_fixed_addToCart = 'no';
        if ($('input[name="tradeace_fixed_mobile_single_add_to_cart_layout"]').length) {
            _mobile_fixed_addToCart = $('input[name="tradeace_fixed_mobile_single_add_to_cart_layout"]').val();
        }
        var _can_render = true;
        if (_tradeace_in_mobile && (_mobile_fixed_addToCart === 'no' || _mobile_fixed_addToCart === 'btn')) {
            _can_render = false;
            $('body').addClass('tradeace-cart-fixed-desktop');
        }
        if (_mobile_fixed_addToCart === 'btn') {
            $('body').addClass('tradeace-cart-fixed-mobile-btn');

            if ($('.tradeace-buy-now').length) {
                $('body').addClass('tradeace-has-buy-now');
            }
        }

        /**
         * Render in desktop
         */
        if (_can_render && $('.tradeace-add-to-cart-fixed').length <= 0) {
            $('body').append('<div class="tradeace-add-to-cart-fixed"><div class="tradeace-wrap-content-inner"><div class="tradeace-wrap-content"></div></div></div>');

            if (_mobile_fixed_addToCart === 'no' || _mobile_fixed_addToCart === 'btn') {
                $('.tradeace-add-to-cart-fixed').addClass('tradeace-not-show-mobile');
                $('body').addClass('tradeace-cart-fixed-desktop');
            }

            var _addToCartWrap = $('.tradeace-add-to-cart-fixed .tradeace-wrap-content');

            /**
             * Main Image clone
             */
            $(_addToCartWrap).append('<div class="tradeace-fixed-product-info"></div>');
            var _src = '';
            if ($('.tradeace-product-details-page .product-thumbnails').length) {
                _src = $('.tradeace-product-details-page .product-thumbnails .tradeace-wrap-item-thumb[data-key="0"]').attr('data-thumb_org') || $('.tradeace-product-details-page .product-thumbnails .tradeace-wrap-item-thumb[data-key="0"] img').attr('src');
            } else {
                _src = $('.tradeace-product-details-page .main-images .item-wrap.first a.product-image').attr('data-o_href') || $('.tradeace-product-details-page .main-images .item-wrap.first img').attr('src');
            }

            if (_src !== '') {
                $('.tradeace-fixed-product-info').append('<div class="tradeace-thumb-clone"><img src="' + _src + '" /></div>');
            }

            /**
             * Title clone
             */
            if ($('.tradeace-product-details-page .product-info .product_title').length) {
                var _title = $('.tradeace-product-details-page .product-info .product_title').html();

                $('.tradeace-fixed-product-info').append('<div class="tradeace-title-clone"><h3>' + _title +'</h3></div>');
            }

            /**
             * Price clone
             */
            if ($('.tradeace-product-details-page .product-info .price.tradeace-single-product-price').length) {
                var _price = $('.tradeace-product-details-page .product-info .price.tradeace-single-product-price').html();
                if ($('.tradeace-title-clone').length) {
                    $('.tradeace-title-clone').append('<span class="price">' + _price + '</span>');
                }
                else {
                    $('.tradeace-fixed-product-info').append('<div class="tradeace-title-clone"><span class="price">' + _price + '</span></div>');
                }
            }

            /**
             * Variations clone
             */
            if ($('.tradeace-product-details-page .variations_form').length) {
                $(_addToCartWrap).append('<div class="tradeace-fixed-product-variations-wrap"><div class="tradeace-fixed-product-variations"></div><a class="tradeace-close-wrap" href="javascript:void(0);"></a></div>');

                /**
                 * Variations
                 * 
                 * @type type
                 */
                var _k = 1,
                    _item = 1;
                $('.tradeace-product-details-page .variations_form .variations tr').each(function() {
                    var _this = $(this);
                    var _classWrap = 'tradeace-attr-wrap-' + _k.toString();
                    var _type = $(_this).find('select').attr('data-attribute_name') || $(_this).find('select').attr('name');

                    if ($(_this).find('.tradeace-attr-ux_wrap').length) {
                        $('.tradeace-fixed-product-variations').append('<div class="tradeace-attr-ux_wrap-clone ' + _classWrap + '"></div>');

                        $(_this).find('.tradeace-attr-ux').each(function() {
                            var _obj = $(this);
                            var _classItem = 'tradeace-attr-ux-' + _item.toString();
                            var _classItemClone = 'tradeace-attr-ux-clone-' + _item.toString();
                            var _classItemClone_target = _classItemClone;

                            if ($(_obj).hasClass('tradeace-attr-ux-image')) {
                                _classItemClone += ' tradeace-attr-ux-image-clone';
                            }

                            if ($(_obj).hasClass('tradeace-attr-ux-color')) {
                                _classItemClone += ' tradeace-attr-ux-color-clone';
                            }

                            if ($(_obj).hasClass('tradeace-attr-ux-label')) {
                                _classItemClone += ' tradeace-attr-ux-label-clone';
                            }

                            var _selected = $(_obj).hasClass('selected') ? ' selected' : '';
                            var _contentItem = $(_obj).html();

                            $(_obj).addClass(_classItem);
                            $(_obj).attr('data-target', '.' + _classItemClone_target);

                            $('.tradeace-attr-ux_wrap-clone.' + _classWrap).append('<a href="javascript:void(0);" class="tradeace-attr-ux-clone' + _selected + ' ' + _classItemClone + ' tradeace-' + _type + '" data-target=".' + _classItem + '">' + _contentItem + '</a>');

                            _item++;
                        });
                    } else {
                        $('.tradeace-fixed-product-variations').append('<div class="tradeace-attr-select_wrap-clone ' + _classWrap + '"></div>');

                        var _obj = $(_this).find('select');

                        var _label = $(_this).find('.label').length ? $(_this).find('.label').html() : '';

                        var _classItem = 'tradeace-attr-select-' + _item.toString();
                        var _classItemClone = 'tradeace-attr-select-clone-' + _item.toString();

                        var _contentItem = $(_obj).html();

                        $(_obj).addClass(_classItem).addClass('tradeace-attr-select');
                        $(_obj).attr('data-target', '.' + _classItemClone);

                        $('.tradeace-attr-select_wrap-clone.' + _classWrap).append(_label + '<select name="' + _type + '" class="tradeace-attr-select-clone ' + _classItemClone + ' tradeace-' + _type + '" data-target=".' + _classItem + '">' + _contentItem + '</select>');

                        _item++;
                    }

                    _k++;
                });
            }
            /**
             * Class wrap simple product
             */
            else {
                $(_addToCartWrap).addClass('tradeace-fixed-single-simple');
            }

            /**
             * Add to cart button
             */
            setTimeout(function() {
                var _button_wrap = tradeace_clone_add_to_cart($);
                $(_addToCartWrap).append('<div class="tradeace-fixed-product-btn"></div>');
                $('.tradeace-fixed-product-btn').html(_button_wrap);
                var _val = $('.tradeace-product-details-page form.cart input[name="quantity"]').val();
                $('.tradeace-single-btn-clone input[name="quantity"]').val(_val);
            }, 250);

            setTimeout(function() {
                if ($('.tradeace-attr-ux').length) {
                    $('.tradeace-attr-ux').each(function() {
                        var _this = $(this);
                        var _targetThis = $(_this).attr('data-target');

                        if ($(_targetThis).length) {
                            var _disable = $(_this).hasClass('tradeace-disable') ? true : false;
                            if (_disable) {
                                if (!$(_targetThis).hasClass('tradeace-disable')) {
                                    $(_targetThis).addClass('tradeace-disable');
                                }
                            } else {
                                $(_targetThis).removeClass('tradeace-disable');
                            }
                        }
                    });
                }
            }, 550);
        }
    }
}
